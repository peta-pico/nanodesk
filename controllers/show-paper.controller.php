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

$paperData = new Papers;
$paper = $paperData->dataArray($_GET['var'], $user_id);

// $query = $db->prepare('SELECT * FROM papers WHERE id=? AND orcid_id=? LIMIT 1');
// $query->execute(array($_GET['var'], $user_id));
// $paper = $query->fetch(PDO::FETCH_ASSOC);

 $functions->dumpArray($paper);


//add metatags
$head['meta']['title'] = $paper['title'];
$head['meta']['description'] = "page to edit papers";
$head['meta']['robots'] = "index, follow";

//add additional files
//$head['add_files'] = [['<style,script,costum>',"<file path>"]];

?>
