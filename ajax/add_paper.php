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
if($action == 'addpaper' || $action == 'addpaper_manual')
{
    if($action == 'addpaper')
    {   
        //default
        $required = array('uid','title','year','author','doi');
    }
    else
    {
         $required = array('uid','title','year','author','doi_url');
    }

    //initiate array
    $json['errors'] = array();

    foreach($required as $val)
    {
        //general check for required vars
        ($_POST[$val] == '') ? array_push($json['errors'], $val):'';

        if($val == 'doi_url' )
        {
            ($_POST['doi_url'] == '' || filter_var($_POST['doi_url'], FILTER_VALIDATE_URL) === FALSE) ? array_push($json['errors'], 'doi_url') : '';
        }
        
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

                //rewrite url for papers that dont have a doi
        $doi_url = "https://doi.org/".$_POST['doi'];
        $doi_url = ($_POST['doi_url'] != '') ? $_POST['doi_url'] : $doi_url;


        $query = $db->prepare("SELECT * FROM papers WHERE doi=? OR doi_url=? ");
        $query->execute(array($_POST['doi'],$doi_url));
        if($query->rowCount() >= 1)
        {
            $json['response'] = false;
            $json['message'] = 'This entry aleardy exsists. Please upload a different paper.';
            echo json_encode($json);
            exit;
        }



		// set paper data array
		$paper_data = array();
		foreach($_POST as $key => $val )
		{
			if($key !='uid' && $key !='trigtype' && $key !='action')
			{
				$paper_data[$key] = $val;
			}
		}

        // format = Berners-Lee et al. 2001. Title of paper. Nature.
        $paper_data['description'] =
        $paper_data['author'].'. '.
        str_replace('—','-',$paper_data['title']).'. '.
        $paper_data['year'].'. ';
        $paper_data['journal'];
        $paper_data['doi_url'] = $doi_url;
        $paper_data_json = json_encode($paper_data);

        //Write nanopub file - returns trusty file name
        $np_array = array();
        $np_array['orcid'] = $login->get_login_info('orcid_id');
        $np_array['doi'] = $_POST['doi'];
        $np_array['doi_url'] = $doi_url;
        $np_array['paper_cite'] = $paper_data['description'];
        $np_array['paper_title'] = htmlspecialchars($_POST['title']);
        $np_array['paper_year'] = $_POST['year'];

        $trigfile = $trig->makeNanopub('read', $np_array);


        //Alter values
        $np_hash = $trig->getHashFromTrusty('../trigfiles/'.$trigfile);
        $np_uri = NP_PUBISH_SERVER.$np_hash;
        

       // prepare query and aroew in DB
        $query = $db->prepare("INSERT INTO papers
        (date , doi, doi_url, title, author, journal, pages, volume, year, paper_data, np_uri, np_hash, user_id,orcid_id)
        VALUES( NOW(), :doi, :doi_url, :title, :author, :journal, :pages, :volume, :year, :paper_data, :np_uri, :np_hash, :user_id,:orcid_id)
        ");


        //Bind values
        $query->bindValue(':doi', htmlspecialchars($_POST['doi'],ENT_QUOTES), PDO::PARAM_STR);
        $query->bindValue(':doi_url', $doi_url, PDO::PARAM_STR);
        $query->bindValue(':title', htmlspecialchars($_POST['title'],ENT_QUOTES), PDO::PARAM_STR);
        $query->bindValue(':author', htmlspecialchars($_POST['author'],ENT_QUOTES), PDO::PARAM_STR);
        $query->bindValue(':journal', htmlspecialchars($_POST['journal'],ENT_QUOTES), PDO::PARAM_STR);
        $query->bindValue(':pages', htmlspecialchars($_POST['pages'],ENT_QUOTES), PDO::PARAM_STR);
        $query->bindValue(':volume', htmlspecialchars($_POST['volume'],ENT_QUOTES), PDO::PARAM_STR);
        $query->bindValue(':year', htmlspecialchars($_POST['year'],ENT_QUOTES), PDO::PARAM_STR);
        $query->bindValue(':paper_data', $paper_data_json, PDO::PARAM_STR);
        $query->bindValue(':np_uri', $np_uri, PDO::PARAM_STR);
        $query->bindValue(':np_hash', $np_hash, PDO::PARAM_STR);
        $query->bindValue(':user_id',$login->get_login_info('id'), PDO::PARAM_INT);
        $query->bindValue(':orcid_id',$login->get_login_info('orcid_id'), PDO::PARAM_INT);


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
