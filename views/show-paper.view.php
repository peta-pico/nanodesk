<?php
	//insert this view
	include('snippets/header.php');
?>

<div class="site-container site-main">
	<div class="container">
		<div class="row">
			<div class="text-center">
				<h2>View Paper</h2>
			</div>
		</div>
		<div id="doi_results" class="row no-gutter site-main-holder">

			<div class="col-md-10 col-md-offset-1 box">

				<?php if($alert['response'] !=''): ?>
					<div class="alert alert-<?php echo $alert['response']; ?>">
					<?php echo $alert['message']; ?>
					</div>
				<?php endif; ?>
				<div class="box-h-50 box-v-50">
					<p class="text-center">
						You have added the following paper on <strong><?php echo date('d M Y', strtotime($paper['date'])) ?></strong>:
					</p>
					<form class="ajaxform" action="<?php echo ROOT.'/ajax/edit_paper.php'; ?>" method="POST">

						<table class="table table-striped">
							<tr>
								<td><strong>Title</strong></td>
								<td><span  id="doi_title"><?php echo $paper['title'] ?></span></td>
							</tr>
							<tr>
								<td><strong>Author</strong></td>
								<td><span id="doi_author"><?php echo $paper['author'] ?></span></td>
							</tr>
							<tr>
								<td><strong>Journal</strong></td>
								<td><span  id="doi_journal"><?php echo $paper['journal'] ?></span></td>
							</tr>
							<tr class="hidden">
								<td><strong>Pages</strong></td>
								<td><span id="doi_pages"><?php echo $paper['pages'] ?></span></td>
							</tr>
							<tr class="hidden">
								<td><strong>Volume</strong></td>
								<td><span id="doi_volume"><?php echo $paper['volume'] ?></span></td>
							</tr>
							<tr>
								<td><strong>Year</strong></td>
								<td><span id="doi_year"><?php echo $paper['year'] ?></span></td>
							</tr>
							<tr>
								<td><strong>DOI</strong></td>
								<td><a href="<?php echo $paper['doi_url']; ?>"><?php echo $paper['doi'] ?></a></td>
							</tr>
						</table>
						

						<div class="box-h-50 box-v-50">
							<h3 class="text-center">AIDA sentence for this paper</h3>
							<?php if ( count($paper['aidas']) < 1 ): ?>
								<div class="alert alert-warning">
									No Aida vailable
								</div>
							<?php else: ?>
								
								<div style="padding:20px; border:1px solid #eee; margin-bottom:10px;">
									<table class="table table-hover">
										<thead>
											<tr>
												<th width="20%">Created on</th>
												<th width="60%"><a href="http://purl.org/aida/" target="_blank">AIDA Sentence <i class="fa fa-info-circle"></i></a></th>
												<th></th>
											</tr>
										</thead>
										<tbody>
											<?php foreach ($paper['aidas'] as $aida): ?>
												<tr>
													<td>
														<?php echo date('d M Y', strtotime($aida['date'])); ?>
													</td>
													<td>
														<?php echo $aida['sentence']; ?>
													</td>
													<td>
														<a class="btn btn-md btn-default" href="<?php echo $aida['np_uri']; ?>" target="_blank">
															<i class="glyphicon glyphicon-new-window"></i>
														</a>
														<a class="btn btn-md btn-danger" href="<?php echo ROOT.'/retract-aida/'.$aida['id']; ?>">
															<i class="glyphicon glyphicon-trash"></i>
														</a>
													</td>
												</tr>
											<?php endforeach ?>
										</tbody>
									</table>
									
								</div>
							
							<?php endif ?>
							
							
						</div>

						<div class="box-h-50 box-v-50 text-center">
							<a href="<?php echo ROOT.'/add-aida/'.$paper['id'].'/'; ?>" class="btn btn-lg btn-default">+ Add AIDA sentence for this paper</a>
						</div>
					</form>
				</div>
			</div><!--end col-10-->

		</div>
	</div><!--end container-->
</div><!--//site container-->


<?php include('snippets/footer.php');  ?>
