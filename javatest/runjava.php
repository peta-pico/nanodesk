<?php 

echo "<h1>Show Files</h1>";

if ($handle = opendir('.')) {

    while (false !== ($entry = readdir($handle))) {

        if ($entry != "." && $entry != "..") {

            echo "$entry\n";
        }
    }

    closedir($handle);
}


$output=array();
$filename="19_0000-0000-0000-0000";

if( file_exists("nanopub.jar") ) { echo "file exits nano <br>";}
else{ echo "nofile nano"; }

if( file_exists($filename.".trig") ) { echo "file exits ".$filename;}
else{ echo "nofile ".$filename; }

echo "<br><br>";

//use exec function
 $output = exec("java -jar nanopub.jar mktrusty ".$filename."_1.trig",$output);
var_dump($output);

//use system function
 $output = system("java -jar nanopub.jar mktrusty ".$filename."_2.trig",$output);
var_dump($output);

echo "<br><br>";


 $output = shell_exec("whoami");
        echo "<strong>WHOAMI</strong>";
        echo "<hr/>";
        echo "$output<br/><br/><br/><br/>";
 

$output = system("java -version 2>&1");
        echo "<strong>Java Version Before Setting Environmental Variable</strong>";
        echo "<hr/>";
        echo "$output<br/><br/><br/><br/>";

?>