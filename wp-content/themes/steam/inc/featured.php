<?php global $itMinisites; 

#set variables from theme options
$featured_layout=it_get_setting('featured_layout');
$featured_category=it_get_setting('featured_category');
$featured_tag=it_get_setting('featured_tag');
$category_disable=it_get_setting('featured_category_disable');
$award_disable=it_get_setting('featured_award_disable');
$rating_disable=it_get_setting('featured_rating_disable');
$meta_disable=it_get_setting('featured_meta_disable');
$title_disable=it_get_setting('featured_title_disable');
$video_disable=it_get_setting('featured_video_disable');
$caption_disable=it_get_setting('featured_caption_disable');
$label_disable=it_get_setting('featured_label_disable');
$label = it_get_setting('featured_label');
if(empty($label)) $label = __('Featured',IT_TEXTDOMAIN); 
$sidecar_category=it_get_setting('sidecar_category');
$sidecar_tag=it_get_setting('sidecar_tag');

#setup query args
$featuredargs = array('posts_per_page' => it_get_setting('featured_number'));
if(!empty($featured_category)) {
	#add category to query args
	$featuredargs['cat'] = $featured_category;	
} 
if(!empty($featured_tag)) {	
	#add tag to query args
	$featuredargs['tag_id'] = $featured_tag;	
}

#get the current minisite
$disable = false;
$minisite = it_get_minisite($post->ID);
if($minisite) {
	#add post type to query args
	if(it_targeted('featured', $minisite)) $featuredargs['post_type'] = $minisite->id;
	#override general theme options with minisite-specific options
	$featured_layout = $minisite->featured_layout;	
	if(is_single() || is_archive()) $disable = true;
}

# setup featured layout variables
$length=168;
$sidecar_length=150;
$image='featured-medium';
$width=840;
$height=435;
switch ($featured_layout) {
	case 'small':
		$sidecar_length=175;
		$image='featured-small';
		$width=672;
		$height=348;
	break;
	case 'large':
		$image='featured-large';
		$width=1158;
		$height=600;
	break;
}

