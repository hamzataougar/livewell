<?php

define('DEFAULT_CACHE_VERSION_CDN' , 1 );
define('CACHE_VERSION_CDN' , get_cache_version_cdn() );
define ('BREADCRUMB_MICRO_DONNEES_HTML', false) ;
define('REWORLDMEDIA_TERMS' , 'hbh');

 $menu_cat_post = array();
 $post_category_from_url = array();



if(isset($_GET['newcdn'])){
	add_action('wp', function(){
		$cdn =	get_cache_version_cdn() ;
		$cdn ++ ;
		update_option('cache_version_cdn', $cdn) ;
	});
}


function get_cache_version_cdn(){
	
	$cache_version_cdn = get_option('cache_version_cdn', DEFAULT_CACHE_VERSION_CDN) ;
	
	return ($cache_version_cdn >  DEFAULT_CACHE_VERSION_CDN)? $cache_version_cdn : DEFAULT_CACHE_VERSION_CDN ;
}


function page_has_video_top(){
	global $post;
	$video_top_page = false;
	if (is_single() && preg_match(REG_VIDEO, $post->post_content, $matches)) {
		$video_top_page = true;
		if(preg_match("/no_top_page=['|\"]?yes['|\"]?/im", $matches[0] , $matches2)){
			$video_top_page = false;
		}
	}
	return $video_top_page;
}

function get_img_top_article_id(){

	$img_top_article_id = apply_filters('img_top_article_id', false);

	if($img_top_article_id == false){
		$img_top_article_id = get_post_thumbnail_id(get_the_ID());
	}

	return $img_top_article_id ;

}

