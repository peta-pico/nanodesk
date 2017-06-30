<?php

// Supress errors and load dependencies
error_reporting(E_ALL & ~E_NOTICE);
include('ajax.inc.php');
include('../classes/trig.class.php');

// vars
$trig = new Trig;
$action = $_POST['action'];
$id = $_POST['id'];

//--
// check login session
//--
if( $login->get_login_info('id') == '' )
{
    die('You shall not pass');
    exit();
}

// start actions
if($action == 'retract')
{

    // Required Fields
    $required = array('ihaveread');
    $json['errors'] = array();

    // Validate required fields
    foreach($required as $val)
    {
        //general check for required vars
        ($_POST[$val] == '') ? array_push($json['errors'], $val):'';
    }

    if(count($json['errors']) >= 1)
    {
        //errors are found
        $json['response'] = false;
        $json['message'] = 'check required fields';
        echo json_encode($json);
    }
    else // form is valid
    {
        //
        $np_array['orcid'] = $login->get_login_info('orcid_id');
        $np_array['np_uri'] = $_POST['np_uri'];

        // create trig file and return its nam
        $trigfile = $trig->makeNanopub('retract', $np_array);

	    // prepare query
        $query = $db->prepare("DELETE FROM aidas WHERE id=? AND orcid_id=? LIMIT 1");

        // upload the nanopub
        if( $trig->uploadNanopub($trigfile) )
        {
            // insert into db
			if( $query->execute( array($id, $np_array['orcid']) ) )
			{
                // return
	            $json['response'] = true;
	            $json['message'] = 'complete';
	            $json['redirect'] = true;
	            $json['redirect_url'] = ROOT.'/my-papers/&feedback=success';
			}
        }
        else
        {
            // throw error if upload fails
            $json['response'] = "error";
            $json['message'] = $query->errorInfo();
        }

        echo json_encode($json);

    }

}// end action: retract

else // if no action is defined, throw error
{
    $json['response'] = 'error';
    $json['message'] = 'No action is defined';
    echo json_encode($json);
}


?>
