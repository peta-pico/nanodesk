<?php 
//curl -LH "Accept: application/json"
//> http://dx.doi.org/10.1103/PhysRevX.4.041036
error_reporting(E_ALL & ~E_NOTICE);

$doi = 'http://dx.doi.org/10.1016/j.bushor.2015.03.006';


//$doi = (isset($_GET["doi"]) && $_GET["doi"] != "" ? $_GET["doi"] : "10.1037/0022-3514.65.6.1190");
$debug = (isset($_GET["debug"]) ? true : false);

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
	print_r($print);
  return $print;
}


function show_json_array($json_array, $debug=false) {

    echo "<pre class='json_array'>";
    print_r($json_array);
    echo "</pre>";
  
}

function doiData(){
$title        = $json_array["title"];
  $author_array = $json_array["author"];
  $jtitle       = $json_array["container-title"];
  $pages        = $json_array["page"];
  $volume       = $json_array["volume"];
  $issue        = $json_array["issue"];
  $issn_array   = $json_array["ISSN"];
  $url          = $json_array["URL"];
  $year         = $json_array["issued"]["date-parts"][0][0];
}

//$doi_url      = doi_url($doi);
$json         = get_curl($doi);
$json_array   = get_json_array($json);


?>



<?php show_json_array($json_array, $debug); ?>
