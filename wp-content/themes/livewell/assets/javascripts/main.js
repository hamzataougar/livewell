jQuery(document).ready(function($){

	if( jQuery.fn.shave ){
		jQuery('.related-posts .title_push a').shave(55);
	}

	$("#custom_arrows .arrow_previous").click(function() {
		$(".block_diapo .visu_block>.btn-navs._left").trigger("click");
	});
	$("#custom_arrows .arrow_next").click(function() {
		$(".block_diapo .visu_block>.btn-navs._right").trigger("click");
	});

	$('.category-list').change(function(){
		var catid = $(this).val();
		if(catid){
			$.ajax({
				url: '/',
				type: "GET",
				data: {
					action: 'load_category_latest_posts',
					categorie_id: catid
				},
				dataType: "json",
			}).success(function(results){
				if(typeof results !== 'undefined' && results){
					$("#posts-rubrique").html('<div class="row post-items">'+results.html_content+'</div>');
					var posts_lazyload = new LazyLoad({ 
						elements_selector: ".lazy-load",
						class_loaded:'lazy-loaded'
					});
				}
			});
		}	
 	});
 	var c2sales_container = $('.c2sales-container');
 	if (typeof c2sales_container != undefined) {
		c2sales_container.slick({
			autoplay: true,
			infinite: true,
			slidesToShow: 1,
			slidesToScroll: 1,
			autoplaySpeed: 4000,
		});
 	}
 	if (typeof $('#quizz') != undefined) {
		var widthTest = $('#quizz .test_progress').width();
		var numItems = $('#quizz .test_progress .steps').length;
		$('#quizz .test_progress .steps:not(:last)').css('width', widthTest/(numItems-1));
		$('#quizz .question-responses-list-item label').click(function(){
			if (!$('#quizz .question-responses-list-item').hasClass('right') && !$('#quizz .question-responses-list-item').hasClass('wrong')) {
				$('#quizz .question-responses-list-item').removeClass('right wrong');
				if ($(this).children('input').attr('correct') == 1) {
					$(this).parent('.question-responses-list-item').addClass('right');
				}else{
					$(this).parent('.question-responses-list-item').addClass('wrong');
				}
				setTimeout(function(){ $('#answer_quizz_form').submit(); }, 2000);
			}
		});
 	}

});