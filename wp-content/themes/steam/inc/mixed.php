<?php #setup minisites
global $itMinisites;

#default settings
$col1 = __('Mixed Column 1',IT_TEXTDOMAIN);
$col2 = __('Mixed Column 2',IT_TEXTDOMAIN);
$col3 = __('Mixed Column 3',IT_TEXTDOMAIN);
$class = 'mixed-widgets';

#determine if we are on a minisite page
$minisite = it_get_minisite($post->ID);
if($minisite) {	
	#add post type to query args
	if(it_targeted('mixed', $minisite)) {
		$col1 = __('Mixed Column 1 ',IT_TEXTDOMAIN) . $minisite->name;
		$col2 = __('Mixed Column 2 ',IT_TEXTDOMAIN) . $minisite->name;
		$col3 = __('Mixed Column 3 ',IT_TEXTDOMAIN) . $minisite->name;
	}
}

?>

<?php do_action('it_before_mixed'); ?>
    
<div class="container">
    
    <div class="row" id="mixed">
    
        <div class="span12">
        
            <div class="mixed-column left">
            
                <?php it_widget_panel($col1, $class); ?>
                
            </div>
            
            <div class="mixed-column mid">
            
                <?php it_widget_panel($col2, $class); ?>
                
            </div>
            
            <div class="mixed-column right">
            
                <?php it_widget_panel($col3, $class); ?>
                
            </div>
        
        </div>
        
    </div>
    
</div>

<?php do_action('it_after_mixed'); ?>