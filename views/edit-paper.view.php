<script>
	$(document).ready(function()
	{

		$("#doi").on("change paste", function(){
			//alert($(this).val());

			var x = $(this).val().replace('http://dx.doi.org/', '').replace('dx.doi.org/', '').replace('https://doi.org/', '');;
			$(this).val(x);
		});

		$('.add-aida').click( function(e)
		{
			e.preventDefault();
			var aida_item = '<div class="aida-item col-md-12"><div class="col-md-3"><label for="">Does:</label><select name="aida_option[]" id="something" class="form-control"><option value="Confirms">Claim</option><option value="Refutes">Refutes</option><option value="option 3">option 3</option></select></div><div class="col-md-8"><label for="">Aida Sentence:</label><textarea name="aida[]" id="" class="form-control"></textarea><input type="hidden" class="aida_id" name="aida_id[]" value=""><input type="hidden" class="aida_action" name="aida_action[]" value="insert"></div><div class="col-md-1"><br><button class="delete-aida btn btn-md btn-default"><i class=" glyphicon glyphicon-trash"></i></button></div></div><!-- end aida -->';
			$('.aida-list--target').append(aida_item);
			//$('.aida-item').clone().insertAfter('.aida-list--target');
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
				<h2>Add Nanopublication</h2>
				<p>Let the world know what you are working on.</p>
			</div>
		</div>
		<div class="row no-gutter site-main-holder">
			<div class="col-md-10 col-md-offset-1 box ">
				<div class="box-h-50 box-v-50">
					<p class="text-center"><strong>Provide us with a DOI, we do the rest</strong></p>
					<div class="doi-holder">
						<div class="input-group">
							<div class="input-group-addon">http://dx.doi.org/</div>
							<input type="text" class="form-control input-lg" id="doi" name="doi" value="10.1109/5254.920602" required>
						</div>
						<div class="text-center" style="margin-top:20px;">
							<div class="error alert alert-danger" style="display:none;">There is no data found under the given DOI</div>
							<button type="submit" id="doi_submit" class="btn btn-lg btn-primary" style="font-weight:bold;">
								<i class="glyphicon glyphicon-search"></i> CHECK DOI
							</button>
							<br>
							<br>
							<div class="w3loader" style="display:none;"></div>
						</div>
					</div>
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
					<p class="text-center">
						Is the following information correct?
					</p>
					<form class="ajaxform" action="<?php echo ROOT.'/ajax/edit_paper.php'; ?>" method="POST">

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
							<tr>
								<td><strong>Pages</strong></td>
								<td><span id="doi_pages"></span></td>
							</tr>
						</table>

						<div class="form-group">
							<input type="hidden" id="title" name="title" value="">
							<input type="hidden" id="author" name="author" value="">
							<input type="hidden" id="journal" name="journal" value="">
							<input type="hidden" id="pages" name="pages" value="">

							<div class="form-group">
								<label for="trigtype">Choose publish format</label>
								<select id="trigtype" name="trigtype" class="form-control" id="">
									<option value="read">Has Read</option>
									<option value="aida">AIDA</option>
								</select>
							</div>


							<div class="form-group text-center box-50">
								<input type="hidden" name="action" value="addpaper">
								<input type="hidden" name="uid" value="<?php echo $login->get_login_info('id'); ?>">
								<button type="submit" class="ajaxsubmit btn btn-lg btn-primary">
									<i class="glyphicon glyphicon-ok"></i> Upload
								</button>
							</div>

						</div>
					</form>
				</div>
			</div><!--end col-10-->

		</div>
	</div><!--end container-->
</div><!--//site container-->


<?php include('snippets/footer.php');  ?>
