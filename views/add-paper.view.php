<script>
	$(document).ready(function()
	{

		$("#doi_check").on("change paste", function(){
			//alert($(this).val());

			var x = $(this).val().replace('http://dx.doi.org/', '').replace('dx.doi.org/', '').replace('https://doi.org/', '').replace('http://doi.org/', '');
			$(this).val(x);
		});

		$('.add-aida').click( function(e)
		{
			e.preventDefault();
			var aida_item = '<div class="aida-item col-md-12"><div class="col-md-3"><label for="">Does:</label><select name="aida_option[]" id="something" class="form-control"><option value="Confirms">Claim</option><option value="Refutes">Refutes</option><option value="option 3">option 3</option></select></div><div class="col-md-8"><label for="">Aida Sentence:</label><textarea name="aida[]" id="" class="form-control"></textarea><input type="hidden" class="aida_id" name="aida_id[]" value=""><input type="hidden" class="aida_action" name="aida_action[]" value="insert"></div><div class="col-md-1"><br><button class="delete-aida btn btn-md btn-default"><i class=" glyphicon glyphicon-trash"></i></button></div></div><!-- end aida -->';
			$('.aida-list--target').append(aida_item);

		});

		$("#doi_submit").click( function(e){
			e.preventDefault();

			//$('#doi_results').show();
			$('#manual_input').hide();
		})

		$('#manual_btn').click( function(e)
		{
			e.preventDefault();

			$('#doi_results').hide();
			$('#manual_input').show();
		});


	});

	$('body').on('click', '.delete-aida', function(e){
		e.preventDefault();
		$(this).closest('.aida-item').slideUp().remove();
	});

</script>
<?php
	//insert this view
	include('snippets/header.php');
?>

<div class="site-container site-main">
	<div class="container">
		<div class="row">
			<div class="text-center">
				<h2>Add Paper I have read</h2>
				<p>Let the world know what you are reading.</p>
			</div>
		</div>
		<div class="row no-gutter site-main-holder">
			<div class="col-md-10 col-md-offset-1 box ">
				<div class="box-h-50 box-v-50">
					<form action="<?php echo ROOT.'/ajax/doi_check.php';?>">
						<p class="text-center"><strong>Provide us with a DOI, we do the rest</strong></p>
						<div class="doi-holder">
							<div class="input-group">
								<div class="input-group-addon">http://dx.doi.org/</div>
								<input type="text" class="form-control input-lg" id="doi_check" name="doi" value="" required>
							</div>
							<div class="text-center" style="margin-top:20px;">
								<div class="error alert alert-danger" style="display:none;">There is no data found under the given DOI</div>
								<button type="submit" id="doi_submit" class="btn btn-lg btn-primary" style="font-weight:bold;">
									<i class="glyphicon glyphicon-search"></i> CHECK DOI
								</button>
								<br>
								<br>
								<a href="#" id="manual_btn">Add paper without DOI</a>
								<br>
								<br>
								<div class="w3loader" style="display:none;"></div>
							</div>
						</div>
					</form>
				</div>

			</div>
		</div>

		<div id="doi_results" class="row no-gutter site-main-holder" style="display:none;">

			<div class="col-md-10 col-md-offset-1 box">

				<?php if($alert['response'] !=''): ?>
					<div class="alert alert-<?php echo $alert['response']; ?>">
					<?php echo $alert['message']; ?>
					</div>
				<?php endif; ?>

				<div class="box-h-50 box-v-50">

					<form class="ajaxform ajax-required" action="<?php echo ROOT.'/ajax/add_paper.php'; ?>" method="POST">

						<table class="table table-striped">
							<tr>
								<td><strong>Title</strong></td>
								<td><span  id="doi_title"></span></td>
							</tr>
							<tr>
								<td><strong>Author</strong></td>
								<td><span id="doi_author"></span></td>
							</tr>
							<tr>
								<td><strong>Journal</strong></td>
								<td><span  id="doi_journal"></span></td>
							</tr>
							<tr class="hidden">
								<td><strong>Pages</strong></td>
								<td><span id="doi_pages"></span></td>
							</tr>
							<tr class="hidden">
								<td><strong>Volume</strong></td>
								<td><span id="doi_volume"></span></td>
							</tr>
							<tr>
								<td><strong>Year</strong></td>
								<td><span id="doi_year"></span></td>
							</tr>
						</table>

						<div class="form-group">
							<input type="hidden" id="title" name="title" value="">
							<input type="hidden" id="author" name="author" value="">
							<input type="hidden" id="journal" name="journal" value="">
							<input type="hidden" id="pages" name="pages" value="">
							<input type="hidden" id="volume" name="volume" value="">
							<input type="hidden" id="year" name="year" value="">
							<input type="hidden" id="doi" name="doi" value="">

							<div id="ihaveread" class="checkbox text-center pd-10">
 								<label>
									Click below to publicly announce that you have read that paper.
								</label>
							</div>

							<div class="form-group text-center pd-10">
								<input type="hidden" name="action" value="addpaper">
								<input type="hidden" name="uid" value="<?php echo $login->get_login_info('id'); ?>">
								<button type="submit" class="ajaxsubmit ajax-required-submit btn btn-lg btn-primary">
									<i class="glyphicon glyphicon-upload"></i>  Announce
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

		<div id="manual_input" class="row no-gutter site-main-holder" style="display:none;">
			<!--
				Form For Manual Input
			-->
			<div class="col-md-10 col-md-offset-1 box ">
				<div class="box-h-50 box-v-50">
					<form class="ajaxform ajax-required" action="<?php echo ROOT.'/ajax/add_paper.php'; ?>" method="POST">

						<div class="form-group">
							<label for="title">Paper URL <span class="redText">*</span></label>
							<input type="text" id="doi_url" class="form-control input-lg" name="doi_url" value="http://">
						</div>

						<div class="form-group">
							<div class="form-group">
							    <label for="title">Title <span class="redText">*</span></label>
							    <input type="text" id="title" class="form-control input-lg" name="title" value="">
							</div>
							<div class="form-group">
							    <label for="author">Author(s)? <span class="redText">*</span> </label>
								<input type="text" id="author" class="form-control input-lg" name="author" value="">
							</div>
							<div class="form-group">
							    <label for="journal">Journal <span class="redText">*</span></label>
							   	<input type="text" id="journal" class="form-control input-lg" name="journal" value="">
							</div>
							<div class="form-group">
							    <label for="year">Year <span class="redText">*</span></label>
							    <input type="text" id="year" class="form-control input-lg" name="year" value="">
							</div>

							<div id="ihaveread" class="checkbox text-center pd-10">
								<label>
									Click below to publicly announce that you have read that paper.
								</label>
							</div>

							<div class="form-group text-center pd-10">
								<input type="hidden" name="action" value="addpaper_manual">
								<input type="hidden" name="uid" value="<?php echo $login->get_login_info('id'); ?>">
								<button type="submit" class="ajaxsubmit ajax-required-submit btn btn-lg btn-primary" disabled="disabled">
									<i class="glyphicon glyphicon-upload"></i>  Announce
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
				</div><!-- end block 50 -->
			</div>
		</div>
	</div><!--end container-->
</div><!--//site container-->


<?php include('snippets/footer.php');  ?>
