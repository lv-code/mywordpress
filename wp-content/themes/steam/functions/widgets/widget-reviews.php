<?php
class it_reviews extends WP_Widget {
	function it_reviews() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'Reviews', 'description' => __( 'Displays latest reviews from selected minisites.',IT_TEXTDOMAIN) );
		/* Widget control settings. */
		$control_ops = array( 'width' => 250, 'height' => 350, 'id_base' => 'it_reviews' );
		/* Create the widget. */
		$this->WP_Widget( 'it_reviews', 'Reviews', $widget_ops, $control_ops );
	}	
	function widget( $args, $instance ) {
		
		global $itMinisites;		

		extract( $args );

		/* User-selected settings. */
		$title = apply_filters('widget_title', $instance['title'] );	
		$numarticles = $instance['numarticles'];
		
		#get post types
		$post_types = array();                
        foreach($itMinisites->minisites as $minisite){			
			if(array_key_exists($minisite->id, $instance)) {
				if($minisite->enabled && $instance[$minisite->id]) {
					array_push($post_types, $minisite->id);			
				}	
			}
		}
		
		    
        #Before widget (defined by themes)
        echo $before_widget;

        #Title of widget (before and after defined by themes)
        if ( $title ) { ?>                	
            <?php echo $before_title; ?>

                <h3><span class="icon-reviewed header-icon"></span><?php echo $title; ?></h3>
                
            <?php echo $after_title; ?>
        <?php } 
        
        #HTML output
        
		echo '<div class="post-list overlays clearfix">';			
        
        #setup the query            
        $args=array('posts_per_page' => $numarticles, 'order' => 'DESC', 'order_by' => 'date', 'post_type' => $post_types, 'meta_query' => array(array( 'key' => IT_META_DISABLE_REVIEW, 'value' => 'false', 'compare' => '=' )));
        
		#setup loop format
		$format = array('loop' => 'overlays', 'width' => 349, 'height' => 240, 'size' => 'grid-post', 'rating' => true, 'title' => 180);

        #display the loop
        $loop = it_loop($args, $format); 
		echo $loop['content'];
		
		echo '</div>';
		
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
		
		return $instance;
		
	}
	function form( $instance ) {
		
		global $itMinisites;	

		#set up some default widget settings.
		$defaults = array( 'title' => 'Latest Reviews', 'numarticles' => 4 );
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
		
		<p><?php _e( 'Included Minisites:',IT_TEXTDOMAIN); ?></p>	
        
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
		
		<?php
	}
}
?>