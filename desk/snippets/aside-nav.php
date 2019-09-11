<!-- snippets/aside-nav -->
<div class="col-md-3 nav-aside-holder">
	<aside class="nav-aside">
		<nav class="nav-secondary">
			<?php 
				$p =  $_GET['p'];
				$active[$p] = "active"
			?>
			<ul>
				<li><a href="<?php echo ROOT; ?>/" class="<?php echo $active['']; ?>"><i class="glyphicon glyphicon-bookmark"></i> Dashboard</a></li>
				<li><a href="<?php echo ROOT; ?>/my-papers/" class="<?php echo $active['my-papers']; ?>/"><i class="glyphicon glyphicon-bookmark"></i> My Papers</a></li>
				<li><a href="<?php echo ROOT; ?>/my-profile/" class="<?php echo $active['my-profile']; ?>"><i class="glyphicon glyphicon-bookmark"></i>My Profile</a></li>
				<li><a href="#"><i class="glyphicon glyphicon-bookmark"></i> Link 4</a></li>
				<li><a href="#"><i class="glyphicon glyphicon-bookmark"></i> Link 5</a></li>
			</ul>
		</nav>
	</aside>				

</div>