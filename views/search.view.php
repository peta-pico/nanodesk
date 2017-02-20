<?php
	//insert this view
	include('snippets/header.php');

?>
<div class="site-container site-main">
	<div class="container">
		<div class="row bg--white box-v-50 box-h-50" style="margin-bottom:30px;">
			<div class="">
				<div class="" style="display:inline-block; border:1px solid #ddd; height:50px; width:400px;">
					<input type="text" name="q" value="" placeholder="DOI" style="width:100%; height:50px; border:0px; padding:0px;margin:0px;">
				</div>
				<div class="">
					<button type="submit">
						Search
					</button>
				</div>
			</div>
		</div>
		<div class="row bg--white">
			<ul class="tabs">
				<li class="col-xs-12">
					<a href="#" class="active">
						Results For DOI: $_GET['q']
					</a>
				</li>
			</ul>
		</div>

		<div class="">

		</div>

	</div>
</div>

<?php include('snippets/footer.php');  ?>
