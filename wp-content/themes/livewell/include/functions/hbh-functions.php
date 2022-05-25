<?php

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