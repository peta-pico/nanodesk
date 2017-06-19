<?php


if( ! $login->get_login_info('id') )
{
	$current_url = rawurlencode($_SERVER[REQUEST_URI]);
	header('Location: '.ROOT.'/login/&next='.rawurlencode($current_url));
}

include('classes/users.class.php');

$users = new Users;
$user = $users->dataArray( $login->get_login_info('orcid_id') );
$user_orcid = $login->get_login_info('orcid_id');

// echo "<pre>";
// print_r($user['papers']);
// echo "</pre>";
//add metatags
$head['meta']['title'] = "My Papers";
$head['meta']['description'] = "page to edit papers";
$head['meta']['robots'] = "index, follow";

//add additional files
#$head['add_files'] = [['<style,script,custom>',"<file path>"]];

// add to form action



// data needed for db


// $query = $db->prepare("SELECT * FROM papers WHERE user_id=? ORDER BY date DESC");
// $query->execute( array($user_orcid) );
// $db_papers = $query->fetchAll(PDO::FETCH_ASSOC);

//-- tobias's papaers
//$data = file_get_contents("http://petapico.d2s.labs.vu.nl/api/database/api.php?search-uri=http%3A%2F%2Forcid.org%2F0000-0002-1267-0234&page=1&head=on&assertion=on&provenance=on&pubinfo=on&format=json");


//-- user papaers
//has read filter
//http://petapico.d2s.labs.vu.nl/api/database/api.php?search-uri=http%3A%2F%2Forcid.org%2F0000-0003-3734-6091%0D%0Ahttp%3A%2F%2Fexample.org%2FhasRead%0D%0A&page=1&begin_timestamp=&end_timestamp=&order=1&head=on&assertion=on&provenance=on&pubinfo=on&format=json

$data = file_get_contents("http://petapico.d2s.labs.vu.nl/api/database/api.php?search-uri=http%3A%2F%2Forcid.org%2F".$user_orcid."&head=on&assertion=on&provenance=on&pubinfo=on&format=json&page=1");
$papers = json_decode($data, true);





$np_online = NP_PUBISH_SERVER.'RAWHdFJKV-aYucpxh3oIDGanaDUMwa3PM5c25lCBHrzpM.jsonld.txt';


//$functions->dumpArray( json_decode(file_get_contents($np_online),true) );

// echo "<pre>";
// echo 'Rows:'.count($papers)."<br>";
// print_r( json_decode($papers, true) );
// echo "</pre>";

?>
