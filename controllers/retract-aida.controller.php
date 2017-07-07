<?php

include('classes/users.class.php');

if( ! $login->get_login_info('id') )
{
	$current_url = rawurlencode($_SERVER[REQUEST_URI]);
	header('Location: '.ROOT.'/login/&next='.rawurlencode($current_url));
}


include('classes/aidas.class.php');
$aidas = new Aidas;

$row = $aidas->dataArrayById($_GET['var'],$login->get_login_info('orcid_id'));


//---
// add metatags
//---
$head['meta']['title'] = "Delete Papers";
$head['meta']['description'] = "page to edit papers";
$head['meta']['robots'] = "index, follow";

?>
