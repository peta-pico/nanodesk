<?php 

$root  = "http://localhost/github/nanodesk";
define('ROOT', $root);


#-------------------------------------------
#  MYSQL DATABASE
#-------------------------------------------

define('DB_HOST','localhost');
define('DB_NAME','nanodesk');
define('DB_USER','root');
define('DB_PASSWORD','');


#-------------------------------------------
#  ORCHID LOGIN REQUIREMENTS
#-------------------------------------------

//Client information
define('OAUTH_CLIENT_ID', 'APP-DYF2BEWUCJNL1I5A'); //client ID
define('OAUTH_CLIENT_SECRET', '919a04c1-9210-4cc1-9ca0-270e52c35b3a'); //client secret
define('OAUTH_REDIRECT_URI', ROOT.'/orcidlogin/'); //redirect URI

//Production - Public API
define('OAUTH_AUTHORIZATION_URL', 'https://orcid.org/oauth/authorize');//authorization endpoint
define('OAUTH_TOKEN_URL', 'https://pub.orcid.org/oauth/token');//token endpoint


?>