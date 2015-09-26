<?php 
function it_loop($args, $format, $timeperiod = '') {
	global $itMinisites, $wp_query;
	if(!is_array($format)) $format = array();
	extract($format);
	if(empty($location)) $location = $loop; #a specified location overrides the loop parameter
	
	#don't care about pagename if we're displaying a post loop on a content page
	$args['pagename'] = '';
	#add a filter if this loop needs a time constraint (can't add to query args directly)
	global $timewhere;
	$timewhere = $timeperiod;
	if(!empty($timeperiod)) {		
		add_filter( 'posts_where', 'filter_where' );
	}	
	#query the posts
	query_posts ( $args );
	#remove the filter after we're done
	if(!empty($timeperiod)) {				
		remove_filter( 'posts_where', 'filter_where' );
	}
	#setup ads array
	$ads=array();
	$ad1=it_get_setting('loop_ad_1');
	$ad2=it_get_setting('loop_ad_2');
	$ad3=it_get_setting('loop_ad_3');
	$ad4=it_get_setting('loop_ad_4');
	$ad5=it_get_setting('loop_ad_5');
	$ad6=it_get_setting('loop_ad_6');
	$ad7=it_get_setting('loop_ad_7');
	$ad8=it_get_setting('loop_ad_8');
	$ad9=it_get_setting('loop_ad_9');
	$ad10=it_get_setting('loop_ad_10');
	if(!empty($ad1)) array_push($ads,$ad1);
	if(!empty($ad2)) array_push($ads,$ad2);
	if(!empty($ad3)) array_push($ads,$ad3);
	if(!empty($ad4)) array_push($ads,$ad4);
	if(!empty($ad5)) array_push($ads,$ad5);
	if(!empty($ad6)) array_push($ads,$ad6);
	if(!empty($ad7)) array_push($ads,$ad7);
	if(!empty($ad8)) array_push($ads,$ad8);
	if(!empty($ad9)) array_push($ads,$ad9);
	if(!empty($ad10)) array_push($ads,$ad10);
	if(it_get_setting('ad_shuffle')) shuffle($ads);

	#counters
	$i=0;
	$p=0;
	$m=0;	
	$a=0;
	$b=0;
	$out = '';
	if(empty($size)) $size = 'grid-post';
	$updatepagination=1;
	$perpage = $args['posts_per_page'];
	$posts_shown = $wp_query->found_posts;
	if($posts_shown > $perpage) $posts_shown = $perpage;
	$percol = ceil($posts_shown / 4); #articles per column for new articles panel
	$first = true;
	if (have_posts()) : while (have_posts()) : the_post(); $m++;	
		#minisite variables			
		$post_type = get_post_type(); #get post type
		if(!empty($post_type)) $minisite = $itMinisites->get_type_by_id($post_type); #get minisite object from post type
		
		#post-specific variables
		$more_link = '';
		if(isset($minisite->more_link))	$more_link = $minisite->more_link;
		
		#featured video
		$video = get_post_meta(get_the_ID(), "_featured_video", $single = true);
											
		if(!empty($video))
			$video = it_video( $args = array( 'url' => $video, 'video_controls' => it_get_setting('loop_video_controls'), 'parse' => true, 'width' => 349, 'height' => 245 ) );	
			
		$awardsargs = array('postid' => get_the_ID(), 'minisite' => $minisite, 'single' => true, 'badge' => false, 'white' => false, 'wrapper' => true);
		
		$ratingargs = array('postid' => get_the_ID(), 'minisite' => $minisite, 'single' => false, 'editor_rating_hide' => false, 'user_rating_hide' => false, 'user_icon' => false, 'small' => '');
		
		$likesargs = array('postid' => get_the_ID(), 'label' => false, 'icon' => true, 'clickable' => false);
		
		$viewsargs = array('postid' => get_the_ID(), 'label' => false, 'icon' => true);
		
		$commentsargs = array('postid' => get_the_ID(), 'label' => false, 'icon' => true, 'showifempty' => false, 'anchor_link' => false);
		
		$box_image = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), $size );
				
		switch ($location) {
			case 'sidecar': #FEATURED SIDECAR SCROLLER
			
				$out.='<div class="sidecar-panel">';
                        
					$out.='<div class="sidecar-image">' . it_featured_image(get_the_ID(), 'sidecar', 480, 150, false, false, false) . '</div>';
					
					$out.='<a class="sidecar-link" href="' . get_permalink() . '"></a>';
					
					$out.='<div class="sidecar-layer"></div>';
					
					$out.='<div class="sidecar-info">';
					
						$out.='<div class="sidecar-inner">';
						
							$out.= it_get_category($minisite, true, false, false);
	
							$out.= it_title($title);
							
						$out.='</div>';
						
					$out.='</div>';
					
				$out.='</div>';
            
			break;
			case 'overlays': #EXPLICIT SCROLLER
			
				$awardsargs['white'] = true;
				$ratingargs['user_icon'] = true;
				if(empty($title)) $title = 180;
				
				$b++;
				if($b > 8) $b = 0; #reset counter
			
				$out.='<div class="box-panel box-' . $b . '">';
                        
					$out.='<div class="box-image" style="background-image:url(' . $box_image[0] . ');"></div>';
					
					$out.='<a class="box-link" href="' . get_permalink() . '"></a>';
					
					$out.='<div class="box-layer black"></div>';
					
					$out.='<div class="box-info">';
					
						$out.='<div class="box-inner">';
						
							if(!empty($minisite) && $rating && !it_get_setting('steam_rating_disable')) $out.=it_show_rating($ratingargs);
							
							if(!it_get_setting('steam_award_disable')) $out.=it_get_awards($awardsargs); 
							
							$out.='<div class="article-info">';
						
								$out.= it_get_category($minisite, true, false, false);
	
								$out.= it_title($title);
							
							$out.='</div>';
							
						$out.='</div>';
						
					$out.='</div>';
					
				$out.='</div>';
            
			break;
			case 'sizzlin': #SIZZLIN CAROUSEL				
			
				$out.='<li><a href="'.get_permalink().'">'.get_the_title().'</a></li>';
            
            break;
			case 'trending': #TRENDING WIDGET
			
				$viewsargs['icon'] = false;
				$likesargs['icon'] = false;
				$commentsargs['icon'] = false;
				
				$size = 'large';
				if($i>0) $size = 'medium';
				if($i>3) $size = 'small';
				if($i>5) $size = 'tiny';
            
            	$out.='<div class="trending-bar bar-' . $i . ' ' . $size . '">';	
				
					$out.='<div class="trending-color">';
							
						$out.='<div class="trending-meta">';
						
							if($metric=='liked') $out.=it_get_likes($likesargs);
							
							if($metric=='viewed') $out.=it_get_views($viewsargs);
							
							if($metric=='commented') $out.=it_get_comments($commentsargs);
						
						$out.='</div>';	
					
						$out.='<div class="trending-overlay">&nbsp;</div>';
						
						$out.='<div class="trending-hover">&nbsp;</div>';
						
					$out.='</div>';
					
					$out.='<div class="title">'.it_title('140').'</div>';
					
					$out.='<a class="trending-link" href="'.get_permalink().'">&nbsp;</a>';	
                    
                $out.='</div>';				
			
			break;
			case 'trending slider': #TRENDING SCROLLER	
			
				$viewsargs['icon'] = false;
				$likesargs['icon'] = false;
				$commentsargs['icon'] = false;	
			
                $out.='<div class="panel item';
				
				if($i==0) $out.=' first active';
				
				$out .='">';
            
                    $out.='<div class="bar-number">';
					
						if($metric=='liked') $out.=it_get_likes($likesargs);
							
						if($metric=='viewed') $out.=it_get_views($viewsargs);
						
						if($metric=='commented') $out.=it_get_comments($commentsargs);
					
					$out.='</div>';
                    
                    $out.='<a href="'.get_permalink().'" class="title">'.it_title('70').'</a>';
                    
                $out.='</div>';
            
			break;
			case 'widget': #WIDGET	
				
				$likesargs['clickable'] = true;
			
				$large = false;
				if($article_format=='first' || $article_format=='large') $large = true;
			
				if($i>0 && $article_format=='first') $large = false;
				
				if(!$large) {
					if($rating_small) {
						$rating = true;
					} else {
						$rating = false;
					}
				}
				
				$sizecss = 'large';
				if(!$large) {
					$sizecss = 'small';
					$ratingargs['small'] = 'small';
				}
            
            	$out.='<div class="list-item clearfix ' . $sizecss;
				if($i==0) $out.=' first';
				if($i==$posts_shown-1) $out.=' last';
				if(!$thumbnail) $out.=' full';
				$out.='">';
				
					if($large) {
						$size = 'widget-post';
						$width = 85;
						$height = 85;
					} else {
						$size = 'tiny';
						$width = 35;
						$height = 35;
					}
                    
                    if($thumbnail) {
                    
                        $out.='<div class="article-image">';
                
                            $out.='<a class="thumbnail darken" href="'.get_permalink().'">'.it_featured_image(get_the_ID(), $size, $width, $height, false, false, false).'</a>';  
                        
                        $out.='</div>';
                        
                    }
                    
                    $out.='<div class="article-excerpt clearfix hover-text">';
					
						if($award && $large) $out.=it_get_awards($awardsargs); 
                                         
                        $out.='<a class="title" href="'.get_permalink().'">'.get_the_title().'</a>';
						
						if(!empty($minisite) && $rating) $out.='<div class="clearfix">' . it_show_rating($ratingargs) . '</div>';
					
						if($large && $meta) { #show rating and meta for large formats
								
							$out.='<div class="article-meta clearfix">';
							
								$out.=it_get_likes($likesargs);
								
								$out.=it_get_views($viewsargs);
								
								$out.=it_get_comments($commentsargs);
							
							$out.='</div>';	
						}
						
					 $out.='</div>';
					
					$out .= '<a class="hover-link" href="'.get_permalink().'">&nbsp;</a>';
                    
                $out.='</div>';
				
				if(!empty($columns)) { #cols might be specified for some widget loops like the recommended area
					
					if($m % $columns==0) $out.='<br class="visible-desktop clearer" />';
					
					if($m % 2==0) $out.='<br class="hidden-desktop clearer two-panel" />'; #visible for tablets and down when sidebar is set to display
					
					if($m % 3==0) $out.='<br class="hidden-desktop clearer three-panel" />'; #visible for tablets and down when sidebar is hidden (full width)
					
				}
			
			break;			
			case 'new articles': #NEW ARTICLES		
            
            	$out.='<div class="list-item';
				if(empty($minisite)) $out.=' no-icon';
				$out.='">';
					
					$out.='<a href="'.get_permalink().'"';
					
					if($first) $out.=' class="first"';
					
					$out.='>'.get_the_title().'</a>';
					
					if(!empty($minisite) && $icon) $out.=it_get_category($minisite, true, false, false); 								
                    
                $out.='</div>';
				
				if($m % $percol==0) {
					$first = false;
					$out.='</div><div class="column">';
				}
			
			break;
			case 'top ten': #TOP TEN SCROLLER
			
				$number = $i+1;			
			
                $out.='<div class="panel item';
				
				if($i==0) $out.=' first active';
				
				$out .='">';
            
                    $out.='<div class="bar-number">' . $number . '</div>';
                    
                    $out.='<a href="'.get_permalink().'" class="title">'.it_title('70').'</a>';
                    
                $out.='</div>';
            
			break;			
			case 'directory': #MINISITE DIRECTORY	
			
				$ratingargs['small'] = 'small';		
            
            	$out.='<div class="listing ' . $minisite->id . '">';
					
					if(!empty($minisite) && $rating) $out.=it_show_rating($ratingargs);
					
					$out.='<a href="'.get_permalink().'">'.get_the_title() . it_featured_image(get_the_ID(), 'tiny', 35, 35, false, false, false) . '</a>';										
                    
                $out.='</div>';
			
			break;
			case 'directory compact': #MINISITE DIRECTORY COMPACT		
            
            	$out.='<div class="listing compact ' . $minisite->id . '">';
					
					$out.='<a href="'.get_permalink().'">'.get_the_title().'</a>';										
                    
                $out.='</div>';
			
			break;
			case 'menu': #POSTS LISTED WITHIN MEGA MENU	
            
            	$out.='<a href="'.get_permalink().'"';
				if(!$thumbnail) $out.=' class="no-thumbnail"';
				$out.='>' . get_the_title();
				if($thumbnail) $out.=it_featured_image(get_the_ID(), 'tiny', 35, 35, false, false, false);
				$out.='</a>';										
                
			break;
			case 'main loop': #MAIN LOOP
				$len_default = 520;
				if($view == 'list') $len_default = 800;
				$len = it_get_setting('loop_excerpt_length');									
				$len = empty($len) ? $len_default : $len;
				
				$postcss = '';
				if(is_sticky()) $postcss = ' sticky-post';
								
				$the_ad = it_get_ad($ads, $m, $a, $columns, $nonajax); #show ads in the loop
				$m = $the_ad['postcount']; #get updated post count
				$a = $the_ad['adcount']; #get updated ad count	
				
				$badgesargs = $awardsargs;
				$badgesargs['badge'] = true;
				$likesargs['clickable'] = true;
				
				$out .= $the_ad['ad'];	
				                        
                $out.='<div class="panel-wrapper clearfix' . $postcss . '">';
                	
                    $out.='<div class="panel">';
					
						$out.='<div class="panel-inner">';
					
							if(!it_get_setting('loop_meta_disable')) {
                        
								$out.='<div class="article-meta clearfix">';
								
									if(!it_get_setting('loop_likes_disable')) $out.=it_get_likes($likesargs);
									
									if(!it_get_setting('loop_views_disable')) $out.=it_get_views($viewsargs);
									
									if(!it_get_setting('loop_comments_disable')) $out.=it_get_comments($commentsargs);
								
								$out.='</div>';
								
							}
							
							if((has_post_thumbnail(get_the_ID()) || (!empty($video) && it_get_setting('loop_video'))) && $thumbnail) {
						
								$out.='<div class="article-image-wrapper">';                      
									
									$out.='<div class="article-image darken">';
									
										if(!empty($minisite) && $icon) $out.=it_get_category($minisite, true, true); #show the minisite icon
									
										if(!empty($minisite) && $rating && !it_get_setting('loop_rating_disable')) $out.=it_show_rating($ratingargs);
									
										if(!empty($video) && it_get_setting('loop_video')) {
											$out.=$video;
										} else {                        
											$out.='<a href="'.get_permalink().'">'.it_featured_image(get_the_ID(), 'grid-post', 349, 240, false, false, false).'</a>';
										}
									
									$out.='</div>';
							
								$out.='</div>';  
								
							}
							
							$out .= '<h2><a href="'.get_permalink().'">';
							if(is_sticky()) $out .= '<span class="icon-pin"></span>';
							$out .= get_the_title().'</a></h2>';							
							
							if(!it_get_setting('loop_authorship_disable')) $out.=it_get_authorship();
							
							if(!it_get_setting('loop_award_disable')) $out.=it_get_awards($awardsargs); 
							
							if(!it_get_setting('loop_badge_disable')) $out.=it_get_awards($badgesargs);
							
							if(!it_get_setting('loop_excerpt_disable')) {
								
								$out.='<div class="excerpt">';
							
									$out.='<div class="excerpt-text">' . it_excerpt($len) . '</div>';
								
								$out.='</div>';
							
							}
							
						$out.='</div>';
                        
                    $out.='</div>';
                     
                $out.='</div>';
                
                if($m % $columns==0) $out.='<br class="clearer" />';
            
            break;
			case 'all articles': #ALL ARTICLES
			
				$awardsargs['white'] = true;
				$likesargs['clickable'] = true;
				$postcss = '';
				$titlecss = '';
				if(is_sticky()) $postcss = ' sticky-post';
				                        
                $out.='<div class="panel-wrapper clearfix' . $postcss . '">';
                	
                    $out.='<div class="panel">';
					
						if($meta) {
                        
							$out.='<div class="article-meta clearfix">';
							
								if(!it_get_setting('loop_likes_disable')) $out.=it_get_likes($likesargs);
								
								if(!it_get_setting('loop_views_disable')) $out.=it_get_views($viewsargs);
								
								if(!it_get_setting('loop_comments_disable')) $out.=it_get_comments($commentsargs);
								
								if(!it_get_setting('loop_authorship_disable')) $out.=it_get_authorship();
							
							$out.='</div>';
							
						}
					
						$out.='<div class="panel-inner">';
					
							if($thumbnail) { 
							
								$out.='<div class="article-image-wrapper">';                        
								
									$out.='<div class="article-image darken">';
									
										if(!empty($minisite) && $icon) $out.=it_get_category($minisite, true, true); #show the minisite icon
										
										if($award) $out.=it_get_awards($awardsargs); 
									
										if(!empty($minisite) && $rating) $out.=it_show_rating($ratingargs);
									
										if(!empty($video)) {
											$out.=$video;
										} else {                        
											$out.='<a href="'.get_permalink().'">'.it_featured_image(get_the_ID(), 'grid-post', 349, 240, false, false, false).'</a>';
										}
									
									$out.='</div>';
								
								$out.='</div>'; 
								
							} else {
								
								$titlecss = ' class="no-image"';
								
							}
						
							$out .= '<h2' . $titlecss . '><a href="'.get_permalink().'">';
							if(is_sticky()) $out .= '<span class="icon-pin"></span>';
							$out .= get_the_title().'</a></h2>';
						
						$out.='</div>'; 
                        
                    $out.='</div>';
                     
                $out.='</div>';
            
            break;
		} 
		
		$i++; endwhile; 
		else:
			
			$out.='<div class="filter-error">'.__('Nothing to see here.', IT_TEXTDOMAIN).'</div>';
			$updatepagination=0;
		
		endif;
    
	$pages = $wp_query->max_num_pages;
	$posts = $posts_shown;
	
	return array('content' => $out, 'pages' => $pages, 'updatepagination' => $updatepagination, 'posts' => $posts);
	
} 
?>