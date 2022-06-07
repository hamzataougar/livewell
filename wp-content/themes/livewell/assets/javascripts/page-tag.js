	
	jQuery(document).ready(function ($ = jQuery) {
        var load_actors = true;
        $('.tag .actors').on('scroll', function() {
            var tag_actors = $(this).get(0);
            if(tag_actors.scrollLeft >= tag_actors.clientWidth/2 && load_actors) {
                tag_id = $('.actors').data('tag-id');
                $.ajax({
                    url : '/',
                    type : 'POST',
                    data : { 
                        action : 'load_more_actors',
                        tag : tag_id
                    },
                    success : function(actors) {
                        $('.tag .actors').html(actors);
                    }
                });
                load_actors = false;
            }
        });

});