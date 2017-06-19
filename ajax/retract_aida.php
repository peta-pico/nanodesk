<?php
//supress errors
error_reporting(E_ALL & ~E_NOTICE);
include('ajax.inc.php');
include('../classes/trig.class.php');

$trig = new Trig;

//Vars
$action = $_POST['action'];
$id = $_POST['id'];

//check login session
if( $login->get_login_info('id') =='' )
{
    die('You shall not pass');
    exit();
}


// start actions
if($action == 'retract')
{
    $required = array('uid','ihaveread');
    $json['errors'] = array();

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
        $np_array['orcid'] = $login->get_login_info('orcid_id');
        $np_array['np_uri'] = $_POST['np_uri'];



        $trigfile = $trig->makeNanopub('retract', $np_array);

	    // prepare query
        $query = $db->prepare("DELETE FROM papers WHERE id=? AND orcid_id=? LIMIT 1");

        // upload the nanopub
        if( $trig->uploadNanopub($trigfile) )
        {
			if( $query->execute( array($id, $np_array['orcid']) ) )
			{
	            $json['response'] = true;
	            $json['message'] = 'complete';
	            $json['redirect'] = true;
	            $json['redirect_url'] = ROOT.'/my-papers/&feedback=success';
			}
        }
        else
        {
            $json['response'] = "error";
            $json['message'] = $query->errorInfo();
        }

        echo json_encode($json);

    }
}// end action: addpaper


?>
