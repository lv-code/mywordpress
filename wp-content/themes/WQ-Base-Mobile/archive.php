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
				<?php if(have_posts()) : ?>			
				<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>			
				<?php if(is_category()) : ?>
				<div class="cbx gry">文档归类：<strong><?php single_cat_title(); ?></strong></div>			
				<?php elseif(is_tag()) : ?>
				<div class="cbx gry">文档标签： <strong><?php single_tag_title(); ?></strong></div>			
				<?php elseif(is_day()) : ?>
				<div class="cbx gry">文档日期： <strong><?php the_time('F jS, Y'); ?></strong></div>				
				<?php elseif(is_month()) : ?>
				<div class="cbx gry">文档月份： <strong><?php the_time('F, Y'); ?></strong></div>				
				<?php elseif(is_year()) : ?>
				<div class="cbx gry">文档年份： <strong><?php the_time('Y'); ?></strong></div>				
				<?php elseif(is_author()) : ?>
				<div class="cbx gry">文档作者：<strong><?php _e('Author Archive', 'mytheme'); ?></strong></div>				
				<?php elseif(isset($_GET['paged']) && !empty($_GET['paged'])) : ?>
				<div class="cbx gry">页面文档：<strong><?php _e('Blog Archives', 'mytheme'); ?></strong></div>				
				<?php endif; ?>
				<?php if($options['pbo_toinner']):?>
				    	<?php if($options['pbo_topnavi']):?>			
            				<div class="pagenavi">
            					<?php par_pagenavi();?>
            				</div>
            			<?php endif;?>
				<?php else:?>
				        <div class="pagenavi">
                            <?php par_pagenavi();?>
                        </div>
				<?php endif;?>
				<?php  while (have_posts()) : the_post(); ?>
				<div class="cbx post">
						<h2><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
						<a href="<?php the_permalink(); ?>" class="readmore">Continue Read.. </a>
						<div class="postmeta">
								<ul>
										<li class="meta-date"><?php the_time('Y年n月j日') ?></li>
										<li class="meta-cat"><?php the_category('&nbsp;');?></li>
										<li class="meta-views"><?php getPostViews($post->ID,'show',true); ?></li>										
										<li class="meta-comments"><?php comments_popup_link('0 条评论', '1 条评论', '% 条评论', '', '评论已关闭'); ?></li>
										<?php the_tags('<li class="meta-tags">', '&nbsp;,&nbsp;', '</li>');?>
										<?php edit_post_link( 'Edit','<li class="meta-edit">','</li>'); ?>
								</ul>
								<div class="clear"></div>
						</div>
						<div class="post-content">                         
                            <a href="<?php the_permalink(); ?>" rel="bookmark">
                              <img class="home-thumb" src="<?php echo get_thumb('140_100',$post->post_content,$post->ID); ?>" alt="<?php the_title(); ?>"  />
                            </a>
                          <?php echo strcut(strip_tags(apply_filters('the_content', $post->post_content)), 450);?>  
                         </div>						
				</div>
				<?php if($options['pbo_a2show']):?>
                    <?php if ($wp_query->current_post == ($options['pbo_a2num']-1)) : ?>                   
                           <div class="cbx post" style="padding:0;">
                             <?php echo $options['pbo_a2code'];?>                               
                          </div>     
                    <?php endif;?>
                <?php endif; ?>
				
				<?php endwhile;endif;?>				
				<?php if($options['pbo_toinner']):?>
                        <?php if($options['pbo_footnavi']):?>            
                            <div class="pagenavi pnb">
                                <?php par_pagenavi($query_string);?>
                            </div>
                        <?php endif;?>
                <?php else:?>
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
