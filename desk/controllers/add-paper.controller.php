<?php 

//check if user is logged in
if( ! $login->get_login_info('id') )
{
	$current_url = rawurlencode($_SERVER[REQUEST_URI]);
	header('Location: '.ROOT.'/login/&next='.rawurlencode($current_url));
}

/*
/ Class for all trig file functions
*/
include('classes/trig.class.php');
$trig = new trig;

//add metatags
$head['meta']['title'] = "Edit paper";
$head['meta']['description'] = "page to edit papers";
$head['meta']['robots'] = "index, follow";

//add additional files 
//$head['add_files'] = [['<style,script,costum>',"<file path>"]];

// user id
$user_id = $login->get_login_info('id');

//form action
$formAction = ( $_GET['var'] !='' ) ? "update":"insert";


/*---------------------------------------------------------------------------------------------------*/
// WRITE FILES
/*---------------------------------------------------------------------------------------------------*/

if(isset($_POST['action'] ) && ( $_POST['action'] == 'directupload' ) )
{
	//SET THE WRITING TYPE
	if($_POST['trigtype']=='read')
	{
		$trigdata = $trig->read_nanopub($_POST['doi'],$login->get_login_info('orcid_id'));
	}
	elseif($_POST['trigtype']=='aida')
	{
		$trigdata = $trig->aida($_POST['doi'],$login->get_login_info('orcid_id'),'a aida sentence about the paper');
	}

	//echo(htmlspecialchars($trigdata));

	//die();
	//-- write nanopub file.
	$filename = uniqid(mt_rand(), true).'_'.time().'_'.$login->get_login_info('orcid_id');
	$trig->writeFile($filename, $trigdata, 'trigfiles');


	//echo "<br><br>prepare upload<br><br>";

	//prepare upload
	if( file_exists("trigfiles/nanopub.jar") )
	{
		$trusty_output = exec("java -jar trigfiles/nanopub.jar mktrusty trigfiles/".$filename.".trig", $trusty_output);

		die('should be trusty');

		if ( $trusty_output == '')
		{
			//try upload
			// if succes, it will return a string
			$publish_output = exec("java -jar trigfiles/nanopub.jar publish trigfiles/trusty.".$filename.".trig", $publish_output);


			if( strpos($publish_output , 'INVALID NANOPUB') != false )
			{
				//-- the file is invalid and cannot be posted
				$alert['response'] =  "warning";
				$alert['message'] =  "INVALID NANOPUB DETECTED";
			}
			else
			{
				if($publish_output != '')
				{
					$alert['response'] =  "success";
					$alert['message'] =  $publish_output.". <br> Your paper will shortly appear in your list.";
				}
				else
				{
					$alert['response'] =  "danger";
					$alert['message'] =  "File is not published<br>".$publish_output;
				}
			}

			//delete the created files
			unlink ( "trigfiles/".$filename.".trig" );
			unlink ( "trigfiles/trusty.".$filename.".trig" );
		}

		else
		{
			//echo "file is not uploding...";
		}

	}
	else{
		//echo "file does not exsist";
	}
	
	
	//print_r( $exec );
	//--echo "<br>OUTPUT:<br>";
	//--print_r( $output );
	//echo exec("java -jar trigfiles/nanopub.jar publish trigfiles/trusty.".$filename.".trig", $output);
	//print_r ( $output );
	//echo exec("java -jar file.jar ", $output);
	//--echo "<br>done";
}



/*---------------------------------------------------------------------------------------------------*/
// Insert , Update , Delete
/*---------------------------------------------------------------------------------------------------*/


