<?php global $itMinisites;
#logo setup
$logo_url=it_get_setting('logo_url');
$logo_url_hd=it_get_setting('logo_url_hd');
$logo_width=it_get_setting('logo_width');
$logo_height=it_get_setting('logo_height');
$sticky_logo_url=it_get_setting('sticky_logo_url');
$sticky_logo_url_hd=it_get_setting('sticky_logo_url_hd');
$sticky_logo_width=it_get_setting('sticky_logo_width');
$sticky_logo_height=it_get_setting('sticky_logo_height');
$dimensions = '';
#determine if we are on a minisite page
$minisite = it_get_minisite($post->ID);
if($minisite) {	
	if(!empty($minisite->logo_url)) $logo_url = $minisite->logo_url;
	if(!empty($minisite->logo_url_hd)) $logo_url_hd = $minisite->logo_url_hd;
	if(!empty($minisite->logo_width)) $logo_width = $minisite->logo_width;
	if(!empty($minisite->logo_height)) $logo_height = $minisite->logo_height;
	if(!empty($minisite->sticky_logo_url)) $sticky_logo_url = $minisite->sticky_logo_url;
	if(!empty($minisite->sticky_logo_url_hd)) $sticky_logo_url_hd = $minisite->sticky_logo_url_hd;
	if(!empty($minisite->sticky_logo_width)) $sticky_logo_width = $minisite->sticky_logo_width;
	if(!empty($minisite->sticky_logo_height)) $sticky_logo_height = $minisite->sticky_logo_height;
}
#use sticky logo instead of main logo
if(!empty($sticky_logo_url)) $logo_url = $sticky_logo_url;
if(!empty($sticky_logo_url_hd)) $logo_url_hd = $sticky_logo_url_hd;
if(!empty($sticky_logo_width)) $logo_width = $sticky_logo_width;
if(!empty($sticky_logo_height)) $logo_height = $sticky_logo_height;

#set dimension css
if(!empty($logo_width)) $dimensions .= ' width="'.$logo_width.'"';
if(!empty($logo_height)) $dimensions .= ' height="'.$logo_height.'"';

