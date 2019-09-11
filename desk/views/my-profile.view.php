<?php 
	//insert this view
	include('snippets/header.php'); 
?>

<div class="site-container site-main">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h2 class="text-center">My Profile</h2>
				<p class="text-center hidden">Edit your profile.</p>
			</div>
		</div>

		<div class="row hidden">
			<div class="col-md-4 text-center">
				<a href="#"><i class="glyphicon glyphicon-user"></i> Profile</a>
			</div>
			<div class="col-md-4 text-center">
				<a href="#"><i class="glyphicon glyphicon-user"></i> Email</a>
			</div>
			<div class="col-md-4 text-center">
				<a href="#"><i class="glyphicon glyphicon-user"></i> profile</a>
			</div>
		</div>

		<div class="row bg--white box--50">
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-12">
						<h3>Profile</h3>
						<hr>
					</div>
					<form class="ajaxform ajaxform-required">
						<div class="col-md-4 col-md-push-8 text-center hidden">
							<div class="text-center">
								<div class="thumbnail" style="height: 180px; width: 180px; display: inline-block; background:url(<?php echo ROOT.'/assets/profile2.png'?>) 50% 50% no-repeat transparent; background-size:cover;">
								</div>
							</div>
							<button class="btn btn-md btn-default">Upload new image</button>
						</div>

						<div class="col-md-8 ">
							<div class="form-group">
								<label for="username">View Public Profile:</label>
								<a href="<?php echo ROOT.'/profile/'.$login->get_login_info('orcid_id').'/';?>">Profile</a>
							</div>
							<div class="form-group">
								<label for="username">Username:</label>
								<input type="text" class="form-control" id="username" value="<?php echo $login->get_login_info('username'); ?>" readonly>
							</div>

							<div class="form-group">
								<label for="doi">ORCID:</label>
								<input type="text" class="form-control" id="" value="<?php echo $login->get_login_info('orcid_id'); ?>" readonly>
							</div>
						</div>


					</form>
					<div class="form-group col-md-12 text-center hidden">
						<hr>
						<button type="submit" class="btn btn-lg btn-primary"><i class="glyphicon glyphicon-ok"></i> Save</button>
					</div>

				</div>
			</div>
		</div>


	</div><!--// container-->
</div><!--//site container-->


<?php include('snippets/footer.php');  ?>


