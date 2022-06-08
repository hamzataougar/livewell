<?php


global $wp_query, $posts_exclude;
get_header();
//$posts_per_category = 24;

//$pagenum = !empty(get_query_var('paged')) ? get_query_var('paged') : 1;
//$offset = ($pagenum > 0) ?  $posts_per_category * ($pagenum - 1) : 0;
$current_cat = get_queried_object();
$parent_cat = get_category($current_cat->parent);
$categoy_has_parent = false;

?>
<div class="row">
	<?php if(!$categoy_has_parent) : ?>
	<div class="category_name"><h1><?php echo $current_cat->name; ?><h1></div>
	<?php endif; ?>
	<div id="content" role="main" class="col-xs-12 col-md-8 category-<?php echo $current_cat->slug; ?>">
		<?php 
				echo breadcrumb(); 
		?>	
		<div id="posts-rubrique">
		<?php

		$posts = $wp_query->posts;
		$bloc['posts'] = $posts;
		$bloc['category_object'] = $current_cat;
		$bloc['categoy_has_parent'] = $categoy_has_parent;
		
		include(locate_template('include/templates/category-posts.php'));
		
		echo reworldmedia_pagination(); 
		?>
		</div>
	</div>
	<?php get_sidebar(); ?>
</div>
<?php get_footer();