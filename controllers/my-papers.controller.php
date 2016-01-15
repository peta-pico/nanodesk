<?php 

if( ! $login->get_login_info('id') ){
	$current_url = rawurlencode($_SERVER[REQUEST_URI]);
	header('Location: '.ROOT.'/login/&next='.rawurlencode($current_url));
}


//add metatags
$head['meta']['title'] = "Edit paper";
$head['meta']['description'] = "page to edit papers";
$head['meta']['robots'] = "index, follow";

//add additional files 
#$head['add_files'] = [['<style,script,custom>',"<file path>"]];

// add to form action



// data needed for db

$user_id = $login->get_login_info('id');

$query = $db->prepare("SELECT * FROM papers WHERE user_id=? ORDER BY date DESC");
$query->execute( array($user_id) );

$papers = $query->fetchAll(PDO::FETCH_ASSOC);


?>