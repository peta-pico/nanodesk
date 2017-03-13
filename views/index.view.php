<?php
	//insert this view
	include('snippets/header.php');

?>
<div class="hero" style="background-image:url(<?php echo ROOT.'/images/hero/web.jpeg';?>); height:90vh;">

	<div class="hero__content text-center">
		<h1>Login to Nanodesk</h1>
		<p style="color:white;">
			Nanodesk requires you to login with an Orcid account.
		</p>

		<a  style="margin-top:20px;" href="<?php echo $orcid->loginUrl(); ?>" class="btn btn-lg btn-success">
		  Login With ORCID
		</a>
	</div>

	<div class="hero__content text-center hidden">
		<h1>Search DOI</h1>
		<div class="hero--search">
			<input type="text" class="__input" placeholder="e.g: 10.1016/0004-3702(91)90053-M">
			<button class="__submit"><i class="glyphicon glyphicon-search"></i></button>
		</div>
	</div>

</div>

<div class="container hidden">

	<div class="row">
		<div class="col-md-4">
			<h3>Bookmark Papers</h3>
			<p>
				Easy bookmarking and storing of papers.
			</p>
		</div>
		<div class="col-md-4 ">
			<h3>Search DOI</h3>
			<p>Just provide us with the DOI. We'll fill in the blanks for ya!</p>
		</div>
		<div class="col-md-4">
			<h3>Find Others</h3>
			<p>See what other researchers are reading.<br> It's inspiring!</p>
		</div>
	</div>
</div>

<?php include('snippets/footer.php');  ?>
