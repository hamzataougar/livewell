<?php
global $wp_query;
if (is_home()) {
    ?>
	<h1 class="title_home"><?php
                        $title_home = wp_title();
                        echo $title_home;
                        ?></h1>
<?php 
} elseif (is_category()) {
    global $current_cat;
    $desc_category = '';
		//$text_pages = ($paged > 1) ? __(" - Page ", REWORLDMEDIA_TERMS).$paged. __(" de ", REWORLDMEDIA_TERMS).$max_num_pages.__(" - ", REWORLDMEDIA_TERMS).multiexplode(array(":",","),get_bloginfo('name'))[0] : "";
    $text_pages = ($paged > 1) ? '<span class="small">' . __(" page ", REWORLDMEDIA_TERMS) . $paged . '</span>' : "";

    $cat_name = apply_filters('archive_title', '<span>' . $current_cat->name . '</span>', $current_cat);
    $desc_category .= '<h1 class="title">' . $cat_name;
    $desc_category .= apply_filters('remove_pagination_title', $text_pages);
    $desc_category .= '</h1>';
    $desc_category = apply_filters('hp_category_description', $desc_category);
    echo $desc_category;
} elseif (is_single()) {
    ?>
		<h1 class="title" itemprop="<?php echo (!empty($is_recette) && $is_recette) ? 'name' : 'headline'; ?> ">
	        <?php the_title(); ?>
	    </h1>
	<?php do_action('exactly_after_title'); 
    $cat = get_menu_cat_post(); 
} elseif (is_archive()) {
    the_archive_title('<h1 class=""><span>', '</span></h1>');
    the_archive_description('<div class="taxonomy-description">', '</div>');
}

