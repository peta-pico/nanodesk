<?php 
	//insert this view
	include('snippets/header.php'); 
?>

<div class="site-container site-main">
	<div class="container">
		<div class="row no-gutter site-main-holder">
			
			<?php include('snippets/aside-nav.php'); ?>

			<div class="col-md-9 site-main__content-holder">
				<main class="site-main__content">
					<div class="row">
						<div class="col-md-6"><h2>My Papers</h2></div>
						<div class="col-md-6 text-right">
							
						</div>
					</div>

					<div class="module">
						<div class="module-block__header" style="display:none;">
							<i class="glyphicon glyphicon-upload"></i> Edit paper
						</div>
						<div class="module-block__content  no-space">
							<form>

								<div class="form-group">
									<label for="username">Username:</label>
									<input type="text" class="form-control" id="username" value="<?php echo $login->get_login_info('username'); ?>">
								</div>

								<div class="form-group">
									<label for="doi">E-mail:</label>
									<input type="text" class="form-control" id="doi" value="<?php echo $login->get_login_info('email'); ?>" readonly>
								</div>

								<div class="form-group">
									<label for="Password">Reset Password</label>
									<input type="text" class="form-control" id="Password" name="Password">
								</div>

								<div class="form-group text-right">
									<button type="submit" class="btn btn-md btn-primary"><i class="glyphicon glyphicon-ok"></i> Save</button>
								</div>

							</form>
						</div>
					</div><!--//end module-->


				</main>				
			</div>
		</div>
	</div>
</div><!--//site container-->


<?php include('snippets/footer.php');  ?>
