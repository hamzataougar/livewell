<?php 
get_header();
global $has_gallery, $has_video, $is_live_content;
$is_live_content = true;
?>

<div id="primary" class="site-content">
	<div class="row">
	 	<div id="content" role="main" class="site-content col-xs-12 col-md-8 col-lg-8 pull-left">
			<div id="results" class="post">
				<?php
				echo breadcrumb();
				while (have_posts()) {
					the_post(); ?>

					<div class="post">
						<article id="post-<?php the_ID(); ?>" class="item">
							<div id="top_intro_article">
								<h1 class="title"><?php the_title(); ?></h1>
								<span class="author_recette">
									<?php
										$author = apply_filters('change_the_author', get_the_author());
										echo $author;
									?>
								</span>
								<span class="date_recette">
									<?php
										$date = apply_filters('change_single_datetime', get_the_date());
										echo $date;
									?>
								</span>
								<?php do_action('into_top_intro_article'); ?>
							</div>
							<?php
							$page_has_video_top = page_has_video_top(); 
							if($page_has_video_top){
								do_action('show_video') ;
							}
							do_action('show_gallery');
							$img_top_id = get_img_top_article_id()  ;
							$attachment = wp_get_attachment_image_src($img_top_id, 'full');
							if (!empty($attachment)) { ?>
								<div class="image_top_single">
									<div class="image_a_lune">
										<span class="top_img" data-href="<?php echo $attachment[0]; ?>" title="<?php the_title(); ?>">
											<?php
												$atts = array("class" => "img-responsive alignnone size-full pinit-here");
												$size_thumb = 'rw_large';
												echo wp_get_attachment_image($img_top_id, $size_thumb, false, $atts);
											?>
										</span>
									</div>
								</div>
							<?php } ?>
							<?php if(has_excerpt()): ?>
							<div class="article-intro excerpt">
								<?php echo get_the_excerpt(); ?>
							</div>
							<?php endif; ?>
							<div class="article-content thecontent">
								<?php
								 	the_content();
									$is_live_content = false;

								  ?>
								<?php do_action('just_after_thecontent'); ?> 
							</div>
						</article>
						<?php 
						if(is_active_sidebar('after-single')) {
							dynamic_sidebar('after-single'); 
						}
						?>
						<div class="share">
							<h2 class="share_txt"><?php echo "Partager ce Contenu"; ?></h2>
							<?php echo do_shortcode("[simple_addthis_single]");?>
							<?php do_action('after_share_bloc');?>
						</div>
			
						<?php
						if (is_active_sidebar('before_comment_block')) { 
							dynamic_sidebar( 'before_comment_block' );
						}
						do_shortcode("[voir_aussi]");
						?>
					</div>
				<?php
				}
				?>
			</div>
		</div>
	<?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>
