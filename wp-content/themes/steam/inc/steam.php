<?php global $itMinisites; 

#set variables from theme options
$steam_category = it_get_setting('steam_category');
$steam_tag = it_get_setting('steam_tag');
$steam_length=180;

#setup query args
$args = array('posts_per_page' => it_get_setting('steam_number'));
if(!empty($steam_category)) {
	#add category to query args
	$args['cat'] = $steam_category;	
} 
if(!empty($steam_tag)) {	
	#add tag to query args
	$args['tag_id'] = $steam_tag;	
}
#setup loop format
$format = array('loop' => 'overlays', 'title' => $steam_length, 'rating' => true, 'width' => 272, 'height' => 188, 'size' => 'steam');

#get the current minisite
$minisite = it_get_minisite($post->ID);
if($minisite) {
	#add post type to query args
	if(it_targeted('steam', $minisite)) $args['post_type'] = $minisite->id;
}

if(!it_component_disabled('steam', $post->ID)) { ?>

	<?php do_action('it_before_steam'); ?>
    
    <div class="container">
        
        <div class="row" id="steam">
        
            <div class="span12">
            
                <div class="steam-content">
                
                    <?php $loop = it_loop($args, $format); echo $loop['content']; ?>
                
                </div>
                
            </div>
            
        </div>
        
    </div>
    
    <?php do_action('it_after_steam'); ?>
	
<?php } ?>

<?php wp_reset_query(); ?>