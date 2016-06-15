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

$user = $login->get_login_info('id');
$user_orcid = $login->get_login_info('orcid_id');

// $query = $db->prepare("SELECT * FROM papers WHERE user_id=? ORDER BY date DESC");
// $query->execute( array($user_id) );
//$papers = $query->fetchAll(PDO::FETCH_ASSOC);

//-- tobias's papaers
$data = file_get_contents("http://petapico.d2s.labs.vu.nl/api/database/api.php?search-uri=http%3A%2F%2Forcid.org%2F0000-0002-1267-0234&page=1&head=on&assertion=on&provenance=on&pubinfo=on&format=json");

//-- user papaers
//$data = file_get_contents("http://petapico.d2s.labs.vu.nl/api/database/api.php?search-uri=http%3A%2F%2Forcid.org%2F".$user_orcid."&head=on&assertion=on&provenance=on&pubinfo=on&format=json");


$papers = json_decode($data, true);


//$functions->dumpArray($papers);

echo "<pre>";
echo 'Rows:'.count($papers)."<br>";
print_r( json_decode($papers, true) );
echo "</pre>";

?>

