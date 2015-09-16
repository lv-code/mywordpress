<?php get_header();?>
<?php if(ISMOBILE):?>
<div class="page_content">
	<div data-role="content" class="pd_l_5 pd_r_5">
	<h2><?php the_title();?></h2>	
	<?php if (have_posts()) : the_post(); update_post_caches($posts);setPostViews(get_the_ID()); ?>
	<?php the_content(); ?>
	<?php endif; ?>	
	</div>
</div>
	
<?php else:?>	


<div id="container">
		<?php include 'views/welcome.php';?>		
		<div id="content" class="single">
				<?php if (have_posts()) : the_post(); update_post_caches($posts);setPostViews(get_the_ID()); ?>
				<div class="sitemap cbx"> <a href="<?php bloginfo('home');?>" title="返回博客主页">
						<?php bloginfo('name');?>
						</a>&nbsp;&raquo;&nbsp;
						<?php the_category(' , ');?>
						&nbsp;&raquo;&nbsp;
						<?php the_title();?>
				</div>               
				<div class="cbx post">
						<h2>
								<?php the_title();?>
						</h2>
						<div class="postmeta">
								<ul>
										<li class="meta-date">
												<?php the_time('Y年n月j日') ?>
										</li>
										<li class="meta-cat">
												<?php the_category(' , ');?>
										</li>										
										<li class="meta-views">
												<?php getPostViews(get_the_ID(),'show',true); ?>
										</li>										
										<li class="meta-comments">
												<?php comments_popup_link('0 条评论', '1 条评论', '% 条评论', '', '评论已关闭'); ?>
										</li>
										<?php the_tags('<li class="meta-tags">', '&nbsp;,&nbsp;', '</li>');?>
										<?php edit_post_link( 'Edit','<li class="meta-edit">','</li>'); ?>
								</ul>
								<div class="clear"></div>
						</div>
						<div class="post-content">
								<div class="post-content-text">								
								<?php the_content(); ?>
								<?php global $options; if($options['pbo_a4show']):?>
                                        <div style="width:695px;height:90px;overflow:hidden;"> 
                                             <?php echo $options['pbo_a4code'];?>
                                        </div>
                                <?php endif; ?>
								</div>
								<div class="sharebar">										
										<!-- JiaThis Button BEGIN -->
										<div class="jiathis_style_24x24">
										<a class="jiathis_button_weixin"></a>
										<a class="jiathis_button_qzone"></a>
										<a class="jiathis_button_tsina"></a>
										<a class="jiathis_button_douban"></a>
										<a class="jiathis_button_tieba"></a>
										<a class="jiathis_button_huaban"></a>
										<a class="jiathis_button_google"></a>
										<a class="jiathis_button_fav"></a>
										<a class="jiathis_button_copy"></a>
										<a class="jiathis_button_email"></a>
										<a class="jiathis_button_print"></a>
										<a href="http://www.jiathis.com/share" class="jiathis jiathis_txt jtico jtico_jiathis" target="_blank"></a>
										<a class="jiathis_counter_style"></a>
										</div>
										<script type="text/javascript" src="http://v3.jiathis.com/code/jia.js" charset="utf-8"></script>
										<!-- JiaThis Button END --> 
								</div>
								<div class="relates">										
										<ul>
												<?php
												$post_tags = wp_get_post_tags($post->ID);
												if ($post_tags) {
												foreach ($post_tags as $tag) 
												{$tag_list[] .= $tag->term_id;}
												$post_tag = $tag_list[ mt_rand(0, count($tag_list) - 1) ];	
												$args = array(
												'tag__in' => array($post_tag),
												'category__not_in' => array(NULL),
												'post__not_in' => array($post->ID),
												'showposts' => 6, 
												'caller_get_posts' => 1
												);
												query_posts($args);
												if (have_posts()) : 
												while (have_posts()) : the_post(); update_post_caches($posts); ?>
												<li><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
														<?php the_title(); ?>
														</a>&nbsp;<span>(<?php getPostViews($post->ID,'show'); ?>)</span></li>
												<?php endwhile; else : ?>
												<li>暂无相关文章</li>
												<?php endif; wp_reset_query(); } ?>
										</ul>
								</div>
								<div class="clear"></div>
						</div>
				</div>
				<div id="prext" class="cbx"> <span class="prev">
						<?php previous_post_link('%link');?>
						</span><span class="next">
						<?php next_post_link('%link');?>
						</span>
						<div class="clear"></div>
				</div>
				<?php endif; ?>
				<?php comments_template();?>
		</div>
		<?php get_sidebar();?>
		<div class="clear"></div>
</div>
<?php endif;?>
<?php get_footer();?>
