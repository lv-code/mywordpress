<?php get_header();?>

<div id="container">
		<?php include 'views/welcome.php';?>
		
		<div id="content" class="single">
				<?php if (have_posts()) : the_post(); update_post_caches($posts); ?>
				<div class="sitemap cbx"> <a href="<?php bloginfo('home');?>" title="返回博客主页">
						<?php bloginfo('name');?>
						</a>&nbsp;&raquo;&nbsp;						
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
										<li class="meta-comments">
												<?php comments_popup_link('0 条评论', '1 条评论', '% 条评论', '', '评论已关闭'); ?>
										</li>
										<?php the_tags('<li class="meta-tags">', '&nbsp;,&nbsp;', '</li>');?>
										<?php edit_post_link( 'Edit','<li class="meta-edit">','</li>'); ?>
								</ul>
								<div class="clear"></div>
						</div>
						<div class="post-content post-page">
								<div class="post-content-text">
								
								<?php the_content(); ?>
								
								</div>
								<?php global $options; if($options['pbo_a4show']):?>
								        <div style="width:695px;height:90px;overflow:hidden;"> 
                                             <?php echo $options['pbo_a4code'];?>
                                        </div>
                                <?php endif; ?>
								<div class="sharebar">
										<h4 class="singleshare">分享该文章：</h4>
										<!-- JiaThis Button BEGIN -->
										<div class="jiathis_style_24x24">
										<a class="jiathis_button_weixin"></a>
										<a class="jiathis_button_qzone"></a>
										<a class="jiathis_button_tsina"></a>
										<a class="jiathis_button_douban"></a>
										<a class="jiathis_button_tieba"></a>
										<a class="jiathis_button_huaban"></a>
										<a class="jiathis_button_google"></a>
										<a class="jiathis_button_ujian"></a>
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
								<div class="clear"></div>
						</div>
				</div>
				<?php endif; ?>				
				<?php comments_template();?>
		</div>
		<?php get_sidebar();?>
		<div class="clear"></div>
</div>
<?php get_footer();?>
