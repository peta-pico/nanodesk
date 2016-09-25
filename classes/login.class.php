<?php
/*
| Dit is de kern van het hele loginsysteem. Hier gebeurt alles.
| Dit is een enkele klasse die overal voor zorgt.
|
| Eerst een beveiliging (ook gevonden in config.php, zie die file voor
| verdere uitleg)
*/
if(basename($_SERVER['PHP_SELF']) == "header.php") 
{
	header("Location: ../index.php");
}

/*
| Het configuratiebestand laden om verbinding te kunnen maken met de database
| en om wat andere instellingen te kunnen gebruiken die later nodig zijn.
*/
//include_once("config.inc.php");

/*
| Nu beginnen we aan de klasse, dit is een simpele klasse die 
| niets meer en niets minder doet dan waarvoor hij gemaakt is:
| gebruikersauthenticatie.
*/
class login
{

	/*
	| instellingen voor de login 
	*/
	var $show_errors = true;

	//-- naam voor de cookie
	var $cookiename;

	//-- tijd van de sessie in uren
	var $login_session_time = 24; 

	//--password ook md5 encripten? Default = true
	var $ip_check = true;

	//--password ook md5 encripten? Default = true
	var $login_password_md5 = true;

	//--Login URL
	var $login_url;

	//-- Next: the next landingpage
	var $next_url;

	//-- input names of form after post
	var $username_postfield, $password_postfield, $orcid_id;

	//-- names of the users table and login table from db
	var $users_table, $logins_table;

	/*
	| database verbinding variable
	*/
	protected $db;
	protected $verbinding;

	/*
	| Een variabele om aan te geven of de gberuiker is ingelogd,
	| wat standaard niet is, dus de waarde 'false' krijgt
	*/
	private static $loginsessie = false;

	/*
	| Een variabele om fouten in op te slaan die het systeem
	| teruggeeft.
	*/
	public $fouten = "";
	
	/*
	| Een variabele (array) om wat informatie over de gebruikers
	| in op te slaan.
	*/
	private static $gebruikersinfo = array();
	
	/*
	| Een variabele om database velden in op te slaan
	*/
	public $database_velden = array();
	
	/*
	| Een variabele die bijhoud hoeveel pogingen een gebruiker al
	| heeft gemaakt om in te loggen. We beginnen met tellen bij 0
	*/
	private $recheck = 0;
	
	
	/*
	| Deze functie word aangeroepen bij het laden van de klasse.
	| Hier word de verbinding met de database tot stand gebracht,
	| gecontroleerd of er al een sessie is, en word er afgewacht
	| tot de gebruiker wil uitloggen
	*/
	public function __construct( $users_table, $logins_table, $var )
	{
		/*
		| required setup
		*/
		$this->users_table = $users_table;
		$this->logins_table = $logins_table;
		$this->cookiename = $var;
		$this->show_errors = true;

		/*
		| Verbinding maken met de database. De informatie word uit config.php 
		| gehaald om te kunnen verbinden.
		*/
		$this->verbinding = Core::dbConnect();
		
		//$this->verbinding = mysqli_connect(mysql_host, mysql_user, mysql_password,mysql_database);
		//mysqli_select_db(mysql_database, $verbinding);
		
		/*
		| Als er fouten zijn en fouten mogen getoond worden dan 
		| worden ze nu opgeroepen (en later pas weergegeven!)
		*/
		if($this->show_errors == true && !$this->verbinding  )
		{
			throw new Exception("MySQL liep tegen de volgende fout aan: <br />".mysql_error());
		}
		
		/*
		| Controleren op een login sessie!
		*/
		$this->check_session();
		
		/*
		| De logout actie koppelen aan de end_session functie welke mensen 
		| uitlogd.
		*/
		if(isset($_GET['actie']) && $_GET['actie'] == "uitloggen" && self::$loginsessie === true)
		{
			$this->end_session();
		}

	}

