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
					<h2>Add new ($module_title)</h2>
					<div class="module">
						<div class="module-block__header" style="display:none;">
							<i class="glyphicon glyphicon-upload"></i> Edit paper
						</div>
						<div class="module-block__content  no-space">
							<form>
								<div class="form-group">
									<label for="exampleInputEmail1">My Paper DOI</label>
									<input type="email" class="form-control" id="exampleInputEmail1" placeholder="http://" value="http://">
								</div>
								<div class="form-group">
									<label for="exampleInputFile">File input</label>
									<input type="file" id="exampleInputFile">
									<p class="help-block">Example block-level help text here.</p>
								</div>
								<div class="form-group">
									<label for="something">Does..</label>
									<select name="options" id="something" class="form-control">
										<option>option 1</option>
										<option>option 2</option>
										<option>option 3</option>
									</select>
								</div>
								<div class="form-group">
									<label for="doi2">About this paper (DOI)</label>
									<input type="text" class="form-control" id="doi2" placeholder="http://">
								</div>
								<div class="form-group text-right">
									<button type="submit" class="btn btn-md btn-primary"><i class="glyphicon glyphicon-ok"></i> Done</button>
								</div>
							</form>
						</div>
					</div>

					<div class="module module--default">
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
