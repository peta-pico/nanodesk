<?php

include('classes/users.class.php');

if( ! $login->get_login_info('id') )
{
	$current_url = rawurlencode($_SERVER[REQUEST_URI]);
	header('Location: '.ROOT.'/login/&next='.rawurlencode($current_url));
}

$users = new Users;
$user = $users->dataArray( $login->get_login_info('id') );
$user_orcid = $login->get_login_info('orcid_id');


$query = $db->prepare("SELECT * FROM papers WHERE id=? LIMIT 1");
$query->execute( array($_GET['var']) );
$row = $query->fetch();

// echo "<pre>";
// print_r($user['papers']);
// echo "</pre>";
//add metatags
$head['meta']['title'] = "Delete Papers";
$head['meta']['description'] = "page to edit papers";
$head['meta']['robots'] = "index, follow";







//$functions->dumpArray( json_decode(file_get_contents($np_online),true) );

// echo "<pre>";
// echo 'Rows:'.count($papers)."<br>";
// print_r( json_decode($papers, true) );
// echo "</pre>";

?>
