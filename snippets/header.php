
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
					<a href="#"><img src="<?php echo ROOT;?>/images/logo.png" alt="NanoDesk"></a>
				</div>

				<?php 
					if( $login->get_login_info('id') ):
				?>
					<div class="nav-profile">
					 	<div class="nav-profile_image" style="background-image:url(<?php echo ROOT.'/assets/profile2.png'?>)"></div>
					 	<div class="nav-profile_username"><?php echo $login->get_login_info('username'); ?></div>
						<i class="glyphicon glyphicon-triangle-bottom"></i>
					 	<ul>
					 		<li><a href="#">My Profile</a></li>
					 		<li><a href="#">Tab2</a></li>
					 		<li class="seperator-top"><a href="#">Log Out</a></li>
					 	</ul>
					</div>
				<?php else: ?>
					<ul class="hidden-xs nav-main__cta">
						<li><a href="<?php echo ROOT.'/login/'; ?>">Sign Up</a></li>
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
					<li><a href="<?php echo ROOT.'/my-papers/'; ?>"><i class="glyphicon glyphicon-file"></i>My Papers</a></li>
				</ul>
			</nav>	
		</div>
	</div>
</div>
<?php 
endif;
?>