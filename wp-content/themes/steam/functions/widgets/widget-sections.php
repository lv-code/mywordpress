<?php
class it_sections extends WP_Widget {
	function it_sections() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'Sections', 'description' => __( 'Displays the latest articles from selected minisites in tabbed format using the minisite icons as the tab navigation.',IT_TEXTDOMAIN) );
		/* Widget control settings. */
		$control_ops = array( 'width' => 250, 'height' => 350, 'id_base' => 'it_sections' );
		/* Create the widget. */
		$this->WP_Widget( 'it_sections', 'Sections', $widget_ops, $control_ops );
	}	
	function widget( $args, $instance ) {
		
		global $itMinisites;		

		extract( $args );

		/* User-selected settings. */
		$title = apply_filters('widget_title', $instance['title'] );	
		$numarticles = $instance['numarticles'];
		$thumbnail = $instance['thumbnail'];
		$rating = $instance['rating'];
		$rating_small = $instance['rating_small'];
		$meta = $instance['meta'];
		$award = $instance['award'];
		$article_format = $instance['format'];
		$overlays = $instance['overlays'];
		
		#get post types
		$post_types = array();                
        foreach($itMinisites->minisites as $minisite){			
			if(array_key_exists($minisite->id, $instance)) {
				if($minisite->enabled && $instance[$minisite->id]) {
					$post_type = $minisite->id;
					break;					
				}	
			}
		}
		
		if($overlays) {
			$loop = 'overlays';
			$css = 'overlays';
		} else {
			$loop = 'widget';
			$css = 'list';
		}
		
		#setup the filterbar
		$filterargs = array('loop' => 'minisite tabs', 'location' => $loop, 'container' => 'sections', 'enabled' => $instance, 'numarticles' => $numarticles, 'thumbnail' => $thumbnail, 'rating' => $rating, 'rating_small' => $rating_small, 'meta' => $meta, 'award' => $award, 'article_format' => $article_format, 'width' => 349, 'height' => 240, 'size' => 'grid-post');
		
		#setup the query            
        $args=array('posts_per_page' => $numarticles, 'post_type' => $post_type);
		
		#setup loop format
		$format = array('loop' => 'minisite tabs', 'location' => $loop, 'thumbnail' => $thumbnail, 'rating' => $rating, 'rating_small' => $rating_small, 'award' => $award, 'meta' => $meta, 'article_format' => $article_format, 'width' => 349, 'height' => 240, 'size' => 'grid-post', 'title' => 180);
		
		$loop = it_loop($args, $format);
		    
        #Before widget (defined by themes)
        echo $before_widget;
		
		echo "<div class='sections-wrapper section-buttons'>";
		
		#Title of widget (before and after defined by themes)                	
		echo $before_title; ?>

            <?php if ( $title ) { ?><h3><span class="icon-grid header-icon"></span><?php echo $title; ?></h3><?php } ?>
            
            <?php echo it_get_minisite_filters($filterargs); ?>
            
        <?php echo $after_title;		

        #post list
		
		echo '<div class="loading"><div>&nbsp;</div></div>';	
		
		echo '<div class="post-list ' . $css . ' clearfix">';	
       
        #display the loop 
		echo $loop['content'];
		
		echo '</div>'; #end post-list div 
		
		echo '</div>'; #end sections div
		
		wp_reset_query();			
        
		# After widget (defined by themes)
        echo $after_widget; ?>		
		
	<?php
	}
	function update( $new_instance, $old_instance ) {
		
		global $itMinisites;
		
		$instance = $old_instance;
		
		foreach($itMinisites->minisites as $minisite){
            if($minisite->enabled) {
				$instance[$minisite->id] = isset( $new_instance[$minisite->id] );
			}			
		}
		$instance['title'] = strip_tags( $new_instance['title'] );		
		$instance['numarticles'] = strip_tags( $new_instance['numarticles'] );		
		$instance['thumbnail'] = isset( $new_instance['thumbnail'] );
		$instance['rating'] = isset( $new_instance['rating'] );
		$instance['rating_small'] = isset( $new_instance['rating_small'] );
		$instance['award'] = isset( $new_instance['award'] );
		$instance['meta'] = isset( $new_instance['meta'] );
		$instance['format'] = strip_tags( $new_instance['format'] );
		$instance['overlays'] = isset( $new_instance['overlays'] );	
		
		return $instance;
		
	}
	function form( $instance ) {
		
		global $itMinisites;	

		#set up some default widget settings.
		$defaults = array( 'title' => 'Sections', 'numarticles' => 4, 'thumbnail' => true, 'rating' => true, 'rating_small' => false, 'award' => true, 'more' => true, 'meta' => true, 'overlays' => false, 'format' => 'first' );
		#add minisite checkboxes to default array
		foreach($itMinisites->minisites as $minisite){
			if($minisite->enabled) {
				 $defaults[$minisite->id] = true;						             
			}
		}
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>	
        
        <p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:',IT_TEXTDOMAIN); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:160px" />
		</p>
		
		<p><?php _e( 'Display These Minisites:',IT_TEXTDOMAIN); ?></p>	
        
        <div style="margin-left:10px;">
			<?php 
            foreach($itMinisites->minisites as $minisite){
                if($minisite->enabled) { ?> 
                    <p>                   
                        <input class="checkbox" type="checkbox" <?php checked(isset( $instance[ $minisite->id ]) ? $instance[ $minisite->id ] : 0  ); ?> name="<?php echo $this->get_field_name( $minisite->id ); ?>" id="<?php echo $this->get_field_id( $minisite->id ); ?>" />
                        <label for="<?php echo $this->get_field_id( $minisite->id ); ?>"><?php echo $minisite->name; ?></label>
                    </p>
                <?php
                }
            }?>
        </div>			
	
		<p>                
			<?php _e( 'Display',IT_TEXTDOMAIN); ?>
			<input id="<?php echo $this->get_field_id( 'numarticles' ); ?>" name="<?php echo $this->get_field_name( 'numarticles' ); ?>" value="<?php echo $instance['numarticles']; ?>" style="width:30px" />  
			<?php _e( 'articles',IT_TEXTDOMAIN); ?>
		</p>
        
        <p>
			<input class="checkbox" type="checkbox" <?php checked(isset( $instance['thumbnail']) ? $instance['thumbnail'] : 0  ); ?> id="<?php echo $this->get_field_id( 'thumbnail' ); ?>" name="<?php echo $this->get_field_name( 'thumbnail' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'thumbnail' ); ?>"><?php _e( 'Display thumbnails',IT_TEXTDOMAIN); ?></label>             
		</p>
        
        <p>
			<input class="checkbox" type="checkbox" <?php checked(isset( $instance['overlays']) ? $instance['overlays'] : 0  ); ?> id="<?php echo $this->get_field_id( 'overlays' ); ?>" name="<?php echo $this->get_field_name( 'overlays' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'overlays' ); ?>"><?php _e( 'Use "overlay" post style',IT_TEXTDOMAIN); ?></label>             
		</p>
        
        <p><?php _e( 'Format:',IT_TEXTDOMAIN); ?></p>	
        
        <div style="margin-left:10px;">	
        
            <p>          
                <input class="radio" type="radio" <?php if($instance['format']=='small') { ?>checked <?php } ?>name="<?php echo $this->get_field_name( 'format' ); ?>" value="small" id="<?php echo $this->get_field_id( 'format' ); ?>_small" />                
                <label for="<?php echo $this->get_field_id( 'format' ); ?>_small"><?php _e( 'Small',IT_TEXTDOMAIN); ?></label><br />
                  
                <input class="radio" type="radio" <?php if($instance['format']=='large') { ?>checked <?php } ?>name="<?php echo $this->get_field_name( 'format' ); ?>" value="large" id="<?php echo $this->get_field_id( 'format' ); ?>_large" />
                <label for="<?php echo $this->get_field_id( 'format' ); ?>_large"><?php _e( 'Large',IT_TEXTDOMAIN); ?></label> <br /> 
                
                <input class="radio" type="radio" <?php if($instance['format']=='first') { ?>checked <?php } ?>name="<?php echo $this->get_field_name( 'format' ); ?>" value="first" id="<?php echo $this->get_field_id( 'format' ); ?>_first" />
                <label for="<?php echo $this->get_field_id( 'format' ); ?>_first"><?php _e( 'Large First Article',IT_TEXTDOMAIN); ?></label>             
            </p>
            
        </div>
        
        <p><?php _e( 'Large article components:',IT_TEXTDOMAIN); ?></p>	
        
        <p>
			<input class="checkbox" type="checkbox" <?php checked(isset( $instance['rating']) ? $instance['rating'] : 0  ); ?> id="<?php echo $this->get_field_id( 'rating' ); ?>" name="<?php echo $this->get_field_name( 'rating' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'rating' ); ?>"><?php _e( 'Display rating',IT_TEXTDOMAIN); ?></label>             
		</p>
        
        <div style="margin-left:10px;">	
            <p>
                <input class="checkbox" type="checkbox" <?php checked(isset( $instance['rating_small']) ? $instance['rating_small'] : 0  ); ?> id="<?php echo $this->get_field_id( 'rating_small' ); ?>" name="<?php echo $this->get_field_name( 'rating_small' ); ?>" />
                <label for="<?php echo $this->get_field_id( 'rating_small' ); ?>"><?php _e( 'on small posts',IT_TEXTDOMAIN); ?></label>             
            </p>
        </div>
        
        <p>
			<input class="checkbox" type="checkbox" <?php checked(isset( $instance['award']) ? $instance['award'] : 0  ); ?> id="<?php echo $this->get_field_id( 'award' ); ?>" name="<?php echo $this->get_field_name( 'award' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'award' ); ?>"><?php _e( 'Display award',IT_TEXTDOMAIN); ?></label>             
		</p>
	
		<p>
			<input class="checkbox" type="checkbox" <?php checked(isset( $instance['meta']) ? $instance['meta'] : 0  ); ?> id="<?php echo $this->get_field_id( 'meta' ); ?>" name="<?php echo $this->get_field_name( 'meta' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'meta' ); ?>"><?php _e( 'Display meta',IT_TEXTDOMAIN); ?></label>             
		</p>
		
		<?php
	}
}
?>