if(isset($_POST['action'] ) && ( $_POST['action'] == 'insert' || $_POST['action'] == 'update') )
{

	if( $_POST['action'] == 'insert' )
	{
		//the insert query
		$query = $db->prepare("INSERT INTO papers (date,user_id,doi) VALUES(NOW(),:user_id, :doi)");
	}
	elseif( $_POST['action'] == 'update' )
	{
		//the update query
		$query = $db->prepare("UPDATE papers SET doi=:doi WHERE id=:paper_id AND user_id=:user_id ");
	}

	/*	
	| bind the params - these fields will allways be filled in on insert or update
	*/
	$query->bindValue(':user_id', $user_id, PDO::PARAM_INT);
	$query->bindValue(':doi', $_POST['doi'], PDO::PARAM_STR);

	//if update bind extra params
	if($_POST['action'] == 'update')
	{
		$query->bindValue(':paper_id', $_POST['paper_id'], PDO::PARAM_STR);
	}

	/*
	| do aida inserts and updates
	*/
	$paper_id = $_POST['paper_id'];
	$i = 0;
	foreach( $_POST['aida'] as $aida_sentence )
	{

		//basic info
		if( ( $_POST['aida_action'][$i] == 'insert' || $_POST['aida_action'][$i] == 'update') && $_POST['aida'][$i] !='' )
		{
			//insert
			if($_POST['aida'][$i] != '')
			{
					$aida = $db->prepare("INSERT INTO aidas ( date , paper_id, aida_option, description) VALUES( NOW(), :paper_id, :aida_option, :description)");
					$aida->bindValue(':paper_id', $paper_id, PDO::PARAM_INT);
				
			}

			//update
			elseif($_POST['aida_action'][$i] == 'update')
			{
				$aida = $db->prepare("UPDATE aidas SET aida_option=:aida_option , description=:description WHERE id=:aida_id");
				$aida->bindValue(':aida_id', $_POST['aida_id'][$i], PDO::PARAM_INT);
			}

			$aida->bindValue(':aida_option', $_POST['aida_option'][$i], PDO::PARAM_STR);
			$aida->bindValue(':description', $_POST['aida'][$i], PDO::PARAM_STR);

			//execute data
			if( !$aida->execute() )
			{
				print_r($aida->errorInfo());
			}
		}
		//run for insert and update

		//delete
		elseif( $_POST['aida_action'][$i] == 'delete' )
		{
			$aida = $db->prepare("DELETE FROM aidas WHERE id=:aida_id");
			$aida->bindValue(':aida_id', $_POST['aida_id'][$i], PDO::PARAM_INT);

			if( !$aida->execute() )
			{
				print_r($aida->errorInfo());
			}
		}
		


		$i++;
	}// end foreach
		

	//check of inserted
	if( $query->execute() )
	{
		$add_to_url = ($_POST['action'] == 'insert') ? $db->lastInsertId('id') : $_POST['paper_id'];

		$alert['response'] = 'success';
		$alert['message'] = 'success';
	}
	else{
		echo "failed";
		print_r( $query->errorInfo() );
	}

}

/*---------------------------------------------------------------------------------------------------*/
// Page information
/*---------------------------------------------------------------------------------------------------*/



if($formAction == 'insert')
{
	$last_item = $db->query("SELECT id FROM papers ORDER BY id DESC LIMIT 1");
	$last_id = $last_item->fetch();
	

	//query
	// $last_aida = $db->query("SELECT id FROM aidas ORDER BY id DESC LIMIT 1");
	// $last_aida_id = $last_aida->fetch();
	// $last_aida_id = $last_id['id'] + 1;

}


if($formAction == 'update' )
{

	$data = $db->prepare("SELECT * FROM papers WHERE id=? LIMIT 1");
	$data->execute( array( $_GET['var'] ) );
	$paper = $data->fetch();

	$aida_data = $db->prepare("SELECT * FROM aidas WHERE paper_id=? ORDER BY id ASC ");
	$aida_data->execute( array( $paper['id'] ) );
	$aidas = $aida_data->fetchAll();
}


$add_to_url = ($formAction == 'insert') ? $last_id['id'] + 1 : $_GET['var'];


?>