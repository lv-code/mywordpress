<?php #setup minisites
global $itMinisites;

#default settings
$sidebar = __('Page Sidebar',IT_TEXTDOMAIN);
$thumbnail = it_get_setting('featured_image_size');
$layout = it_get_setting('layout');
$disable_view_count = it_component_disabled('sortbar_views', $post->ID);
$disable_like_count = it_component_disabled('sortbar_likes', $post->ID);
$disable_comment_count = it_component_disabled('sortbar_comments', $post->ID);
$disable_authorship = it_component_disabled('authorship', $post->ID);
$disable_comments = it_component_disabled('comments', $post->ID);
$disable_postnav = it_component_disabled('postnav', $post->ID);
$template = it_get_template_file();
$disable_postinfo = false;
$disable_sortbar = false;
$disable_recommended = false;
$full = '';
$pagecss = '';
$imagecss = ' floated-image';
$item_type = 'http://schema.org/Article';
$item_reviewed = '';
$details_position = '';
$proscons_position = '';
$ratings_position = '';
$bottomline_position = '';

#some setup logic for variables
if(!is_single()) $disable_authorship = true; #only show date/author on posts

#section-specific settings
if(is_404()) {
	#settings for 404 pages
	$title = __('404 Error - Page Not Found', IT_TEXTDOMAIN);
	$content_title = __('We could not find the page you were looking for. Try searching for it:', IT_TEXTDOMAIN);
	$layout_specific = it_get_setting('page_layout');
	$disable_view_count = true;
	$disable_like_count = true;
	$disable_comment_count = true;
	$disable_postinfo = true;
	$disable_recommended = true;
	$disable_comments = true;
	$disable_postnav = true;
} elseif(is_page()) {
	#settings for all standard WordPress pages
	$layout_specific = it_get_setting('page_layout');
	$thumbnail_specific = it_get_setting('page_featured_image_size');
	$title = get_post_meta($post->ID, "_subtitle", $single = true);
	$disable_postinfo = true;
	$disable_recommended = true;
	$page_comments = it_get_setting('page_comments');
	if(!$page_comments) {
		$disable_comments = true;
		$disable_comment_count = true;
	}
	$disable_postnav = true;
} elseif(is_single()) {
	#settings for single posts
	$layout_specific = it_get_setting('post_layout');
	$thumbnail_specific = it_get_setting('post_featured_image_size');
}
#settings for buddypress pages
if(it_buddypress_page()) {
	$disable_postinfo = true;	
	$disable_postnav = true;
	$disable_sortbar = true;
	$disable_authorship = true;
	$pagecss = 'buddypress-page';
	$layout_specific = it_get_setting('bp_layout');
	if(it_get_setting('bp_sidebar_unique')) $sidebar = __('BuddyPress Sidebar',IT_TEXTDOMAIN);	
}
#settings for woocommerce pages
if(it_woocommerce_page()) {	
	$disable_postinfo = true;
	$disable_postnav = true;
	$disable_sortbar = true;
	$disable_authorship = true;
	$pagecss = 'woocommerce-page';
	$layout_specific = it_get_setting('woo_layout');
	if(it_get_setting('woo_sidebar_unique')) $sidebar = __('WooCommerce Sidebar',IT_TEXTDOMAIN);	
}
#specific template files
switch($template) {
	case 'template-authors.php':
		$pagecss = 'template-authors';
		$disable_view_count = true;
		$disable_like_count = true;
		$disable_comment_count = true;
		$disable_authorship = true;
		$disable_postinfo = true;
		$disable_recommended = true;
		$disable_comments = true;
		$disable_postnav = true;
		$avatar_size = 80;	
		$display_admins = it_get_setting('author_admin_enable');
		$hide_empty = it_get_setting('author_empty_disable');
		$manual_exclude = it_get_setting('author_exclude');		
		$order_by = it_get_setting('author_order');
		$role = it_get_setting('author_role');
	break;	
}
#specific to minisite settings
$post_type = get_post_type();
$minisite = $itMinisites->get_type_by_id($post_type);
if($minisite) {
	$pagecss = 'minisite-page';
	$imagecss = ' full-image';
	$unique_sidebar = $minisite->unique_sidebar;
	$layout_specific = $minisite->post_layout;
	$thumbnail_specific = $minisite->post_featured_image_size;
	$disable_postnav = $minisite->postnav_disable;
	$editor_rating_disable = $minisite->editor_rating_disable;
	$details_position = !empty($minisite->details_position) ? $minisite->details_position : 'top';
	$proscons_position = !empty($minisite->proscons_position) ? $minisite->proscons_position : 'top';
	$ratings_position = !empty($minisite->ratings_position) ? $minisite->ratings_position : 'top';
	$bottomline_position = !empty($minisite->bottomline_position) ? $minisite->bottomline_position : 'top';
	if($details_position!='top' && $proscons_position!='top' && $ratings_position!='top' && $bottomline_position!='top') $imagecss = '';
	if($unique_sidebar) {
		$sidebar = $minisite->name . __(' Sidebar',IT_TEXTDOMAIN);
	}
}

