<?php
class it_all_articles extends WP_Widget {
	function it_all_articles() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'All Articles', 'description' => __( 'Displays paginated articles with several available filtering options.',IT_TEXTDOMAIN) );
		/* Widget control settings. */
		$control_ops = array( 'width' => 250, 'height' => 350, 'id_base' => 'it_all_articles' );
		/* Create the widget. */
		$this->WP_Widget( 'it_all_articles', 'All Articles', $widget_ops, $control_ops );
	}	
	function widget( $args, $instance ) {
		
		global $itMinisites, $wp, $post, $wp_query;
		$numpages = $wp_query->max_num_pages;
		
		$current_query = $wp->query_vars;		

		extract( $args );

		/* User-selected settings. */
		$title = apply_filters('widget_title', $instance['title'] );	
		$disable_recent = $instance['disable_recent'];
		$disable_liked = $instance['disable_liked'];
		$disable_viewed = $instance['disable_viewed'];
		$disable_reviewed = $instance['disable_reviewed'];
		$disable_rated = $instance['disable_rated'];
		$disable_commented = $instance['disable_commented'];
		$disable_awarded = $instance['disable_awarded'];
		$disable_filters = $instance['disable_filters'];
		$display_title = $instance['display_title'];
		$numarticles = $instance['numarticles'];
		$thumbnail = $instance['thumbnail'];
		$rating = $instance['rating'];
		$icon = $instance['icon'];
		$award = $instance['award'];
		$meta = $instance['meta'];
		
		#create semantic variables		
		$disable_title = ( $display_title ) ? false : true;
		$disable_recent = ( $disable_recent ) ? 'recent' : '';
		$disable_liked = ( $disable_liked ) ? 'liked' : '';
		$disable_viewed = ( $disable_viewed ) ? 'viewed' : '';
		$disable_reviewed = ( $disable_reviewed ) ? 'reviewed' : '';
		$disable_rated = ( $disable_rated ) ? 'rated' : '';
		$disable_commented = ( $disable_commented ) ? 'commented' : '';
		$disable_awarded = ( $disable_awarded ) ? 'awarded' : '';
		
		#setup the query            
        $args=array('posts_per_page' => $numarticles);
		
		#setup loop format
		$format = array('loop' => 'main loop', 'location' => 'all articles', 'thumbnail' => $thumbnail, 'rating' => $rating, 'meta' => $meta, 'award' => $award, 'icon' => $icon, 'nonajax' => true, 'numarticles' => $numarticles, 'container' => 'all-articles', 'columns' => 1, 'view' => 'grid', 'sort' => 'recent');	
		
		#determine if we are on a minisite page
		$current_query = array();
		$minisite = it_get_minisite($post->ID);
		if($minisite) {		
			#add post type to query args			
			$args['post_type'] = $minisite->id;	
			#also add to current query for ajax purposes
			$current_query['post_type'] = $minisite->id;			
		}
		#encode current query for ajax purposes
		$current_query_encoded = json_encode($current_query);
		
		$disabled = array($disable_recent, $disable_liked, $disable_viewed, $disable_reviewed, $disable_rated, $disable_commented, $disable_awarded);
		
		$sortbarargs = array('title' => $title, 'loop' => 'main loop', 'location' => 'all articles', 'container' => 'all-articles', 'cols' => 1, 'class' => 'sortbar-hidden', 'disabled' => $disabled, 'numarticles' => $numarticles, 'disable_filters' => $disable_filters, 'disable_title' => $disable_title, 'prefix' => false, 'view' => 'grid', 'thumbnail' => $thumbnail, 'rating' => $rating, 'meta' => $meta, 'award' => $award);
		
		#fetch the loop
		$loop = it_loop($args, $format); 
		    
        #Before widget (defined by themes)
        echo $before_widget;
		
		echo "<div id='all-articles' class='articles' data-currentquery='" . $current_query_encoded . "'>";

			#display the sortbar
			if(!$disable_filters && !$disable_title) echo it_get_sortbar($sortbarargs);
			
			echo '<div class="loading"><div>&nbsp;</div></div>';	
			
			echo '<div class="loop grid">';
				
				echo $loop['content'];
				
			echo '</div>';
						
			echo '<div class="pagination-wrapper">';
			
				echo it_pagination($numpages, $format, it_get_setting('page_range'));
				
			echo '</div>';
			
			echo '<div class="pagination-wrapper mobile">';
			
				echo it_pagination($numpages, $format, it_get_setting('page_range_mobile'));
				
			echo '</div>';
			
		echo '</div>';
		
		wp_reset_query();			
        
		# After widget (defined by themes)
        echo $after_widget; ?>		
		
	<?php
	}
	function update( $new_instance, $old_instance ) {
		
		global $itMinisites;
		
		$instance = $old_instance;
		
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['disable_recent'] = isset( $new_instance['disable_recent'] );
		$instance['disable_liked'] = isset( $new_instance['disable_liked'] );
		$instance['disable_viewed'] = isset( $new_instance['disable_viewed'] );
		$instance['disable_reviewed'] = isset( $new_instance['disable_reviewed'] );
		$instance['disable_rated'] = isset( $new_instance['disable_rated'] );
		$instance['disable_commented'] = isset( $new_instance['disable_commented'] );
		$instance['disable_awarded'] = isset( $new_instance['disable_awarded'] );	
		$instance['disable_filters'] = isset( $new_instance['disable_filters'] );	
		$instance['display_title'] = isset( $new_instance['display_title'] );	
		$instance['numarticles'] = strip_tags( $new_instance['numarticles'] );		
		$instance['thumbnail'] = isset( $new_instance['thumbnail'] );
		$instance['rating'] = isset( $new_instance['rating'] );
		$instance['icon'] = isset( $new_instance['icon'] );	
		$instance['award'] = isset( $new_instance['award'] );	
		$instance['meta'] = isset( $new_instance['meta'] );		
		
		return $instance;
		
	}
	function form( $instance ) {
		
		global $itMinisites;	

		#set up some default widget settings.
		$defaults = array( 'title' => __('MOST RECENT', IT_TEXTDOMAIN), 'disable_recent' => false, 'disable_liked' => false, 'disable_viewed' => false, 'disable_reviewed' => false, 'disable_rated' => false, 'disable_commented' => false, 'disable_awarded' => false, 'display_title' => true, 'numarticles' => 4, 'thumbnail' => true, 'rating' => true, 'icon' => true );		
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>	
        
        <p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:',IT_TEXTDOMAIN); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:160px" />
		</p>
		
		<p><?php _e( 'Disable Filters:',IT_TEXTDOMAIN); ?></p>	
        
        <div style="margin-left:10px;">			
            <p>                   
                <input class="checkbox" type="checkbox" <?php checked(isset( $instance['disable_recent']) ? $instance['disable_recent'] : 0  ); ?> name="<?php echo $this->get_field_name('disable_recent'); ?>" id="<?php echo $this->get_field_id('disable_recent'); ?>" />
                <label for="<?php echo $this->get_field_id('disable_recent'); ?>"><?php _e('Recent',IT_TEXTDOMAIN); ?></label>
            </p>   
            <p>                   
                <input class="checkbox" type="checkbox" <?php checked(isset( $instance['disable_liked']) ? $instance['disable_liked'] : 0  ); ?> name="<?php echo $this->get_field_name('disable_liked'); ?>" id="<?php echo $this->get_field_id('disable_liked'); ?>" />
                <label for="<?php echo $this->get_field_id('disable_liked'); ?>"><?php _e('Liked',IT_TEXTDOMAIN); ?></label>
            </p> 
            <p>                   
                <input class="checkbox" type="checkbox" <?php checked(isset( $instance['disable_viewed']) ? $instance['disable_viewed'] : 0  ); ?> name="<?php echo $this->get_field_name('disable_viewed'); ?>" id="<?php echo $this->get_field_id('disable_viewed'); ?>" />
                <label for="<?php echo $this->get_field_id('disable_viewed'); ?>"><?php _e('Viewed',IT_TEXTDOMAIN); ?></label>
            </p> 
            <p>                   
                <input class="checkbox" type="checkbox" <?php checked(isset( $instance['disable_reviewed']) ? $instance['disable_reviewed'] : 0  ); ?> name="<?php echo $this->get_field_name('disable_reviewed'); ?>" id="<?php echo $this->get_field_id('disable_reviewed'); ?>" />
                <label for="<?php echo $this->get_field_id('disable_reviewed'); ?>"><?php _e('Reviewed',IT_TEXTDOMAIN); ?></label>
            </p> 
            <p>                   
                <input class="checkbox" type="checkbox" <?php checked(isset( $instance['disable_rated']) ? $instance['disable_rated'] : 0  ); ?> name="<?php echo $this->get_field_name('disable_rated'); ?>" id="<?php echo $this->get_field_id('disable_rated'); ?>" />
                <label for="<?php echo $this->get_field_id('disable_rated'); ?>"><?php _e('Rated',IT_TEXTDOMAIN); ?></label>
            </p> 
            <p>                   
                <input class="checkbox" type="checkbox" <?php checked(isset( $instance['disable_commented']) ? $instance['disable_commented'] : 0  ); ?> name="<?php echo $this->get_field_name('disable_commented'); ?>" id="<?php echo $this->get_field_id('disable_commented'); ?>" />
                <label for="<?php echo $this->get_field_id('disable_commented'); ?>"><?php _e('Commented',IT_TEXTDOMAIN); ?></label>
            </p> 
            <p>                   
                <input class="checkbox" type="checkbox" <?php checked(isset( $instance['disable_awarded']) ? $instance['disable_awarded'] : 0  ); ?> name="<?php echo $this->get_field_name('disable_awarded'); ?>" id="<?php echo $this->get_field_id('disable_awarded'); ?>" />
                <label for="<?php echo $this->get_field_id('disable_awarded'); ?>"><?php _e('Awarded',IT_TEXTDOMAIN); ?></label>
            </p>              
        </div>
        
        <p>
			<input class="checkbox" type="checkbox" <?php checked(isset( $instance['disable_filters']) ? $instance['disable_filters'] : 0  ); ?> id="<?php echo $this->get_field_id( 'disable_filters' ); ?>" name="<?php echo $this->get_field_name( 'disable_filters' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'disable_filters' ); ?>"><?php _e( 'Completely Disable Filtering',IT_TEXTDOMAIN); ?></label>             
		</p>			
	
		<p>                
			<?php _e( 'Display',IT_TEXTDOMAIN); ?>
			<input id="<?php echo $this->get_field_id( 'numarticles' ); ?>" name="<?php echo $this->get_field_name( 'numarticles' ); ?>" value="<?php echo $instance['numarticles']; ?>" style="width:30px" />  
			<?php _e( 'articles per page',IT_TEXTDOMAIN); ?>
		</p>
        
        <p>
			<input class="checkbox" type="checkbox" <?php checked(isset( $instance['display_title']) ? $instance['display_title'] : 0  ); ?> id="<?php echo $this->get_field_id( 'display_title' ); ?>" name="<?php echo $this->get_field_name( 'display_title' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'display_title' ); ?>"><?php _e( 'Display Title',IT_TEXTDOMAIN); ?></label>             
		</p>
        
        <p>
			<input class="checkbox" type="checkbox" <?php checked(isset( $instance['thumbnail']) ? $instance['thumbnail'] : 0  ); ?> id="<?php echo $this->get_field_id( 'thumbnail' ); ?>" name="<?php echo $this->get_field_name( 'thumbnail' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'thumbnail' ); ?>"><?php _e( 'Display Thumbnail',IT_TEXTDOMAIN); ?></label>             
		</p>
        
        <p>
			<input class="checkbox" type="checkbox" <?php checked(isset( $instance['rating']) ? $instance['rating'] : 0  ); ?> id="<?php echo $this->get_field_id( 'rating' ); ?>" name="<?php echo $this->get_field_name( 'rating' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'rating' ); ?>"><?php _e( 'Display Rating',IT_TEXTDOMAIN); ?></label>             
		</p>
        
        <p>
			<input class="checkbox" type="checkbox" <?php checked(isset( $instance['icon']) ? $instance['icon'] : 0  ); ?> id="<?php echo $this->get_field_id( 'icon' ); ?>" name="<?php echo $this->get_field_name( 'icon' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'icon' ); ?>"><?php _e( 'Display Minisite Icon',IT_TEXTDOMAIN); ?></label>             
		</p>
        
        <p>
			<input class="checkbox" type="checkbox" <?php checked(isset( $instance['award']) ? $instance['award'] : 0  ); ?> id="<?php echo $this->get_field_id( 'award' ); ?>" name="<?php echo $this->get_field_name( 'award' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'award' ); ?>"><?php _e( 'Display Award',IT_TEXTDOMAIN); ?></label>             
		</p>
        
        <p>
			<input class="checkbox" type="checkbox" <?php checked(isset( $instance['meta']) ? $instance['meta'] : 0  ); ?> id="<?php echo $this->get_field_id( 'meta' ); ?>" name="<?php echo $this->get_field_name( 'meta' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'meta' ); ?>"><?php _e( 'Display Meta',IT_TEXTDOMAIN); ?></label>             
		</p>
		
		<?php
	}
}
?>