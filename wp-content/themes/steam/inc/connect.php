<?php global $itMinisites; 

#set variables from theme options
$label_top = it_get_setting('connect_label_top');
$label_bottom = it_get_setting('connect_label_bottom');
if(empty($label_top)) $label_top = __('HELLO!', IT_TEXTDOMAIN);
if(empty($label_bottom)) $label_bottom = __('CONNECT', IT_TEXTDOMAIN);

if(!it_component_disabled('connect', $post->ID)) { ?>

<?php do_action('it_before_connect'); ?>

<div class="container">
    
    <div class="row" id="connect">
    
        <div class="span12">
        
            <div class="bar-wrapper clearfix">
            
                <div class="bar-label">
                
                    <div class="label-text"><?php echo $label_top; ?></div>
                    
                    <div class="timeperiod-text"><?php echo $label_bottom; ?></div>
                    
                </div>
                
                <?php if(!it_get_setting('connect_email_disable')) { ?>
                        
                    <?php echo it_email_form(); ?>
                    
                <?php } ?>
                
                <?php if(!it_get_setting('connect_counts_disable')) { ?>
                
                    <div class="connect-counts">
                        
                        <?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('connect-widgets')) : else : ?>
                                                                
                            <?php _e('Connect Widgets', IT_TEXTDOMAIN); ?>
                        
                        <?php endif; ?>
                    
                    </div>
                    
                <?php } ?>
                
                <?php if(!it_get_setting('connect_social_disable')) { ?>
                
                    <div class="connect-social">
                        
                        <?php echo it_social_badges(); ?>
                    
                    </div>
                    
                <?php } ?>
                
            </div>
            
        </div>
    
    </div>
    
</div>

<?php do_action('it_after_connect'); ?>

<?php } ?>