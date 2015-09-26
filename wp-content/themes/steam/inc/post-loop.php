<?php #setup minisites
global $itMinisites, $wp, $wp_query;
#get the current query to pass it to the ajax functions through the html data tag
#don't want this if we're viewing a single post
if(!is_single()) $current_query = $wp->query_vars;

#default settings
$view = 'grid';
$loop_layout = it_get_setting('layout');
$sidebar = __('Loop Sidebar',IT_TEXTDOMAIN);
$loops = array();
$numpages = $wp_query->max_num_pages;
$postsperpage = get_option('posts_per_page');
if(empty($postsperpage)) $postsperpage = 1;
$args = array('posts_per_page' => $postsperpage);
$template = it_get_template_file();
$count = 0;
$loop_style = 'main loop';
$solo = '';
$postloopcss = '';
$prefix = '';
$right = '';
$class = 'sortbar-hidden';
$container = 'content';
$disable_title = it_component_disabled('loop_title', $post->ID);
$disable_content_title = false;
$title = it_get_setting("loop_title");
if(empty($title)) $title = __('LATEST',IT_TEXTDOMAIN);
$loop_layout = it_get_setting("loop_layout");
$disable_filters = false;

#if we don't set current query then post loop pagination on front page won't display
if(empty($current_query)) $current_query = array('posts_per_page' => $postsperpage);

#for front page (main loop) determine excludes/limits
if(is_front_page()) {
	#limits
	$limit_cat = it_get_setting('loop_limit_cat');
	if(!empty($limit_cat)) $current_query['cat'] = $limit_cat;
	$limit_tag = it_get_setting('loop_limit_tag');	
	if(!empty($limit_tag)) $current_query['tag_id'] = $limit_tag;	
	#excludes
	$exclude_cat = it_get_setting('loop_exclude_cat');
	if(!empty($exclude_cat)) $current_query['category__not_in'] = array($exclude_cat);
	$exclude_tag = it_get_setting('loop_exclude_tag');	
	if(!empty($exclude_tag)) $current_query['tag__not_in'] = array($exclude_tag);
	$exclude_minisites = it_get_setting('loop_exclude_minisites');	
	if(!empty($exclude_minisites)) {
		$all_minisites = array();
		$include_minisites = array();
		#get all minisites into array
		if(is_array($itMinisites->minisites)) {
			foreach($itMinisites->minisites as $minisite) {
				$all_minisites[] = $minisite->id;
			}
		}
		$all_minisites[] = 'post';	
		#include minisites that are not excluded
		if(is_array($exclude_minisites)) $include_minisites = array_diff($all_minisites, $exclude_minisites);
		#if all minisites are excluded, need to set var to 'post' so it's not empty, or else pre_get_posts will inject all minisites
		if(empty($include_minisites)) $include_minisites = 'post';
		$current_query['post_type'] = $include_minisites;
	}
	
	#get new page number count
	query_posts ($current_query);
	$numpages = $wp_query->max_num_pages;
	wp_reset_query();
}

#minisite-specific settings
$minisite = it_get_minisite($post->ID);
if($minisite) {	
	$args['post_type'] = $minisite->id;
	#also add to current query for ajax purposes
	$current_query['post_type'] = $minisite->id;
	$postloopcss = ' minisite-page';
	if(!is_tax()) $numpages = ceil(wp_count_posts($minisite->id)->publish / $postsperpage); #already have numpages on taxonomy listings
	#theme options
	$loop_layout = $minisite->layout;
	$unique_sidebar = $minisite->unique_sidebar;
	if($unique_sidebar) $sidebar = $minisite->name . __(' Sidebar',IT_TEXTDOMAIN);
}

#determine css classes
if($loop_layout=='e' || $loop_layout=='f') $layout = 'full';
if($loop_layout=='c' || $loop_layout=='d') $layout = 'sidebar-left';
if($loop_layout=='a' || $loop_layout=='b') $layout = 'sidebar-right';
if($loop_layout=='b' || $loop_layout=='d' || $loop_layout=='f') $view = 'list';

