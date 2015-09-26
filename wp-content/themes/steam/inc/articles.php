<?php #setup minisites
global $itMinisites, $wp, $wp_query;
#get the current query to pass it to the ajax functions through the html data tag
$current_query = $wp->query_vars;

#default settings
$args = array();
$numpages = $wp_query->max_num_pages;
$postsperpage = get_option('posts_per_page');
if(empty($postsperpage)) $postsperpage = 1;
$loop = 'main loop';
$cols = 3;
$view = 'grid';
$location = '';
$container = 'articles';
$class = 'sortbar-hidden';
$disable_filters = false;
$disable_title = it_component_disabled('loop_title', $post->ID);

#section-specific settings
$title = it_get_setting("loop_title");
if(empty($title)) $title = __('LATEST',IT_TEXTDOMAIN);
$loop_layout = it_get_setting("loop_layout");
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

#query args
$args = array('posts_per_page' => $postsperpage);

#setup loop format for non-directory pages
$format = array('loop' => $loop, 'location' => $location, 'view' => $view, 'sort' => 'recent', 'columns' => $cols, 'paged' => 1, 'container' => $container, 'thumbnail' => true, 'rating' => true, 'icon' => true, 'nonajax' => true, 'meta' => true, 'numarticles' => $postsperpage);

#determine if we are on a minisite page
$minisite = it_get_minisite($post->ID);
if($minisite) {	
	#add post type to query args
	if(it_targeted('articles', $minisite)) {
		$args['post_type'] = $minisite->id;	
		#also add to current query for ajax purposes
		$current_query['post_type'] = $minisite->id;
	}
}

if(!is_single()) $args = array_merge($args, $current_query);

#setup sortbar
$disabled = ( is_array( it_get_setting("loop_filter_disable") ) ) ? it_get_setting("loop_filter_disable") : array();

$sortbarargs = array('title' => $title, 'loop' => $loop, 'location' => $location, 'container' => $container, 'view' => $view, 'cols' => $cols, 'class' => $class, 'disabled' => $disabled, 'numarticles' => $postsperpage, 'disable_filters' => $disable_filters, 'disable_title' => $disable_title, 'prefix' => false, 'thumbnail' => true, 'rating' => true, 'meta' => true);

?>

<?php do_action('it_before_articles'); ?>

<?php $current_query_encoded = json_encode($current_query); ?>

<div class="container">
    
    <div id="articles" class="articles" data-currentquery='<?php echo $current_query_encoded; ?>'>
    
        <?php echo it_get_sortbar($sortbarargs); ?>
        
        <div class="row">
    
            <div class="span12">
            
                <div class="content-inner">
            
                    <div class="loading"><div>&nbsp;</div></div>
                
                    <div class="loop grid">
                    
                        <?php $loop = it_loop($args, $format); echo $loop['content']; ?>
                        
                    </div>
                                
                    <div class="pagination-wrapper">
                    
                        <?php echo it_pagination($numpages, $format, it_get_setting('page_range')); ?>
                        
                    </div>
                    
                    <div class="pagination-wrapper mobile">
                    
                        <?php echo it_pagination($numpages, $format, it_get_setting('page_range_mobile')); ?>
                        
                    </div>
                    
                </div>
            
            </div>
            
        </div>
        
    </div>
    
</div>

<?php do_action('it_after_articles'); ?>

<?php wp_reset_query(); ?>