<?php global $itMinisites, $wp; 
#get the current query to pass it to the ajax functions through the html data tag
#don't want this if we're viewing a single post
$current_query = array();
if(!is_single()) $current_query = $wp->query_vars;

#set variables from theme options
$trending_timeperiod = it_get_setting('trending_timeperiod');
$timeperiod_label = it_get_setting('trending_sublabel');
if(empty($timeperiod_label)) $timeperiod_label = __("WHAT'S HOT", IT_TEXTDOMAIN);
$trending_label = it_get_setting("trending_label");
$trending_label = ( !empty( $trending_label ) ) ? $trending_label : __('TRENDING', IT_TEXTDOMAIN);
$numarticles = it_get_setting('trending_number');
$default_icon = 'viewed';

#setup wp_query args
$args = array('posts_per_page' => $numarticles, 'order' => 'DESC', 'orderby' => 'meta_value_num', 'meta_key' => IT_META_TOTAL_VIEWS);
#setup loop format
$format = array('loop' => 'trending', 'location' => 'trending slider', 'thumbnail' => false, 'rating' => false, 'icon' => false, 'nonajax' => true, 'numarticles' => $numarticles, 'metric' => 'viewed');

#determine if we are on a minisite page
$minisite = it_get_minisite($post->ID);
if($minisite) {	
	#add post type to query args
	if(it_targeted('trending', $minisite)) {
		$args['post_type'] = $minisite->id;	
		#also add to current query for ajax purposes
		$current_query['post_type'] = $minisite->id;
	}
}

#encode current query for ajax purposes
$current_query_encoded = json_encode($current_query);

if(!it_component_disabled('trending', $post->ID)) { ?>

<?php do_action('it_before_trending'); ?>

<div class="container">
    
    <div class="row bar-slider" id="trending" data-currentquery='<?php echo $current_query_encoded; ?>'>
    
        <div class="span12">
        
            <div class="bar-wrapper">
            
            	<div class="bar-label-wrapper">
            
                    <div class="bar-label">
                    
                        <div class="icon-trending"></div>
                    
                        <div class="label-text"><?php echo $trending_label; ?></div>
                        
                        <div class="timeperiod-text"><?php echo $timeperiod_label; ?></div>
                        
                    </div>
                            
                    <div class="bar-selector">
                    
                    	<div class="bar-selector-down">&nbsp;</div>
                    
                        <ul>
                        
                            <li>
                                
                                <div class="bar-selected">
                                
                                    <div class="selector-icon"><span class="icon-<?php echo $default_icon; ?>"></span></div>
                                    
                                    <a class="selector-button">&nbsp;</a>
                                    
                                    <div class="icon-down-bold"></div> 
                                    
                                </div>                   
                                
                                <ul data-loop="trending" data-location="trending slider" data-timeperiod="<?php echo $trending_timeperiod; ?>">
                                    
                                    <li>
                                
                                        <a class="selector-button clickable info-right" data-sorter="liked" title="<?php _e('Most Liked',IT_TEXTDOMAIN); ?>"><span class="selector-icon icon-liked">&nbsp;</span></a>
                                    
                                    </li>
                                    
                                    <li>
                                
                                        <a class="selector-button clickable info-right" data-sorter="commented" title="<?php _e('Most Commented',IT_TEXTDOMAIN); ?>"><span class="selector-icon icon-commented">&nbsp;</span></a>
                                    
                                    </li>
                                                            
                                    <li>
                                
                                        <a class="selector-button clickable info-right" data-sorter="viewed" title="<?php _e('Most Viewed',IT_TEXTDOMAIN); ?>"><span class="selector-icon icon-viewed">&nbsp;</span></a>
                                    
                                    </li>
                                    
                                    <li class="bar-selector-down">&nbsp;</li> 
                                
                                </ul>
                                
                            </li>                    
                        
                        </ul>
                        
                    </div>
                    
                </div>
                    
                <div class="loading"><div>&nbsp;</div></div>
                
                <div id="trending-slider" class="slide">
                
                    <?php
                    $week = date('W');
                    $month = date('n');
                    $year = date('Y');
                    switch($trending_timeperiod) {
                        case 'This Week':
                            $args['year'] = $year;
                            $args['w'] = $week;
                            $trending_timeperiod='';
                        break;	
                        case 'This Month':
                            $args['monthnum'] = $month;
                            $args['year'] = $year;
                            $trending_timeperiod='';
                        break;
                        case 'This Year':
                            $args['year'] = $year;
                            $trending_timeperiod='';
                        break;
                        case 'all':
                            $trending_timeperiod='';
                        break;			
                    }
                    ?> 
                
                    <?php $loop = it_loop($args, $format, $trending_timeperiod); echo $loop['content']; ?>
                    
                </div> 
                
            </div>
            
        </div>
    
    </div>
    
</div>

<?php do_action('it_after_trending'); ?>

<?php } ?>

<?php wp_reset_query(); ?>