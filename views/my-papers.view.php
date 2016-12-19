<?php 
	//insert this view
	include('snippets/header.php'); 
?>

<div class="site-container site-main">
	<div class="container">
		<div class="row no-gutter site-main-holder">
			
			<div class="col-md-12">
				<div class="row">
					<h2 class="text-center">My Papers</h2>
					<p class="text-center">All those papers, all in one place.</p>
				</div>
				<main class="site-main__content">
					
					
						
					<div class="padding-bottom-30">
						<a href="<?php echo ROOT.'/edit-paper/'; ?>" class="btn btn-lg btn-default">+ Add Nanopub</a>
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
