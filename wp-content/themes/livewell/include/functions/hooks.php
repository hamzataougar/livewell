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