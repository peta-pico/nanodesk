<?php

/* start editable */
// Register your client at https://orcid.org/developer-tools and replace the details below
define('OAUTH_CLIENT_ID', 'APP-DYF2BEWUCJNL1I5A');
define('OAUTH_CLIENT_SECRET', '919a04c1-9210-4cc1-9ca0-270e52c35b3a');
define('OAUTH_REDIRECT_URI', 'https://developers.google.com/oauthplayground'); // URL of this script
define('ORCID_PRODUCTION', true); // sandbox; change to true when ready to leave the  sandbox
/* end editable */

if (ORCID_PRODUCTION) {
  // production endpoints
  define('OAUTH_AUTHORIZATION_URL', 'https://orcid.org/oauth/authorize');
  define('OAUTH_TOKEN_URL', 'https://pub.orcid.org/oauth/token'); // public
  //define('OAUTH_TOKEN_URL', 'https://api.orcid.org/oauth/token'); // members
} else {
  // sandbox endpoints
  define('OAUTH_AUTHORIZATION_URL', 'https://sandbox.orcid.org/oauth/authorize');
  define('OAUTH_TOKEN_URL', 'https://pub.sandbox.orcid.org/oauth/token'); // public
  //define('OAUTH_TOKEN_URL', 'https://api.sandbox.orcid.org/oauth/token'); // members
}

// redirect the user to approve the application
if (!$_GET['code']) {
  $state = bin2hex(openssl_random_pseudo_bytes(16));
  setcookie('oauth_state', $state, (time() + (86400 * 30)), "/");

  $url = OAUTH_AUTHORIZATION_URL . '?' . http_build_query(array(
      'response_type' => 'code',
      'client_id' => OAUTH_CLIENT_ID,
      'redirect_uri' => OAUTH_REDIRECT_URI,
      'scope' => '/authenticate',
      'state' => $state,
  ));

  header('Location: ' . $url);
  exit();
}

// code is returned, check the state
if (!$_GET['state'] || $_GET['state'] !== $_COOKIE['oauth_state']) {
  //exit('Invalid state');
}

// fetch the access token
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => OAUTH_TOKEN_URL,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_HTTPHEADER => array('Accept: application/json'),
  CURLOPT_POST => true,
  //CURLOPT_SSL_VERIFYHOST => 1,
  //CURLOPT_SSL_VERIFYPEER => 1,
  CURLOPT_POSTFIELDS => http_build_query(array(
    'code' => $_GET['code'],
    'grant_type' => 'authorization_code',
    'client_id' => OAUTH_CLIENT_ID,
    'client_secret' => OAUTH_CLIENT_SECRET,
  ))
));

$result = curl_exec($curl);
$info = curl_getinfo($curl);
$response = json_decode($result, true);

// ORCID = $response['orcid']
echo '<pre>';
print_r($curl);
echo '</pre>';

echo '<pre>';
print_r($info);
echo '</pre>';

echo '<pre>';
print_r($response);
echo '</pre>';


print curl_error($curl);
exit();


?>