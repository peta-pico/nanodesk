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
						<a href="<?php echo ROOT.'/add-paper/'; ?>" class="btn btn-lg btn-default">+ Add paper I have read</a>
					</div>

					<div class="module module--list">
						<div style="display:block; overflow:hidden; position:relative; width:100%;">

							<table class="table table-striped">
								<tr>
									<td><strong>Date</strong></td>
									<td><strong>Paper</strong></td>
									<td></td>
								</tr>

								<?php

									foreach($user['papers'] as $paper):

								?>
										<tr>
											<td><?php echo $paper['date']; ?></td>
											<td>
												<?php echo '<strong>'.$paper['title'].'</strong>'; ?><br>
												<?php echo '<i>'.$paper['year'].'</i>'; ?>
											</td>
											<td style="width:30%; text-align:right;">
												<a href="<?php echo ROOT.'/show-paper/'.$paper['id']; ?>" class="btn btn-md btn-default"><i class="fa fa-eye"></i>Show</a>
												<a href="<?php echo $paper['np_uri']; ?>" target="_blank" class="btn btn-md btn-default">Nanopub</a>
												<a href="<?php echo 'https://doi.org/'.$paper['doi']; ?>" target="_blank" class="btn btn-md btn-default">Paper</a>
												<a href="<?php echo ROOT.'/retract-paper/'.$paper['id'].'/'; ?>" target="" class="btn btn-md btn-danger">
													<i class="glyphicon glyphicon-trash"></i>
												</a>
											</td>

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
