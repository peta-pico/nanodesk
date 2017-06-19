<?php
//supress errors
error_reporting(E_ALL & ~E_NOTICE);
include('ajax.inc.php');
include('../classes/trig.class.php');

$trig = new Trig;

//Vars
$action = $_POST['action'];


//check login session
if( $login->get_login_info('id') =='' )
{
    die('You shall not pass');
    exit();
}


// start actions
if($action == 'addaida')
{

    //default
    $required = array('paper_id','ihaveread','aida_sentence');

    //initiate array
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
        $json['message'] = 'Check required fields';
        echo json_encode($json);
    }
    else // form is valid
    {
        // set paper data array
        $trig_data = array();
        foreach($_POST as $key => $val )
        {
            if($key !='uid' && $key !='trigtype' && $key !='action')
            {
                $trig_data[$key] = $val;
            }
        }

        $trig_data['orcid'] = $login->get_login_info('orcid_id');

        $trigfile = $trig->makeNanopub('aida',  $trig_data);


        //Alter values
        $np_hash = $trig->getHashFromTrusty('../trigfiles/'.$trigfile);
        $np_uri = NP_PUBISH_SERVER.$np_hash;
        

       // prepare query
        $query = $db->prepare("INSERT INTO aidas 
        ( date, orcid_id, paper_id, sentence, np_uri, np_hash )
        VALUES( NOW(), :orcid_id, :paper_id, :sentence, :np_uri, :np_hash )
        ");

        //Bind values
        $query->bindValue(':orcid_id',$login->get_login_info('orcid_id'), PDO::PARAM_STR);
        $query->bindValue(':paper_id', $_POST['paper_id'], PDO::PARAM_INT);
        $query->bindValue(':sentence', $_POST['aida_sentence'], PDO::PARAM_STR);
        $query->bindValue(':np_uri', $np_uri, PDO::PARAM_STR);
        $query->bindValue(':np_hash', $np_hash, PDO::PARAM_STR);
      


        // upload the nanopub
        if( $trig->uploadNanopub($trigfile) )
        {
			if( $query->execute() )
			{
	            $json['response'] = true;
	            $json['message'] = 'complete';
	            $json['redirect'] = true;
	            $json['redirect_url'] = ROOT.'/my-papers/&feedback=success';
			}
            else
            {
                print_r($query->errorInfo());
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
