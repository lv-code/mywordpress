<?php get_header();?>
<div id="container">
		<?php include 'views/welcome.php';?>
		<div id="content">				
				<div class="cbx gry">搜索关键字：<strong> <?php the_search_query(); ?></strong></div>							
				<?php if(have_posts()): ?>
				<?php if($options['pbo_topnavi']):?>
				<div class="pagenavi">
					<?php par_pagenavi($query_string);?>
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
						<div class="post-content"><?php the_content('阅读全文...'); ?> </div>						
				</div>
							
				
				<?php endwhile;?>	
				<div class="pagenavi pnb">
						<?php par_pagenavi($query_string);?>
				</div>
				<?php else:?>
				<div class="cbx post searchno">
					<h3>所有文章中没有出现你搜索的关键词</h3>
					<p>请换一个关键词搜索。另外你可以点击导航栏的Archives或Tags以找到你想要的东西。 </p>
					
					<p>以下是<strong>最近10篇文章</strong>，或许你会感兴趣。 </p>
					<ul><?php get_archives('postbypost', 10); ?></ul>
				</div>
				<?php endif;?>
		</div>
		<?php get_sidebar();?>
		<div class="clear"></div>
</div>
<?php get_footer();?>