function breadcrumb() {
	global $post, $folder;
	$breadcrumb = apply_filters('generate_breadcrumb', '') ;
	if($breadcrumb == '' ){
		$cat_site_id=(function_exists('get_cat_site_id')) ? hbh_get_category_by_slug(get_cat_site_id())->term_id : '';
		if (is_single()) {						
			$link_current_page = get_permalink();
			$link_current_page = str_replace(get_site_url().'/', '', $link_current_page);
			$link_current_page = explode('/', $link_current_page);
			if($folder !=null){
				$breadcrumb .='<li class="parent">'. __('Dossier' , REWORLDMEDIA_TERMS)  .'</li>' ;
				if(BREADCRUMB_MICRO_DONNEES_HTML){
					$breadcrumb .= '<li class="parent" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
										<a href="'. get_permalink($folder->ID) .'" itemprop="item">
											<span itemprop="name">'. $folder->post_title .'</span>
										</a>
										<meta itemprop="position" content="CNT_COUNT" />
								   	</li>' ;
				}else{
				    if (is_object($folder)){
                        $breadcrumb .='<li class="parent" ><a href="'. get_permalink($folder->ID) .'" >'. $folder->post_title .'</a></li>' ;
                    }
				}
			}else{				
				for ($i=0; $i<count($link_current_page)-1; $i++) {
					$link_part = $link_current_page[$i];
					$cat_object = hbh_get_category_by_slug($link_part);
					if (is_object($cat_object) && $cat_object->term_id != $cat_site_id) {
						$cat_id = $cat_object->term_id;
						if(BREADCRUMB_MICRO_DONNEES_HTML){
							$breadcrumb .='<li class="'. (($cat_object->parent== 0)? "parent":"") .'" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
												<a href="'. get_category_link($cat_id) .'" itemprop="item">
													<span itemprop="name">'.get_cat_name($cat_id).'</span>
												</a>
												<meta itemprop="position" content="CNT_COUNT" />
											</li>' ;
						}else{
							$breadcrumb .='<li class="'. (($cat_object->parent== 0)? "parent":"") .'" ><a href="'. get_category_link($cat_id) .'" >'.get_cat_name($cat_id).'</a></li>' ;	
						}
					}
				}			
			}
		} 
		if (is_category()) {
			$cat_id = get_query_var('cat');
			$cat = $current_cat = get_category($cat_id);
			$breadcrumb_parts = array();
			while ($cat->parent!=0 && $cat->parent!=$cat_site_id) {
				if(BREADCRUMB_MICRO_DONNEES_HTML){
					$breadcrumb_part = '<li class="parent" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
											<a href="'. get_category_link($cat->parent) .'" itemprop="item">
												<span itemprop="name">'.get_cat_name($cat->parent).'</span>
											</a>
					 						<meta itemprop="position" content="CNT_COUNT" />
										</li>';
					array_push($breadcrumb_parts,$breadcrumb_part);
				}else{
					array_push($breadcrumb_parts, '<li class="parent" ><a href="'. get_category_link($cat->parent) .'" >'.get_cat_name($cat->parent).'</a></li>');
				}
				$cat = get_category($cat->parent);
			}
			$breadcrumb_parts = array_reverse($breadcrumb_parts);
			$breadcrumb .= implode('', $breadcrumb_parts);
			if(BREADCRUMB_MICRO_DONNEES_HTML){
				$breadcrumb .= '<li class=" '. ($current_cat->parent==0 ? 'parent':'') .'" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
								<a href="'. get_category_link($cat_id) .'" itemprop="item">
									<span itemprop="name">'.get_cat_name($cat_id).'</span>
								</a>
								<meta itemprop="position" content="CNT_COUNT" />
							</li>';
			}else{
				$breadcrumb .= '<li class=" '. ($current_cat->parent==0 ? 'parent':'') .'" ><a href="'. get_category_link($cat_id) .'" >'.get_cat_name($cat_id).'</a></li>';
			}		
		}

		if (is_page() ) {
			if(BREADCRUMB_MICRO_DONNEES_HTML){
				$breadcrumb .= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
									<a href="'.get_permalink().'" itemprop="item">
										<span itemprop="name">'.get_the_title().'</span>
									</a>
									<meta itemprop="position" content="CNT_COUNT" />
								</li>' ;
			}else{
				$breadcrumb .='<li class="" ><a href="'.get_permalink().'" >'.get_the_title().'</a></li>' ;
			}	
		}

		if (is_author() ) {
			$author_name = get_author_name();
			$posts_url = get_author_posts_url(get_the_author_meta('user_nicename'));
			    
			if(BREADCRUMB_MICRO_DONNEES_HTML){
				$breadcrumb .= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
									<a itemprop="item">
										<span itemprop="name">'.__('AUTEURS',REWORLDMEDIA_TERMS).'</span>
									</a>
									<meta itemprop="position" content="CNT_COUNT" />
								</li>' ;
				$breadcrumb .= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
									<a href="'.$posts_url.'" itemprop="item">
										<span itemprop="name">'.$author_name.'</span>
									</a>
									<meta itemprop="position" content="CNT_COUNT" />
								</li>' ;
			}else{
				$breadcrumb .='<li class="" ><a>'. __('AUTEURS',REWORLDMEDIA_TERMS).'</a></li>' ;
				$breadcrumb .='<li class="" ><a href="'.$posts_url.'" >'.$author_name.'</a></li>' ;
			}
		}
	}
	
	$breadcrumb = apply_filters('breadcrumb_rewo', $breadcrumb) ;
	if($breadcrumb){
		$class_breadcrumb = apply_filters("class_breadcrumb","breadcrumb");
		if(BREADCRUMB_MICRO_DONNEES_HTML){
			$breadcrumb  ='<ol itemprop="breadcrumb"  itemscope itemtype="http://schema.org/BreadcrumbList" class="'. $class_breadcrumb .'">' . $breadcrumb.'</ol>';			
		}else{
			$breadcrumb  ='<ol class="'. $class_breadcrumb .'" >' . $breadcrumb.'</ol>';
		}	
		$breadcrumb = apply_filters('breadcrumb_ol_rewo', $breadcrumb) ;

		$breadcrumb  ='<div class="'.apply_filters('breadcrumb_folder','').'" itemscope itemtype="http://data-vocabulary.org/Breadcrumb" >' . $breadcrumb.'</div>';
	}
	$breadcrumb .= apply_filters('insert_script_microdata', '') ;
	$breadcrumb = apply_filters('filter_after_breadcrumb', $breadcrumb) ;
	
	return $breadcrumb;
}

function hbh_get_category_by_slug($slug){
	global $cache_categories;
	if(!isset($_GET['debug_cache'])):
		if ( defined('TIMEOUT_CACHE_TERMS') && TIMEOUT_CACHE_TERMS > 0 ){
			$time = time() ;
			// get from cache
			if ( empty($cache_categories) ) 
				$cache_categories = wp_cache_get( 'all' , 'categories_by_slug' ) ;
	     		
	 		if ( isset($cache_categories[$slug]) &&  ( $time - $cache_categories[$slug][1] ) < TIMEOUT_CACHE_TERMS )
	 			return $cache_categories[$slug][0];	
		}
	endif;
	$term = get_category_by_slug($slug);
	
	if( defined('TIMEOUT_CACHE_TERMS') &&  TIMEOUT_CACHE_TERMS > 0 ) {
		// don't cache not existing categories
		if( $term ){
			$cache_categories[$slug]= array ( $term , $time );
			wp_cache_set( 'all' , $cache_categories , 'categories_by_slug' , TIMEOUT_CACHE_TERMS );
		}
    }

    return $term;
}

