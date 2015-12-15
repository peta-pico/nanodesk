<?php 

//add metatags
$head['meta']['title'] = "The Title tag";
$head['meta']['description'] = "description";
$head['meta']['robots'] = "index, follow";

//add additional files 
#$head['add_files'] = [['<style,script,custom>',"<file path>"]];

if( ! $login->get_login_info('id') ){
	$current_url = rawurlencode($_SERVER[REQUEST_URI]);
	header('Location: '.ROOT.'/login/&next='.rawurlencode($current_url));
}


?>