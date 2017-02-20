<?php
//curl -LH "Accept: application/json"
//> http://dx.doi.org/10.1103/PhysRevX.4.041036
error_reporting(E_ALL & ~E_NOTICE);




//$doi = (isset($_GET["doi"]) && $_GET["doi"] != "" ? $_GET["doi"] : "10.1037/0022-3514.65.6.1190");
//$debug = (isset($_GET["debug"]) ? true : false);

function doi_url($doi)
{
  return "http://dx.doi.org/" . $doi;
  //return "http://data.crossref.org/" . $doi;
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
	foreach ($json_array["author"] as $key)
	{
		$data['author'] .= $key['given'].' '.$key['family'].', ';
	}
	$data['author'] = substr($data['author'],0,-2);
//:[{"given":"Tom","family":"Heath","affiliation":[]},
  $json_array["author"][0]['family'].','.$json_array["author"][0]['given'];



  $data['journal']  = $json_array["container-title"];
  $data['pages']    = $json_array["page"];
  $data['volume']   = $json_array["volume"];
  $data['issue']    = $json_array["issue"];
  //$issn_array   = $json_array["ISSN"];
  //$url          = $json_array["URL"];
  $data['year']     = $json_array["issued"]["date-parts"][0][0];


  //echo $data['title'];

  return json_encode( $data );
}





$doi = $_POST['doi'];
$doi      		= doi_url($doi);
//echo $doi;

$json         = get_curl($doi);

//print_r($json);

$json_array   = get_json_array($json);

//print_r($json_array);
// echo "<br><br>---------------------------------<br><br>";
//echo "<pre>";
//print_r(   $json_array );
//echo "</pre>";

echo doiData( $json_array );
?>
