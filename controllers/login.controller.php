<?php 

//add metatags
$head['meta']['title'] = "Login";
$head['meta']['description'] = "Login to acces your profile";
$head['meta']['robots'] = "no-index, no-follow";

//add additional files 
#$head['add_files'] = [['style | script | custom>',"<file path>"]];


//check if user is logged in
if( $login->get_login_info('id') ){


	/*
	| The user is now logged in
	*/
	
	if($_GET['next'] != '')
	{

		$next = rawurldecode($_GET['next']);
	}
	else
	{
		$next = ROOT.'/';
	}

	header('Location: '.$next);
}
?>