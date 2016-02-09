
<script>
	$(document).ready(function(){
		$('.add-aida').click( function(e){
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
								<div class="form-group">
									<label for="doi">DOI:</label>
									<input type="text" class="form-control" id="doi" name="doi" value="http://dx.doi.org/10.1145/2531602.2531659" required>
								</div>

								<div class="form-group">
									<div class="col-md-12">
										<p><strong>Author:</strong> abc</p>
										<p><strong>Author:</strong> abc</p>
										<p><strong>Author:</strong> abc</p>
									</div>
								</div>
								<div class="form-group">
									<label for="recommend">
									<input type="checkbox" id="recommend" class="" name="recommend">
									I reccomend this paper
									</label>
								</div>
								<div class="form-group" style="display:none;">
									<label for="exampleInputFile">File input</label>
									<input type="file" id="exampleInputFile">
									<p class="help-block">Example block-level help text here.</p>
								</div>

								<div class="form-group aida-list aida-list--target">
								
									<?php 
										if($formAction == 'insert'):
									?>
										<div class="aida-item col-md-12" style="display:none;">
											<div class="col-md-3">
												<label for="">Does:</label>
												<select name="aida_option[]" id="something" class="form-control">
													<option value="Confirms">Claim</option>
													<option value="Refutes">Refutes</option>
													<option value="option 3">option 3</option>
												</select>
											</div>
											<div class="col-md-8">
													<label for="">Aida Sentence:</label>
													<textarea name="aida[]" class="form-control"></textarea>
													<input type="hidden" class="aida_id" name="aida_id[]" value="<?php echo $last_aida_id; ?>">
													<input type="hidden" class="aida_action" name="aida_action[]" value="<?php echo $formAction; ?>">
											</div>
											<div class="col-md-1">
												<br>
												<button class="delete-aida btn btn-md btn-default"><i class="glyphicon glyphicon-trash"></i></button>
											</div>
										</div><!-- end aida -->
									<?php
										endif;

										if($formAction == 'update'):

											foreach($aidas as $aida_item):
											$selected[$aida_item['aida_option']] = 'selected="selected"'; 
									?>
									
												<div class="aida-item col-md-12">
													<div class="col-md-3">
														<label for="">Does:</label>
														<select name="aida_option[]" id="something" class="form-control">
															<option value="Confirms" <?php echo $selected['Confirms']; ?>>Claim</option>
															<option value="Refutes" <?php echo $selected['Refutes']; ?>>Refutes</option>
															<option value="option 3" <?php echo $selected['option 3']; ?>>option 3</option>
														</select>
													</div>
													<div class="col-md-8">
															<label for="">Aida Sentence:</label>
															<textarea name="aida[]" class="form-control"><?php echo $aida_item['description'] ?></textarea>
															<input type="hidden" class="aida_id" name="aida_id[]" value="<?php echo $aida_item['id']; ?>">
															<input type="hidden" class="aida_action" name="aida_action[]" value="<?php echo $formAction; ?>">
													</div>
													<div class="col-md-1">
														<br>
														<button class="delete-aida btn btn-md btn-default"><i class="glyphicon glyphicon-trash"></i></button>
													</div>
												</div><!-- end aida -->
									<?php
											endforeach;
										endif;
									?>


								</div><!--end aida-list-->
								<div class="form-group text-left aida-controls">
									<button class="add-aida btn btn-md- btn-primary">+ Add Aida</button>
								</div>
								<div class="form-group" style="display:none;">
									<label for="doi2">About this paper (DOI)</label>
									<input type="text" class="form-control" id="doi2" name="doi2" placeholder="http://" value="http://"  required>
								</div>


								<div class="form-group text-right" style="border-top:1px solid #ccc; padding-top:20px; ">
									<input type="hidden" name="action" value="<?php echo $formAction; ?>">
									<input type="hidden" name="paper_id" value="<?php echo ($formAction == 'insert' ) ? $add_to_url:$_GET['var']?>">
									<button type="submit" class="btn btn-md btn-primary"><i class="glyphicon glyphicon-ok"></i> Save</button>
								</div>

								<code>
									<?php 
										if($_GET['var']){
											//echo $paper['doi'];

											$trigdata = $trig->aida($paper['doi'],$date,$login->get_login_info('orcid'));

											echo(htmlspecialchars($trigdata));

											$filename = $paper['id'].'_'.$login->get_login_info('orcid').'_'.date('Y-d-m');
											$trig->writeFile($filename, $trigdata, 'trigfiles');
										}
									?>
								</code>

							</form>
						</div>
					</div>

					<div class="module module--default" style="display:none;">
						<div class="module-block__header">
							<i class="glyphicon glyphicon-bookmark"></i> Block title
						</div>
						<div class="module-block__content">
							<form>
								<div class="form-group">
									<label for="exampleInputEmail1">Email address</label>
									<input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email">
								</div>
								<div class="form-group">
									<label for="exampleInputPassword1">Password</label>
									<input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
									</div>
								
								<div class="checkbox">
									<label>
									  <input type="checkbox"> Check me out
									</label>
								</div>

								<button type="submit" class="btn btn-default">Submit</button>

							</form>
						</div>
					</div><!--// module-->
				</main>				
			</div>
		</div>
	</div>
</div><!--//site container-->


<?php include('snippets/footer.php');  ?>