#new articles setup
$disable_new_articles = it_component_disabled('new_articles', $post->ID);
$timeperiod = it_get_setting('new_timeperiod');
if(empty($timeperiod)) $timeperiod = 'Today'; 
$prefix = it_get_setting('new_prefix');
if(!empty($prefix)) $prefix .= ' ';
$timeperiod_label = $prefix . it_timeperiod_label($timeperiod);
$number = it_get_setting('new_number');
if(empty($number)) $number = 16;
$label_override = it_get_setting('new_label_override');
if(!empty($label_override)) $timeperiod_label = $label_override;
#setup wp_query args
$args = array('posts_per_page' => $number);
#setup loop format
$format = array('loop' => 'new articles', 'thumbnail' => false, 'rating' => false, 'icon' => true);
#add time period to args
$day = date('j');
$week = date('W');
$month = date('n');
$year = date('Y');
switch($timeperiod) {
	case 'Today':
		$args['day'] = $day;
		$args['monthnum'] = $month;
		$args['year'] = $year;
		$timeperiod='';
	break;
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
#check if this is a minisite
$minisite = it_get_minisite($post->ID);
if(it_targeted('new', $minisite) && $minisite) $args['post_type'] = $minisite->id;	

#perform the loop function to retrieve post count
$loop = it_loop($args, $format, $timeperiod);
$post_count = $loop['posts'];
if($post_count == 0) $disable_new_articles = true;  

#search results hack
$forcepage = false;
if(is_search()) $forcepage = true;                         

?>

<?php wp_reset_query(); ?>

<?php if (!it_component_disabled('topmenu', $post->ID)) { ?>

	<div class="container-fluid no-padding">
   
        <div id="sticky-bar">
            
            <div class="row-fluid"> 
            
                <div class="span12"> 
                
                	<div class="container">
                    
                    	<?php if(!it_component_disabled('sticky_logo', $post->ID, $forcepage)) { ?>
                        
                        	<div class="logo">
        
								<?php if(it_get_setting('display_logo') && $logo_url!='') { ?>
                                    <a class="info-bottom" href="<?php echo home_url(); ?>/" title="<?php _e('Home',IT_TEXTDOMAIN); ?>">
                                        <img id="site-logo" alt="<?php bloginfo('name'); ?>" src="<?php echo $logo_url; ?>"<?php echo $dimensions; ?> />   
                                        <img id="site-logo-hd" alt="<?php bloginfo('name'); ?>" src="<?php echo $logo_url_hd; ?>"<?php echo $dimensions; ?> />  
                                    </a>
                                <?php } else { ?>     
                                    <h1><a class="info-bottom" href="<?php echo home_url(); ?>/" title="<?php _e('Home',IT_TEXTDOMAIN); ?>"><?php bloginfo('name'); ?></a></h1>
                                <?php } ?>
                                
                            </div>
                        
                        <?php } ?>
                        
                        <?php if(!it_component_disabled('sticky_menu', $post->ID)) { ?>
                
                            <div id="top-menu">         
                        
                                <ul>
                                
                                    <li>
                                
                                        <a id="top-menu-selector"><span class="icon-list"></span></a>
                                    
                                        <?php //title attribute gets in the way - remove it
                                        $menu = wp_nav_menu( array( 'theme_location' => 'top-menu', 'container' => false, 'fallback_cb' => 'fallback_pages', 'echo' => false ) );
                                        $menu = preg_replace('/title=\"(.*?)\"/','',$menu);
                                        echo $menu;
                                        ?>
                                        
                                    </li>
                                    
                                </ul>
                                
                            </div> 
                            
                        <?php } ?>
                        
                        <?php if(!$disable_new_articles) { ?>
            
                            <div id="new-articles">
                            
                                <div class="selector info-right" title="<?php echo $timeperiod_label; ?>">
                                
                                    <a><span class="number"><?php echo $post_count; ?></span></a>
                                    
                                    <span class="icon-down-bold"></span> 
                                    
                                </div>
                                
                                <div class="post-container">
                                        
                                    <div class="column">
                                    
                                        <?php echo $loop['content']; wp_reset_query(); ?>
                                    
                                    </div>
                                
                                </div>
                           
                            </div>
                            
                        <?php } ?>
                        
                        <div id="section-menu" class="menu-container">
                    
                            <div id="section-menu-full">
                                            
                                <?php 
                                switch(it_get_setting('section_menu_type')) {
                                case 'standard':
                                    echo '<div class="standard-menu">';
                                    $menu = wp_nav_menu( array( 'theme_location' => 'main-menu', 'container' => false, 'fallback_cb' => 'fallback_categories', 'echo' => false ) );
                                    //title attribute gets in the way - remove it
                                    $menu = preg_replace('/title=\"(.*?)\"/','',$menu);
                                    echo $menu;
                                    echo '</div>';
                                break;
                                case 'mega':
									$mega_menu = it_section_menu();
                                    echo $mega_menu;
                                break;
                                } 
                                ?>
                                
                            </div>
                            
                            <div id="section-menu-compact">
                            
                                <ul>
                            
                                    <li>
                            
                                        <a id="section-menu-selector">
                                        
                                            <span class="icon-grid"></span>
                                    
                                            <?php echo ( it_get_setting("section_menu_label")!="" ) ? it_get_setting("section_menu_label") : __("SECTIONS", IT_TEXTDOMAIN); ?>
                                            
                                            <span class="icon-down-bold selector"></span> 
                                            
                                        </a> 
                                        
                                        <?php 
                                        switch(it_get_setting('section_menu_type')) {
                                        case 'standard':
                                            echo '<div class="standard-menu">';
                                            $menu = wp_nav_menu( array( 'theme_location' => 'main-menu', 'container' => false, 'fallback_cb' => 'fallback_categories', 'echo' => false ) );
                                            //title attribute gets in the way - remove it
                                            $menu = preg_replace('/title=\"(.*?)\"/','',$menu);
                                            echo $menu;
                                            echo '</div>';
                                        break;
                                        case 'mega':
                                            echo $mega_menu;
                                        break;
                                        } 
                                        ?>
                                        
                                    </li>
                                    
                                </ul>
                                
                            </div>  
                            
                        </div>
                        
                        <?php if(!it_get_setting('random_disable')) { ?>
                            
                            <a id="random-article" href="<?php echo it_get_random_article(); ?>" class="info-bottom icon-random" title="<?php _e('Random Article',IT_TEXTDOMAIN); ?>"></a>
                        
                        <?php } ?>
                    
                        <div id="sticky-controls">
                        
                        	<?php if(!it_get_setting('search_disable')) { ?>
                        
                                <div id="menu-search-button">
                                
                                    <span class="icon-search info-bottom" title="<?php _e('Search',IT_TEXTDOMAIN); ?>"></span>
                                    
                                </div>
                            
                                <div id="menu-search" class="info-bottom" title="<?php _e('Type and hit Enter',IT_TEXTDOMAIN); ?>">
                                
                                    <form method="get" id="searchformtop" action="<?php echo home_url(); ?>/">                             
                                        <input type="text" placeholder="<?php _e( 'search', IT_TEXTDOMAIN ); ?>" name="s" id="s" />          
                                    </form>
                                    
                                </div>
                                
                            <?php } ?>
                                            
                            <a id="back-to-top" href="#top" class="info icon-up-open" title="<?php _e('Top',IT_TEXTDOMAIN); ?>" data-placement="bottom"></a>
                            
                            <?php if(!it_component_disabled('sticky_controls', $post->ID)) { ?>                  
                            
								<?php global $user_ID, $user_identity; get_currentuserinfo(); if (!$user_ID) { ?>
                                
                                    <div class="register-wrapper">
                                    
                                        <a id="sticky-register" class="info-bottom icon-register sticky-button" title="<?php _e('Register',IT_TEXTDOMAIN); ?>"></a>
                                    
                                        <div class="sticky-form" id="sticky-register-form">
                                    
                                            <div class="loading"><div>&nbsp;</div></div>
                                        
                                            <?php echo it_register_form(); ?>
                                        
                                        </div>
                                    
                                    </div>
                                    
                                    <div class="login-wrapper">
                                    
                                        <a id="sticky-login" class="info-bottom icon-login sticky-button" title="<?php _e('Login',IT_TEXTDOMAIN); ?>"></a>
                                        
                                        <div class="sticky-form" id="sticky-login-form">
                                    
                                            <div class="loading"><div>&nbsp;</div></div>
                                        
                                            <?php echo it_login_form(); ?>
                                        
                                        </div>
                                    
                                    </div>                               
                                
                                <?php } else { ?>
                                
                                    <a id="sticky-account" class="info icon-cog sticky-button" href="<?php echo admin_url( 'profile.php' ); ?>" title="<?php _e('Account',IT_TEXTDOMAIN); ?>" data-placement="bottom"></a>
                                    
                                    <a id="sticky-logout" class="info icon-logout sticky-button" href="<?php echo wp_logout_url( home_url() ); ?>" title="<?php _e('Logout',IT_TEXTDOMAIN); ?>" data-placement="bottom"></a>
                                
                                <?php } ?>
                                
                                <?php if(!empty($_GET)) $register = $_GET['register']; 
                                if(empty($register)) $register = 'false';
                                if($register == 'true') { ?>
                                
                                    <div class="sticky-form check-password info" title="<?php _e('click to dismiss',IT_TEXTDOMAIN); ?>" data-placement="bottom">
                                        
                                        <span class="icon-thumbs-up"></span>
                                
                                        <?php _e('Check your email for your password.',IT_TEXTDOMAIN); ?>
                                    
                                    </div>
                                
                                <?php } ?>
                                
                            <?php } ?>
                            
                        </div>
                        
                    </div>
                    
                </div>
                
            </div>
    
        </div>
        
    </div>
    
    <?php wp_reset_query(); ?>
    
    <div id="sticky-logo-mobile" class="container">
    
		<?php if(!it_component_disabled('sticky_logo', $post->ID)) { ?>
                            
            <div class="logo info-bottom" title="<?php _e('Home',IT_TEXTDOMAIN); ?>">
    
                <?php if(it_get_setting('display_logo') && $logo_url!='') { ?>
                    <a href="<?php echo home_url(); ?>/">
                        <img id="site-logo" alt="<?php bloginfo('name'); ?>" src="<?php echo $logo_url; ?>"<?php echo $dimensions; ?> />   
                        <img id="site-logo-hd" alt="<?php bloginfo('name'); ?>" src="<?php echo $logo_url_hd; ?>"<?php echo $dimensions; ?> />  
                    </a>
                <?php } else { ?>     
                    <h1><a href="<?php echo home_url(); ?>/"><?php bloginfo('name'); ?></a></h1>
                <?php } ?>
                
            </div>
        
        <?php } ?>
    
    </div>

<?php } wp_reset_query();?>