<?php #setup minisites
global $itMinisites;

#default settings
$boxes_layout=it_get_setting('boxes_layout');
$boxes_overlay_type=it_get_setting('boxes_overlay_type');
$boxes_category=it_get_setting('boxes_cat');
$boxes_tag=it_get_setting('boxes_tag');
$boxes = array();
$cols = array();
$disable = false;

$minisite = it_get_minisite($post->ID);
if($minisite) {
	#override general theme options with minisite-specific options
	$boxes_layout = $minisite->boxes_layout;
}

#determine boxes number from layout
switch($boxes_layout) {
	case 'a':
		$cols[] = 1;
		$cols[] = 2;
		$cols[] = 1;
		$boxes[] = 'tall';
		$boxes[] = 'short';
		$boxes[] = 'short';
		$boxes[] = 'tall';
	break;
	case 'b':
		$cols[] = 1;
		$cols[] = 1;
		$cols[] = 1;
		$boxes[] = 'tall';
		$boxes[] = 'tall';
		$boxes[] = 'tall';
	break;
	case 'c':
		$cols[] = 2;
		$cols[] = 2;
		$cols[] = 2;
		$boxes[] = 'short';
		$boxes[] = 'short';
		$boxes[] = 'short';
		$boxes[] = 'short';
		$boxes[] = 'short';
		$boxes[] = 'short';
	break;
	case 'd':
		$cols[] = 1;
		$cols[] = 2;
		$cols[] = 2;
		$boxes[] = 'tall';
		$boxes[] = 'short';
		$boxes[] = 'short';
		$boxes[] = 'short';
		$boxes[] = 'short';
	break;
	case 'e':
		$cols[] = 2;
		$cols[] = 2;
		$cols[] = 1;
		$boxes[] = 'short';
		$boxes[] = 'short';
		$boxes[] = 'short';
		$boxes[] = 'short';
		$boxes[] = 'tall';
	break;
	case 'f':
		$cols[] = 2;
		$cols[] = 1;
		$cols[] = 2;
		$boxes[] = 'short';
		$boxes[] = 'short';
		$boxes[] = 'tall';
		$boxes[] = 'short';
		$boxes[] = 'short';
	break;
	case 'g':
		$cols[] = 1;
		$cols[] = 1;
		$cols[] = 1;
		$boxes[] = 'short';
		$boxes[] = 'short';
		$boxes[] = 'short';
	break;
}
$boxes_num = count($boxes);
#setup query args
$boxesargs = array('posts_per_page' => $boxes_num);
if(!empty($boxes_category)) {
	#add category to query args
	$boxesargs['cat'] = $boxes_category;	
}
if(!empty($boxes_tag)) {	
	#add tag to query args
	$boxesargs['tag_id'] = $boxes_tag;	
}
#get the current minisite
$minisite = it_get_minisite($post->ID);
if($minisite) {
	#add post type to query args	
	if(it_targeted('boxes', $minisite)) $boxesargs['post_type'] = $minisite->id;
}

if(!it_component_disabled('boxes', $post->ID) && !$disable) { 
?>

	<?php do_action('it_before_boxes'); ?>
    
    <div class="container-fluid no-padding">
    
        <div id="boxes" class="row-fluid">
        
            <div class="span12">
            
                <?php query_posts( $boxesargs );
                if(have_posts()) { ?>
                
                    <div class="box-column">
                    
                        <?php 
                        $postcount = 0;
                        $col = 0;
                        $percol = 0;
                        while (have_posts()) : the_post();
                            $height = 230;
                            $excerpt_length = 550;
							if(!isset($boxes[$postcount])) { #avoid undefined index notices
								$boxes[$postcount] = 'tall';
							}
                            if($boxes[$postcount] == 'tall') $height = 460;
							$minisite = it_get_minisite(get_the_ID(), true);
                            $awardsargs = array('postid' => get_the_ID(), 'minisite' => $minisite, 'single' => true, 'badge' => false, 'white' => true, 'wrapper' => true);
                            $ratingargs = array('postid' => get_the_ID(), 'minisite' => $minisite, 'single' => false, 'editor_rating_hide' => false, 'user_rating_hide' => false, 'user_icon' => true, 'small' => '');
                            $likesargs = array('postid' => get_the_ID(), 'label' => false, 'icon' => true, 'clickable' => false);		
                            $viewsargs = array('postid' => get_the_ID(), 'label' => false, 'icon' => true);
                            $commentsargs = array('postid' => get_the_ID(), 'label' => false, 'icon' => true, 'showifempty' => false, 'anchor_link' => false);
							$box_image = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'box-' . $boxes[$postcount] );
                            ?>
                            
                            <div class="box-panel <?php echo $boxes[$postcount]; ?> box-<?php echo $postcount; ?>">
                            
                                <div class="box-image" style="background-image:url('<?php echo $box_image[0] ?>');"></div>
                                
                                <a class="box-link <?php echo $boxes_overlay_type; ?>" href="<?php the_permalink(); ?>">&nbsp;</a>
                                
                                <div class="box-layer <?php echo $boxes_overlay_type; ?>"></div>
                                
                                <div class="box-info">
                                
                                    <div class="box-inner">
                                    
                                    	<?php if(!it_get_setting('loop_award_disable')) echo it_get_awards($awardsargs); ?>
                                        
                                        <?php if(!it_get_setting('loop_badge_disable')) echo it_show_rating($ratingargs); ?>
                                    
                                    	<div class="article-meta">
                                        
                                            <?php if(!it_get_setting('loop_likes_disable')) echo it_get_likes($likesargs); ?>
                                            
                                            <?php if(!it_get_setting('loop_views_disable')) echo it_get_views($viewsargs); ?>
                                            
                                            <?php if(!it_get_setting('loop_comments_disable')) echo it_get_comments($commentsargs); ?>
                                        
                                        </div>
                                        
                                        <div class="article-info">
                                    
											<?php echo it_get_category($minisite, true, false, false); ?>
                    
                                            <h2><?php echo it_title(); ?></h2>
                                            
                                            <?php if($boxes[$postcount]=='tall' && !it_get_setting('boxes_excerpt_disable')) { ?>
                                            
                                                <div class="excerpt">
                                                
                                                    <?php echo it_excerpt($excerpt_length); ?>
                                                
                                                </div>
                                            
                                            <?php } ?>
                                        
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                                
                            </div>
                            
                        <?php $postcount++; $percol++;                
                        #start a new span if this isn't the last column
						if(!isset($cols[$col])) $cols[$col] = 1;
						if($percol % $cols[$col] === 0 && $col < 3) { 
							#increase column count if we're at the end of one 
							$col++;
							$percol = 0;
							?>
						
							</div>
							<div class="box-column">
							
						<?php }
						endwhile; ?>
                    
                    </div>
                
                <?php } else { ?>
                                
                    <div class="no-articles"><?php _e('No "Boxes" articles found. Check your settings in Theme Options >> Front Page >> Boxes', IT_TEXTDOMAIN); ?></div>
                
                <?php } ?>
                
                <?php wp_reset_query(); ?>
            
            </div>
            
        </div>
        
    </div>
    
    <?php do_action('it_after_boxes'); ?>

<?php } ?>

<?php wp_reset_query(); ?>