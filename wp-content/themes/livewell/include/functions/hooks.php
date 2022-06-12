<?php

add_action('wp_enqueue_scripts', 'separated_stylesheet');

function separated_stylesheet(){
	global $wp_query;

	$stylesheet_dir_uri = get_stylesheet_directory_uri();
	$css_dir_uri = $stylesheet_dir_uri .'/assets/stylesheets/';

	$css_file = 'all';
	if( is_wp_home() ){
		$css_file =  "home";
	}else if( is_single() ){
		$css_file =  ( page_has_gallery() ) ? "single_gallery" : "single" ;
	}else if( is_page() ){
		$css_file =  "page";
	}else if( is_category() || is_archive() ){
		$css_file =  "rubrique";
	}else if( is_search() ){
		$css_file =  "search";
	}

	if( rw_is_mobile() ) $css_file .='_mobile';

    rw_enqueue_style( 'page_css', $css_dir_uri.$css_file.'.css', array('hbh-style'), CACHE_VERSION_CDN  );
}

add_action('wp_enqueue_scripts', 'add_scripts_css_js', 1);

function add_scripts_css_js() { 
	global $wp_styles, $site_config;

	$template_style_uri = get_stylesheet_uri();

	rw_enqueue_style('hbh-style', $template_style_uri, array(), CACHE_VERSION_CDN);
}

function wpi_stylesheet_uri($stylesheet_uri, $stylesheet_dir_uri) 
{	
	if(rw_is_mobile()){
		return $stylesheet_dir_uri."/assets/stylesheets/global_mobile.css";
	}else{
		return $stylesheet_dir_uri."/assets/stylesheets/global.css";
	}
}

add_filter('stylesheet_uri','wpi_stylesheet_uri',10,2);

add_action('after_homeMoreArticles_title','add_cat_more_article',1);
add_action('after_homeMoreArticles_title','add_cat_introduction',1);


/**
 * action : after_homeMoreArticles_title
 * 
 * ajouter le titre voir plus.
 * 
 * @param  array  $bloc
 * 
 * @return void
 */
function add_cat_more_article($bloc){
    if(isset($bloc['url']) && isset($bloc['title'])){
        echo '<a href="javascript:void(0);" data-href="'.$bloc['url'].'" title="'.$bloc['title'].'" class="read_more">Voir plus d\'articles</a>';
    }
}

/**
 * action : after_homeMoreArticles_title
 * 
 * ajouter un introduction pour la categorie.
 * 
 * @param  array  $bloc
 * 
 * @return void
 */
function add_cat_introduction(array $bloc) : void{
    $desc_cat = category_description($bloc['category']);
    if(!empty($desc_cat) ){
        echo '<div class="introduction"><p>'.$desc_cat.'</p></div>';
    }
   
}

add_action('custom_block_push','include_block_push',10,3);

function include_block_push(array $menu_items, array $bloc, int $index_block): void
{
	include(locate_template('include/templates/category-item.php'));
}


add_action( 'after_setup_theme', 'reworldmedia_setup' );
function reworldmedia_setup() {	
	add_theme_support('automatic-feed-links');
	register_nav_menu('primary', __('Primary Menu', 'reworldmedia'));
	add_theme_support('post-thumbnails');
	add_theme_support( 'menus' );
	add_theme_support( 'widgets' );
}
add_filter('use_block_editor_for_post', '__return_false');
add_filter( 'gutenberg_use_widgets_block_editor', '__return_false', 100 );
add_filter( 'use_widgets_block_editor', '__return_false' );

function register_widgets_init() {
	register_sidebar(array(
		'name' => __( 'Main Sidebar', 'reworldmedia' ),
		'id' => 'sidebar-1',
		'description' => __( 'Main Sidebar', 'reworldmedia' ),
		'before_widget' => '<div class="sidebar-1_widget">',
		'after_widget' => '</div>',
		'before_title' => '',
		'after_title' => '',
		));	
	
}
add_action( 'widgets_init', 'register_widgets_init' );