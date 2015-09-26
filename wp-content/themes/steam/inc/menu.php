<?php                         
global $post;
$postid = $post->ID;
$minisite = it_get_minisite($postid);		
$current_term_name = '';
$top_parent_name = '';	
$nav_label = it_get_setting('sub_menu_label');
$nav_label = ( !empty( $nav_label ) ) ? $nav_label : __('NAV', IT_TEXTDOMAIN);
?>

<div class="container">
    
    <div class="row">
            
        <div class="span12">
                    
            <div id="sub-menu" class="menu-container">  
            
				<?php                				
                #show taxonomy menu if this is a minisite page								
                if($minisite && $minisite->taxonomy_submenu){
                    /*
                    get list of all terms in the primary taxononmy for this review type
                    we do not want to hide empty just in case the user only selects children and does
                    not select the parent taxonomy when creating posts. If one of the taxonomies
                    is never actually assigned to any posts but rather only its children are assigned,
                    then, if we hid empty taxonomies, the parent taxonomy would never show in the menu
                    even though there are posts inside of it (assigned to its children)	
                    */	
                    $primary_taxonomy = $minisite->get_primary_taxonomy();										
                    $terms = get_terms($primary_taxonomy->slug, array('parent' => 0, 'hide_empty' => 0));							
                    if (is_tax()) {
                        #for taxonomy pages use get_term_by to find the current term name
                        $current_term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
                        $current_term_name = $current_term->name;                                    
                        #get top parent of the current taxonomy
                        #only if the current taxonomy matches the primary taxonomy
                        if($primary_taxonomy->id==get_query_var( 'taxonomy' )) {
                            $top_parent = get_term_top_most_parent($current_term->term_id, $primary_taxonomy->slug); 
                            $top_parent_name = $top_parent->name;
                        }
                    } elseif (is_single()) {
                        #for single pages use wp_get_object_terms to get all assigned terms for this page
                        #use the first one in case there are several assigned
                        $current_terms = wp_get_object_terms($postid,$primary_taxonomy->slug);
                        $current_term_name = $current_terms[0]->name;							
                    }                                
                    $count = count($terms);						
                    if ( $count > 0 ){ ?> 
                    
                        <div id="sub-menu-full">
                        
                        	<div class="bar-label-wrapper">
                    
                                <div class="bar-label">
                            
                                    <div class="label-text"><?php echo $nav_label; ?><span class="icon-right"></span></div>
                                    
                                </div>
                                
                                <div class="home-button"><a href="<?php echo home_url(); ?>/"><span class="icon-home"></span></a></div>
                                
                            </div>
                        
                            <ul>
                                
                                <?php foreach ( $terms as $term ) { 
                                    $term_name = $term->name;
                                    $term_slug = $term->slug;
                                    $term_link = get_term_link($term_slug, $primary_taxonomy->slug);
                                    $current_page_item=false;
                                    #is this the current top level term?
                                    if(is_single()) { #for single pages look at all assigned terms and highlight all of them											
                                        foreach ($current_terms as $current_term) {
                                            #echo "current_term_name=".$current_term->name;
                                            $top_parent = get_term_top_most_parent($current_term->term_id, $primary_taxonomy->slug); 
                                            $top_parent_name = $top_parent->name;
                                            if($term_name==$current_term->name || $term_name==$top_parent_name) {
                                                $current_page_item=true;
                                            }
                                        }
                                    } else { #for taxonomy pages there can be only one selected current term to highlight
                                        if($term_name==$current_term_name || $term_name==$top_parent_name) {
                                            $current_page_item=true;
                                        }
                                    }
                                    ?>
                                    <li <?php if($current_page_item) { ?>class="current_page_item"<?php } ?>>
                                        <a href="<?php echo $term_link; ?>"><?php echo $term_name; ?></a>
                                    </li>							
                                <?php } ?>
                            </ul> 
                            
                            <br class="clearer" />                              
                            
                        </div>
                        
                        <div id="sub-menu-compact">
                        
                        	<div class="bar-label-wrapper">
                    
                                <div class="bar-label">
                            
                                    <div class="label-text"><?php echo $nav_label; ?><span class="icon-right"></span></div>
                                    
                                </div>
                                
                                <div class="home-button"><a href="<?php echo home_url(); ?>/"><span class="icon-home"></span></a></div>
                                
                            </div>
            
                            <ul>
                        
                                <li>
                        
                                    <a id="sub-menu-selector">
                                    
                                        <span class="icon-list"></span>
                                
                                        <?php echo $nav_label; ?>
                                        
                                    </a> 
                                    
                                    <ul>
                                        <?php foreach ( $terms as $term ) { 
                                            $term_name = $term->name;
                                            $term_slug = $term->slug;
                                            $term_link = get_term_link($term_slug, $primary_taxonomy->slug);
                                            $current_page_item=false;
                                            #is this the current top level term?
                                            if(is_single()) { #for single pages look at all assigned terms and highlight all of them											
                                                foreach ($current_terms as $current_term) {
                                                    #echo "current_term_name=".$current_term->name;
                                                    $top_parent = get_term_top_most_parent($current_term->term_id, $primary_taxonomy->slug); 
                                                    $top_parent_name = $top_parent->name;
                                                    if($term_name==$current_term->name || $term_name==$top_parent_name) {
                                                        $current_page_item=true;
                                                    }
                                                }
                                            } else { #for taxonomy pages there can be only one selected current term to highlight
                                                if($term_name==$current_term_name || $term_name==$top_parent_name) {
                                                    $current_page_item=true;
                                                }
                                            }
                                            ?>
                                            <li <?php if($current_page_item) { ?>class="current_page_item"<?php } ?>>
                                                <a href="<?php echo $term_link; ?>"><?php echo $term_name; ?></a>
                                            </li>							
                                        <?php } ?>
                                    </ul>
                                    
                                </li>
                                
                            </ul>
                        
                        </div>
                        
                    <?php } else { ?>
                    
                        <div id="sub-menu-full"> 
                        
                        	<div class="bar-label-wrapper">
                    
                                <div class="bar-label">
                            
                                    <div class="label-text"><?php echo $nav_label; ?><span class="icon-right"></span></div>
                                    
                                </div>
                                
                                <div class="home-button"><a href="<?php echo home_url(); ?>/"><span class="icon-home"></span></a></div>
                                
                            </div>
                        
                            <ul>
                                <li><a href="#"><?php _e('No primary taxonomy items found.',IT_TEXTDOMAIN); ?></a></li>
                            </ul>  
                            
                            <br class="clearer" />                             
                        
                        </div>
                        
                        <div id="sub-menu-compact">&nbsp;</div>
                        
                    <?php }
					
                } else { ?>
                
                    <div id="sub-menu-full"> 
                    
                    	<div class="bar-label-wrapper">
                    
                            <div class="bar-label">
                        
                                <div class="label-text"><?php echo $nav_label; ?><span class="icon-right"></span></div>
                                
                            </div>
                            
                            <div class="home-button"><a href="<?php echo home_url(); ?>/"><span class="icon-home"></span></a></div>
                            
                        </div>
                    
                        <?php 
                        //title attribute gets in the way - remove it
                        $menu = wp_nav_menu( array( 'theme_location' => 'sub-menu', 'container' => false, 'fallback_cb' => false, 'echo' => false ) );
                        $menu = preg_replace('/title=\"(.*?)\"/','',$menu);
                        echo $menu;
                        ?>  
                        
                        <br class="clearer" />                            
                    
                    </div>
                        
                    <div id="sub-menu-compact">
                    
                    	<div class="bar-label-wrapper">
                    
                            <div class="bar-label">
                        
                                <div class="label-text"><?php echo $nav_label; ?><span class="icon-right"></span></div>
                                
                            </div>
                            
                            <div class="home-button"><a href="<?php echo home_url(); ?>/"><span class="icon-home"></span></a></div>
                            
                        </div>
                    
                        <ul>
                            
                            <li>
                    
                                <a id="sub-menu-selector">
                                
                                    <span class="icon-list"></span>
                            
                                    <?php echo $nav_label; ?>
                                    
                                </a> 
                                
                                <?php echo $menu; ?>  
                                        
                            </li>
                            
                        </ul>
            
                    </div>                   
                    
                <?php } ?>  
                
            </div>
            
        </div>
        
    </div>
    
</div>