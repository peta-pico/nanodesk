<?php

//check if user is logged in
if( ! $login->get_login_info('id') )
{
	$current_url = rawurlencode($_SERVER[REQUEST_URI]);
	header('Location: '.ROOT.'/login/&next='.rawurlencode($current_url));
}

/*
/ Class for all trig file functions
*/
include('classes/trig.class.php');
$trig = new trig;

//add metatags
$head['meta']['title'] = "Edit paper";
$head['meta']['description'] = "page to edit papers";
$head['meta']['robots'] = "index, follow";

//add additional files
//$head['add_files'] = [['<style,script,costum>',"<file path>"]];

// user id
$user_id = $login->get_login_info('id');

$query = $db->prepare('SELECT * FROM papers WHERE id=? AND user_id=? LIMIT 1');
$query->execute(array($_GET['var'], $user_id));
$paper = $query->fetch(PDO::FETCH_ASSOC);

?>
