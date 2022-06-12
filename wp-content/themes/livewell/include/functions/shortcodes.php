<?php

function simple_addthis_single($attr) {
	global $site_config, $post;
	$position = isset($attr['position'])?  isset($attr['position']): null ;
	$is_remove_count= @$site_config['is_remove_count'];
	if(is_single() || is_singular()){
		$url_item = get_permalink();
		$title = get_the_title();
		$description = get_the_excerpt();
	}
	
	if(isset($position) && $position=="v"){
		$html='<div class="blockShare_vertical">' ;
				$html .='<div class="addthis_toolbox" addthis:url="'.$url_item.'" addthis:title="'.$title.'" addthis:description="'.$description.'">';
					$html .='<a class="fb addthis_button_facebook"></a>';
					$html .='<a  class="google addthis_button_google_plusone" g:plusone:size="medium" g:plusone:count="false"></a>';
					$html .='<a class="pint addthis_button_pinterest"></a>';

				$html .='</div>';
			$html .='</div>';	
	}else{
		$btn_fb_count="button_count";
		$plusone_count = 'true';
		$tw_count = '';
		if($is_remove_count){
			$btn_fb_count="button";
			$plusone_count = 'false';
			$tw_count = ' tw:count="none"';
		}

		$html='<div class="blockShare_single" >
				<div class="addthis_toolbox" addthis:url="'.$url_item.'" addthis:title="'.$title.'" addthis:description="'.$description.'">
					<a class="fb addthis_button_facebook_share" fb:share:layout="'.$btn_fb_count.'"></a>
					<a class="pint addthis_button_pinterest_pinit" pi:pinit:layout="horizontal"></a>
					<a class="google addthis_button_google_plusone" g:plusone:size="medium" g:plusone:count="'.$plusone_count.'"></a>';

		$html.='</div>
			</div>';	
	}
		
	return $html;
}

add_shortcode("simple_addthis_single", "simple_addthis_single");


function shortcode_social_links($atts=false) {
	$in_header=isset($atts['in_header'])? true:false;
	$in_footer=(isset($atts['footer']) && $atts['footer']) ? true:false;
	$title = isset($atts['title'])? $atts['title'] : '';
	$description = isset($atts['description'])? $atts['description'] : '';

	$hide_social_links_names=(empty($atts['hide_social_names'])) ? false : true;
	global $site_config;
	$shares_ul='<div class="sociallink-container">';
	$balise = apply_filters('edit_balise_title_social_links', 'div');
	$shares_ul .= !empty($title) ? '<'.$balise.' class="title">'.$title.'</'.$balise.'>' : '';
	$shares_ul .= !empty($description) ? '<p class="description">'.$description.'</p>' : '';
	if($in_header==true || $in_footer){
		if($in_footer){
			$class_social="list-inline navbar-sociallink";
		}else{
			$class_social="nav navbar-sociallink";
		}
		$shares_ul.='<ul class="'.$class_social.'">';

		/*utiliser un ordre personnalise si il est defini dans site-config*/
		
		    $list_shares = array(array('facebook_url','fb'),array('twitter_url','tw'),array('instagram_url','cam'),array('pinterest_url','pint'));
		    $list_shares = apply_filters('shortcode_liste_shares',$list_shares);
	    /*---*/
		foreach ($list_shares as $list_share) {
			if(!empty( get_url_by_social_media($list_share[0]) ) ) {
				$link_share_page=  get_url_by_social_media($list_share[0]);
				$_BLANK= ' target="_BLANK"';
				$hidden_sm="";

				if($link_share_page){
					$attr_no_follow = apply_filters('attr_no_follow', '');
					$enable_seo_link =false;
					$enable_link_rs_javascript = false;
					$shares_ul.='<li>';
					if ($enable_seo_link && !$enable_link_rs_javascript) {
						$shares_ul.='<a '. (($list_share[1] == 'g')? 'rel="publisher"':$attr_no_follow) .' href="' . str_replace(Array("http:","https:"),"",$link_share_page) . '" class="'.$list_share[1].' '.$hidden_sm.'"'.$_BLANK.'>';
					}elseif($enable_link_rs_javascript){
						$shares_ul.='<a href="javascript:void(0);" '. (($list_share[1] == 'g')? 'rel="publisher"':$attr_no_follow) .' data-href="' . str_replace(Array("http:","https:"),"",$link_share_page) . '" class="'.$list_share[1].' '.$hidden_sm.'"'.$_BLANK.'>';
					}else {
						$shares_ul.='<span '. (($list_share[1] == 'g')? 'rel="publisher"':$attr_no_follow) .' data-href="' . str_replace(Array("http:","https:"),"",$link_share_page) . '" class="'.$list_share[1].' '.$hidden_sm.'"'.$_BLANK.'>';
					}
					if( !apply_filters('hide_social_links_names', $hide_social_links_names) ){
						$shares_ul.=$list_share[1];
					}

					if ($enable_seo_link) {
						$shares_ul.='</a>';
					}else{
						$shares_ul.='</span>';
					}
					$shares_ul.='</li>';
				}
			}
		}
		$shares_ul.='</ul></div>';	
	}

	/**
	*	Filter pour modifier le html des liens des RS dans le footer
	*	Ticket : 2367 : Projet Dubai | Intégration du footer
	*	By: bouhou@webpick.info
	**/
	$shares_ul = apply_filters('social_links_html', $shares_ul, $in_footer);
	/**
	*	End of ticket 2367
	**/

	return $shares_ul;
}
add_shortcode("social_links", "shortcode_social_links");