	public function checkRequiredVariables()
	{

		if( $this->login_url == '' || $this->password_postfield == '' || $this->username_postfield == '' || $this->landing_page_url == '' )
		{
			$errors[] = ( $this->login_url == '' ) ? "->login_url not set. <br>": "";
			$errors[] = ( $this->password_postfield == '' ) ? "->password_postfield not set. <br>": "";
			$errors[] = ( $this->username_postfield == '' ) ? "->username_postfield not set. <br>": "";
			$errors[] = ( $this->landing_page_url == '' ) ? "->landing_page_url not set. <br>": "";

			print_r($errors);
			echo " File:".__FILE__.'<br>';
			die(' Cannot start login ');
		}

	}
	
	/*
	| De init functie. Deze zorgt ervoor dat wanneer de gebruiker inlogt of registreert
	| hij/zij de juiste pagina voor z'n neus krijgt.
	*/
	public function init()
	{
		/*
		| Check of verplichte velden zijn ingevuld
 		*/
		$this->checkRequiredVariables();

		/*
		| Iemand heeft ergens een formulier verzonden wat bij dit loginsysteem hoort
		*/

		if( ($_SERVER['REQUEST_METHOD'] == "POST" && self::$loginsessie === false) )
		{
			//die('going to work...');

			/*
			| En het 'actie' veld is gezet, tijd voor wat actie.
			*/
			if( isset($_POST['actie']) )
			{
				/*
				| Om een grote if-else lussen constructie tegen te 
				| gaan doen we het in een switch, dat is makeklijker
				| uit te breiden.
				*/
				
				switch( $_POST['actie'] )
				{
					case "login": $this->controleer_gegevens(); break;
					case "registreer_gebruiker": $this->registreer_gebruiker(); break;
				}
		

			}
		}
	}
	
	/*
	| Een functie om het IP-adres van de gebruiker mee te achterhalen
	*/
	public function get_ip()
	{
		/*
		| Als PHP gebruikt maakt van $_SERVER,
		| meerdere pogingen doen om het IP te achterhalen
		| en in $realip weg te schrijven.
		*/
		if(isset($_SERVER))
		{
			if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
			{
				$realip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			}
			elseif(isset($_SERVER['HTTP_CLIENT_IP']))
			{
				$realip = $_SERVER['HTTP_CLIENT_IP'];
			}
			else
			{
				$realip = $_SERVER['REMOTE_ADDR'];
			}
		}
		
		/*
		| Als PHP geen gebruik maakt van $_SERVER 
		| moeten we wat anders proberen.
		*/
		else
		{
			if(getenv('HTTP_X_FORWARDED_FOR'))
			{
				$realip = getenv('HTTP_X_FORWARDED_FOR');
			}
			elseif(getenv('HTTP_CLIENT_IP'))
			{
				$realip = getenv('HTTP_CLIENT_IP');
			}
			else
			{
				$realip = getenv('REMOTE_ADDR');
			}
		}
		
		/*
		| De variabele realip returnen, zodat we die kunnen gebruiken
		*/
		return $realip;
	}
	
	
	/*
	| Een functie om de gegevens van de gebruikers die in willen loggen te controleren.
	*/
	//private function controleer_gegevens()
	public function controleer_gegevens($orcid_id=false)
	{
		/*
		| Het actie veld is gezet en de waarde is ook goed
		*/
		if(isset($_POST['actie']) && $_POST['actie'] == "login" || $orcid_id !='' )
		{


			/*
			| Even de gebruikersnaam en wachtwoord beveiligen 
			| voordat we deze in de database gooien
			*/
			#$gebruiker = mysql_real_escape_string($_POST['gebruikersnaam']);
			#$wachtwoord = mysql_real_escape_string($_POST['wachtwoord']);
			$gebruiker = $_POST[$this->username_postfield];
			$wachtwoord = $_POST[$this->password_postfield];

			/*
			| Als je in config.php hebt ingesteld dat wachtwoorden
			| gecodeerd moeten worden moet MD5, dan doen we dat hier
			*/
			if($this->login_password_md5 === true)
			{
				$wachtwoord = sha1(md5($wachtwoord));
			}
			
			/*
			| Een query uitvoeren om te kijken of de gebruiker in de database zit
			*/
			$query = $this->verbinding->prepare("SELECT * FROM ".$this->users_table." WHERE orcid_id=? LIMIT 1");

			if( !$query->execute( array( $orcid_id ) ) )
			{
				print_r( $query->errorInfo() );
				die('Query error '.__LINE__);
			}


			/*
			| Als dat zo is moet de gebruikersinfo array gevuld worden met informatie,
			| en er moet een sessie gestart worden.
			*/
			$row = $query->fetch();

			if( count( $row ) > 1 )
			{
				self::$gebruikersinfo = array();
				self::$gebruikersinfo['info'] = $row;
				//print_r(self::$gebruikersinfo['info']['id']);
				//die('290');
				return $this->start_session();
				
			}
			
			/*
			| De gebruiker zit niet in de database. Fout laten zien dan maar
			*/
			else
			{
				/*
				| Als er een MySQL fout is deze tonen (of niet, ligt aan je config.php)
				| Is dat niet zo, dan is of de gebruikersnaam of het wachtwoord
				| fout.
				*/
				if(mysqli_connect_error())
				{
					($this->show_errors == true) ? trigger_error("Er is een MySQL fout opgetreden:<br />".mysql_error(), E_USER_ERROR) : $this->fouten = "Er is een MySQL fout opgetreden";
				}
				else
				{
					$this->fouten = "Gebruikersnaam/wachtwoord niet correct.";
				}
			}
		}
	}
	
