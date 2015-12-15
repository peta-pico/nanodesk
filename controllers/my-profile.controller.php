<?php 

/*
| Check if user is logged in
*/
if( ! $login->get_login_info('id') ){
	$current_url = rawurlencode($_SERVER[REQUEST_URI]);
	header('Location: '.ROOT.'/login/&next='.rawurlencode($current_url));
}

/*
| The user is logged in and may access data
*/

//add metatags
$head['meta']['title'] = "Edit paper";
$head['meta']['description'] = "page to edit papers";
$head['meta']['robots'] = "index, follow";

?>