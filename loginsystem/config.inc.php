<?php
/*
| Dit is het configuratiebestand van het loginsysteem. Hier worden 
| bepaalde dingen ingesteld die door het gehele loginsysteem gebruikt
| worden.
|
| Gemaakt door Vlerknozem (dit hele loginsysteem eigenlijk!)
*/

# Een beveiliging om te voorkomen dat men 
# probeert je config.php te openen
if(basename($_SERVER['PHP_SELF']) == "config.php")
{
    # De bezoeker terug verwijden naar de index
    header("Location: ../index.php");
    
    # En stoppen met PHP uitvoeren, voor de zekerheid
    exit; 
}

$host = 'localhost';
$dbname = 'boekendeals';
$dbuser = 'root';
$dbpass = '';

# Een config array aanmaken
$cfg = array(); 

# De mysql host, waar je database op draait. Is meestal localhost
define("mysql_host", "localhost");

# De mysql gebruikersnaam. Is meestal niet root
define("mysql_user", $dbuser);

# Het mysql wachtwoord, is eigenlijk nooit leeg
define("mysql_password", $dbpass);

# De tabel waar het systeem op draait. Als je de SQL niet hebt uitgevoerd moet je deze aanpassen
define("mysql_database", $dbname);

# De login sessie tijd, het aantal uren dat je bent ingelogd dus.
define("login_session_time", 720);

# MD5 gebruiken om wachtwoorden te coderen? Staat standaard uit
define("login_password_md5", true);

# Fouten weergeven ? Alleen handig als je aan het testen bent!
define("show_errors", true);

/*
| De benodigde database velden instellen
| Elk veld dat je bij het registeren wilt hebben kan je hier toevoegen als nieuwe array waarde. 
| De syntax is: 'veldnaam:flag1|flag2'
| Het veldnaam en de flags scheid je met dubbele punt. De flags scheid je van elkaar met een verticaal streepje.
|
| Flags:
|	verplicht	= maak het veld verplicht
|	uniek		= De ingevulde waarde voor dit veld mag maar een keer gebruikt worden. (handig voor gebruikersnamen)
|	min=3		= Minimaal in te vullen karakters is in dit geval 3.
|	max=10		= Maximaal in te vullen karakters is in dit geval 10.
|	==wachtwoord2	= De ingevulde waarde van het huidge veld moet overeen komen met in dit geval de inhoud van het veld 'wachtwoord2'
|	email		= Er wordt gecontrolleerd of de ingevulde waarde voldoet aan de eisen van een geldig e-mailadres.
|	md5		= Codeer de ingevulde waarde naar md5.
*/
$database_velden = array();
array_push($database_velden, 'gebruikersnaam:verplicht|uniek|min=3|max=15');
array_push($database_velden, 'wachtwoord:verplicht|min=3|max=10|==wachtwoord2');
?>