	/*
	| Een functie om te kijken of de gebruiker al is ingelogd.
	*/
	private function check_session()
	{
		/*
		| kijken of de recheck variabele van daarstraks niet
		| te groot is geworden. 
		| Is dat wel zo dan een foutmelding laten zien en 
		| 'false' retourneren.
		*/
		if($this->recheck >= 3)
		{
			$this->fouten = "Er is een ongeldige sleutel gevonden.";
			return false;
		}
		
		/*
		| als de cookie (sid) is gezet en NIET leeg is
		| even controleren of de sleutel uit de cookie
		| klopt met die uit de database (als die er 
		| al in staat om mee te beginnen)
		|
		| Is dat zo dan word self::$loginsessie waar en
		| word self::$gebruikersinfo['info'] met de juiste
		| velden gevuld
		|
		| Zo niet, dan word $this->recheck een groter
		*/

		if(isset($_COOKIE[$this->cookiename]) && !empty($_COOKIE[$this->cookiename]))
		{
			/*
			| De waarde van de Cookie met cookie naam
			*/
			$sid = $_COOKIE[$this->cookiename];

			/*
			| Start query
			*/			
			$q = "SELECT * FROM ".$this->logins_table." WHERE sid=? AND ip = ? LIMIT 1";

			$query = $this->verbinding->prepare( $q );
			if( $query->execute( array( $sid , $this->get_ip() ) ) )
			{
				//-- Get user data
				$row 	 = $query->fetch();
				//print_r($row);
				//die();
				$user_id = $row['uid'];

				$user_query = $this->verbinding->prepare("SELECT * FROM ".$this->users_table." WHERE id=? LIMIT 1");
				if( $user_query->execute( array($user_id ) ) )
				{
					$user_row = $user_query->fetch();
					self::$loginsessie = true;
					self::$gebruikersinfo = array();
					self::$gebruikersinfo['info'] = $user_row;
					
				}
				else{
					print_r( $user_query->errorInfo() );	
				}
			}
			else
			{
				print_r( $query->errorInfo() );
			}


		}
		else
		{
			$secondes = $this->login_session_time * 3600;
			setcookie($this->cookiename, "", time()-$secondes, "/");
			$this->recheck = $this->recheck + 1;
		}
	}
	
