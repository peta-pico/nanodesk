<?php

$root  = "."; //In the normal implementation this was nanodesk.nl
define('ROOT', $root);

$env = 'dev'; // PROD | DEV
define('NP_ENV',$env);


#-------------------------------------------
#  MYSQL DATABASE
#-------------------------------------------

define('DB_HOST','db');
define('DB_NAME','nanodesk');
define('DB_USER','root');
define('DB_PASSWORD','');

//where to publish the NANOPUBS
// options: auto , <url to server eg: http://app.petapico.d2s.labs.vu.nl/nanopub-server/>
define('NP_PUBLISH_METHOD','auto');

if(NP_PUBLISH_METHOD == 'auto')
{
	define('NP_PUBISH_SERVER','http://purl.org/np/');
}
elseif(NP_PUBLISH_METHOD == 'manual')
{
	define('NP_PUBISH_SERVER','http://app.petapico.d2s.labs.vu.nl/nanopub-server/');
}

// default servers
define('PURL', 'http://purl.org');
define('PURL_AIDA', 'http://purl.org/aida/');



#-------------------------------------------
#  ORCHID LOGIN REQUIREMENTS
#-------------------------------------------

//Client information
define('OAUTH_CLIENT_ID', ''); //add client ID
define('OAUTH_CLIENT_SECRET', ''); // add client secret
define('OAUTH_REDIRECT_URI', ROOT.'/orcidlogin/'); //redirect URI

//Production - Public API
define('OAUTH_AUTHORIZATION_URL', 'https://orcid.org/oauth/authorize');//authorization endpoint
define('OAUTH_TOKEN_URL', 'https://pub.orcid.org/oauth/token');//token endpoint


?>
