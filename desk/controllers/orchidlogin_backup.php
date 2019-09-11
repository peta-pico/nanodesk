
<?php
//ORCID API CREDENTIALS - replace these values with your API credentials
////////////////////////////////////////////////////////////////////////

  # Defined in ../includes/config.inc

//define('OAUTH_CLIENT_ID', 'APP-DYF2BEWUCJNL1I5A');//client ID
//define('OAUTH_CLIENT_SECRET', '919a04c1-9210-4cc1-9ca0-270e52c35b3a');//client secret
//define('OAUTH_REDIRECT_URI', 'http://149.210.214.2/~nanodesk/orcidlogin/');//redirect URI


//ORCID API ENDPOINTS
////////////////////////////////////////////////////////////////////////
//Sandbox - Member API
//define('OAUTH_AUTHORIZATION_URL', 'https://sandbox.orcid.org/oauth/authorize');//authorization endpoint
//define('OAUTH_TOKEN_URL', 'https://api.sandbox.orcid.org/oauth/token'); //token endpoint

//Sandbox - Public API
//define('OAUTH_AUTHORIZATION_URL', 'https://sandbox.orcid.org/oauth/authorize');//authorization endpoint
//define('OAUTH_TOKEN_URL', 'https://pub.sandbox.orcid.org/oauth/token');//token endpoint

//Production - Member API
//define('OAUTH_AUTHORIZATION_URL', 'https://orcid.org/oauth/authorize');//authorization endpoint
//define('OAUTH_TOKEN_URL', 'https://api.orcid.org/oauth/token'); //token endpoint

//Production - Public API
define('OAUTH_AUTHORIZATION_URL', 'https://orcid.org/oauth/authorize');//authorization endpoint
define('OAUTH_TOKEN_URL', 'https://pub.orcid.org/oauth/token');//token endpoint


//EXCHANGE AUTHORIZATION CODE FOR ACCESS TOKEN
////////////////////////////////////////////////////////////////////////
//If an authorization code exists, fetch the access token
if (isset($_GET['code']))
{
  echo 'processing';
  //Build request parameter string
  $params = "client_id=" . OAUTH_CLIENT_ID . "&client_secret=" . OAUTH_CLIENT_SECRET . "&grant_type=authorization_code&code=" . $_GET['code'] . "&redirect_uri=" . OAUTH_REDIRECT_URI;
  //Initialize cURL session
  $ch = curl_init();
  //Set cURL options
  curl_setopt($ch, CURLOPT_URL, OAUTH_TOKEN_URL);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
  //curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 1);//Turn off SSL certificate check for testing - remove this for production version!
  //curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 1);//Turn off SSL certificate check for testing - remove this for production version!
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
  
  //Execute cURL command
  $result = curl_exec($ch);
  $info = curl_getinfo($ch);

  //dont display errors for now
  #print curl_error($ch);
  
  //Close cURL session
  curl_close($ch);

  //Transform cURL response from json string to php array
  $response = json_decode($result, true);

  // echo '<pre>';
  // print_r($info);
  // echo '</pre>';

 //print_r($response);


  #---------------------
  # orchid login complete
  # proceed witch account check or creation
  #---------------------
 

  if($response['orcid'] !='' )
  {

    echo "<br> <br> checking user info";

    $query = $db->prepare("SELECT * FROM nanousers WHERE orcid_id=? LIMIT 1");
    $query->execute( array( $response['orcid'] ) );

    //print_r( $query->errorInfo() );

      if( $query->rowCount() >= 1)
      {
        // an valid orchid id is found - redirect the user

        // make cookie

        $login->controleer_gegevens($response['orcid']);
        //$login->orcid_id = 'abc'.$response['orcid'];

        //redirect
        echo ("<br> <br> Not a new user - you are being redirected!");
      }
      else
      {
        // a valid orcid is not found. add the user to the database
        $query_i = $db->prepare("INSERT INTO nanousers (orcid_id, username,date) VALUES( ?, ?, NOW() )");
        if ( $query_i->execute( array( $response['orcid'], $response['name'],) ) )
        {
          echo ("<br> <br> you have been added to our system!");
          //the user is added to the database

          //make cookie

          //redirect
        }
        else
        {
          echo "We could not add you to our system";
          print_r( $query_i->errorInfo() );

        }
      }
    

  }
  else{
    echo "We could not retrieve your ORCID information";
  }


} 
else{
  //If an authorization code doesn't exist, throw an error
  echo "Unable to connect to ORCID";
}


?>

<a href="https://orcid.org/oauth/authorize?client_id=<?php echo OAUTH_CLIENT_ID; ?>&response_type=code&scope=/authenticate&redirect_uri=<?php echo OAUTH_REDIRECT_URI; ?>">
  Login ORCID
</a>

  <div class="jumbotron">
      <h1>Thanks, <?php echo $response['name']; ?>!</h1>
      <br>
      <p class="lead">Your ORCID <img src="http://orcid.org/sites/default/files/images/orcid_16x16.png" class="logo" width='16' height='16' alt="iD"/> is <?php echo $response['orcid']; ?></p>
      <p class="lead">The access token we're storing in our database so that we can update your ORCID record in the future is <b><?php echo $response['access_token']; ?></b></p>
      <p>(for demo purposes only - don't show access tokens in live apps!)</p>
      <br> <br>
      <a class="btn btn-large"  href="http://sandbox.orcid.org/my-orcid" target="_blank">Go to your ORCID record</a>
  </div>