function is_wp_home(){
	global $wp_query ;
	return is_home() && empty($wp_query->query);
}

function page_has_gallery(){
	global $post;

	if ( is_single() && $post ) 
	{
		$post_content = $post->post_content ;
		return stristr($post_content , "[gallery" );
	}
	return false ;
}

function rw_is_mobile(){
	return defined('MOBILE_MODE') && MOBILE_MODE;
}

function rw_enqueue_style( $handle, $src = '', $deps = array(), $ver = false, $media = 'all' ) {
	wp_enqueue_style( $handle, $src,  $deps , $ver, $media)  ;
}

/**
 * Afficher le menu de la zone header
 *
 * @return void
 */
function header_menu() : void {
    $nav_cls = "nav navbar-nav";
    if (rw_is_mobile()) $nav_cls .= " scrolable_nav";
    $html_nav = '';
    $menu_items = wp_get_nav_menu_items('menu_header');
    if(is_category()){
        $cat =get_queried_object();
    }else if(is_single()){
        $cat = '';
    }
    if (!empty($menu_items)) {
        $html_nav .= '<nav class="menu-site hidden-xs">';
        $html_nav .= '<ul id="header-top-menu" class="' . $nav_cls . '">';
        $html_nav .= apply_filters('nav_menu_logo_sticky','');
        $html_nav_items = '';
        $target = '';
        $cat = isset($cat) ? $cat : '';
        foreach ($menu_items as $menu_item) {
            if ($menu_item->menu_item_parent == 0) {
                $link = $menu_item->url;
                $target = !empty($menu_item->target) ? 'target="' . $menu_item->target . '"' : '';
                $link = apply_filters('header_menu_href_link', $link);
                $cls =apply_filters('header_menu_anker_class','',$menu_item->object_id,$cat,$link); 
                $html_nav_items .= '<li class="' . (isset($menu_item->classes) ? implode(" ", $menu_item->classes) : "") . ' ' . ' menu-item menu-item-type-taxonomy menu-item-object-category menu-item-has-children menu-item-' . $menu_item->ID . '">
                    <a href="' . $link . '" ' . $target . ' class="'.$cls.'">' . $menu_item->title . '</a>
                    </li>';
            }
        }
        $html_nav .= apply_filters('header_menu_li_items', $html_nav_items);
        $html_nav .= '</ul>';
        $html_nav .= '</nav>';
    }
    echo $html_nav;
}

