<?php
/*
| This is the main file for the entire system for logging in.
| It contains one class that takes care of everything.
|
| The security can be found in config.php and also additional explanation
*/
if(basename($_SERVER['PHP_SELF']) == "header.php")
{
	header("Location: ../index.php");
}

/*
| Load the configuration file to connect with the database
| and to get other settings that are needed later in time.
*/
//include_once("config.inc.php");

/*
| This class takes care of the userauthentication.
*/
class login
{

	/*
	| settings for logging in
	*/
	var $show_errors = true;

	//-- name of the cookie
	var $cookiename;

	//-- time of the session
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
	| database connection variable
	*/
	protected $db;
	protected $verbinding;

	/*
	| The variable for knowing if the user is logged in,
	| which is standard not the case.

	*/
	private static $loginsessie = false;

	/*
	| Variables for saving the given errors of the system
	*/
	public $fouten = "";

	/*
	| Variable to save information about the user
	*/
	private static $gebruikersinfo = array();

	/*
	| Variable to save database fields.
	*/
	public $database_velden = array();

	/*
	| Counter to check how many times an user has tried to login.
	*/
	private $recheck = 0;


	/*
	| This function is being called when the class is loaded.
	| The connection with the database is being initiated,
	| checked whether there is already a session running and
	| waiteed for the user to log out.
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
		| Connect with the database, based on the information in config.php
		*/
		$this->verbinding = Core::dbConnect();

		//$this->verbinding = mysqli_connect(mysql_host, mysql_user, mysql_password,mysql_database);
		//mysqli_select_db(mysql_database, $verbinding);

		/*
		| When there are errors that are allowed to be displayed
		| they are being called and displayed later.
		*/
		if($this->show_errors == true && !$this->verbinding  )
		{
			throw new Exception("MySQL liep tegen de volgende fout aan: <br />".mysql_error());
		}

		/*
		| Check for a login session.
		*/
		$this->check_session();

		/*
		| Connecting the logout action with the end_sessionn function
		| which logs people out.
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
	| The init function, this ensures that when people login or registers themselves,
	| he/or she gets displayed the right page.
	*/
	public function init()
	{
		/*
		| Check of every required field is filled in.
 		*/
		$this->checkRequiredVariables();

		/*
		| Somebody send a form that is part of the loginsystem.
		*/

		if( ($_SERVER['REQUEST_METHOD'] == "POST" && self::$loginsessie === false) )
		{
			//die('going to work...');

			/*
			| `The action field is set.
			*/
			if( isset($_POST['actie']) )
			{
				/*
				| We are using a switch to emit large if-else clauses.
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
	| Check the Ip of the user.
	*/
	public function get_ip()
	{
		/*
		| When PHP uses $_SERVER,
		| and does multiple tries to get the ip address
		| and tries to write it in  $realip .
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
		| When PHP doesnt use $_SERVER
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
		| Return the variable such that it can be used.
		*/
		return $realip;
	}


	/*
	| a function to check the data of users that want to login.
	*/
	//private function controleer_gegevens()
	public function controleer_gegevens($orcid_id=false)
	{
		/*
		| Set the action field
		*/
		if(isset($_POST['actie']) && $_POST['actie'] == "login" || $orcid_id !='' )
		{


			/*
			| Secure the username and password before writing it into the databawse.
	
			*/
			#$gebruiker = mysql_real_escape_string($_POST['gebruikersnaam']);
			#$wachtwoord = mysql_real_escape_string($_POST['wachtwoord']);
			$gebruiker = $_POST[$this->username_postfield];
			$wachtwoord = $_POST[$this->password_postfield];

			/*
			| When in config.php is set that passwords need to be checked
			| then it is done over here.
			*/
			if($this->login_password_md5 === true)
			{
				$wachtwoord = sha1(md5($wachtwoord));
			}

			/*
			| Run a query to check whether the user is in the database
			*/
			$query = $this->verbinding->prepare("SELECT * FROM ".$this->users_table." WHERE orcid_id=? LIMIT 1");

			if( !$query->execute( array( $orcid_id ) ) )
			{
				print_r( $query->errorInfo() );
				die('Query error '.__LINE__);
			}


			/*
			| When this is the case the user information array needs to be filled,
			| and a session needs to be started.
			
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
			| User is not inside the database display errors.
			*/
			else
			{
				/*
				| When there is a MySQL error then display this,
				| When there is no such an error then the username and/ or password is wrong.
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
	| Check whether a user is already logged in.
	*/
	private function check_session()
	{
		/*
		| Check whether the $recheck variable hasn't become to large
		| Otherwise, show an erro and return false.
		*/
		if($this->recheck >= 3)
		{
			$this->fouten = "Er is een ongeldige sleutel gevonden.";
			return false;
		}

		/*
		| When the cookie (sid) is set and is not empty
		| check if the key of the cookie matches the key
		| of the database when it is in the database.
		|
		| Is this the case than will self::$loginsessie and
		| self::$gebruikersinfo['info'] being filled with the
		| right data/
		|
		| Otherwise, $this->recheck is becoming bigger.
		*/

		if(isset($_COOKIE[$this->cookiename]) && !empty($_COOKIE[$this->cookiename]))
		{
			/*
			| The value of the cookie with the cookie name
			*/
			$sid = $_COOKIE[$this->cookiename];

			/*
			| Start query
			*/
			$q = "SELECT * FROM ".$this->logins_table." WHERE sid=? AND ip=? LIMIT 1";

			$query = $this->verbinding->prepare( $q );
			if( $query->execute( array( $sid , $this->get_ip() ) ) )
			{
				//-- Get user data
				$row  = $query->fetch();
				if($query->rowCount() == 1 )
				{
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
	| Start the session mentioned above, save the right information in the database
	| make a cookie and redirect the user where he or she came from.
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
	| A function to stop the session mentioned above and delete the information
	| in the database, destroy the cookie and redirect the user back where
	| he or she came from.
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
	| Function to get the user information and check whether he/or she is logged in
	*/
	public static function get_login_info($wat=false)
	{
		/*
		| When not logged in return false
		*/


		if(!self::$loginsessie || !count(self::$gebruikersinfo))
		{
			return false;
		}

		/*
		| Otherwise, some checks to know what needs to be done
		*/
		else
		{
			/*
			| Show everything of the user
			*/
			if($wat == '')
			{
				return self::$gebruikersinfo['info'];
			}

			/*
			| Show a specific field of the user.
			*/
			elseif(isset(self::$gebruikersinfo['info'][$wat]))
			{
				return self::$gebruikersinfo['info'][$wat];
			}

			/*
			| Otherwise return true
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
| Immediately make a new instance of this class and load thede __constructor() function 
| (in this case login(), the name is named by php based on the class name
*/
//users table, logins table, cookie name
$login = new login('nanousers', 'logins', 'nda');
//$login->cookiename = '';
$login->login_url = ROOT.'/login/';
$login->landing_page_url = ROOT.'/my-papers/';
$login->username_postfield = 'email';
$login->password_postfield = 'wachtwoord';



/*
| call the init function
*/
$login->init();
?>
