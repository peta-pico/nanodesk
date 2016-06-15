
<?php 
// echo "<pre>";
// print_r( $login->get_login_info() );
// echo "</pre>";
?>
<div class="site-container header-main">
	<div class="container">
		<div class="row">
			<header>
				<nav class="nav-main">
					<div class="header-main__branding">
						<a href="#"><img src="<?php echo ROOT;?>/images/logo.png" alt="NanoDesk"></a>
					</div>

					<?php 
						if( $login->get_login_info('id') ):
					?>
						<ul class="hidden-xs nav-main__cta">
							<li><a href="<?php echo ROOT.'/?actie=uitloggen';?>">Log Out</a></li>
						</ul>
					<?php else: ?>
						<ul class="hidden-xs nav-main__cta">
							<li><a href="#">Sign Up</a></li>
							<li><a href="#">Log In</a></li>
						</ul>
					<?php 
						endif;
					?>
				</nav>			
			</header>
		</div><!--// row-->
	</div><!--// container-->
</div><!--//site container-->