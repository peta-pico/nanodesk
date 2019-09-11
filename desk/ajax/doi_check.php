<?php

error_reporting(E_ALL & ~E_NOTICE);


function doi_url($doi)
{
  return "http://dx.doi.org/" . $doi;
}

function get_curl($url)
{
  $curl = curl_init();
  $header[0] = "Accept: application/rdf+xml;q=0.5,";
  $header[0] .= "application/vnd.citationstyles.csl+json;q=1.0";
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_USERAGENT, 'Googlebot/2.1 (+http://www.google.com/bot.html)');
  curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
  curl_setopt($curl, CURLOPT_REFERER, 'http://www.google.com');
  curl_setopt($curl, CURLOPT_AUTOREFERER, true);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($curl, CURLOPT_TIMEOUT, 10);
  $json = curl_exec($curl);
  curl_close($curl);
  //print_r($json);
  return $json;
}

function get_json_array($json)
{
	$print = json_decode($json, true);
	//print_r($print);
 	return $print;
}


function show_json_array($json_array, $debug=false) {

    echo "<pre class='json_array'>";
    print_r($json_array);
    echo "</pre>";
}

function doiData($json_array)
{

	$data = array();

	$data['doi']    = $json_array["DOI"];
	$data['title']    = ($json_array["title"] !='') ? $json_array["title"]: "null";
	$data['author']   = '';

	if( count($json_array["author"]) > 5)
	{

		for($i=0; $i < 5; $i++)
		{
			$data['author'] .= $json_array["author"][$i]['family'].', ';
		}

		$data['author'] = substr($data['author'],0,-2);
		$data['author'] .= ' et al';
	}
	else
	{
		if(count($json_array["author"]) > 0)
		{
			foreach ($json_array["author"] as $key)
			{
				$data['author'] .= $key['family'].', ';
			}
			$data['author'] = substr($data['author'],0,-2);
		}
	}


	$data['journal']  = $json_array["container-title"];
	$data['pages']    = $json_array["page"];
	$data['volume']   = $json_array["volume"];
	$data['issue']    = $json_array["issue"];
	//$issn_array   = $json_array["ISSN"];
	//$url          = $json_array["URL"];
	$data['year']     = $json_array["issued"]["date-parts"][0][0];

	// end check data count
	//echo $data['title'];

  return json_encode( $data );
}





$doi = $_POST['doi'];
$doi = doi_url($doi);

$json         = get_curl($doi);

$json_array   = get_json_array($json);

echo doiData( $json_array );
?>
