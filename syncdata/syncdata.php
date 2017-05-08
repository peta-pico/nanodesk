<?php
//
$argv;


die('i died');
//invokes basic info
include('../config.inc.php');

//invokes $db for database operations
include('../classes/core.class.php');

include('../classes/trig.class.php');
$trig = new Trig;

include('../classes/functions.class.php');
$functions = new Functions;


//$data = file_get_contents("data.txt");
$data = "data.txt";
$papers = json_decode(file_get_contents($data), true);


echo "<hr>";
//echo "Total Nanopubs = ". count($papers)/4;

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
		$title = $paper[1]['@graph'][0]['http://purl.org/dc/terms/title'][0]['@value'];
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
?>
