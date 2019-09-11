<?php 

//check if user is logged in
if( ! $login->get_login_info('id') )
{
	$current_url = rawurlencode($_SERVER[REQUEST_URI]);
	header('Location: '.ROOT.'/login/&next='.rawurlencode($current_url));
}

// include papers class
include('classes/papers.class.php');

// user id
$user_id = $login->get_login_info('orcid_id');

$paper = new Papers;
$paperData = $paper->dataArray($_GET['var'], $user_id);



//add metatags
$head['meta']['title'] = $paperData['title'];
$head['meta']['description'] = "page to edit papers";
$head['meta']['robots'] = "index, follow";

//add additional files
//$head['add_files'] = [['<style,script,costum>',"<file path>"]];


?>