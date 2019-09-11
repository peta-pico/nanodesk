<?php

class Core{

	protected static $db;

	private function __construct(){

		$host = DB_HOST;
		$dbname = DB_NAME;
		$dbuser = DB_USER;
		$dbpass = DB_PASSWORD;

		//--try catch
		try {
			self::$db = new PDO("mysql:host=$host;dbname=$dbname", $dbuser, $dbpass);
		}
		catch (PDOException $e) {
	   		$sMsg = '<p> 
	            Line: '.$e->getLine().'<br /> 
	            File: '.$e->getFile().'<br /> 
	            Error Message: '.$e->getMessage().' 
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