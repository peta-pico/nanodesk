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
// $query->execute( array($user_id) );
//$papers = $query->fetchAll(PDO::FETCH_ASSOC);

//-- tobias's papaers
//$data = file_get_contents("http://petapico.d2s.labs.vu.nl/api/database/api.php?search-uri=http%3A%2F%2Forcid.org%2F0000-0002-1267-0234&page=1&head=on&assertion=on&provenance=on&pubinfo=on&format=json");


//-- user papaers

$data = file_get_contents("http://petapico.d2s.labs.vu.nl/api/database/api.php?search-uri=http%3A%2F%2Forcid.org%2F".$user_orcid."&head=on&assertion=on&provenance=on&pubinfo=on&format=json&page=1");
$papers = json_decode($data, true);



foreach ($papers as $nanopub)
{
	$rac = explode("/",$nanopub);
	$rac = end($rac);

	$np_online = NP_PUBISH_SERVER.$rac.'.jsonld.txt';
	//echo $np_online;
	$jsondata = json_decode(file_get_contents($np_online),true);

	//extract description
	$paper_title = $jsondata[1]['@graph'][1]['http://purl.org/dc/terms/description'][0]['@value'];

	echo $paper_title ? $paper_title.'<br>':'no title available<br>';
}








	//$jsondata = json_decode(file_get_contents('http://app.petapico.d2s.labs.vu.nl/nanopub-server/RAWHdFJKV-aYucpxh3oIDGanaDUMwa3PM5c25lCBHrzpM.jsonld.txt'),true);
	$jsondata = json_decode(file_get_contents('http://np.inn.ac/RAWHdFJKV-aYucpxh3oIDGanaDUMwa3PM5c25lCBHrzpM.jsonld.txt'),true);

//np_hash

//get doi
echo $jsondata[1]['@graph'][0]['http://example.org/hasRead'][0]['@id'].'<br>';
//get title
$title = $jsondata[1]['@graph'][1]['http://purl.org/dc/terms/description'][0]['@value'].'<br>';
print_r(explode('.',$title));
echo '<br>';


$functions->dumpArray( $jsondata, true  );

// echo "<pre>";
// echo 'Rows:'.count($papers)."<br>";
// print_r( json_decode($papers, true) );
// echo "</pre>";

?>