function reworldmedia_pagination($max_page=0) { 
	global $wp_query ;
	if ($max_page==0) {
		$max_page = $wp_query->max_num_pages;
	} 	
	$big = 999999999;
	if(!defined('NEWRW')){ 
		$paginate_args = array(
			'base'         => str_replace($big, '%#%', get_pagenum_link($big)),
			'format'       => '?paged=%#%',
			'current' 	   => max( 1, get_query_var('paged')),
			'show_all'     => false,
			'end_size'     => 4,
			'mid_size'     => 4,
			'prev_next'    => true ,
			 'prev_text'    => __('Précédent' , REWORLDMEDIA_TERMS ),
			 'next_text'    => __('Suivant' , REWORLDMEDIA_TERMS),
			 'total'        => $max_page
		);

		$paginate_links = paginate_links($paginate_args) ;
		if(is_category()){
			$current_cat = get_term($wp_query->query_vars['cat'], 'category');
			$is_parent_cat = $current_cat->parent==0;
			if($is_parent_cat){
				$paginate_links = str_replace( array('/<a /', '/<\/a>/', '/href=/') , array('<span ','</span>', 'data-href='), $paginate_links) ;
			}
		}
		return '<div class="pagination">'.$paginate_links.'</div>';
	}else{ 
		$paginate_args = array(
			'base'         => str_replace($big, '%#%', get_pagenum_link($big)),
			'format'       => '?paged=%#%',
			'current' 	   => max( 1, get_query_var('paged')),
			'show_all'     => false,
			'end_size'     => 2,
			'mid_size'     => 2,
			'prev_next'    => apply_filters('remove_next_previous',true) ,
			 'prev_text'    => __('Précédent' , REWORLDMEDIA_TERMS ),
			 'next_text'    => __('Suivant' , REWORLDMEDIA_TERMS),
			 'total'        => $max_page,
			 'type'		   => 'array'
		);


		$paginate_links = paginate_links($paginate_args) ;

		$r = '';
		if ( $paginate_links ){
			if(defined('V3')){
				foreach ($paginate_links as $link) {
					$is_active = strpos($link, 'page-numbers current') !== false ;
					$r .= '<li class="'. ($is_active?'active':'') .'">'.  $link .'</li>'; 
				}
			}else{
				$j = 0;

					$links_count = count($paginate_links);
					$dots_post = array();
					$pagination_vals = array();
					$active_page_pos = 0;

					foreach ($paginate_links as $link){
						++$j;
						if( strpos($link, 'page-numbers current') ){
							$active_page_val = strip_tags($link);
							$active_page_pos = $j;
						}
						$pagination_vals[] = strip_tags($link);
					}
					// pagination first item position
					if( $active_page_val < 10 ){
						$page_first_pos = 0;
					}else{
						$page_first_pos = 1;
					}
					// pagination last item position
					if( $active_page_pos == $links_count ){
						$page_last_pos = $links_count-1;
					}else{
						$page_last_pos = $links_count-2;
					}
					// pagination first dots position
					if( ($pagination_vals[$page_first_pos]+1) != $pagination_vals[$page_first_pos+1] ){
						$dots_post[] = 2;
					}
					// pagination last dots position
					if( ($pagination_vals[$page_last_pos]-1) != $pagination_vals[$page_last_pos-1] ){
						$dots_post[] = $links_count-2;
					}
					$j = 0;


				foreach ($paginate_links as $link) {
					$j++;
	
					$is_active = strpos($link, 'page-numbers current') !== false ;
					$is_prev = strpos($link, 'prev page-numbers') !== false ;
					$is_next = strpos($link, 'next page-numbers') !== false ;
					if(strpos($link, '<a') === false ){
						$link = '<a href="#">'.$link .'</a>' ;
					}
					$r .= apply_filters('rw_paginate_links','',$paginate_links,$j);
					$r .= '<li class="page-numbers '. ($is_active?'active':'') . ($is_prev?'prev-page':'') . ($is_next?'next-page':'') .'">'.  strip_tags($link, '<a>') .'</li>'; 
					
				}
			}
		}
		$paged = get_query_var('paged')?get_query_var('paged'):1;
		$r=apply_filters('show_last_and_first_pagination',$r,$paged,$max_page);
		if( !empty($r) ){
		$r = '<ul class="pagination">'.$r.'</ul>';
		}
		if($wp_query->max_num_pages){
			$r .= apply_filters('current_pagination_nb', '<span class="number_page">'.  __('Page' , REWORLDMEDIA_TERMS)  .' <span class="active_page">'. $paged .'</span> '. __('sur' , REWORLDMEDIA_TERMS) .' '. $wp_query->max_num_pages.' </span>', $paged, $wp_query->max_num_pages);
		}
		if ( apply_filters('pagination_js',false))  {
			$r = str_replace( array('<a ', '</a>', 'href=') , array('<span ','</span>', 'data-href='), $r) ;
		}
		$r=apply_filters('reworldmedia_pagination',$r,$paged,$max_page);
		
		return $r;
	}
}

function get_menu_cat_link($post, $class='', $first_level=false, $parent_id=false, $href_js=false, $simple_cat=false, $attr=array(),$exclude_cat='') {
	$link = '';
	$category = get_menu_cat_post($post, $class, $first_level, $parent_id, $href_js, $simple_cat, $attr,$exclude_cat);
	if(is_object($category))
		$link = gen_link_cat($category, $class, $category->parent, $href_js, $attr);

	return $link;
}

function get_menu_cat_post($p='', $class='', $first_level=false, $parent_id=false, $href_js=false, $simple_cat=false, $attr=array(),$exclude_cat='') {

	global $post ;
	$p = ($p)? $p:$post ;
	if(!is_object($p)){
		$p = get_post($p);
	} 
	$id = (!empty($p->ID)) ? $p->ID : 0;
	if(isset($menu_cat_post[$id . $first_level])){
		return $menu_cat_post[$id . $first_level] ;
	}

	$category  = null ;


	$cat =  get_post_meta($id,'_category_permalink',true) ;
	if($cat){
		$category = get_category($cat) ;	
	}

	if(!$category){

		// TODO : get rid of this get_post_category_from_url
		if( apply_filters( 'disable_category_from_url' , !$simple_cat , $p) ) {
			$category = get_post_category_from_url($p, $first_level);
		} 

		if(!$category){
			$category = get_the_category();
			if($exclude_cat!='') {
				foreach ($category as $categor) {
					if($categor->slug!=$exclude_cat) {
						$category = $categor;
						break;
					}
				}
			}else {
				$category=isset($category[0]) ? $category[0] : '';
			}
		}
	}
	$menu_cat_post[$id . $first_level]  = $category;
	return $category;
}

