<!DOCTYPE html>

<html <?php language_attributes(); ?> class='no-js'>
<!--<![endif]-->
<?php do_action('before_head_tag');


?>

<head>
	<meta charset="utf-8" />
	<?php
	//do_action('top_head_rw');

	$favicon = get_bloginfo('stylesheet_directory') . '/assets/images/favicon.png';
	?>
	<link rel="shortcut icon" type="image/png" href="<?php echo  $favicon; ?>">
	<?php

	do_action('wp_head');
	?>

</head>
<?php
$attributs = apply_filters('add_attributs_body', '');
?>
<body <?php echo $attributs; body_class(); ?>>
	<?php
	do_action('rew_top_head');

	$sidebar = apply_filters('filter_all_sidebar', 'sidebar-after-body');
	if (is_active_sidebar($sidebar)) {
		dynamic_sidebar($sidebar);
	}
	$sidebar = apply_filters('filter_all_sidebar', 'sidebar-header-pub');
	if (is_active_sidebar($sidebar)) {
	?>
		<div class="sidebar-header-pub row">
			<?php
			dynamic_sidebar($sidebar);
			?>
		</div>
	<?php } ?>

	<div id="page">
		<?php
		load_template(locate_template('nav-menu.php'));
		do_action('before_id_container');
		$classes = apply_filters('header_container_classes', '');
		?>
		<div id="container" <?php echo $classes; ?>>
			<div class="container">
				<?php
				//do_action('rew_head', 'all');
