<?php global $itMinisites, $wp; 
#get the current query to pass it to the ajax functions through the html data tag
#don't want this if we're viewing a single post
$current_query = array();
if(!is_single()) $current_query = $wp->query_vars;

#set variables from theme options
$topten_timeperiod = it_get_setting('topten_timeperiod');
$timeperiod_label = it_timeperiod_label($topten_timeperiod);
if(empty($timeperiod_label)) $timeperiod_label = __('This Month', IT_TEXTDOMAIN);
$topten_label = it_get_setting("topten_label");
$topten_label = ( !empty( $topten_label ) ) ? $topten_label : __('TOP TEN', IT_TEXTDOMAIN);

#setup wp_query args
$args = array('posts_per_page' => 10, 'order' => 'DESC', 'orderby' => 'meta_value_num');
#setup loop format
$format = array('loop' => 'top ten', 'thumbnail' => false, 'rating' => false, 'icon' => false);

#get array of disabled filters
$disabled = ( is_array( it_get_setting("topten_disable_filter") ) ) ? it_get_setting("topten_disable_filter") : array();
#determine default options
$default_metric = 'viewed';
$args['meta_key'] = IT_META_TOTAL_VIEWS;
$default_label = __('Most Views', IT_TEXTDOMAIN);
$default_icon = '';
#loop through each metric and set to default until one is found
if(!in_array('viewed', $disabled)) {
	$default_metric = 'viewed';
	$args['meta_key'] = IT_META_TOTAL_VIEWS;
	$default_label = __('Most Views', IT_TEXTDOMAIN);
} elseif (!in_array('liked', $disabled)) {
	$default_metric = 'liked';
	$args['meta_key'] = IT_META_TOTAL_LIKES;
	$default_label = __('Most Likes', IT_TEXTDOMAIN);
} elseif (!in_array('reviewed', $disabled)) {
	$default_metric = 'reviewed';
	$format['rating'] = true;
	$args['meta_key'] = IT_META_TOTAL_SCORE_NORMALIZED;
	$args['meta_query'] = array(array( 'key' => IT_META_DISABLE_REVIEW, 'value' => 'false', 'compare' => '=' ));
	$default_label = __('Best Reviewed', IT_TEXTDOMAIN);
} elseif (!in_array('rated', $disabled)) {
	$default_metric = 'users';
	$format['rating'] = true;
	$default_icon = 'rated';
	$args['meta_key'] = IT_META_TOTAL_USER_SCORE_NORMALIZED;
	$args['meta_query'] = array(array( 'key' => IT_META_DISABLE_REVIEW, 'value' => 'false', 'compare' => '=' ));
	$default_label = __('Highest Rated', IT_TEXTDOMAIN);
} elseif (!in_array('commented', $disabled)) {
	$default_metric = 'commented';
	$args['orderby'] = 'comment_count';
	$default_label = __('Most Comments', IT_TEXTDOMAIN);
}
$format['metric'] = $default_metric;
if(empty($default_icon)) $default_icon = $default_metric;

#determine if we are on a minisite page
$minisite = it_get_minisite($post->ID);
if($minisite) {	
	#add post type to query args
	if(it_targeted('topten', $minisite)) {
		$args['post_type'] = $minisite->id;	
		#also add to current query for ajax purposes
		$current_query['post_type'] = $minisite->id;
	}
}

#encode current query for ajax purposes
$current_query_encoded = json_encode($current_query);

