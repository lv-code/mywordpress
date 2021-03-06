<?php 
 
global $more, $k_options; 

$k_option['custom']['bodyclass'] = ""; //<-- Display Sidebar
// $k_option['custom']['bodyclass'] = "fullwidth"; //<-- Dont display Sidebar

get_header(); ?>

			
	<!-- ###################################################################### -->
	<div id="main">
	<!-- ###################################################################### -->
		
		<div id="content">
			<h2><?php _e('Search Results','newscast'); ?></h2>
		
		
		<?php 
		$fullsized = $k_option['general']['article_appearance'];
		$smallsized = 1;
				
		if (have_posts()) :
		while (have_posts()) : the_post();

		// ############################# FULL SIZED POSTS #############################
		if ($fullsized > 0) :
		
		$preview_image = kriesi_post_thumb($post->ID, array('size'=> array('M'),
													'display_link' => '_prev_image_link',
													'linkurl' => array ('L','_preview_big'),
													'wh' => $k_option['custom']['imgSize']['M']
													));
		
		
		?> 
		<div class="entry <?php if(!$preview_image) echo 'entry-no-pic';?>">
			<?php 
			if($preview_image)
			{ 
			echo '<div class="entry-previewimage rounded preloading_background">';
			echo $preview_image;	
			echo '</div>';
			} 
			
			?>
			
			<div class="entry-content">
				<h1 class="entry-heading">
					<a href="<?php echo get_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link:','newscast')?> <?php the_title(); ?>">
					<?php the_title(); ?>
					</a>
				</h1>
				
				<div class="entry-head">
					<span class="date ie6fix"><?php the_time('M d, Y') ?></span>
					<span class="comments ie6fix"><?php comments_popup_link(__('No Comments','newscast'), __('1 Comment','newscast'), __('% Comments','newscast')); ?></span>
					<span class="author ie6fix"><?php _e('by','newscast');?> <?php the_author_posts_link(); ?></span>
				</div>
				
				<div class="entry-text">
					<?php the_excerpt() ?>
				</div>
				
				<div class="entry-bottom">
					<span class="categories"><?php the_category(', '); ?></span>
					<a href="<?php echo get_permalink() ?>" class="more-link"><?php _e('Read more','newscast'); ?></a>
				</div>
			</div><!--end entry_content-->
		</div><!--end entry -->
		<?php 
		$fullsized--;
		
		else: 
		// ############################# SMALL SIZED POSTS #############################
			if($smallsized == 1): echo '<div class="doubleentry">'; endif;
			$smallsized ++;
			
			$small_prev = kriesi_post_thumb($post->ID, array('size'=> array('S'),
															'display_link' => '_prev_image_link',
															'linkurl' => array ('L','_preview_big'),
															'wh' => $k_option['custom']['imgSize']['S'],
															'img_attr' => array('class'=>'rounded alignleft'),
															'link_attr' => array('class'=>'alignleft preloading_background')
															));
															
			?>
			<div class="entry">
			<div class="entry-content">
				<h1 class="entry-heading">
					<a href="<?php echo get_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link:','newscast')?> <?php the_title(); ?>">
					<?php the_title(); ?>
					</a>
				</h1>				<div class="entry-head">
					<span class="date ie6fix"><?php the_time('M d, Y') ?></span>
					<span class="comments ie6fix"><?php comments_popup_link(__('No Comments','newscast'), __('1 Comment','newscast'), __('% Comments','newscast')); ?></span>
				</div>
				
				<div class="entry-text">
					<?php 
					if($small_prev) echo $small_prev;
					the_excerpt(); 
					?>
				</div>
				
				<div class="entry-bottom">
					<a href="<?php echo get_permalink() ?>" class="more-link"><?php _e('Read more','newscast'); ?></a>
				</div>
			</div>
		</div>
		
		<?php
		if($smallsized > 2): echo '</div>'; $smallsized = 1; endif;
		
		endif; endwhile; 
		if($smallsized == 2):echo '</div>'; endif;
		 	 
		kriesi_pagination();
		
		else: 
		
			echo'<div class="entry">';
			echo'<h2>'.__('Nothing Found','newscast').'</h2>';
			echo'<p>'.__('Sorry, no posts matched your criteria','newscast').'</p>';
			echo'</div>';
			
 		endif;
 		
 		// end content: ?></div> 
		
		<?php 
		get_sidebar();
		
		get_footer();
		?>			

