<?php

include('classes/users.class.php');

$users = new Users;
$user = $users->dataArray($_GET['var']);


include('classes/aidas.class.php');
$aidasData = new Aidas;
$aidas = $aidasData->dataArray($_GET['var']);


// $paper = $user['papers'];
// $functions->dumpArray($paper);
// echo "<br>";
// $functions->dumpArray($aida);
// echo '<br>--------<br>';
// $n = array_merge($paper,$aida);

// $functions->dumpArray($n);

//add metatags
$head['meta']['title'] = "Nanodesk Profile of ";
$head['meta']['description'] = "page to edit papers";
$head['meta']['robots'] = "index, follow";



?>
