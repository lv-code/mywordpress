<?php global $itMinisites; 

#set variables from theme options
$label_top = it_get_setting('exclusive_label_top');
$label_bottom = it_get_setting('exclusive_label_bottom');
if(empty($label_top)) $label_top = __('EXCLUSIVE!', IT_TEXTDOMAIN);
$exclusive_category=it_get_setting('exclusive_category');
$exclusive_tag=it_get_setting('exclusive_tag');

#setup wp_query args
$args = array('posts_per_page' => 1);
#setup loop format
$format = array('loop' => 'sizzlin', 'thumbnail' => false, 'rating' => false, 'icon' => false);

if(!empty($exclusive_category)) {
	#add category to query args
	$args['cat'] = $exclusive_category;	
} else {	
	#add tag to query args
	$args['tag_id'] = $exclusive_tag;	
}

#determine if we are on a minisite page
$minisite = it_get_minisite($post->ID);
if($minisite) {	
	#add post type to query args
	if(it_targeted('exclusive', $minisite)) $args['post_type'] = $minisite->id;
}

if(!it_component_disabled('exclusive', $post->ID)) { ?>

<?php do_action('it_before_exclusive'); ?>

<div class="container">
    
    <div class="row" id="exclusive">
    
        <div class="span12">
        
            <div class="bar-wrapper">
            
                <div class="bar-label">
                
                    <div class="label-text"><?php echo $label_top; ?></div>
                    
                    <div class="timeperiod-text"><?php echo $label_bottom; ?></div>
                    
                </div>
                
                <ul class="hover-link">
                
                    <?php $loop = it_loop($args, $format); echo $loop['content']; ?>
                    
                </ul>
                
                <?php if(!it_get_setting('exclusive_more_disable')) { ?>
                
                    <div class="exclusive-more hover-text">
                        
                        <?php _e('Full Story', IT_TEXTDOMAIN); ?>
                        
                        <span class="icon-right"></span>
                    
                    </div>
                    
                <?php } ?>
                
            </div>
            
        </div>
    
    </div>
    
</div>

<?php do_action('it_after_exclusive'); ?>

<?php } ?>

<?php wp_reset_query(); ?>