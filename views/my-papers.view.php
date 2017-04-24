<?php
	//insert this view
	include('snippets/header.php');
?>

<div class="site-container site-main">
	<div class="container">
		<div class="row no-gutter site-main-holder">

			<div class="col-md-12">
				<div class="row">
					<h2 class="text-center text-upper">Papers I have read</h2>
					<!-- <p class="text-center">All those papers, all in one place.</p> -->
				</div>
				<main class="site-main__content">
					<?php if($_GET['feedback'] !=''): ?>
						<div class="alert alert-success text-center mg-bottom-30">
							<strong>Success!</strong> Action completed.
						</div>
					<?php endif; ?>


					<div class="padding-bottom-30">
						<a href="<?php echo ROOT.'/edit-paper/'; ?>" class="btn btn-lg btn-default">+ Add paper I have read</a>
					</div>

					<div class="module module--list">
						<div style="display:block; overflow:hidden; position:relative; width:100%;">
							Papers From DB
							<table class="table table-striped">
								<tr>
									<td>Date</td>
									<td>Paper</td>
									<td></td>
								</tr>

								<?php

									foreach($user['papers'] as $paper):

								?>
										<tr>
											<td><?php echo$paper['date']; ?></td>
											<td>
												<?php echo $paper['title']; ?><br>
												<?php echo $paper['np_hash']; ?>
											</td>
											<td style="width:30%; text-align:right;">
												<a href="<?php echo $paper['np_uri']; ?>" target="_blank" class="btn btn-md btn-default">Nanopub</a>
												<a href="<?php echo 'https://doi.org/'.$paper['doi']; ?>" target="_blank" class="btn btn-md btn-default">Paper</a>
												<a href="<?php echo ROOT.'/delete-paper/'.$paper['id'].'/'; ?>" target="" class="btn btn-md btn-danger">
													<i class="glyphicon glyphicon-trash"></i>
												</a>
											</td>

										</tr>
								<?php
									endforeach;
								?>
							</table>

							Papers From API
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