#don't use specific settings if they are not set
if(!empty($layout_specific) && $layout_specific!='') $layout = $layout_specific;
if(!empty($thumbnail_specific) && $thumbnail_specific!='') $thumbnail = $thumbnail_specific;

#page-specific settings
$layout_meta = get_post_meta($post->ID, "_layout", $single = true);
if(!empty($layout_meta) && $layout_meta!='') $layout = $layout_meta;
$thumbnail_meta = get_post_meta($post->ID, "_featured_image_size", $single = true);
if(!empty($thumbnail_meta) && $thumbnail_meta!='') $thumbnail = $thumbnail_meta;
$sidebar_meta = get_post_meta($post->ID, "_custom_sidebar", $single = true);
if(!empty($sidebar_meta) && $sidebar_meta!='') $sidebar = $sidebar_meta;
$disable_review = get_post_meta( $post->ID, IT_META_DISABLE_REVIEW, $single = true );
$disable_title = get_post_meta($post->ID, IT_META_DISABLE_TITLE, $single = true);

if($minisite && $disable_review!='true' && !$editor_rating_disable) {
	$item_type = 'http://schema.org/Review';
	$item_reviewed = ' itemprop="itemReviewed"';
}

#global settings (override all other settings)
if(it_get_setting('featured_image_size_global')) $thumbnail = it_get_setting('featured_image_size');
if(it_get_setting('layout_global')) $layout = it_get_setting('layout');
if(it_get_setting('comments_disable_global')) $disable_comments = it_get_setting('comments_disable_global');

#special class for full-width featured images
if($thumbnail == '790') $imagecss = ' full-image';

#full width layout needs large full width featured image
if($layout == 'full' && $thumbnail == '790') $thumbnail = '1130';

$awardsargs = array('postid' => $post->ID, 'minisite' => $minisite, 'single' => false, 'badge' => false, 'white' => false, 'wrapper' => true);
$likesargs = array('postid' => $post->ID, 'label' => true, 'icon' => true, 'clickable' => true, 'tooltip_hide' => true);
$viewsargs = array('postid' => $post->ID, 'label' => true, 'icon' => true, 'tooltip_hide' => true);
$commentsargs = array('postid' => get_the_ID(), 'label' => true, 'icon' => true, 'showifempty' => true, 'tooltip_hide' => true, 'anchor_link' => true);
?>

<?php do_action('it_before_content_page'); ?>

