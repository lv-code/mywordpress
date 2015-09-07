<?php

/*

Template Name:weibo 

*/

?>

<?php get_header();?>

<div id="container">
        <?php include 'views/welcome.php';?>
        
        <div id="content" class="single">
                <?php if (have_posts()) : the_post(); update_post_caches($posts); ?>
                <div class="sitemap cbx"> <a href="<?php bloginfo('home');?>" title="返回博客主页">
                        <?php bloginfo('name');?>
                        </a>&nbsp;&raquo;&nbsp;                     
                        明子的微博
                </div>              
                <div class="cbx post">                        
                        <div class="post-content post-page">
                               
                                
                                <?php the_content(); ?>
                                
                                
                                                               
                                <div class="clear"></div>
                        </div>
                </div>
                <?php endif; ?>             
                <?php comments_template();?>
        </div>
        <div id="sidebar" style="margin-top:15px;">
            <iframe width="100%" height="800" class="share_self"  frameborder="0" scrolling="no" src="http://widget.weibo.com/weiboshow/index.php?language=&width=0&height=800&fansRow=2&ptype=1&speed=0&skin=6&isTitle=1&noborder=1&isWeibo=1&isFans=1&uid=1743988495&verifier=5a87f2d1&dpc=1"></iframe>           
        </div>
        <div class="clear"></div>
</div>
<?php get_footer();?>