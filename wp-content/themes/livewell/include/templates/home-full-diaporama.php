	<div class="custom-full-carousel col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="navs">
			<span class="_left">&nbsp;</span>
			<span class="_right">&nbsp;</span>
		</div>
		<div class="list-items">
			<?php 
			global $posts_exclude ;
			for ($i=0; $i < count($diaporama_accueil) ; $i++) {

				$post=$diaporama_accueil[$i]; 
				setup_postdata($post);
				$posts_exclude =add_value_to_array(get_the_ID(), $posts_exclude);
				$slug_item=get_origin_cat(get_the_ID(),'diaporama-accueil');
				$excerpt = mini_excerpt_for_lines(360, 2);
				$active_class=($i == 0) ? " active" : "";
			?>
			<div class="row container pull-left">
			<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 pull-left">
				<div class="item<?php echo $active_class; ?> item-<?php echo $i; ?>">
					<a href="<?php echo get_permalink(); ?>">
					<?php 
					$args_ = array('class'=>'img-responsive');
						$args_ = array_merge($args_, array('data-lazyloading' => 'false'));
					echo get_the_post_thumbnail(get_the_ID(), 'rw_large', $args_); ?>
					</a>
					<div class="title_block">
						<div class="cat_name">
							<?php echo get_menu_cat_link($post, 'info_cat', false, false, true, true); ?>
						</div>
						<div class="block">
							<h2>	
				                <a href="<?php echo get_permalink(); ?>">							
				                	<?php echo split_title ( get_the_title() ,  get_the_ID() ) ; ?>		
				                </a>							
			                </h2>
			                	<p><?php echo $excerpt ; ?></p>
						</div>


			        </div>
				</div>
			</div>

				<?php 
					$i++;
					$post=$diaporama_accueil[$i]; 
					setup_postdata($diaporama_accueil[$i]);
					$posts_exclude = add_value_to_array(get_the_ID(), $posts_exclude);
					$slug_item=get_origin_cat(get_the_ID(),'diaporama-accueil');
					$is_exist_post=false;
					$excerpt = mini_excerpt_for_lines(50, 2);

					if(is_array($post) && count($post)>0) {
						$is_exist_post =true;
				?>
			<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pull-right">
				<?php }
					if(is_array($post) && count($post)>0) {
				 ?>
				<div class="item item-<?php echo $i; ?>">
					<a href="<?php echo get_permalink(); ?>">					
					<?php 
					$args_ = array('class'=>'img-responsive');
						$args_ = array_merge($args_, array('data-lazyloading' => 'false'));
					echo get_the_post_thumbnail(get_the_ID(), 'rw_large', $args_); ?>
					</a>
					<div class="title_block">
						<div class="cat_name"><?php echo get_menu_cat_link($post, 'info_cat', false, false, true, true); ?></div>
						<div class="block">
							<h2 class="visible-xs visible-sm">	
				                <a href="<?php echo get_permalink(); ?>">							
				                	<?php echo split_title ( get_the_title() ,  get_the_ID() ) ; ?>		
				                </a>							
			                </h2>
			                	<p class="visible-xs"><?php echo $excerpt; ?></p>
						</div>
					</div>
				</div>
				<?php }
					$i++;
					$post=$diaporama_accueil[$i]; 
					setup_postdata($diaporama_accueil[$i]);
					$posts_exclude = add_value_to_array(get_the_ID(), $posts_exclude);
					$slug_item=get_origin_cat(get_the_ID(),'diaporama-accueil');
					$excerpt = mini_excerpt_for_lines(50, 2);

					if(is_array($post) && count($post)>0) {
				?>
				<div class="item item-<?php echo $i; ?>">
					<a href="<?php echo get_permalink(); ?>">	
					<?php 
					$args_ = array('class'=>'img-responsive');
						$args_ = array_merge($args_, array('data-lazyloading' => 'false'));
					echo get_the_post_thumbnail(get_the_ID(), 'rw_large', $args_); ?>
					</a>
					<div class="title_block">
						<div class="cat_name"><?php echo get_menu_cat_link($post, 'info_cat', false, false, true, true); ?></div>
						<div class="block">
							<h2 class="visible-xs visible-sm">	
				                <a href="<?php echo get_permalink(); ?>">							
				                	<?php echo split_title ( get_the_title() ,  get_the_ID() ) ; ?>		
				                </a>							
			                </h2>
			                	<p class="visible-xs"><?php echo $excerpt ; ?></p>
						</div>
					</div>
				</div>
			<?php } if($is_exist_post) { ?>
				</div>
			<?php } ?>
			</div>
			<?php } ?>
		</div>
	</div>

