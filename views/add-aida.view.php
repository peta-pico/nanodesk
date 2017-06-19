<?php
	//insert this view
	include('snippets/header.php');
?>

<div class="site-container site-main">
	<div class="container">
		<div class="row">
			<div class="text-center">
				<h2>Add Aida</h2>
				
			</div>
		</div>
		<div id="doi_results" class="row no-gutter site-main-holder">

			<div class="col-md-10 col-md-offset-1 box">

				<?php if($alert['response'] !=''): ?>
					<div class="alert alert-<?php echo $alert['response']; ?>">
					<?php echo $alert['message']; ?>
					</div>
				<?php endif; ?>

				<div class="box-h-50 box-v-50">

					<form class="ajaxform ajax-required" action="<?php echo ROOT.'/ajax/add_aida.php'; ?>" method="POST">
						<div class="text-center" style="padding-bottom:40px;">
							<strong>Add Aida Claim for the following paper:</strong><br>
							<?php echo $paperData['title'] ?>
						</div>
						<div class="form-group">


							<div class="form-group">
								<label for="aida_sentence">Aida Sentence:</label>

								<textarea name="aida_sentence" class="form-control" rows="3" id="aida_sentence"></textarea>
							</div>

							<div id="ihaveread" class="checkbox text-center pd-10">
 								<label>
									<input type="checkbox" name="ihaveread" class="required">I understand that this claim will be made public
								</label>
							</div>

							<div class="form-group text-center pd-10">
								<input type="hidden" name="action" value="addaida">
								<input type="hidden" name="paper_id" value="<?php echo $paperData['id']; ?>">
								<input type="hidden" name="doi_url" value="<?php echo $paperData['doi_url']; ?>">
								<input type="hidden" name="uid" value="<?php echo $login->get_login_info('id'); ?>">

								<button type="submit" class="ajaxsubmit ajax-required-submit btn btn-lg btn-primary" disabled="disabled">
									<i class="glyphicon glyphicon-upload"></i>  Make Public
								</button>
							</div>
							<div class="form-group text-center pd-10">
								<div class="alert alert-danger text-center" style="display:none;">
									There was an error while uploading. Please try again in a few mintutes.
								</div>
								<div class="alert alert-warning text-center" style="display:none;">
									This cannot be done..
								</div>
							</div>
						</div>
					</form>

				</div>
			</div><!--end col-10-->

		</div>


	</div><!--end container-->
</div><!--//site container-->


<?php include('snippets/footer.php');  ?>
