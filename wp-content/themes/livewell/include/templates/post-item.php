<?php

$where = isset($where) ? $where : null;
$is_ul_tag = $is_ul_tag ?? false;
$title = apply_filters( 'block_post_title' , $post->post_title);
$cat_link = get_menu_cat_link($post, "link_cat", false, false, true);
$post_cat = apply_filters('block_post_categorie',$cat_link);
$link = get_permalink($post->ID);
$size = !empty($size) ? $size : 'rw_medium';
$class_post_item = !empty($class_post_item) ? $class_post_item : apply_filters('class_post_item','col-xs-12 col-sm-6',$where);
$class_post_item_image = !empty($class_post_item_image) ? $class_post_item_image : apply_filters('class_post_item_image','col-xs-12',$where);
$class_post_item_caption = !empty($class_post_item_caption) ? $class_post_item_caption : apply_filters('class_post_item_caption','col-xs-12',$where);
$index_block = isset($index_block) ? $index_block : 1;
$title_h2_to_h3 = $title_h2_to_h3 ?? false;

if (get_post_meta( $post->ID , 'post_auteur_ops' , true ) ) 
{
	$author = get_post_meta( $post->ID , 'post_auteur_ops' , true );
} else if (get_post_meta( $post->ID , 'post_auteur' , true ) ) 
{
	$author = get_post_meta( $post->ID , 'post_auteur' , true );
} else 
{
	$author = get_the_author();
}
?>
<?php if($is_ul_tag):?>
	<li class="post <?php echo $class_post_item;?>">
<?php else:?>
	<div class="post <?php echo $class_post_item;?>">
<?php endif;?>
		<div class="post_img <?php echo $class_post_item_image ;?> ">
		<a title="<?php echo $title ;?>" href="javascript:void(0);" data-href="<?php echo $link; ?>">
			<?php
				$yoast_wpseo_title = get_post_meta( $post->ID, "_yoast_wpseo_title", true );
				if( $yoast_wpseo_title != "" ){
					$img_attr = array( 'alt' => $yoast_wpseo_title );
				}else{
					$img_attr = array();
				}
				$img_attr['class'] = 'img-responsive';
				$image =  get_the_post_thumbnail( $post->ID, $size, $img_attr );
				$image = apply_filters("post_item_image", $image);
				echo $image;
			do_action('inside_post_image',$index_block,$class_post_item_caption,$post_cat,$post->post_type);				
				?>
		</a>
		<?php do_action('before_post_caption',$post->post_type,$link);?>
		</div>
	<div class="post_caption <?php echo $class_post_item_caption; ?>">
			<?php 
				do_action('after_post_image',$post->post_type,$post_cat,$index_block);

				$tag = '<div';
				$close_tag = '</div>';
				if( !$title_h2_to_h3){
					$tag = '<h2';
					$close_tag = '</h2>';
				}
				if($title_h2_to_h3){
					$tag = '<h3';
					$close_tag = '</h3>';
				}
				$tag .= ' class="post_title">';
				echo $tag;
			?>
			<a title="<?php echo $title;?>" href="<?php echo $link; ?>" >
				<?php echo $title; ?>
			</a>
		<?php
		echo $close_tag;
		$post_date = get_the_date();
		$post_date = apply_filters('custom_post_date', $post_date, $post,$index_block);
		if($post_date != ""){
		?>
		<div class="post_date"><?php echo $post_date; ?></div>
		<?php }?>
	</div>
<?php if($is_ul_tag):?>
	</li>
<?php else:?>
	</div>
<?php endif;?>
