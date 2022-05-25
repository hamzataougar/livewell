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