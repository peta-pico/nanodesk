<?php 

echo "<h1>Show Files</h1>";

if ($handle = opendir('.')) {

    while (false !== ($entry = readdir($handle))) {

        if ($entry != "." && $entry != "..") {

            echo "- $entry <br>";
        }
    }

    closedir($handle);
}

echo "<hr><br><br>";

$output=array();
$filename="nanopub_1";

if( file_exists("nanopub.jar") ) { echo "file exits nano <br>";}
else{ echo "nofile nano"; }

if( file_exists($filename.".trig") ) { echo "file exits ".$filename;}
else{ echo "nofile ".$filename; }

echo "<br><br>";

//use exec function
$output = exec("java -jar nanopub.jar mktrusty ".$filename.".trig",$output);
//var_dump($output);

if($_GET['publish'] == 1)
{
//publish the paper
 $output = exec("java -jar nanopub.jar publish trusty.".$filename.".trig",$output);


 echo '<strong>Output:</strong>'.$output.' <br><br>';

 if($output !='')
 {
 	echo '<strong>Your pub is being uploaded</strong><br><br>';
 }
 else{
 	echo '<strong>Your pub is NOT uploaded .. retry</strong><br><br>';
 }
 //var_dump($output);
}

//use system function
//$output = system("java -jar nanopub.jar mktrusty ".$filename."_2.trig",$output);
//var_dump($output);

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