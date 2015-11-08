<?php 
//include controller
session_start();
error_reporting(E_ALL & ~E_NOTICE);


// depencencies
include('includes/config.inc.php');
include('classes/head.class.php');

//global head file
$head = array();

//---[start] all in controller

//add metatag files
$head['meta']['title'] = "The Title tag";
$head['meta']['description'] = "description";
$head['meta']['robots'] = "index, follow";

//add additional files 
#$head['add_files'] = [['<style,script,custom>',"<file path>"]];

//---[end] end controller


//include head (start html)
include('head.php');

//include view
include('views/index.view.php'); 

//end html
include('footer.php');


?>