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
						You have read the following paper:
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
							<tr>
								<td><strong>Pages</strong></td>
								<td><span id="doi_pages"><?php echo $paper['pages'] ?></span></td>
							</tr>
							<tr>
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
						<p>
							<a href="#">2 others have read this paper</a>
						</p>

						<div class="box-h-50 box-v-50 text-center">
							<a href="#" class="btn btn-lg btn-default">+ Add Aida</a>
						</div>
					</form>
				</div>
			</div><!--end col-10-->

		</div>
	</div><!--end container-->
</div><!--//site container-->


<?php include('snippets/footer.php');  ?>