#review directory-specific settings (override the loop_layout variable)
$directory_layout = '';
$directory_minisites = '';
$directory_type = '';
$directory_reviews = '';
$directorycss = '';
$location = '';
$disable_filter_control = '';
$disable_sortbar = false;
$directory = false;
if($template=='template-directory.php') {	
	$directory = true;
	$unique_sidebar = it_get_setting('directory_sidebar_unique');
	if($unique_sidebar) $sidebar = __('Minisite Directory Sidebar',IT_TEXTDOMAIN);
	$directory_minisites = get_post_meta($post->ID, "_directory_minisites", $single = true);
	$directory_type = get_post_meta($post->ID, "_directory_type", $single = true);	
	$postsperpage = get_post_meta($post->ID, "_directory_number", $single = true);
	$directory_layout = get_post_meta($post->ID, "_directory_layout", $single = true);
	$args['posts_per_page'] = $postsperpage;
	$current_query['posts_per_page'] = $postsperpage;
	$location = get_post_meta($post->ID, "_directory_style", $single = true);
	$directory_reviews = get_post_meta($post->ID, "_directory_reviews", $single = true);
	if($directory_reviews) $args['meta_query'] = array(array( 'key' => IT_META_DISABLE_REVIEW, 'value' => 'false', 'compare' => '=' ));
	$loop_style = $location;
	if($loop_style=='main loop list') {
		$view = 'list';
		$loop_style = 'main loop';
		$location = 'main loop';
	}
	if($directory_type=='merged') {
		$loop_style = 'main loop';
		$args['post_type'] = $directory_minisites;
		$current_query['post_type'] = $directory_minisites;	
		$i = 0;
		foreach($directory_minisites as $dm) {
			$i += wp_count_posts($dm)->publish;
		}
		$numpages = ceil($i / $postsperpage);
	} else {
		foreach($directory_minisites as $dm) {
			$this_minisite = $itMinisites->get_type_by_id($dm);
			$args['post_type'] = $dm;
			$current_query['post_type'] = $dm;
			#sorting options
			$directory_sort = get_post_meta($post->ID, "_directory_sort", $single = true);	
			switch($directory_sort) {
				case 'recent':	
					break;
				case 'title':
					$args['orderby'] = 'title';
					$args['order'] = 'ASC';
					break;
				case 'liked':
					$args['orderby'] = 'meta_value_num';
					$args['meta_key'] = IT_META_TOTAL_LIKES;
					break;
				case 'viewed':
					$args['orderby'] = 'meta_value_num';
					$args['meta_key'] = IT_META_TOTAL_VIEWS;	
					break;
				case 'users':
					$args['orderby'] = 'meta_value_num';
					$args['meta_key'] = IT_META_TOTAL_USER_SCORE_NORMALIZED;
					break;
				case 'reviewed':
					$args['orderby'] = 'meta_value_num';
					$args['meta_key'] = IT_META_TOTAL_SCORE_NORMALIZED;
					break;
				case 'commented':
					$args['orderby'] = 'comment_count';	
					break;
				case 'awarded':
					$args['orderby'] = 'date';
					$args['order'] = 'DESC';
					$meta_query = $args['meta_query'];
					$new_meta_query = array( array( 'key' => IT_META_AWARDS, 'value' => array(''), 'compare' => 'NOT IN') );
					if(!empty($meta_query)) {
						$meta_query = array_merge($meta_query, $new_meta_query);
					} else {
						$meta_query = $new_meta_query;
					}
					$args['meta_query'] = $meta_query;	
					break;
			}
			$icon = it_get_category($this_minisite);
			$loops[$dm] = array('args' => $args, 'current_query' => $current_query, 'name' => $this_minisite->name, 'icon' => $icon);
		}		
		$disable_sortbar = true;
		$prefix = get_the_title();
	}
	if($location!='main loop') {
		$directorycss = 'directory-list';
	}
	#main layout (sidebar or full-width)
	$layout_meta = get_post_meta($post->ID, "_layout", $single = true);
	if(!empty($layout_meta) && $layout_meta!='') $layout = $layout_meta;
	$title_meta = get_post_meta($post->ID, "_subtitle", $single = true);
	if(!empty($title_meta) && $title_meta!='') $title = $title_meta;
}

