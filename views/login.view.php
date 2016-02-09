<?php 
	//insert this view
	include('snippets/header.php'); 
?>

<div class="site-container site-main">
	<div class="container">
		<div class="row no-gutter site-main-holder">
			<form action="<?php print $_SERVER['REQUEST_URI'];?>" method="post">
					<div class="panel panel-default">
						<div class="panel-body">
							Login with<br>
							account: test@test.com<br>
							pass: test<br>
							<?php 
								if($login->fouten)
								{
									echo '<div class="alert alert-danger" role="alert">
									  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
									  <span class="sr-only">Error:</span>
									   '.$login->fouten.'</div>';
								} 
							?>
							<div class="form-group input-group-md">
								<label for="gebruikersnaam">E-mail</label>
								<input class="form-control" type="email" name="gebruikersnaam" id="gebruikersnaam" placeholder="email@domein.nl" value="<?php echo $_POST['gebruikersnaam']; ?>" required>
							</div>
							<div class="form-group input-group-md">
								<label for="password">Wachtwoord</label>
								<input class="form-control"  type="password" name="wachtwoord" id="password" required>
							</div>
							<div class="form-group text-right">
								<input type="hidden" name="actie"  value="login">
								<input type="hidden" name="next"  value="<?php echo rawurlencode($_GET['next']); ?>">
								<button class="btn btn-md btn-primary" name="submit_login" type="submit"><i class="fa fa-sign-in"></i> Inloggen</button>
							</div>

							<a 
							href="https://orcid.org/oauth/authorize?client_id=APP-DYF2BEWUCJNL1I5A&response_type=code&scope=/authenticate&redirect_uri=http://localhost/github/nanodesk/orcidlogin/"
							class="btn btn-lg btn-primary"
							>
							Login With OrcId
						</a>
								
						</div>
					</div>
				</form>			

		</div>
	</div>
</div><!--//site container-->


<?php include('snippets/footer.php');  ?>
