<?php

include('classes/users.class.php');

$users = new Users;
$user = $users->dataArray($_GET['var']);

//$functions->dumpArray($user);

//add metatags
$head['meta']['title'] = "Nanodesk Profile of ";
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
$data = file_get_contents("http://petapico.d2s.labs.vu.nl/api/database/api.php?search-uri=http%3A%2F%2Forcid.org%2F".$user_orcid."&head=on&assertion=on&provenance=on&pubinfo=on&format=json");


$papers = json_decode($data, true);

$query = $db->prepare('SELECT * FROM papers WHERE id=? AND user_id=? LIMIT 1');
$query->execute(array($_GET['var'], $user_id));
$paper = $query->fetch(PDO::FETCH_ASSOC);





//$functions->dumpArray($papers);

// echo "<pre>";
// echo 'Rows:'.count($papers)."<br>";
// print_r( json_decode($papers, true) );
// echo "</pre>";

?>
