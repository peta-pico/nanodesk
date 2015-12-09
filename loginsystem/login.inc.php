<section class="container">
	<div class="col-md-offset-4 col-md-4">
		<div class="spacer col-md-12" style="margin:0 0 1em 0;"></div>
		<div class="form-group input-group-md text-center" style="margin:2em 0;">
			<a href="<?php echo $helper->getLoginUrl(array('email')); ?>" class="btn btn-lg btn-fbcolor">
				<i class="fa fa-4 fa-facebook-square"></i>
				&nbsp;Inloggen met Facebook!
			</a>
			<br>
		</div>
		<form action="<?php print $_SERVER['REQUEST_URI'];?>" method="post">
			<div class="panel panel-default">
				<div class="panel-body">

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
						<button class="btn btn-md btn-primary"  type="submit"><i class="fa fa-sign-in"></i> Inloggen</button>
					</div>
						
				</div>
			</div>
		</form>
		<p class="text-center">
			<a href="<?php echo ROOT.'/wachtwoordvergeten/'; ?>"><i class="fa fa-lock"></i> Wachtwoord vergeten?</a> | 
			<a href="<?php echo ROOT.'/registreren/'; ?>"><i class="fa fa-pencil-square-o"></i> Registreren</a>
		</p>
	</div>
	
</section>