if(!it_component_disabled('featured', $post->ID) && !$disable) { ?>

	<?php do_action('it_before_featured'); ?>
    
    <div class="container">
        
        <div class="row" id="featured">
        
            <div class="span12">
            
                <div class="featured-wrapper clearfix">
                                
                    <?php query_posts( $featuredargs );
                    if(have_posts()) { ?>
                    
                        <div class="revolution-wrapper">
                        
                            <div class="revolution-slider <?php echo $featured_layout; ?>">
                            
                                <ul>
                            
                                    <?php # loop through featured slider panels
                                    $postcount=0;
                                    while (have_posts()) : the_post();  $postcount++;	
                                        $category = get_the_category();	
                                        if(is_array($category)) {
                                            if(array_key_exists(0, $category)) {
                                                if($category[0]) $category_name=$category[0]->cat_name;	
                                            }
                                        }
                                        #minisite variables	
										$minisite = '';	
										$rating_disable = false;
										$award_disable = false;	
										$category_disable = false;	
                                        $post_type = get_post_type(); #get post type
                                        $minisite = $itMinisites->get_type_by_id($post_type); #get minisite object from post type
                                        $awardsargs = array('postid' => get_the_ID(), 'minisite' => $minisite, 'single' => true, 'badge' => false, 'white' => true, 'wrapper' => true);
                                        $ratingargs = array('postid' => get_the_ID(), 'minisite' => $minisite, 'single' => false, 'editor_rating_hide' => false, 'user_rating_hide' => false, 'user_icon' => false, 'small' => '');
                                        $likesargs = array('postid' => get_the_ID(), 'label' => false, 'icon' => true, 'clickable' => false);		
                                        $viewsargs = array('postid' => get_the_ID(), 'label' => false, 'icon' => true);
                                        $commentsargs = array('postid' => get_the_ID(), 'label' => false, 'icon' => true, 'showifempty' => false, 'anchor_link' => false);
                                        if(!empty($minisite)) {
                                            #determine if rating should be shown
                                            $review_disable = get_post_meta( get_the_ID(), IT_META_DISABLE_REVIEW, $single = true );
                                            $editor_rating_disable = $minisite->editor_rating_disable;
                                            $user_rating_disable = $minisite->user_rating_disable;
                                            if($review_disable=='true' || ($editor_rating_disable && $user_rating_disable)) $rating_disable = true;
                                            $category_name = it_get_category($minisite, true, false, false);
                                            $award = it_get_awards($awardsargs);
                                        } else {
                                            $rating_disable=true;
                                            $award_disable=true;	
                                        }	
                                        if(empty($category_name)) $category_disable=true;
                                        if(empty($award)) $award_disable=true;	
                                        
                                        #featured video
                                        $video_disable = false;
                                        $video = get_post_meta( get_the_ID(), '_featured_video', $single = true );											
                                        if( !empty( $video ) )
                                            $video = it_video( $args = array( 'url' => $video, 'video_controls' => false, 'style' => it_get_setting('featured_video_style'), 'parse' => true, 'width' => $width, 'height' => $height, 'noframe' => '1' ) );												
                                        if(empty($video) || it_get_setting('featured_video_disable')) $video_disable = true;
                                        if(it_get_setting('featured_video_style') == 'top') {
                                            $video_style = 'style="z-index:100;" data-autoplay="false"';
                                        } else {
                                            $video_style = 'data-autoplay="true"';
                                        }
                                        ?>
                                        
                                        <li data-transition="<?php echo it_get_setting('featured_transition'); ?>" data-slotamount="7" data-link="<?php the_permalink(); ?>">
                                        
                                            <?php echo it_featured_image(get_the_ID(), $image, $width, $height, false, false, false); ?>
                                            
                                            <?php if(!$video_disable) { ?>
                                            
                                                <div class="caption fade video" <?php echo $video_style; ?> data-nextslideatend="true" data-x="left" data-y="top" data-speed="0" data-start="0" data-easing="easeInOutExpo">
                                                     <?php echo $video; ?>
                                                </div>
                                            
                                            <?php } ?> 
                                            
                                            <?php if(!$caption_disable) { ?>
                                            
                                                <div class="caption-bar caption lft" data-hoffset="0" data-x="left" data-y="top" data-speed="400" data-start="500" data-easing="easeInOutExpo" data-captionhidden="on">
                                                
                                                    <?php if(!$rating_disable) { ?>
                                                    
                                                        <?php echo it_show_rating($ratingargs); ?>
                                                        
                                                    <?php } ?>
                                                    
                                                    <?php if(!$category_disable) { ?>
                                                    
                                                        <div class="category"><?php echo $category_name; ?></div>
                                                        
                                                    <?php } ?>
                                                    
                                                    <?php if(!$meta_disable) { ?>
                                                    
                                                        <div class="article-meta">
                                                        
                                                            <?php echo it_get_likes($likesargs); ?>
                                                
                                                            <?php echo it_get_views($viewsargs); ?>
                                                            
                                                            <?php echo it_get_comments($commentsargs); ?>
                                                        
                                                        </div>
                                                        
                                                    <?php } ?>
                                                    
                                                    <?php if(!$award_disable) { ?>
                                                    
                                                        <?php echo $award; ?>
                                                        
                                                    <?php } ?>
                                                    
                                                    <?php if(!$label_disable) { ?>
                                                    
                                                        <div class="slider-label"><?php echo $label; ?></div>
                                                        
                                                    <?php } ?>
                                                
                                                </div>
                                                
                                            <?php } ?>
                                            
                                            <?php if(!$title_disable) { ?>
                                            
                                                <div class="title-bar caption lfb" data-x="left" data-y="bottom" data-speed="600" data-start="700" data-easing="easeInOutExpo">
                                            
                                                    <div class="title"><?php echo it_title($length); ?></div> 
                                                    
                                                </div> 
                                                
                                            <?php } ?>  
                                                
                                        </li>
                                            
                                        <?php                                
                                    endwhile; ?>
                                
                                    <?php wp_reset_query(); ?>  
                                
                                </ul>
                                
                                <?php if(!it_get_setting('featured_timer_disable')) { ?>
                                
                                    <div class="tp-bannertimer tp-bottom"></div> 
                                    
                                <?php } ?>          
                            
                            </div>
                            
                        </div>
                        
                    <?php } else { ?>
                    
                        <div class="revolution-wrapper">
                        
                            <div class="revolution-slider <?php echo $featured_layout; ?>">
                            
                                <div class="no-articles"><?php _e('No "Featured" articles found. Check your settings in Theme Options >> Content Carousels >> Featured Slider', IT_TEXTDOMAIN); ?></div>
                                
                            </div>
                            
                         </div>
                    
                    <?php } ?>
                    
                    <?php wp_reset_query(); ?>
                    
                    <?php $minisite = it_get_minisite($post->ID); ?>
                    
                    <?php if($featured_layout!='large') { ?>       
                         
                        <div class="sidecar-wrapper <?php echo $featured_layout; ?>">
                    
                            <div class="sidecar">
                            
                                <?php #setup wp_query args
                                $args = array('posts_per_page' => 10);
                                #should the scroller be targeted
                                if($minisite && it_targeted('featured', $minisite)) if(it_targeted('featured', $minisite)) $args['post_type'] = $minisite->id;
                                #add category to query args
                                if(!empty($sidecar_category)) {								
                                    $args['cat'] = $sidecar_category;	
                                } 
                                #add tag to query args
                                if(!empty($sidecar_tag)) {									
                                    $args['tag_id'] = $sidecar_tag;	
                                }
                                #setup loop format
                                $format = array('loop' => 'sidecar', 'title' => $sidecar_length);
                                ?>
                            
                                <?php $loop = it_loop($args, $format); echo $loop['content']; ?>
                            
                            </div>
                            
                        </div> 
                        
                    <?php } ?>   
                
                </div>
                
            </div>
        
        </div>
        
    </div>
    
    <?php do_action('it_after_featured'); ?>
	
<?php } ?>

<?php wp_reset_query(); ?>