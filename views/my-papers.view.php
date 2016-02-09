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
						<div class="row module__list-item">
							<div class="col-md-3"><strong>Date</strong></div>
							<div class="col-md-3"><strong>Paper title</strong></div>
							<div class="col-md-3"><strong>doi?</strong></div>
							<div class="col-md-3 text-right">
								&nbsp;
							</div>

						</div><!--//row-->
						<?php 
							foreach($papers as $paper):
						?>
						<div class="row module__list-item">
							<div class="col-md-3"><?php echo $paper['date']; ?></div>
							<div class="col-md-3"><?php echo $paper['id']; ?></div>
							<div class="col-md-3"><?php echo $paper['doi']; ?></div>
							<div class="col-md-3 text-right">
								<a href="<?php echo ROOT; ?>/edit-paper/<?php echo $paper['id']; ?>/">
									<i class="glyphicon glyphicon-pencil"></i>
								</a>
								<a href="#">
									<i class="glyphicon glyphicon-trash"></i>
								</a>
							</div>

						</div><!--//row-->
						<?php 
							endforeach;
						?>
					</div>
				</main>				
			</div>
		</div>
	</div>
</div><!--//site container-->


<?php include('snippets/footer.php');  ?>
