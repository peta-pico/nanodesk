<?php
	//insert this view
	include('snippets/header.php');

?>
<div class="site-container site-main">
<div class="container">

	<div class="row bg--white" style="padding:30px 0px; margin-bottom:20px;">
		<div class="col-md-2">

		</div>
		<div class="col-md-2">
			<div style="width:150px; height:150px; background:url(http://lorempixel.com/300/300/sports/) 50% 50% no-repeat transparent; border-radius:50%; border:0px; background-size:cover;">
			</div>
		</div>
		<div class="col-md-4">
			<h2 style="margin-top:30px;"><?php echo $user['username']; ?>
				<a href="#" class="btn btn-md btn-default hidden" style="margin-right:15px;">+ Follow</a>
			</h2>
			<p class="hidden">Title Description</p>
			<div class="hidden">
				<a href="#" style="margin-right:15px;" class="">Following 8</a>
				<a href="#" style="margin-right:15px;" class="">Followers 12</a>
			</div>
		</div>
	</div>


	<div class="row bg--white">
		<ul class="tabs">
			<li class="col-xs-4">
				<a href="#" class="active">
					<i class="fa fa-eye" aria-hidden="true"></i> Has Read
				</a>
			</li>
			<li class="col-xs-4 hidden">
				<a href="#">
					<i class="fa fa-commenting" aria-hidden="true"></i>	Aida
				</a>
			</li>
			<li class="col-xs-4 hidden">
				<a href="#">
					tab3
				</a>
			</li>
		</ul>
	</div>

	<div class="row posrel bg--white">
		<div class="col-md-12">
			<div class="" style="padding:30px;">
				<table class="table table-striped">
					<tr>
						<td>Date</td>
						<td>Paper</td>
						<td>Action</td>
					</tr>

					<?php
						$i=0;
						foreach($user['papers'] as $paper):
					?>
							<tr>
								<td><?php echo $paper['date']; ?></td>
								<td><?php echo $paper['title']; ?></td>
								<td><a href="#" class="btn btn-md btn-default">View</a></td>
							</tr>
					<?php
						endforeach;
					?>
				</table>
			</div>
		</div>
	</div>
</div>
</div>

<?php include('snippets/footer.php');  ?>