#post-specific meta
$sidebar_meta = get_post_meta($post->ID, "_custom_sidebar", $single = true);
if(!empty($sidebar_meta) && $sidebar_meta!='') $sidebar = $sidebar_meta;
$disable_title = get_post_meta($post->ID, IT_META_DISABLE_TITLE, $single = true);
#for front page retain title in post loop but hide main content title
if(is_front_page() && $disable_title) {
	$disable_title = false;
	$disable_content_title = true;
}

#global settings (override all other settings)
if(it_get_setting('layout_global')) $global_layout = it_get_setting('layout');

#override with global setting if set
if(!empty($global_layout) && $global_layout!='') $layout = $global_layout;

#determine number of columns
$cols=2;
if($layout=='full') $cols=3;
if($view=='list') $cols=1;
if($directory_layout=='wide' && $loop_style!='main loop') {
	$cols=2;
	if($layout=='full') $cols=3;
}

if($layout!='full') $directorycss .= ' non-full';

#determine title
if(is_archive()) {
	$post = $posts[0]; # Hack. Set $post so that the_date() works.
	if (is_category()) {
		$prefix = single_cat_title('', false);
	} elseif( is_tag() ) {
		$prefix = __("Posts Tagged &#8216;".single_tag_title('', false)."&#8217;", IT_TEXTDOMAIN);
	} elseif (is_day()) {
		$prefix = __("Archive for ".get_the_date('F jS, Y'), IT_TEXTDOMAIN);
	} elseif (is_month()) {
		$prefix = __("Archive for ".get_the_date('F, Y'), IT_TEXTDOMAIN);
	} elseif (is_year()) {
		$prefix = __("Archive for ".get_the_date('Y'), IT_TEXTDOMAIN);
	} elseif (is_author()) {
		$prefix = __("Author Archive", IT_TEXTDOMAIN);
	} elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {
		$prefix = __("Blog Archives", IT_TEXTDOMAIN);
	}
}
if(is_search()) {
	$prefix = __('Search results for ' , IT_TEXTDOMAIN) . '"' . get_search_query() . '"';	
}

#make title uppercase
$title = strtoupper($title);

#setup default $loops if this isn't a page with multiple loops
if($directory_type!='separated') $loops[0] = array('args' => $args, 'current_query' => $current_query);

#setup loop format for non-directory pages
$format = array('loop' => $loop_style, 'location' => $location, 'view' => $view, 'sort' => 'recent', 'container' => $container, 'columns' => $cols, 'paged' => 1, 'thumbnail' => true, 'rating' => true, 'icon' => true, 'nonajax' => true, 'meta' => false, 'numarticles' => $postsperpage);

#setup sortbar
$disabled = ( is_array( it_get_setting("loop_filter_disable") ) ) ? it_get_setting("loop_filter_disable") : array();

$sortbarargs = array('title' => $title, 'prefix' => $prefix, 'loop' => $loop_style, 'location' => $location, 'container' => $container, 'view' => $view, 'cols' => $cols, 'class' => $class, 'disabled' => $disabled, 'numarticles' => $postsperpage, 'disable_filters' => $disable_filters, 'disable_title' => $disable_title, 'thumbnail' => true, 'rating' => true, 'meta' => true);

?>

<?php do_action('it_before_loop'); ?>

<?php $current_query_encoded = json_encode($current_query); ?>

