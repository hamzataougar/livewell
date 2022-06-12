<header class="main-header">
	<div class="container clearfix">

		<?php
		$home_url = esc_url(apply_filters('logo_home_url', home_url('/')));
		$alt_logo_header = apply_filters('alt_logo_header', get_bloginfo('name'));
		$img_logo = apply_filters('default_logo_site', STYLESHEET_DIR_URI . '/assets/images/logo_header.png');
		if (!rw_is_mobile()) :
			do_action('before_nav_menu');
			if (apply_filters('show_logo_site', true)) :
		?>
			<div class="navbar-brand">
				<a href="<?php echo $home_url; ?>">
					<img src="<?= $img_logo; ?>" class="img-responsive" alt="<?php echo $alt_logo_header; ?>" />
				</a>
			</div>
		<?php endif;
		endif; ?>
		<nav class="navbar navbar-site">
			<div class="navbar_elem_wrapper">
				<?php 
				do_action('into_nav_menu');
 				?>
				<button type="button" class="default-toggle" data-action="burger" data-toggle="modal" data-target="#MainMenu">
					<span class="mobile-navigation-toggle">Toggle navigation</span>
				</button>
				<div class="navbar-brand-sm">
					<a href="<?php echo $home_url; ?>">
						<img src="<?= $img_logo; ?>" class="img-responsive" alt="<?php echo $alt_logo_header; ?>" />
					</a>
				</div>
				<?php

				header_menu();
				?>
				<button type="button" class="toggle_search" data-toggle="modal" data-target="#searchmodal"><span>search</span></button>
			</div>
		</nav>
	</div>
</header>

<?php
do_action('after_nav_menu_v3');
?>
<?php if (rw_is_mobile()) : ?>
	<div class="modal fade" id="MainMenu" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-body">
					<button type="button" class="close close-burger" data-dismiss="modal" aria-label="Close"></button>
					<?php echo get_the_menu_header_v2(); ?>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>