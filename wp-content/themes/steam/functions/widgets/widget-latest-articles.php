<?php
class it_latest_articles extends WP_Widget {
	function it_latest_articles() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'Latest Articles', 'description' => __( 'Displays latest articles from a specific minisite, all minisites, or all articles, and can be limited to a specific category and/or tag.',IT_TEXTDOMAIN) );
		/* Widget control settings. */
		$control_ops = array( 'width' => 250, 'height' => 350, 'id_base' => 'it_latest_articles' );
		/* Create the widget. */
		$this->WP_Widget( 'it_latest_articles', 'Latest Articles', $widget_ops, $control_ops );
	}	
	function widget( $args, $instance ) {
		
		global $itMinisites;		

		extract( $args );

		/* User-selected settings. */
		$title = apply_filters('widget_title', $instance['title'] );	
		$selected_minisite = $instance['minisite'];
		$selected_category = $instance['category'];
		$selected_tag = $instance['tag'];
		$numarticles = $instance['numarticles'];
		$thumbnail = $instance['thumbnail'];
		$rating = $instance['rating'];
		$rating_small = $instance['rating_small'];
		$more = $instance['more'];
		$meta = $instance['meta'];
		$award = $instance['award'];
		$article_format = $instance['format'];
		$overlays = $instance['overlays'];
		
		if($overlays) {
			$loop = 'overlays';
			$css = 'overlays';
		} else {
			$loop = 'widget';
			$css = 'list';
		}
		
		#selected category
		if($selected_category=='All Categories') $selected_category = '';
		
		#selected tag
		if($selected_tag=='All Tags') $selected_tag = '';
		
		#get post type variable                    
        if($selected_minisite=="All Minisites" || $selected_minisite=="Everything") {
			$more = false;
            $post_types = array(); 
            foreach($itMinisites->minisites as $minisite){
                if($minisite->enabled) {
                     array_push($post_types, $minisite->id);						             
                }
            }
        } else {
            $post_types = $selected_minisite;
			$minisite = $itMinisites->get_type_by_id($post_types);
			$morelink = $minisite->more_link;
        }
        #add in 'post' type for all articles
        if($selected_minisite=="Everything") {
            array_push($post_types, 'post');
        }
		    
        #Before widget (defined by themes)
        echo $before_widget;

        #Title of widget (before and after defined by themes)
        if ( $title ) { ?>                	
            <?php echo $before_title; ?>

                <h3><span class="icon-recent header-icon"></span><?php echo $title; ?></h3>
                
                <?php if($more) { ?>
            
                    <div class="widget-more hover-text">
                                            
                        <?php _e('See All', IT_TEXTDOMAIN); ?>
                        
                        <span class="icon-right"></span>
                    
                    </div>
                    
                    <a class="hover-link" href="<?php echo $morelink; ?>">&nbsp;</a>
                    
                <?php } ?>
                
            <?php echo $after_title; ?>
        <?php } 
        
        #HTML output
        
		echo '<div class="post-list ' . $css . ' clearfix">';			
        
			#setup the query            
			$args=array('suppress_filters' => true, 'posts_per_page' => $numarticles, 'order' => 'DESC', 'order_by' => 'date', 'post_type' => $post_types, 'cat' => $selected_category, 'tag_id' => $selected_tag);
			
			#setup loop format
			$format = array('loop' => $loop, 'thumbnail' => $thumbnail, 'rating' => $rating, 'rating_small' => $rating_small, 'award' => $award, 'meta' => $meta, 'article_format' => $article_format, 'width' => 349, 'height' => 240, 'size' => 'grid-post', 'title' => 180);
	
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
		$instance = $old_instance;

		/* Strip tags (if needed) and update the widget settings. */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['minisite'] = strip_tags( $new_instance['minisite'] );
		$instance['category'] = strip_tags( $new_instance['category'] );
		$instance['tag'] = strip_tags( $new_instance['tag'] );
		$instance['numarticles'] = strip_tags( $new_instance['numarticles'] );
		$instance['thumbnail'] = isset( $new_instance['thumbnail'] );
		$instance['rating'] = isset( $new_instance['rating'] );
		$instance['rating_small'] = isset( $new_instance['rating_small'] );
		$instance['award'] = isset( $new_instance['award'] );
		$instance['meta'] = isset( $new_instance['meta'] );
		$instance['more'] = isset( $new_instance['more'] );
		$instance['format'] = strip_tags( $new_instance['format'] );
		$instance['overlays'] = isset( $new_instance['overlays'] );

		return $instance;
	}
	function form( $instance ) {
		
		global $itMinisites;		

		/* Set up some default widget settings. */
		$defaults = array( 'title' => 'Latest Articles', 'minisite' => 'Everything', 'category' => 'All Categories', 'tag' => 'All Tags', 'numarticles' => 5, 'thumbnail' => true, 'rating' => true, 'rating_small' => false, 'award' => true, 'more' => true, 'meta' => true, 'overlays' => false, 'format' => 'first' );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:',IT_TEXTDOMAIN); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:160px" />
		</p>
		
		<p>
			<?php _e( 'Type:',IT_TEXTDOMAIN); ?>
			<select name="<?php echo $this->get_field_name( 'minisite' ); ?>">
				<option<?php if($instance['minisite']=='Everything') { ?> selected<?php } ?> value="Everything"><?php _e( 'Everything', IT_TEXTDOMAIN ); ?></option>
                <option<?php if($instance['minisite']=='All Minisites') { ?> selected<?php } ?> value="All Minisites"><?php _e( 'All Minisites', IT_TEXTDOMAIN ); ?></option>
				<?php 
				foreach($itMinisites->minisites as $minisite){
					if($minisite->enabled) { ?>
						<option<?php if($instance['minisite']==$minisite->id) { ?> selected<?php } ?> value="<?php echo $minisite->id ?>"><?php echo $minisite->name; ?></option>
				<?php
					}
				}?>
			</select>
		</p>
        
        <p>
			<?php _e( 'Category:',IT_TEXTDOMAIN); ?>
			<select name="<?php echo $this->get_field_name( 'category' ); ?>">
				<option<?php if($instance['category']=='All Categories') { ?> selected<?php } ?> value="All Categories"><?php _e( 'All Categories', IT_TEXTDOMAIN ); ?></option>
				<?php 
				$catargs = array('orderby' => 'name', 'order' => 'ASC', 'hide_empty' => 0);
				$categories = get_categories($catargs);
				foreach($categories as $category){ ?>
                	<option<?php if($instance['category']==$category->term_id) { ?> selected<?php } ?> value="<?php echo $category->term_id; ?>"><?php echo $category->name; ?></option>
				<?php } ?>
			</select>
		</p>
        
         <p>
			<?php _e( 'Tag:',IT_TEXTDOMAIN); ?>
			<select name="<?php echo $this->get_field_name( 'tag' ); ?>">
				<option<?php if($instance['tag']=='All Tags') { ?> selected<?php } ?> value="All Tags"><?php _e( 'All Tags', IT_TEXTDOMAIN ); ?></option>
				<?php 
				$tagargs = array('orderby' => 'name', 'order' => 'ASC', 'hide_empty' => 0);
				$tags = get_tags($tagargs);
				foreach($tags as $tag){ ?>
                	<option<?php if($instance['tag']==$tag->term_id) { ?> selected<?php } ?> value="<?php echo $tag->term_id; ?>"><?php echo $tag->name; ?></option>
				<?php } ?>
			</select>
		</p>
        
        <p>                
			<?php _e( 'Display',IT_TEXTDOMAIN); ?>
			<input id="<?php echo $this->get_field_id( 'numarticles' ); ?>" name="<?php echo $this->get_field_name( 'numarticles' ); ?>" value="<?php echo $instance['numarticles']; ?>" style="width:30px" />  
			<?php _e( 'articles',IT_TEXTDOMAIN); ?>
		</p>
        
        <p>
			<input class="checkbox" type="checkbox" <?php checked(isset( $instance['more']) ? $instance['more'] : 0  ); ?> id="<?php echo $this->get_field_id( 'more' ); ?>" name="<?php echo $this->get_field_name( 'more' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'more' ); ?>"><?php _e( 'Display "See All" link in header',IT_TEXTDOMAIN); ?></label>             
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