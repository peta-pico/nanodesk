
<script>
	$(document).ready(function(){
		$('.add-aida').click( function(e){
			e.preventDefault();
			var aida_item = '<div class="aida-item col-md-12"><div class="col-md-3"><label for="">Does:</label><select name="aida_option[]" id="something" class="form-control"><option value="Confirms">Claim</option><option value="Refutes">Refutes</option><option value="option 3">option 3</option></select></div><div class="col-md-8"><label for="">Aida Sentence:</label><textarea name="aida[]" id="" class="form-control"></textarea><input type="hidden" class="aida_id" name="aida_id[]" value=""><input type="hidden" class="aida_action" name="aida_action[]" value="insert"></div><div class="col-md-1"><br><button class="delete-aida btn btn-md btn-default"><i class=" glyphicon glyphicon-trash"></i></button></div></div><!-- end aida -->';
			$('.aida-list--target').append(aida_item);
			//$('.aida-item').clone().insertAfter('.aida-list--target');
		});

		//ajax info
		$("#doi_submit").click(function(e)
		{
			e.preventDefault();
			var doi = $("#doi").val();
			//alert('the doi:'+ doi);

			$.ajax({
				type:"POST",
				url: "<?php echo ROOT;?>/ajax/doi_check.php",
				dataType:"json", 
				data:{ doi:doi },
	            cache:false,
	            beforeSend: function()
	            {
	                $(".preloader").hide().show();
	                $(".error").hide();
	                $(".success").hide();
	            },		

				success: function(result)
				{
					$(".preloader").hide();

					$.each(result, function(key, value){
					    console.log(key, value);
					    if(value != null || value != false || value !='' || value !='null'){
					    	$("#doi_"+key).text(value);
					    }
					});
					

		       		//alert(result);
				}
			}); // end ajax
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
		<div class="row no-gutter site-main-holder">
			
			<?php include('snippets/aside-nav.php'); ?>

			<div class="col-md-9 site-main__content-holder">
				<main class="site-main__content">
					<h2>Add new</h2>

					<div class="module">
						<div class="module-block__header" style="display:none;">
							<i class="glyphicon glyphicon-upload"></i> Edit paper
						</div>

						<?php if($alert['response'] !=''): ?>
							<div class="alert alert-<?php echo $alert['response']; ?>">
								<?php echo $alert['message']; ?>
							</div>
						<?php endif; ?>

						<div class="module-block__content  no-space">
							<form action="<?php echo ROOT.'/'.$_GET['p'].'/'.$add_to_url.'/'; ?>" method="POST">
								<label for="doi">DOI:</label>	

								<div class="doi-holder">
									<div class="input-group">
										<div class="input-group-addon">http://dx.doi.org/</div>
										<input type="text" class="form-control input-lg" id="doi" name="doi" value="10.1145/2531602.2531659" required>
									</div>
									<div class="text-center" style="margin-top:20px;">
										<button type="submit" id="doi_submit" class="btn btn-lg btn-primary">Check DOI</button>
									</div>
								</div>

								<div class="form-group">
									<div class="row">
										<p><strong>Title:</strong> <span id="doi_title"></span></p>
										<p><strong>Author:</strong> <span id="doi_author"></span></p>
										<p><strong>Journal:</strong> <span id="doi_journal"></span></p>
										<p><strong>pages:</strong> <span id="doi_pages"></span></p>
									</div>
								</div>

								<div class="form-group text-right" style="border-top:1px solid #ccc; padding-top:20px; ">
									<input type="hidden" name="action" value="directupload">
									<input type="hidden" name="paper_id" value="<?php echo ($formAction == 'insert' ) ? $add_to_url:$_GET['var']?>">
									<button type="submit" class="btn btn-md btn-primary"><i class="glyphicon glyphicon-ok"></i> Upload</button>
								</div>

							</form>
						</div>
					</div><!-- END module-->

				</main>				
			</div>
		</div>
	</div>
</div><!--//site container-->


<?php include('snippets/footer.php');  ?>

