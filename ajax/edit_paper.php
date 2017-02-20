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
if($action == 'addpaper')
{
    $required = array('uid');
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

        //Write nanopub file - returns trusty file name
       $trigfile = $trig->writeReadNanopub($_POST['doi'],$login->get_login_info('orcid_id'));

       // prepare query
        $query = $db->prepare("INSERT INTO papers
        VALUES(date, title, author, journal, pages, volume, year, paper_data, np_uri, np_hash)
        (NOW(), :title, :author, :journal, :pages, :volume, :year, :paper_data, :np_uri, :np_hash)
        ");

        //Alter values
        $np_uri = '';
        $np_hash = $trig->getHashFromTrusty('../trigfiles/'.$trigfile);

        $paper_data = array();
        foreach($_POST as $key => $val )
        {
            array_push($paper_data, array($key=>$val));
        }
        $paper_data = json_encode($paper_data);

        //Bind values
        $query->bindValue(':title', htmlspecialchars($_POST['title'],ENT_QUOTES), PDO::PARAM_STR);
        $query->bindValue(':author', htmlspecialchars($_POST['author'],ENT_QUOTES), PDO::PARAM_STR);
        $query->bindValue(':journal', htmlspecialchars($_POST['journal'],ENT_QUOTES), PDO::PARAM_STR);
        $query->bindValue(':pages', htmlspecialchars($_POST['pages'],ENT_QUOTES), PDO::PARAM_STR);
        $query->bindValue(':volume', htmlspecialchars($_POST['volume'],ENT_QUOTES), PDO::PARAM_STR);
        $query->bindValue(':year', htmlspecialchars($_POST['year'],ENT_QUOTES), PDO::PARAM_STR);
        $query->bindValue(':paper_data', $paper_data,ENT_QUOTES, PDO::PARAM_STR);
        $query->bindValue(':np_uri', $_POST['np_uri'], PDO::PARAM_STR);
        $query->bindValue(':np_hash', $np_hash, PDO::PARAM_STR);

        if($query->execute())
        {
            $json['response'] = true;
            $json['message'] = 'complete';
        }
        else
        {
            $json['response'] = false;
            $json['message'] = $query->errorInfo();

        }

        echo json_encode($json);

    }
}// end action: addpaper


?>
