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
						<div class="col-md-6 text-right"><a href="<?php echo ROOT.'/edit-paper/'; ?>" class="btn btn-md btn-default">+ Add New</a></div>
					</div>
	
					<div class="module" style="display:none;">
						<a href="#" class="btn btn-md btn-default">+ Add New</a>
					</div>
					<div class="module module--list">
						<div style="display:block; overflow:hidden; position:relative; width:100%;">
							<table class="table table-striped">
								<tr>
									<td>#</td>
									<td>Paper</td>
									<td>Action</td>
								</tr>
								
								<?php 
									$i=0;
									foreach($papers as $paper):
									
								?>
										<tr>
											<td><?php echo $i++; ?></td>
											<td><?php echo $paper; ?></td>
											<td><a href="#" class="btn btn-md btn-default">View</a></td>
										</tr>
								<?php 
									endforeach;
								?>
							</table>
						</div>
					</div>
				</main>				
			</div>
		</div>
	</div>
</div><!--//site container-->


<?php include('snippets/footer.php');  ?>
