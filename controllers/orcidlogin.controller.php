
<?php

  //initate orcid_login class
  include('classes/orcid_login.class.php');

  if($_GET['code'] !='' )
  {
      //fetch the acces token
      $response = $orcid->fetchAccessToken($_GET['code']);

      //handle the user
      if( $response['orcid'] !='' && !empty( $response['orcid'] ) )
      {

        //Check if the user already exists
        $query = $db->prepare("SELECT * FROM nanousers WHERE orcid_id=? LIMIT 1");
        $query->execute( array( $response['orcid'] ) );

        if( $query->rowCount() >= 1)
        {
          // an existing orchid id is found
          // initate the login
          $login->controleer_gegevens( $response['orcid'] );

        }
        else
        {
          // a valid orcid is not found. add the user to the database
          $query_i = $db->prepare("INSERT INTO nanousers ( orcid_id, username, date ) VALUES( ?, ?, NOW() )");

          if ( $query_i->execute( array( $response['orcid'], $response['name'],) ) )
          {
            //make cookie and redirect
            $login->controleer_gegevens( $response['orcid'] );
          }
          else
          {
            $orcid->errors .= "We could not add you to our system. Please contact the Administrator <a href='#'>here</a>";
              //print_r( $query_i->errorInfo() );
          }
        }


      }
      else
      {
        //the orcid login is not valid
        $orcid->errors .= "We could not retrieve your ORCID information<br>";
        $orcid->errors .= $response['error-desc']['value'];
      }


    }

?>

