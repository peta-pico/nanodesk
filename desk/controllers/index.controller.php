<?php

//initate orcid_login class
include('classes/orcid_login.class.php');


//add metatags
$head['meta']['title'] = "Nanodesk";
$head['meta']['description'] = "Nanodeks, publish nanopublications with ease";
$head['meta']['robots'] = "index, follow";

//add additional files
#$head['add_files'] = [['<style,script,custom>',"<file path>"]];

//$login->check_login();

// if( ! $login->get_login_info('id') )
// {
// 	$current_url = rawurlencode($_SERVER[REQUEST_URI]);
// 	header('Location: '.$login->login_url.'&next='.rawurlencode($current_url));
// }


?>