<div class="container">

    <div id="content-wrapper" class="loop-page">
        
        <div class="row">
    
            <div class="span12">
                    
                <?php if($layout=='sidebar-left') { ?>
                
                    <?php it_widget_panel($sidebar, $layout); ?>
                                
                <?php } ?>
            
                <div id="content" data-currentquery='<?php echo $current_query_encoded; ?>' class="main-content articles <?php echo $view; ?> <?php echo $layout; ?> <?php echo $directory_layout; ?> <?php echo $directory_type; ?> <?php echo $directorycss; ?>">
                
                    <div class="main-sortbar">
        
                        <?php if(!$disable_sortbar) echo it_get_sortbar($sortbarargs); ?>
                        
                    </div>
                    
                    <div class="content-inner">
                
                        <?php foreach($loops as $this_loop) { $count++; $right = ''; ?>
                    
                            <?php #if this is a minisite front page or if there is some custom homepage content to be displayed
                            if(($minisite && !is_tax() && !it_component_disabled('content', $post->ID)) || $directory || (is_front_page() && get_option('show_on_front')!='posts' && get_the_content()!='')) { ?>
                            
                                <?php if($count==1) { ?>
                                
                                    <div class="single-page">
                                    
                                        <div class="main-content">
                                    
                                            <div class="intro-content">
                                    
                                                <?php do_action('it_before_loop_title'); ?>
                                                
                                                <?php if(!$disable_title && !$disable_content_title) { ?>
                                                
                                                    <h1><?php the_title(); ?></h1>
                                                    
                                                <?php } ?>
                                                
                                                <?php if(get_the_content()!='') { ?>
                                            
                                                    <div class="the-content clearfix">
                                                    
                                                        <?php do_action('it_before_loop_content'); ?> 
                                                        
                                                        <?php the_content(); ?>
                                                
                                                        <?php do_action('it_after_loop_content'); ?>
                                                            
                                                    </div> 
                                                
                                                <?php } ?>
                                                
                                                <?php do_action('it_after_loop_title'); ?>
                                                
                                            </div>
                                            
                                        </div>
                                        
                                    </div>
                                        
                                <?php } ?>
                                
                            <?php } ?>
                        
                            <div class="loading"><div>&nbsp;</div></div>
                            
                            <?php if($directory && $location=='main loop' && $directory_type!='merged') { ?>
                            
                                <div class="directory-panel no-margin">
                                
                                    <h2><?php echo $this_loop['name']; ?></h2>
                                    
                                </div>
                            
                            <?php } ?>
                            
                            <?php if($directory && $location!='main loop') { ?>
                                
                                <?php if($count % $cols == 0) $right = 'right'; ?>
                            
                                <div class="directory-panel-wrapper">
                                
                                    <div class="directory-panel <?php echo $right; ?>">
                                    
                                        <?php if($directory && $directory_type!='merged') { ?>
                                                
                                            <h2><?php echo $this_loop['icon']; ?><?php echo $this_loop['name']; ?></h2>
                                        
                                        <?php } ?>
                            
                            <?php } ?>
                            
                            <div class="loop clearfix <?php echo $view; ?>">
                            
                                <?php if(!empty($this_loop['current_query']) && is_array($this_loop['current_query'])) $this_loop['args'] = array_merge($this_loop['args'], $this_loop['current_query']); ?>
                                <?php $loop = it_loop($this_loop['args'], $format); echo $loop['content']; ?>
                                
                            </div>
                            
                            <?php if($directory && $location!='main loop') { ?>
                                
                                    </div>
                            
                                </div>
                            
                            <?php } ?>
                            
                        <?php } ?>
                        
                        <?php wp_reset_query(); ?>
                
                        <div class="pagination-wrapper">
                            
                            <?php echo it_pagination($numpages, $format, it_get_setting('page_range')); ?>
                            
                        </div>
                        
                        <div class="pagination-wrapper mobile">
                        
                            <?php echo it_pagination($numpages, $format, it_get_setting('page_range_mobile')); ?>
                            
                        </div>
                        
                        <?php wp_reset_query(); ?>
                        
                    </div>
                        
                </div>          
             
                <?php if($layout=='sidebar-right') { ?>
                
                    <?php it_widget_panel($sidebar, $layout); ?>
                
                <?php } ?>
            
            </div>
        
        </div>
        
    </div>
    
</div>

<?php do_action('it_after_loop'); ?>

<?php wp_reset_query(); ?>