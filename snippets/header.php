
<?php
// echo "<pre>";
// print_r( $login->get_login_info() );
// echo "</pre>";
?>
<div class="header-main">
	<div class="container">
		<div class="row">
			<nav class="nav-main">
				<div class="header-main__branding">
					<a href="<?php echo ROOT; ?>"><img src="<?php echo ROOT;?>/images/logo_white.png" alt="NanoDesk"></a>
				</div>

				<?php
					if( $login->get_login_info('id') ):
				?>
					<div class="nav-profile">
					 	<div class="nav-profile_image hidden" style="background-image:url(<?php echo ROOT.'/assets/profile2.png'?>)"></div>
					 	<div class="nav-profile_username"><?php echo $login->get_login_info('username'); ?></div>
						<i class="glyphicon glyphicon-triangle-bottom"></i>
					 	<ul>

					 		<li><a href="<?php echo ROOT.'/profile/'.$login->get_login_info('id'); ?>">View Profile</a></li>
							<li><a href="<?php echo ROOT.'/my-profile/'?>">My Account</a></li>
					 		<li class="seperator-top"><a href="<?php echo ROOT.'/&actie=uitloggen/'?>">Log Out</a></li>
					 	</ul>
					</div>
				<?php else: ?>
					<ul class="hidden-xs nav-main__cta">
						<li><a href="<?php echo ROOT.'/login/'; ?>">Log In</a></li>
					</ul>
				<?php
					endif;
				?>
			</nav>


		</div><!--// row-->
	</div><!--// container-->
</div><!--//site container-->
<?php
	if( $login->get_login_info('id') ):
?>
<div class="header-logged-in">
	<div class="container">
		<div class="row">
			<nav class="nav-logged-in">
				<ul>
					<!-- <li><a href="<?php echo ROOT.'/my-papers/'; ?>"><i class="glyphicon glyphicon-home" aria-hidden="true"></i> Feed</a></li> -->
					<li><a href="<?php echo ROOT.'/my-papers/'; ?>"><i class="glyphicon glyphicon-bookmark"></i>Papers i have read</a></li>
				</ul>
			</nav>
		</div>
	</div>
</div>
<?php
endif;
?>