function gen_link_cat($cat, $class='', $parent_id = 0, $href_js=null, $attr=array()) {
		
	if(!is_object($cat)){
		$cat = get_category($cat) ;
	}

	$style = 'info_cat '.$class;
	$attr_str = "";
	if(count($attr)>0){
		foreach ($attr as $k => $v){
			$attr_str .= $k ."=\"$v\" ";
		}
	}
	$cat_name = $cat->name;
	$cat_link = get_category_link($cat);
	
	if ($parent_id!=0) {
		$style .= ' '.get_cat_slug($parent_id);
	}
	$style = apply_filters('classes_gen_link_cat', $style, $cat->term_id, $parent_id);

	if($href_js){
		$link  = '<span '.$attr_str.' class="'.$style.'" data-href="'.$cat_link.'">';		
		$link .= $cat_name;
		$link .= '</span>';
	}else{
		$link  = '<a '.$attr_str.' class="'.$style.'" href="'.$cat_link.'">';
		$link .= $cat_name;
		$link .= '</a>';			
	}

	return $link;
}

function get_post_category_from_url($p=null, $first_level=false) {

	global $post ;
	$post_id = $p!=null?$p->ID: $post->ID;
	$post_ = $p !=null ? $p : $post;

	if(isset($post_category_from_url[$post_id . $first_level])){
		return $post_category_from_url[$post_id . $first_level] ;
	}

	if(in_array($post_->post_status, array( 'draft', 'pending', 'auto-draft', 'future' ))){
		$link_current_page = get_not_publish_permalink($post_id);
	}else{
		$link_current_page = get_permalink($post_);
	}
	
	$link_current_page = str_replace(home_url('/'), '', $link_current_page);
	$link_current_page = trim($link_current_page, '/');
	$link_current_page = explode('/', $link_current_page);

	if (!$first_level) {
		$cat_part = (count($link_current_page) >= 2 && isset($link_current_page[count($link_current_page)-2]) ) ? $link_current_page[count($link_current_page)-2] : false;
	} else {
		$cat_part = array_shift($link_current_page);
	}	
	$cat_object = rw_get_category_by_slug($cat_part);
	$post_category_from_url[$post_id . $first_level] = $cat_object ;
	return $cat_object;
}

function rw_get_category_by_slug($slug){
	global $cache_categories;
	if(!isset($_GET['debug_cache'])):
		if ( defined('TIMEOUT_CACHE_TERMS') && TIMEOUT_CACHE_TERMS > 0 ){
			$time = time() ;
			// get from cache
			if ( empty($cache_categories) ) 
				$cache_categories = wp_cache_get( 'all' , 'categories_by_slug' ) ;
	     		
	 		if ( isset($cache_categories[$slug]) &&  ( $time - $cache_categories[$slug][1] ) < TIMEOUT_CACHE_TERMS )
	 			return $cache_categories[$slug][0];	
		}
	endif;
	$term = get_category_by_slug($slug);
	
	if( defined('TIMEOUT_CACHE_TERMS') &&  TIMEOUT_CACHE_TERMS > 0 ) {
		// don't cache not existing categories
		if( $term ){
			$cache_categories[$slug]= array ( $term , $time );
			wp_cache_set( 'all' , $cache_categories , 'categories_by_slug' , TIMEOUT_CACHE_TERMS );
		}
    }

    return $term;
}

function add_value_to_array($value, $array){
	if(!is_array($array)) 
		$array = array();
	if($value && !in_array($value, $array)){
		$array[] = $value;
	}
	return $array;
}
function purge_objetc_cache_url( $url){
	$url_to_purge = add_query_arg(['disable_cache' => '1', 'delete_cache' => rand()] , $url ) ;
	wp_remote_get($url_to_purge, array(
		  'user-agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/93.0.4577.82 Safari/537.36'
	));
	wp_remote_get($url_to_purge, array(
		  'user-agent' => 'Mozilla/5.0 (Linux; Android 6.0.1; Moto G (4)) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/93.0.4577.82 Mobile Safari/537.36'
	));
}

function get_cat_slug($cat_id) {
	$cat_id = (int) $cat_id;
	$category = get_category($cat_id);
	if (isset($category->slug)) {
		return $category->slug;
	} else {
		return "";
	}	
}