<?php 
global $posts_exclude;

    $last_posts = last_posts_by_category( 0 , apply_filters( 'count_posts_block_category' , 3 ));


	$pull_list=" pull_list";

	$menu_id = apply_filters('get_menu_name', 'menu_header', 'menu_header');			
	$menu_items = wp_get_nav_menu_items($menu_id);
$index_block= 0 ;
$min_bloc_posts_nb = apply_filters('hp_bloc_article_min_posts_nb', 3);

foreach ($last_posts as $bloc) {
	do_action('block_push_before_index_'.($index_block+1));
	$force_bloc_push = apply_filters('force_bloc_push', false , $bloc["category"]) ;
	$force_hide_bloc_push = apply_filters('force_hide_bloc_push', false , $bloc['category_object']) ;
	do_action('before_homeMoreArticle_bloc', $bloc['category_object']) ;
	if( ((count($bloc['posts']) >= $min_bloc_posts_nb or $force_bloc_push)) && !$force_hide_bloc_push){
		$cat_id_block_push=$bloc["category"];
		$cat_name = get_cat_slug($cat_id_block_push);
		$cat_style_bloc = apply_filters('bloc_push_cls', " block_" .$cat_name, $index_block+1);
	 	?>
    	<div class="homeMoreArticles<?php echo $pull_list; ?><?php echo $cat_style_bloc; ?> bloc_rubrique clearfix">
    		<?php do_action('before_block_push', $bloc); ?>
    		
	    	<?php
		    	$title = apply_filters('title_home_h2', $bloc['title'],$cat_name);
		    	echo '<div class="homeMoreArticles_head">';
		    	show_title_home_h2($title, $bloc['url'] , apply_filters('more_category_text' , '' , $bloc['title'] ), apply_filters('bloc_push_js_link', true));
		    	do_action('after_homeMoreArticles_title', $bloc);
		    	echo '</div>';
			$desc = apply_filters('show_category_description',"",$cat_id_block_push);
			echo $desc;
				do_action('custom_block_push',$menu_items,$bloc, $index_block);
			

	        ?>
    	</div>
	<?php

			$pull_list=" pull_list";

		do_action('after_homeMoreArticle_bloc', $bloc['category_object']) ;
	} 

	do_action('liste_plus_artiles_rubriques', $index_block, $last_posts);
	do_action('display_between_category_last-posts', $index_block, count($last_posts));
	$index_block++;
}
	do_action('after_homeMoreArticles');
?>

