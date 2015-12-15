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
include_once("config.inc.php");

/*
| Nu beginnen we aan de klasse, dit is een simpele klasse die 
| niets meer en niets minder doet dan waarvoor hij gemaakt is:
| gebruikersauthenticatie.
*/
class login
{

	public $verbinding,$cookiename="nd_sid";

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
	public function __construct()
	{
		/*
		| Verbinding maken met de database. De informatie word uit config.php 
		| gehaald om te kunnen verbinden.
		*/
		$this->verbinding = mysqli_connect(mysql_host, mysql_user, mysql_password,mysql_database);
		#mysqli_select_db(mysql_database, $verbinding);
		
		/*
		| Als er fouten zijn en fouten mogen getoond worden dan 
		| worden ze nu opgeroepen (en later pas weergegeven!)
		*/
		if(show_errors == true && mysql_error())
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
	
	/*
	| De init functie. Deze zorgt ervoor dat wanneer de gebruiker inlogt of registreert
	| hij/zij de juiste pagina voor z'n neus krijgt.
	*/
	public function init()
	{
		/*
		| Iemand heeft ergens een formulier verzonden wat bij dit loginsysteem hoort
		*/
		if($_SERVER['REQUEST_METHOD'] == "POST" && self::$loginsessie === false)
		{
			/*
			| En het 'actie' veld is gezet, tijd voor wat actie.
			*/
			if(isset($_POST['actie']))
			{
				/*
				| Om een grote if-else lussen constructie tegen te 
				| gaan doen we het in een switch, dat is makeklijker
				| uit te breiden.
				*/
				switch($_POST['actie'])
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
	private function controleer_gegevens()
	{
		/*
		| Het actie veld is gezet en de waarde is ook goed
		*/
		if(isset($_POST['actie']) && $_POST['actie'] == "login")
		{
			/*
			| Even de gebruikersnaam en wachtwoord beveiligen 
			| voordat we deze in de database gooien
			*/
			#$gebruiker = mysql_real_escape_string($_POST['gebruikersnaam']);
			#$wachtwoord = mysql_real_escape_string($_POST['wachtwoord']);
			$gebruiker = $_POST['gebruikersnaam'];
			$wachtwoord = $_POST['wachtwoord'];
			
			/*
			| Als je in config.php hebt ingesteld dat wachtwoorden
			| gecodeerd moeten worden moet MD5, dan doen we dat hier
			*/
			if(login_password_md5 === true)
			{
				$wachtwoord = sha1(md5($wachtwoord));
			}
			
			/*
			| Een query uitvoeren om te kijken of de gebruiker in de database zit
			*/
			$query = mysqli_query($this->verbinding,"SELECT * FROM users2 WHERE email = '$gebruiker' AND password = '$wachtwoord' LIMIT 1");
			
			/*
			| Als dat zo is moet de gebruikersinfo array gevuld worden met informatie,
			| en er moet een sessie gestart worden.
			*/
			if(mysqli_num_rows($query))
			{
				self::$gebruikersinfo = array();
				self::$gebruikersinfo['info'] = mysqli_fetch_array($query);
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
					(show_errors == true) ? trigger_error("Er is een MySQL fout opgetreden:<br />".mysql_error(), E_USER_ERROR) : $this->fouten = "Er is een MySQL fout opgetreden";
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
		| al instaat om mee te beginnen)
		|
		| Is dat zo dan word self::$loginsessie waar en
		| word self::$gebruikersinfo['info'] met de juiste
		| velden gevuld
		|
		| Zo niet, dan word $this->recheck een groter
		*/
		if(isset($_COOKIE[$this->cookiename]) && !empty($_COOKIE[$this->cookiename]))
		{
			$sid = $_COOKIE[$this->cookiename];
			$query = mysqli_query($this->verbinding,"SELECT * FROM logins WHERE sid = '".$sid."' AND ip = '".$this->get_ip()."'") or die(mysql_error());
			if(mysqli_num_rows($query))
			{
				#$f = mysql_fetch_array($query);
				$f = mysqli_fetch_object($query);
				$query = mysqli_query($this->verbinding,"SELECT * FROM users2 WHERE id = '".$f->uid."'") or die(mysql_error());
				if(mysqli_num_rows($query))
				{
					self::$loginsessie = true;
					self::$gebruikersinfo = array();
					self::$gebruikersinfo['info'] = mysqli_fetch_array($query);
				}
			}
		}
		else
		{
			$secondes = login_session_time * 3600;
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
		$SQL  = "INSERT INTO logins ";
		$SQL .= "SET uid	= '". $info['id'] ."' ";
		$SQL .= ",   sid   = '". self::$gebruikersinfo['sleutel'] ."' ";
		$SQL .= ",   ip	= '". $this->get_ip() ."' ";
		$SQL .= ",   datum = NOW() ";
		mysqli_query($this->verbinding,$SQL) or die("Error: kon niet inloggen. :".mysqli_error($this->verbinding));
		$secondes = login_session_time * 3600;
		setcookie("nd_sid", self::$gebruikersinfo['sleutel'], time()+$secondes, "/");
		header("Location: ".$_SERVER['REQUEST_URI']);
	}
	
	/*
	| Een functie om de sessie die hierboven besproken word te stoppen, en de 
	| informatie uit de database te halen, de cookie te vernietigen en de
	| gebruiker terug te leiden naar waar hij/zij vandaan kwam.
	*/
	private function end_session()
	{
		mysqli_query($this->verbinding,"DELETE FROM logins WHERE sid = '".$_COOKIE[$this->cookiename]."' AND ip = '".$this->get_ip()."'") or die(mysql_error());
		$secondes = login_session_time * 3600;
		setcookie($this->cookiename, "", time()-$secondes, "/");
		unset($_SESSION['fb_token']);
		unset($_SESSION['user_infocheck']);
		$url = str_replace("&actie=uitloggen/", "", $_SERVER['REQUEST_URI']);
		#header("Location: ".$url);
		header("Location: ".ROOT);
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
			if($wat === 'alles')
			{
				return self::$gebruikersinfo['info'];
			}
			
			/*
			| Een specefiek veld van de gebruiker laten zien
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
}

/*
| Meteen maar een nieuwe instantie van deze klasse maken en meteen de __constructor() functie laden
| (in dit geval dus login(), de naam word door PHP bepaald aan de hand van de klasse naam)
*/
$login = new login();

/*
| De benodigde database velden instellen
*/
$login->database_velden = $database_velden;

/*
| En de init functie aanaroepen
*/
$login->init();
?>