<div class="container">

    <div id="content-wrapper" class="single-page <?php echo $pagecss; ?><?php echo $imagecss; ?>">
    
        <div class="row">
    
            <div class="span12">
                
                <?php if(!$disable_postnav) echo it_get_postnav(); ?>
                    
                <?php if($layout=='sidebar-left') it_widget_panel($sidebar, $layout); ?>
                
                <div id="content" class="main-content <?php echo $layout; ?>" data-location="single-page">
                              
                    <?php if (is_404()) : ?>
                    
                        <div class="main-sortbar">
                    
                            <div class="sortbar-wrapper">
                            
                                <div class="sortbar clearfix">
                                
                                    <span class="icon-attention"></span>
                        
                                    <div class="sortbar-title"><?php echo $title; ?></div>
                                    
                                </div>
                                
                            </div> 
                            
                        </div>
                        
                        <div class="content-inner">
                        
                            <div class="content-panel">
                        
                                <h1><?php echo $content_title; ?></h1>
                                    
                                <form method="get" class="form-search" action="<?php echo home_url(); ?>/"> 
                                    <div class="input-append">
                                        <input class="span6 search-query" name="s" id="s" type="text" placeholder="<?php _e('keyword(s)',IT_TEXTDOMAIN); ?>">
                                        <button class="btn icon-search" type="button"></button>
                                    </div>        
                                </form>
                                
                            </div>  
                            
                        </div>                      
                    
                    <?php elseif($template=='template-authors.php') : ?>
                    
                        <div class="main-sortbar">
                    
                            <div class="sortbar-wrapper">
                            
                                <div class="sortbar clearfix">
                                
                                    <span class="icon-users"></span>
                        
                                    <div class="sortbar-title"><?php the_title(); ?></div>
                                    
                                </div>
                                
                            </div> 
                            
                        </div>
                    
                        <div class="content-inner">
                            
                            <div class="the-content">
                            
                                <?php the_content(); ?>
                                
                            </div>
                            
                            <div class="loop">
                            
                                <?php #get authors and display loop							
                                $authors = it_get_authors($display_admins, $order_by, $role, $hide_empty, $manual_exclude);								
                                foreach($authors as $author) {
                                    $authorid = $author['ID'];
                                    ?>
                                    
                                    <div class="panel-wrapper clearfix">
                                    
                                        <div class="panel">
                                        
                                            <div class="panel-inner">
                                            
                                                <h2><a href="<?php echo get_author_posts_url($authorid); ?>" class="contributor-link"><?php echo the_author_meta('display_name', $authorid); ?></a></h2>
                                        
                                                <div class="article-image-wrapper">
                                            
                                                    <div class="article-image darken">
                                        
                                                        <a href="<?php echo get_author_posts_url($authorid); ?>"><?php echo get_avatar($authorid, $avatar_size); ?></a>
                                                        
                                                    </div>
                                                    
                                                    <?php echo it_author_profile_fields($authorid); ?>
                                                    
                                                    <a class="articles-link" href="<?php echo get_author_posts_url($authorid); ?>"><?php _e('All articles from this author &raquo;',IT_TEXTDOMAIN); ?></a>
                                                
                                                </div>
                                                
                                                <div class="article-excerpt-wrapper">
                                                
                                                    <div class="article-excerpt">
                                                        
                                                        <div class="excerpt">
                                                        
                                                            <p><?php echo the_author_meta('description', $authorid); ?></p>
                                                                              
                                                            <p class="articles-link"><?php echo it_author_latest_article($authorid); ?></p>
                                                        
                                                        </div>
                                                        
                                                    </div>
                                                    
                                                </div>
                                                
                                            </div>
                                    
                                        </div>
                                        
                                    </div>
                                
                                <?php } ?>
                                
                            </div>
                                
                        </div>
                        
                    <?php elseif (have_posts()) : ?>
                    
                        <?php if(!$disable_sortbar) { ?>
                        
                            <div class="main-sortbar">
                        
                                <div class="sortbar-wrapper">
                                
                                    <div class="sortbar clearfix">
                                    
                                        <span></span>
                        
                                        <?php if($minisite) { ?>
                                        
                                            <?php if(!it_component_disabled('sortbar_label', $post->ID)) { ?>
                                        
                                                <?php echo stripslashes(it_get_category($minisite, false, true, true)); ?>
                                                
                                            <?php } ?>
                                            
                                            <?php if(!it_component_disabled('sortbar_awards', $post->ID)) { ?>
                                            
                                                <?php echo '<div class="award-grid">' . it_get_awards($awardsargs) . '</div>'; ?>
                                                
                                            <?php } ?>
                                        
                                        <?php } else { ?>
                                        
                                            <?php if(!it_component_disabled('loop_title', $post->ID) && !empty($title) && $title!='') { ?>
                                            
                                                <div class="sortbar-title"><?php echo $title; ?></div>
                                                
                                            <?php } ?>
                                            
                                        <?php } ?>
                                        
                                        <?php if(!$disable_view_count) echo it_get_views($viewsargs); ?>
                                        
                                        <?php if(!$disable_like_count) echo it_get_likes($likesargs); ?>
                                        
                                        <?php if(!$disable_comment_count) echo it_get_comments($commentsargs); ?>
                                    
                                    </div>
                                    
                                </div>
                                
                            </div>
                            
                        <?php } ?>
                        
                        <div class="content-inner">
                        
                            <?php do_action('it_before_single_main'); ?>
                    
                            <?php while (have_posts()) : the_post(); ?>
                            
                                <?php #featured video
                                $video = get_post_meta(get_the_ID(), "_featured_video", $single = true);
                                                                    
                                if(!empty($video))
                                    $video = it_video( $args = array( 'url' => $video, 'video_controls' => it_get_setting('loop_video_controls'), 'parse' => true ) );
                                ?>
                            
                                <div id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope itemtype="<?php echo $item_type; ?>">
                                
                                    <div class="content-panel image-container">
                        
                                        <?php do_action('it_before_single_title'); ?>
                                        
										<?php if(!$disable_title) { ?>
                                            <h1<?php echo $item_reviewed; ?>>								
                                                <?php 
                                                if(!empty($content_title)) {
                                                    echo $content_title;
                                                } else { 
                                                    the_title();
                                                } 
                                                ?>                                    
                                            </h1>
                                        <?php } ?>
                                        
                                        <?php if(!$disable_authorship) it_show_authorship(); ?>
                                        
                                        <?php do_action('it_after_single_title'); ?>
                                        
                                        <?php do_action('it_before_single_featured_image'); ?>
                                        
                                        <?php if($thumbnail!='none' && has_post_thumbnail()) { ?>
                                            
                                            <?php 
                                            if(!empty($video)) {
                                                echo $video;
                                            } else {
                                                $featured_image = it_featured_image(get_the_ID(), 'single-'.$thumbnail, 818, 450, true, true);
                                            }
                                            ?>
                                                
                                            <?php echo $featured_image; ?>
                                            
                                        <?php } ?>
                                        
                                        <?php do_action('it_after_single_featured_image'); ?>
                                        
                                    </div>
                                    
                                    <?php if($details_position=='top') echo it_get_details(get_the_ID()); ?>
                                            
                                    <?php if($proscons_position=='top') echo it_get_pros_cons(get_the_ID()); ?>
                                        
                                    <?php if($ratings_position=='top') echo it_get_criteria(get_the_ID()); ?>
                                    
                                    <?php if($bottomline_position=='top') echo it_get_bottom_line(get_the_ID()); ?>
                                    
                                    <div class="content-panel content-container">
                                        
                                        <div class="the-content clearfix">
                                        
                                            <?php do_action('it_before_single_content'); ?>  
                                            
                                            <div class="safari-text-fix">&nbsp;</div>
                            
                                            <div class="clearfix"><?php the_content(); ?></div>
                                    
                                            <?php do_action('it_after_single_content'); ?>
                                                    
                                        </div> 
                                        
                                    </div>
                                    
                                    <?php if($details_position=='bottom') echo it_get_details(get_the_ID()); ?>
                                            
                                    <?php if($proscons_position=='bottom') echo it_get_pros_cons(get_the_ID()); ?>
                                        
                                    <?php if($ratings_position=='bottom') echo it_get_criteria(get_the_ID()); ?>
                                    
                                    <?php if($bottomline_position=='bottom') echo it_get_bottom_line(get_the_ID()); ?>
                                    
                                    <?php if(!$disable_postinfo) echo it_get_post_info(get_the_ID()); ?>                             
                                    
                                </div>
                            
                            <?php endwhile; ?>
                        
                            <?php if(!$disable_recommended) echo it_get_recommended(get_the_ID()); #don't put this in the loop because it contains a loop! ?>
                            
                            <?php if(!$disable_comments && comments_open()) comments_template(); // show comments ?>
                                                        
                            <?php do_action('it_after_single_main'); ?>
                            
                        </div>
                    
                    <?php endif; ?> 
                    
                    <?php wp_reset_query(); ?>
                        
                </div>          
             
                <?php if($layout=='sidebar-right') it_widget_panel($sidebar, $layout); ?>
            
            </div>
        
        </div>
        
    </div>
    
</div>

<?php do_action('it_after_single_page'); ?>

<?php wp_reset_query(); ?>