<?php

// check if logged in
if( ! $login->get_login_info('id') )
{
	$current_url = rawurlencode($_SERVER[REQUEST_URI]);
	header('Location: '.ROOT.'/login/&next='.rawurlencode($current_url));
}

include('classes/users.class.php');
include('classes/trig.class.php');

$users = new Users;
$user = $users->dataArray( $login->get_login_info('orcid_id') );
$user_orcid = $login->get_login_info('orcid_id');


//add metatags
$head['meta']['title'] = "My Papers";
$head['meta']['description'] = "page to edit papers";
$head['meta']['robots'] = "index, follow";

?>
