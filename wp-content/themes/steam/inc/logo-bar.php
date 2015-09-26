<?php global $itMinisites;

#theme options
$logo_url=it_get_setting('logo_url');
$logo_url_hd=it_get_setting('logo_url_hd');
$logo_width=it_get_setting('logo_width');
$logo_height=it_get_setting('logo_height');
$link_url=home_url();
$dimensions = '';

#determine if we are on a minisite page
$minisite = it_get_minisite($post->ID);
if($minisite) {		
	#add post type to query args
	if($minisite->logo_url) $logo_url = $minisite->logo_url;	
	if($minisite->logo_url_hd) $logo_url_hd = $minisite->logo_url_hd;
	if($minisite->logo_width) $logo_width = $minisite->logo_width;
	if($minisite->logo_height) $logo_height = $minisite->logo_height;
	$link_url = $minisite->more_link;
}
if(!empty($logo_width)) $dimensions .= ' width="'.$logo_width.'"';
if(!empty($logo_height)) $dimensions .= ' height="'.$logo_height.'"';
?>

<?php if(!it_component_disabled('logobar', $post->ID, true)) { ?>

    <div class="container" id="logo-bar">
    
        <div class="row">
    
            <div class="span12">
            
                <div id="logo-inner">
                
                	<?php if(!it_component_disabled('logo', $post->ID, true)) { ?>
                
                        <div class="logo">
            
                            <?php if(it_get_setting('display_logo') && $logo_url!='') { ?>
                                <a href="<?php echo $link_url; ?>">
                                    <img id="site-logo" alt="<?php bloginfo('name'); ?>" src="<?php echo $logo_url; ?>"<?php echo $dimensions; ?> />   
                                    <img id="site-logo-hd" alt="<?php bloginfo('name'); ?>" src="<?php echo $logo_url_hd; ?>"<?php echo $dimensions; ?> />  
                                </a>
                            <?php } else { ?>     
                                <h1><a href="<?php echo $link_url; ?>/"><?php bloginfo('name'); ?></a></h1>
                            <?php } ?>
                            
                            <?php if(!it_get_setting('description_disable') && get_bloginfo('description')!=='') { ?>
                            
                                <div class="subtitle"><?php bloginfo('description'); ?></div>
                                
                            <?php } ?>
                            
                        </div>
                        
                    <?php } ?>
                    
                    <?php if(it_get_setting('ad_header')!='' && !it_component_disabled('ad_header', $post->ID)) { ?>
        
                        <div class="ad" id="ad-header">
                            
                            <?php echo it_get_setting('ad_header'); ?> 
                              
                        </div>
                    
                    <?php } ?> 
                    
                    <br class="clearer" /> 
                    
                </div>    
                
            </div> 
        
        </div>
        
    </div>
    
<?php } ?>

<?php wp_reset_query(); ?>