<?php
class it_trending extends WP_Widget {
	function it_trending() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'Trending', 'description' => __( 'Displays sortable trending articles in bar graph style with metric counts.',IT_TEXTDOMAIN) );
		/* Widget control settings. */
		$control_ops = array( 'width' => 250, 'height' => 350, 'id_base' => 'it_trending' );
		/* Create the widget. */
		$this->WP_Widget( 'it_trending', 'Trending', $widget_ops, $control_ops );
	}	
	function widget( $args, $instance ) {
		
		global $itMinisites, $wp, $post;
		
		$current_query = $wp->query_vars;		

		extract( $args );

		/* User-selected settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$numarticles = $instance['numarticles'];
		$timeperiod = $instance['timeperiod'];
		$timeperiod_label = it_timeperiod_label($timeperiod);
		if(empty($timeperiod_label)) $timeperiod_label = 'This Month';	
		$trending_label = ( !empty( $trending_label ) ) ? $trending_label : __('TRENDING', IT_TEXTDOMAIN);
		$trending_label .= ' ' . $timeperiod_label;
		if(empty($title)) $title = $trending_label;
		
		#setup the query            
        $args=array('posts_per_page' => $numarticles, 'orderby' => 'meta_value_num', 'meta_key' => IT_META_TOTAL_VIEWS);
		
		#setup loop format
		$format = array('loop' => 'trending', 'nonajax' => true, 'numarticles' => $numarticles, 'metric' => 'viewed');	
		
		#determine if we are on a minisite page
		$current_query = array();
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
		
		$disabled = array('reviewed', 'rated', 'awarded', 'recent');
		
		$sortbarargs = array('title' => $title, 'icon' => 'trending', 'disable_arrow' => true, 'loop' => 'trending', 'disabled' => $disabled, 'numarticles' => $numarticles, 'prefix' => false, 'disable_title' => false, 'disable_filters' => false, 'view' => 'grid', 'cols' => 1, 'container' => '', 'location' => '', 'thumbnail' => false, 'rating' => false, 'meta' => false, 'timeperiod' => $timeperiod);
		
		$week = date('W');
		$month = date('n');
		$year = date('Y');
		switch($timeperiod) {
			case 'This Week':
				$args['year'] = $year;
				$args['w'] = $week;
				$timeperiod='';
			break;	
			case 'This Month':
				$args['monthnum'] = $month;
				$args['year'] = $year;
				$timeperiod='';
			break;
			case 'This Year':
				$args['year'] = $year;
				$timeperiod='';
			break;
			case 'all':
				$timeperiod='';
			break;			
		}
		
		#fetch the loop
		$loop = it_loop($args, $format, $timeperiod); 
		    
        #Before widget (defined by themes)
        echo $before_widget;
		
		echo "<div class='trending-wrapper' data-currentquery='" . $current_query_encoded . "'>";

			#display the sortbar
			echo it_get_sortbar($sortbarargs);
			
			echo '<div class="loading"><div>&nbsp;</div></div>';	
			
			echo '<div class="loop">';
				
				echo $loop['content'];
				
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
		$instance['numarticles'] = strip_tags( $new_instance['numarticles'] );
		$instance['timeperiod'] = strip_tags( $new_instance['timeperiod'] );	
		
		return $instance;
		
	}
	function form( $instance ) {
		
		global $itMinisites;	

		#set up some default widget settings.
		$defaults = array( 'title' => __('TRENDING', IT_TEXTDOMAIN), 'numarticles' => 8, 'timeperiod' => 'This Year' );		
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>	
        
        <p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:',IT_TEXTDOMAIN); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:160px" />
		</p>	
	
		<p>                
			<?php _e( 'Display',IT_TEXTDOMAIN); ?>
			<input id="<?php echo $this->get_field_id( 'numarticles' ); ?>" name="<?php echo $this->get_field_name( 'numarticles' ); ?>" value="<?php echo $instance['numarticles']; ?>" style="width:30px" />  
			<?php _e( 'articles',IT_TEXTDOMAIN); ?>
		</p>
        
         <p>
			<?php _e( 'Time Period:',IT_TEXTDOMAIN); ?>
			<select name="<?php echo $this->get_field_name( 'timeperiod' ); ?>">
                <option<?php if($instance['timeperiod']=='This Week') { ?> selected<?php } ?> value="This Week"><?php _e( 'This Week', IT_TEXTDOMAIN ); ?></option>
				<option<?php if($instance['timeperiod']=='This Month') { ?> selected<?php } ?> value="This Month"><?php _e( 'This Month', IT_TEXTDOMAIN ); ?></option>
                <option<?php if($instance['timeperiod']=='This Year') { ?> selected<?php } ?> value="This Year"><?php _e( 'This Year', IT_TEXTDOMAIN ); ?></option>
                <option<?php if($instance['timeperiod']=='-7 days') { ?> selected<?php } ?> value="-7 days"><?php _e( 'Within Past Week', IT_TEXTDOMAIN ); ?></option>
                <option<?php if($instance['timeperiod']=='-30 days') { ?> selected<?php } ?> value="-30 days"><?php _e( 'Within Past Month', IT_TEXTDOMAIN ); ?></option>
                <option<?php if($instance['timeperiod']=='-60 days') { ?> selected<?php } ?> value="-60 days"><?php _e( 'Within Past 2 Months', IT_TEXTDOMAIN ); ?></option>
                <option<?php if($instance['timeperiod']=='-90 days') { ?> selected<?php } ?> value="-90 days"><?php _e( 'Within Past 3 Months', IT_TEXTDOMAIN ); ?></option>
                <option<?php if($instance['timeperiod']=='-180 days') { ?> selected<?php } ?> value="-180 days"><?php _e( 'Within Past 6 Months', IT_TEXTDOMAIN ); ?></option>
                <option<?php if($instance['timeperiod']=='-365 days') { ?> selected<?php } ?> value="-365 days"><?php _e( 'Within Past Year', IT_TEXTDOMAIN ); ?></option>
                <option<?php if($instance['timeperiod']=='all') { ?> selected<?php } ?> value="all"><?php _e( 'All Time', IT_TEXTDOMAIN ); ?></option>
			</select>
		</p>
        
		<?php
	}
}
?>