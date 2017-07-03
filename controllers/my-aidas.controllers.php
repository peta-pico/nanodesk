<?php


if( ! $login->get_login_info('id') )
{
	$current_url = rawurlencode($_SERVER[REQUEST_URI]);
	header('Location: '.ROOT.'/login/&next='.rawurlencode($current_url));
}

$user_orcid = $login->get_login_info('orcid_id');

//
include('classes/aidas.class.php');
$aidas = new Aidas;
$data = $aidas->dataArray($user_orcid);

//add metatags
$head['meta']['title'] = "My Papers";
$head['meta']['description'] = "page to edit papers";
$head['meta']['robots'] = "index, follow";


?>
