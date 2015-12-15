<?php 

//check if user is logged in
if( ! $login->get_login_info('id') ){
	$current_url = rawurlencode($_SERVER[REQUEST_URI]);
	header('Location: '.ROOT.'/login/&next='.rawurlencode($current_url));
}



//add metatags
$head['meta']['title'] = "Edit paper";
$head['meta']['description'] = "page to edit papers";
$head['meta']['robots'] = "index, follow";

//add additional files 
#$head['add_files'] = [['<style,script,custom>',"<file path>"]];


$add_to_url = '';

$user_id = $login->get_login_info('id');

if(isset($_POST['action'] ) && $_POST['action'] == 'insert'){


	$query = $db->prepare("INSERT INTO papers (date,user_id,doi,doi2,doi_option) VALUES(NOW(),?,?,?,?)");
	

	if($query->execute(array( $user_id, $_POST['doi'], $_POST['doi2'], $_POST['doi_option'] ))){

		$add_to_url = $db->lastInsertId('id');
		print_r($query->errorInfo());
		echo "inserted";
	}
	else{
		echo "failed";
		print_r($query->errorInfo());
	}

}

?>