	/*
	| De sessie die hierboven word besproken starten, de correcte informatie
	| in de database opslaan ,een cookie maken en de gebruiker terugleiden
	| naar waar hij/zij vandaan kwam.
	*/
	private function start_session()
	{

		self::$gebruikersinfo['sleutel'] = md5(rand(0,99999999999).date("dmyhis"));
		$info = self::$gebruikersinfo['info'];
		$SQL  = "INSERT INTO ".$this->logins_table." ";
		$SQL .= "SET uid	= '". $info['id'] ."' ";
		$SQL .= ",   sid   = '". self::$gebruikersinfo['sleutel'] ."' ";
		$SQL .= ",   ip	= '". $this->get_ip() ."' ";
		$SQL .= ",   datum = NOW() ";
		$query = $this->verbinding->query($SQL);
		if( $query )
		{
			/*
			| Make cookie
			*/
			$secondes = $this->login_session_time * 3600;
			setcookie($this->cookiename, self::$gebruikersinfo['sleutel'], time()+$secondes, "/");
			
			/*
			| Send to the next page
			*/
			$next = rawurldecode(rawurldecode( $_POST['next'] ));

			$the_url = ( $next != '' ) ?  $next: $this->landing_page_url;

			header("Location:". $the_url);
			
		}
		else
		{
			print_r( $query->errorInfo() );
		}
	}
	
	/*
	| Een functie om de sessie die hierboven besproken word te stoppen, en de 
	| informatie uit de database te halen, de cookie te vernietigen en de
	| gebruiker terug te leiden naar waar hij/zij vandaan kwam.
	*/
	private function end_session()
	{
		$SQL = "DELETE FROM ".$this->logins_table." WHERE sid = '".$_COOKIE[$this->cookiename]."' AND ip = '".$this->get_ip()."'";

		$query = $this->verbinding->query( $SQL );

		if ( $query )
		{
			$secondes = $this->login_session_time * 3600;
			setcookie($this->cookiename, "", time()-$secondes, "/");	
			unset($_SESSION['fb_token']);
			unset($_SESSION['user_infocheck']);
			header("Location: ".ROOT);
		}




		
		
		
	}
	
	/*
	| De functie om gebruikers informatie op te halen en te controleren
	| of de gebruikers ingelogd is.
	*/
	public static function get_login_info($wat=false)
	{
		/*
		| Als de gebruikers niet is ingelogd 'false' retourneren.
		*/


		if(!self::$loginsessie || !count(self::$gebruikersinfo))
		{
			return false;
		}
		
		/*
		| Anders even wat controles uitvoeren wat er moet gebeuren
		*/
		else
		{
			/*
			| Alles van de gebruiker laten zien
			*/
			if($wat == '')
			{
				return self::$gebruikersinfo['info'];
			}
			
			/*
			| Een specefiek veld van de gebruiker latgeen zien
			*/
			elseif(isset(self::$gebruikersinfo['info'][$wat]))
			{
				return self::$gebruikersinfo['info'][$wat];	
			}
			
			/*
			| Anders true retourneren (zie eerste if() lus van deze functie)
			*/
			else
			{
				return true;
			}
		}
	}

	public function check_login()
	{
		if( ! $this->get_login_info('id') )
		{
			$current_url = rawurlencode($_SERVER[REQUEST_URI]);
			header('Location: '.$this->login_url.'&next='.rawurlencode($current_url));
		}
		else
		{
			return true;
		}
	}
}

/*
| Meteen maar een nieuwe instantie van deze klasse maken en meteen de __constructor() functie laden
| (in dit geval dus login(), de naam word door PHP bepaald aan de hand van de klasse naam)
*/
//users table, logins table, cookie name
$login = new login('nanousers', 'logins', 'nda');
//$login->cookiename = '';
$login->login_url = ROOT.'/login/';
$login->landing_page_url = ROOT.'/my-papers/';
$login->username_postfield = 'email';
$login->password_postfield = 'wachtwoord';



/*
| En de init functie aanaroepen
*/
$login->init();
?>