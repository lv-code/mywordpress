<?php
/**
 * Template Name: Blog Page
 *
 *
 * @package WordPress
 * @subpackage Sparkler
 * @since Sparkler 1.0
 */

	get_header();
?>

<?php
	global $ct_options, $wp_query;

	isset( $ct_options['blog_sidebar'] ) ? $sidebar_position = $ct_options['blog_sidebar'] : $sidebar_position = 'right';
	isset( $ct_options['blog_pagination'] ) ? $blog_pagination = $ct_options['blog_pagination'] : $blog_pagination = 'standard';

	$push_content = '';
	$pull_sidebar = '';

	if ( $sidebar_position == 'left' ) {
		$push_content = 'col-md-push-4';
		$pull_sidebar = 'col-md-pull-8';
	}
?>
<?php
if (is_page_template()) : $ct_is_blogpage = 1; endif;

	// What page are we on? And what is the pages limit?
	$max = $wp_query->max_num_pages;

	if ( get_query_var('paged') ) {
    	$paged = get_query_var('paged');
	} elseif ( get_query_var('page') ) {
		$paged = get_query_var('page');
	} else {
		$paged = 1;
	}

	query_posts( array( 'post_type' => 'post', 'paged' => $paged ) );


		if ( !function_exists( 'ct_blog_pagination' ) ) {
    		function ct_blog_pagination($pages = '', $range = 2)
    		{
        		$showitems = ($range * 2)+1;

		        global $paged;
		        if(empty($paged)) $paged = 1;

		        if($pages == '')
			    {
		            global $wp_query;
            		$pages = $wp_query->max_num_pages;
            		if(!$pages)
            		{
                		$pages = 1;
            		}
        		}

		if(1 != $pages)
		{
			echo "<div class=\"pagination clearfix\" role=\"navigation\"><span>".__('Page ','color-theme-framework').$paged." ".__('of','color-theme-framework')." ".$pages."</span>";

			if (is_rtl()) {
				if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'><i class=\"icon-double-angle-right\"></i> ".__('First','color-theme-framework')."</a>";
			} else {
				if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'><i class=\"icon-double-angle-left\"></i> ".__('First','color-theme-framework')."</a>";
			}


			if (is_rtl()) {
				if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'><i class=\"icon-angle-right\"></i> ".__('Previous','color-theme-framework')."</a>";
			} else {
				if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'><i class=\"icon-angle-left\"></i> ".__('Previous','color-theme-framework')."</a>";
			}

			for ($i=1; $i <= $pages; $i++)
			{
				if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
				{
					echo ($paged == $i)? "<span class=\"current\">".$i."</span>":"<a href='".get_pagenum_link($i)."' class=\"inactive\">".$i."</a>";
				}
			}

			if (is_rtl()) {
				if ($paged < $pages && $showitems < $pages) echo "<a href=\"".get_pagenum_link($paged + 1)."\">".__('Next','color-theme-framework')." <i class=\"icon-angle-left\"></i></a>";
			} else {
				if ($paged < $pages && $showitems < $pages) echo "<a href=\"".get_pagenum_link($paged + 1)."\">".__('Next','color-theme-framework')." <i class=\"icon-angle-right\"></i></a>";
			}

			if (is_rtl()) {
				if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>".__('Last','color-theme-framework')." <i class=\"icon-double-angle-left\"></i></a>";
			} else {
				if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>".__('Last','color-theme-framework')." <i class=\"icon-double-angle-right\"></i></a>";
			}

			echo "</div>\n";
		}
    		}
		}
?>
<div id="main-content" class="main-content clearfix">
	<div id="primary" role="main">
			<?php if ( have_posts() ) : ?>

			<div class="container">
				<div class="row">
					<div class="col-md-8 <?php echo esc_attr( $push_content ); ?>">

						<div id="blog-entry" class="clearfix">
							<?php
							while ( have_posts() ) : the_post();
								get_template_part( 'content', get_post_format() );
							endwhile;
							?>
						</div> <!-- #blog-entry -->

						<?php ct_get_pagintaion(); ?>

					</div> <!-- .col-md-12 -->
						<?php if ( is_active_sidebar( 'ct_blog_sidebar' ) ) : ?>
							<div id="sidebar" class="col-md-4 ct-sidebar <?php echo esc_attr( $pull_sidebar ); ?>" role="complementary">
								<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('ct_blog_sidebar') ) : ?>
								<?php endif; ?>
							</div> <!-- .col-md-4 -->
						<?php endif; ?>

				</div> <!-- .row -->
			</div> <!-- .container -->

			<?php
				else :
					get_template_part( 'content', 'none' );
				endif;
			?>
	</div> <!--#primary -->
</div><!-- #main-content -->

<?php get_footer(); ?>
