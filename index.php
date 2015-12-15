<?php 
//include controller
session_start();
error_reporting(E_ALL & ~E_NOTICE);



// depencencies
include('includes/config.inc.php');
include('classes/head.class.php');
include('classes/core.class.php');
include('classes/functions.class.php');
include('loginsystem/header.inc.php');

$start_mc_time = microtime_float();

//global variables
$head = array();


//global read page
$p = $_GET['p'];
if($p ==''){
	$p = 'index';
}

echo $_GET['a'];



//include controller (contains all the logic that needs to be displayed on the view)
// it can sometimes contain arrays that need to be looped into the view (requires minimal logical coding in the view)
include('controllers/'.$p.'.controller.php');

//include start of html
include('head.php');

//include view
include('views/'.$p.'.view.php'); 


$end_mc_time = microtime_float();
echo $end_mc_time - $start_mc_time;

//include end html
include('footer.php');

?>