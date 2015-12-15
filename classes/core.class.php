<?php

class Core{

	protected static $db;

	private function __construct(){

		$host = 'localhost';
		$dbname = 'nanodesk';
		$dbuser = 'root';
		$dbpass = '';

		//--try catch
		try {
			self::$db = new PDO("mysql:host=$host;dbname=$dbname", $dbuser, $dbpass);
		}
		catch (PDOException $e) {
	   		$sMsg = '<p> 
	            Regelnummer: '.$e->getLine().'<br /> 
	            Bestand: '.$e->getFile().'<br /> 
	            Foutmelding: '.$e->getMessage().' 
	        </p>'; 
	     
	    	trigger_error($sMsg);
		}

	}// end construct

	public static function dbConnect(){

		//Guarantees single instance, if no connection object exists then create one.
		if(!self::$db){

			//new connection object.
			new core();
		}

		//return connection.
		return self::$db;
	}




}//end class

$db = Core::dbConnect();
?>


