<?php 
global $posts_exclude , $diaporama_accueil, $articles_accueil;

get_header(); 
$diaporama_accueil = '';
$paged = get_query_var('paged') ? get_query_var('paged') : 1;

$number_posts_accueil=  4;

$diaporama_accueil = $articles_accueil = [];

$args_diapo = [
			'paged' => $paged, 
			'posts_per_page' => 1,
			'post_type' =>array('post'),
			'numberposts' => 1
			];
$args_diapo = apply_filters('diaporama_accueil_articles_args', $args_diapo);
// cache Diaporama articles

	$diaporama_accueil = get_posts($args_diapo);


$posts_exclude = add_value_to_array($diaporama_accueil[0]->ID, $posts_exclude);	

include(locate_template('include/templates/title-page.php'));

do_action('block_before_full_carousel');

$home_diapo_template = apply_filters( "home_diapo_template", 'include/templates/home-full-diaporama.php' );
include(locate_template($home_diapo_template));

do_action('block_after_full_carousel');
do_action('rew_head','home');

$args = [
			'paged' => $paged, 
			'posts_per_page' => $number_posts_accueil,
			'post__not_in' => $posts_exclude, 
			'post_type' => apply_filters('post_type_filter', array('post','test'), 'articles_accueil', 'home_last_posts'),
		];	

$args = apply_filters('accueil_articles_args', $args);

// cache  last post accueil

	$articles_accueil = get_posts($args);
?>

<div class="row">
	<div id="content" role="main" class="col-xs-12 col-md-8 col-lg-8 pull-left">
		<div id="results">
			<?php do_action('block_before_carousel'); ?>
			<div id="homeBody" >
				<?php
				echo '<div class="row items-posts">';
				foreach($articles_accueil  as $post) { 
					setup_postdata($post); 
					$i ++;
					do_action('before_item_'.$i.'_hp', $articles_accueil);
					$posts_exclude = add_value_to_array(get_the_ID(), $posts_exclude);
					include(locate_template('include/templates/post-item.php'));
					do_action('after_item_'.$i.'_hp', $articles_accueil);
					do_action( 'after_item_hp' );
				}
				do_action('index_homebody_after_list-item-normal');

			
					echo '</div>';

				$args_['post__not_in'] = $posts_exclude; 

				wp_reset_postdata();
				?>
			</div>

			<?php 
			do_action('after_home_block');
	        include(locate_template(  apply_filters(  'last_posts_template' ,  'include/templates/last-posts.php' ) ));
			do_action('after_home_categories') ; 
			?>
		</div>
	</div>

<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
