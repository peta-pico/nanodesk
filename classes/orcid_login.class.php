<?php 

class orcid_login extends login
{
	/*
	| Database initation
	*/
	protected $db;

	/*
	| Setup requirements
	*/
	var $client_id, $client_secrect, $redirect_uri, $authorization_url, $token_url;

	/*
	| Error array / string
	*/
	public $errors = '';


	function __construct( $client_id, $client_secrect, $redirect_uri, $authorization_url, $token_url ){

		 $this->client_id = $client_id;
		 $this->client_secret =  $client_secrect;
		 $this->redirect_uri = $redirect_uri;
		 $this->authorization_url =  $authorization_url;
		 $this->token_url = $token_url;

		 $this->db = Core::dbConnect();




	}

	function loginUrl()
	{
		$val = $this->authorization_url.'?client_id='. $this->client_id .'&response_type=code&scope=/authenticate&redirect_uri='. $this->redirect_uri; 
		return $val;
	}

	function fetchAccessToken($code)
	{
		  //Build request parameter string
		  $params = "client_id=" . $this->client_id . "&client_secret=" . $this->client_secret . "&grant_type=authorization_code&code=" . $code . "&redirect_uri=" . $this->redirect_uri;
		  
		  //Initialize cURL session
		  $ch = curl_init();
		  
		  //Set cURL options
		  curl_setopt($ch, CURLOPT_URL, $this->token_url);
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

		  return $response;


	} // end fetchAccessToken()

	function checkUser($response)
	{
		// echo "<pre>";
		// print_r(  );
		// echo "</pre>";
		//die("<br>end of the road");
		//the user orcid is present
		if( $response['orcid'] !='' && !empty( $response['orcid'] ) )
		{

			//Check if the user already exists
			$query = $this->db->prepare("SELECT * FROM nanousers WHERE orcid_id=? LIMIT 1");
			$query->execute( array( $response['orcid'] ) );

			if( $query->rowCount() >= 1)
			{
				// an existing orchid id is found
				// initate the login
				$this->controleer_gegevens( $response['orcid'] );

			}
			else
			{
				// a valid orcid is not found. add the user to the database
				$query_i = $this->db->prepare("INSERT INTO nanousers ( orcid_id, username, date ) VALUES( ?, ?, NOW() )");

				if ( $query_i->execute( array( $response['orcid'], $response['name'],) ) )
				{
					//make cookie and redirect
					$this->controleer_gegevens($response['orcid']);
				}
				else
				{
					$this->errors .= "We could not add you to our system. Please contact the Administrator <a href='#'>here</a>";
				  	//print_r( $query_i->errorInfo() );
				}
			}


		}
		else
		{
			//the orcid login is not valid
			$this->errors .= "We could not retrieve your ORCID information<br>";
			$this->errors .= $response['error-desc']['value'];
		}

	}


} // end orcid_login


// Call orcid and setup
// Setup found in ../includes/config.inc.php;
$orcid = new orcid_login( OAUTH_CLIENT_ID, OAUTH_CLIENT_SECRET, OAUTH_REDIRECT_URI, OAUTH_AUTHORIZATION_URL, OAUTH_TOKEN_URL );

?>