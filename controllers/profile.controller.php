<?php

include('classes/users.class.php');

$users = new Users;
$user = $users->dataArray($_GET['var']);

//$functions->dumpArray($user);

//add metatags
$head['meta']['title'] = "Nanodesk Profile of ";
$head['meta']['description'] = "page to edit papers";
$head['meta']['robots'] = "index, follow";



?>
