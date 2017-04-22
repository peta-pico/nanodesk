<?php
//
// check if it is a nanopub


//invokes $db for database operations
include('../config.inc.php');

//invokes $db for database operations
include('../classes/core.class.php');

include('../classes/trig.class.php');
$trig = new Trig;

include('../classes/functions.class.php');
$functions = new Functions;

//Set database
// $query = $db->prepare("INSERT INTO papers
// (date, title, year, orcid_id, hash, hash_url )
// VALUES()
//
// ");


//$data = file_get_contents("data.txt");
$data = "data.txt";
$papers = json_decode(file_get_contents($data), true);


echo "<hr>";

echo "Total Nanopubs = ". count($papers)/4;

echo "<hr>";



$all_nanos = '';

$i=1;
$y=0;

// seperate the whole file
// every nanopub as 4 pieces.
foreach($papers as $paper)
{
	if($i==1)
	{
		$all_nanos[$y] = array();
	}

 	array_push($all_nanos[$y], $paper);

	if( $i%4 == 0 )
	{
		$i=0;
		$y++;
	}
	$i++;
}

//echo $all_nanos[0][0]['@graph'][0]['@id'].'<br>';
//now read nanopubs

// prepare statement

$query = $db->prepare("INSERT INTO papers
(date, orcid_id, doi, doi_url, np_uri, np_hash, title, year, paper_data)
VALUES( NOW(),:orcid_id, :doi, :doi_url, :np_uri, :np_hash, :title, :year, :paper_data)
");


$i=0;
foreach	($all_nanos as $paper)
{
	//print_r($paper);
	//
	$np_hash =  $trig->getHashFromUrl($paper[0]['@graph'][0]['@id']);
	$orcid = $trig->getHashFromUrl($paper[1]['@graph'][1]['@id']);
	$np_uri = $paper[0]['@graph'][0]['@id'];
	$cite = $paper[1]['@graph'][0]['http://purl.org/dc/terms/bibliographicCitation'][0]['@value'];
	$title = $paper[1]['@graph'][0]['http://purl.org/dc/terms/title'][0]['@value'].'<br>';
	$year = $paper[1]['@graph'][0]['http://purl.org/spar/fabio/hasPublicationYear'][0]['@value'];
	$doi_url = $paper[1]['@graph'][0]['@id'];
	$remove = array('http://dx.doi.org/','https://dx.doi.org/','http://doi.org/','https://doi.org/');
	$doi = str_replace($remove,'',$paper[1]['@graph'][0]['@id']);
	$doi_url = $paper[1]['@graph'][0]['@id'];
	$paper_data = 'abc';
	echo '---<br>';

	$query->bindValue(':orcid_id', htmlspecialchars($orcid,ENT_QUOTES), PDO::PARAM_STR);
	$query->bindValue(':doi', htmlspecialchars($doi,ENT_QUOTES), PDO::PARAM_STR);
	$query->bindValue(':doi_url', htmlspecialchars($doi_url,ENT_QUOTES), PDO::PARAM_STR);
	$query->bindValue(':np_uri', htmlspecialchars($np_uri,ENT_QUOTES), PDO::PARAM_STR);
	$query->bindValue(':np_hash', htmlspecialchars($np_hash,ENT_QUOTES), PDO::PARAM_STR);
	$query->bindValue(':title', htmlspecialchars($title,ENT_QUOTES), PDO::PARAM_STR);
	$query->bindValue(':year', $year, PDO::PARAM_INT);
	$query->bindValue(':paper_data', $paper_data, PDO::PARAM_STR);

	$query->execute();
	// insert ino db



	$i++;
}



//echo count($all_nanos);
//echo "<hr>";
//$functions->dumpArray($all_nanos);

	// echo $trig->getHashFromUrl($paper[0]['@graph'][0]['@id']).'<br>';
	// echo $trig->getHashFromUrl($paper[1]['@graph'][1]['@id']).'<br>';
	// echo $paper[0]['@graph'][0]['@id'].'<br>';
	// echo $paper[1]['@graph'][0]['http://purl.org/dc/terms/bibliographicCitation'][0]['@value'].'<br>';
	// echo $paper[1]['@graph'][0]['http://purl.org/dc/terms/title'][0]['@value'].'<br>';
	// echo $paper[1]['@graph'][0]['http://purl.org/spar/fabio/hasPublicationYear'][0]['@value'].'<br>';
	// echo $paper[1]['@graph'][0]['@id'].'<br>';










//$functions->dumpArray( $papers, true  );


// foreach($papers as $nanopub)
// {
// 	$rac = explode("/",$nanopub);
// 	$rac = end($rac);
//
// 	$np_online = NP_PUBISH_SERVER.$rac.'.jsonld.txt';
// 	//echo $np_online;
// 	$jsondata = json_decode(file_get_contents($np_online),true);
//
// 	//extract description
// 	$paper_title = $jsondata[1]['@graph'][1]['http://purl.org/dc/terms/description'][0]['@value'];
//
// 	echo $paper_title ? $paper_title.'<br>':'no title available<br>';
// }
//






//
// 	//$jsondata = json_decode(file_get_contents('http://app.petapico.d2s.labs.vu.nl/nanopub-server/RAWHdFJKV-aYucpxh3oIDGanaDUMwa3PM5c25lCBHrzpM.jsonld.txt'),true);
// 	$jsondata = json_decode(file_get_contents('http://np.inn.ac/RAWHdFJKV-aYucpxh3oIDGanaDUMwa3PM5c25lCBHrzpM.jsonld.txt'),true);
//
// //np_hash
//
// //get doi
// echo $jsondata[1]['@graph'][0]['http://example.org/hasRead'][0]['@id'].'<br>';
// //get title
// $title = $jsondata[1]['@graph'][1]['http://purl.org/dc/terms/description'][0]['@value'].'<br>';
// print_r(explode('.',$title));
// echo '<br>';
//
//
// $functions->dumpArray( $jsondata, true  );

?>
