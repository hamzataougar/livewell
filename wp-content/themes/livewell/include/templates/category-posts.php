<?php 
$tag_categories =[
    'parent_tag' => 'div',
    'item_tag' => 'div'
];
$tag_categories_list = apply_filters('change_tag_category_post', $tag_categories);
?>

<<?php echo $tag_categories_list["parent_tag"] ?> class="row">
    <?php
    $bloc_slug = !empty($bloc['category_object']->slug) ? $bloc['category_object']->slug : '';
    $categoy_has_parent = $bloc['categoy_has_parent'] ?? false;
    $nth_post = 0;
    $class_post_item =  'col-sm-12';
    foreach ($bloc['posts'] as $post) {
        setup_postdata($post);
        ?>
            <<?php echo $tag_categories_list["item_tag"]; ?> class="post col-xs-12 col-sm-6">
                <?php
                    $size = "rw_medium";
                    include(locate_template('include/templates/post-item.php'));
                ?>
            </<?php echo $tag_categories_list["item_tag"]; ?>>
		<?php 
        $nth_post++;
        $posts_exclude = add_value_to_array($post->ID, $posts_exclude);
        do_action('after_nth_category_post', $nth_post, $categoy_has_parent, $bloc['category_object']);
    }
    wp_reset_postdata();
    ?>
</<?php echo $tag_categories_list["parent_tag"] ?>>

