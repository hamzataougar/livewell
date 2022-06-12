<div class="row">
	<?php
	global $posts_exclude;
	$bloc['posts'] = apply_filters('articles_block', $bloc['posts'], $bloc['category']) ;
	$bloc_slug = !empty($bloc['category_object']->slug) ? $bloc['category_object']->slug : '';
	$class_post_item= apply_filters('custom_bloc_classes', 'col-sm-6', $index_block+1 );
	$categoy_has_parent = $bloc['categoy_has_parent'] ?? false;
	$nth_post = 0;
	$class_post_item = ($index_block %2 == 0) ? 'col-md-12' : 'col-md-6';
	$class_post_item_image = ($index_block %2 !== 0) ? 'col-md-12' : 'col-md-6';
	$class_post_item_image = apply_filters('class_bloc_category_post_image', $class_post_item_image, $index_block);
	$class_post_item_caption = ($index_block %2 !== 0) ? 'col-md-12' : 'col-md-6';
	$class_post_item_caption = apply_filters('class_bloc_category_post_caption', $class_post_item_caption, $index_block);
	$is_ul_tag =false;
	$title_h2_to_h3 =true;
	if($is_ul_tag && is_home()) echo '<ul class="list-cat-items">';
	foreach ($bloc['posts'] as $post) {
		setup_postdata($post);
		$size = "rw_medium";
		include(locate_template('include/templates/post-item.php'));
		$nth_post++;
		do_action('after_item_hp_bloc_rubrique');
		$posts_exclude = add_value_to_array($post->ID, $posts_exclude);
		do_action('after_nth_category_post',$nth_post, $categoy_has_parent, $bloc['category_object']);
	}
	if($is_ul_tag && is_home()) echo '</ul>';
	do_action('after_hp_bloc_rubrique_posts', $bloc['url']);
	wp_reset_postdata();
	?>

</div>
