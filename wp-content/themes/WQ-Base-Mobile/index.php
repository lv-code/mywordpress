<?php get_header();?>
<?php if(ISMOBILE):?>
<div class="page_content">
	<div data-role="content" class="pd_l_5 pd_r_5">
	<ul data-role="listview"  data-mini="true" data-inset="true" class="margin_top_0">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<li>
			<a href="<?php the_permalink(); ?>">							
				<h3><?php the_title(); ?></h3>
				<p><?php echo strcut(strip_tags(apply_filters('the_content', $post->post_content)), 450);?></p>
				<span class="ui-li-count"><?php getPostViews($post->ID,'show','true'); ?></span>
				<a href="<?php the_permalink(); ?>" data-theme="d" data-iconpos="right">Purchase album</a>				
			</a>
			</li>
		<?php endwhile;endif;?>
	</ul>
	</div>
</div>
	
<?php else:?>	
<div id="container">
		<?php include 'views/welcome.php';?>		
		<div id="content">
			<div class="pagenavi pnb">
		        <?php if($options['pbo_topnavi'] && ''!=par_pagenavi($query_string)):?>  				
				<div class="pagenavi">
					<?php par_pagenavi($query_string);?>
				</div>
				<?php endif;?>
				</div>
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<div class="cbx post">
						<h2><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
						<a href="<?php the_permalink(); ?>" class="readmore">阅读全文</a>
						<div class="postmeta">
								<ul>
										<li class="meta-date"><?php the_time('Y年n月j日') ?></li>
										<li class="meta-cat"><?php the_category('&nbsp;');?></li>
										<li class="meta-views"><?php getPostViews($post->ID,'show',true); ?></li>										
										<li class="meta-comments"><?php comments_popup_link('无评论', '1条评论', '%条评论', '', '评论已关闭'); ?></li>
										<?php the_tags('<li class="meta-tags">', '&nbsp;,&nbsp;', '</li>');?>
										<?php edit_post_link( 'Edit','<li class="meta-edit">','</li>'); ?>
								</ul>
								<div class="clear"></div>
						</div>
						<div class="post-content">						    
                                <a href="<?php the_permalink(); ?>" rel="bookmark">
                                  
                                  <img class="home-thumb" src="<?php echo get_thumb('140_100',$post->post_content,$post->ID); ?>" alt="<?php the_title(); ?>" />
                                </a>                           
	                        <?php echo strcut(strip_tags(apply_filters('the_content', $post->post_content)), 450);?>
						   </div>						
				</div>
				
				<?php if($options['pbo_a1show']):?>
				    <?php if ($wp_query->current_post == ($options['pbo_a1num']-1)) : ?>                   
                           <div class="cbx post" style="padding:0;">
                             <?php echo $options['pbo_a1code'];?>                               
                          </div>     
                    <?php endif;?>
                <?php endif; ?>
                
				<?php endwhile;endif;?>	
				<?php if($options['pbo_footnavi']):?>			
				<div class="pagenavi pnb">
						<?php par_pagenavi($query_string);?>
				</div>
				<?php endif;?>
		</div>
		<?php get_sidebar();?>
		<div class="clear"></div>
</div>
<?php endif;?>
<?php get_footer();?>
