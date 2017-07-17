<?php
	//insert this view
	include('snippets/header.php');

?>
<div class="site-container site-main">
<div class="container">

	<div class="row bg--white" style="padding:30px 0px; margin-bottom:20px;">
		<div class="col-md-12 text-center">
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
			<li class="col-xs-6">
				<a href="#tabs-paper" class="active">
					<i class="fa fa-eye" aria-hidden="true"></i> Has Read
				</a>
			</li>
			<li class="col-xs-6">
				<a href="#tabs-aida" class="inactive">
					<i class="fa fa-commenting" aria-hidden="true"></i>	AIDA
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
		<div id="tabs-paper" class="col-md-12 tabs-content">
			<div class="" style="padding:30px;">
				<table class="table table-striped">
					<tr>
						<td width="12%"><strong>Date Added</strong></td>
						<td><strong>Paper</strong></td>
						<td></td>
					
					</tr>

					<?php
						$i=0;
						foreach($user['papers'] as $paper):
					?>
							<tr>
								<td><?php echo date('d M Y', strtotime($paper['date'])); ?></td>
								<td>
									<?php echo '<strong>'.$paper['title'].'</strong>'; ?><br>
									<?php echo '<i>'.$paper['author'].'. '.$paper['journal'].'. '.$paper['year'].'</i>'; ?>
								</td>
								<td><a href="<?php echo $paper['doi_url']; ?>" target="_blank" class="btn btn-md btn-default">
									<i class="glyphicon glyphicon-new-window"></i> Read</a></td>
							</tr>
					<?php
						endforeach;
					?>
				</table>
			</div>
		</div>
		<div id="tabs-aida" class="col-md-12  tabs-content" style="display:none;">
			<div class="" style="padding:30px;">
				<table class="table table-striped">
					<tr>
						<td><strong>Date Added</strong></td>
						<td><strong>Sentence</strong></td>
						<td></td>
					</tr>

					<?php
						$i=0;
						foreach($aidas as $aida):
					?>
							<tr>
								<td><?php echo date('d M Y', strtotime($aida['date'])); ?></td>
								<td><?php echo $aida['sentence']; ?></td>
								<td><a href="<?php echo $aida['paper']['doi_url']; ?>" target="_blank" class="btn btn-md btn-default">
									<i class="glyphicon glyphicon-new-window"></i> Paper</a></td>
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