if(!it_component_disabled('topten', $post->ID)) { ?>

<?php do_action('it_before_topten'); ?>

<div class="container">
    
    <div class="row bar-slider" id="top-ten" data-currentquery='<?php echo $current_query_encoded; ?>'>
    
        <div class="span12">
        
            <div class="bar-wrapper">
            
            	<div class="bar-label-wrapper">
            
                    <div class="bar-label">
                    
                        <div class="label-text"><?php echo $topten_label; ?></div>
                        
                        <div class="timeperiod-text"><?php echo $timeperiod_label; ?></div>
                        
                    </div>
                            
                    <div class="bar-selector">
                    
                    	<div class="bar-selector-down">&nbsp;</div>
                    
                        <ul>
                        
                            <li>
                                
                                <div class="bar-selected">
                                
                                    <div class="selector-icon"><span class="icon-<?php echo $default_icon; ?>"></span></div>
                                    
                                    <a class="selector-button"><?php echo $default_label; ?></a>
                                    
                                    <div class="icon-down-bold"></div> 
                                    
                                </div>                   
                                
                                <ul data-loop="top ten" data-timeperiod="<?php echo $topten_timeperiod; ?>">
                                    
                                    <?php if(!in_array('liked', $disabled)) { ?>
                                    
                                    <li>
                                    
                                        <div class="selector-icon icon-liked"></div>
                                
                                        <a class="selector-button clickable" data-sorter="liked" data-label="<?php _e('Most Likes', IT_TEXTDOMAIN); ?>"><?php _e('Most Likes', IT_TEXTDOMAIN); ?></a>
                                    
                                    </li>
                                    
                                    <?php } ?> 
                                    
                                    <?php if(!in_array('reviewed', $disabled)) { ?>                          
                                    
                                    <li>
                                    
                                        <div class="selector-icon icon-reviewed"></div>
                                
                                        <a class="selector-button clickable" data-sorter="reviewed" data-label="<?php _e('Best Reviewed', IT_TEXTDOMAIN); ?>"><?php _e('Best Reviewed', IT_TEXTDOMAIN); ?></a>
                                    
                                    </li>
                                    
                                    <?php } ?> 
                                    
                                    <?php if(!in_array('rated', $disabled)) { ?>
                                    
                                    <li>
                                    
                                        <div class="selector-icon icon-users"></div>
                                
                                        <a class="selector-button clickable" data-sorter="rated" data-label="<?php _e('Highest Rated', IT_TEXTDOMAIN); ?>"><?php _e('Highest Rated', IT_TEXTDOMAIN); ?></a>
                                    
                                    </li>
                                    
                                    <?php } ?> 
                                    
                                    <?php if(!in_array('commented', $disabled)) { ?>
                                    
                                    <li>
                                    
                                        <div class="selector-icon icon-commented"></div>
                                
                                        <a class="selector-button clickable" data-sorter="commented" data-label="<?php _e('Most Comments', IT_TEXTDOMAIN); ?>"><?php _e('Most Comments', IT_TEXTDOMAIN); ?></a>
                                    
                                    </li>
                                    
                                    <?php } ?> 
                                    
                                    <?php if(!in_array('viewed', $disabled)) { ?>
                                                            
                                    <li>
                                    
                                        <div class="selector-icon icon-viewed"></div>
                                
                                        <a class="selector-button clickable" data-sorter="viewed" data-label="<?php _e('Most Views', IT_TEXTDOMAIN); ?>"><?php _e('Most Views', IT_TEXTDOMAIN); ?></a>
                                    
                                    </li> 
                                    
                                    <?php } ?>
                                    
                                    <li class="bar-selector-down">&nbsp;</li>
                                
                                </ul>
                                
                            </li>                    
                        
                        </ul>
                        
                    </div>
                    
                </div>
                    
                <div class="loading"><div>&nbsp;</div></div>
                
                <div id="top-ten-slider" class="slide">
                
                    <?php
                    $week = date('W');
                    $month = date('n');
                    $year = date('Y');
                    switch($topten_timeperiod) {
                        case 'This Week':
                            $args['year'] = $year;
                            $args['w'] = $week;
                            $topten_timeperiod='';
                        break;	
                        case 'This Month':
                            $args['monthnum'] = $month;
                            $args['year'] = $year;
                            $topten_timeperiod='';
                        break;
                        case 'This Year':
                            $args['year'] = $year;
                            $topten_timeperiod='';
                        break;
                        case 'all':
                            $topten_timeperiod='';
                        break;			
                    }
                    ?> 
                
                    <?php $loop = it_loop($args, $format, $topten_timeperiod); echo $loop['content']; ?>
                    
                </div> 
                
            </div>
            
        </div>
    
    </div>
    
</div>

<?php do_action('it_after_topten'); ?>

<?php } ?>

<?php wp_reset_query(); ?>