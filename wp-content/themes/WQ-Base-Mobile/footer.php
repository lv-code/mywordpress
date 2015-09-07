<?php if(ISMOBILE):?>
<div data-role="footer" class="footer"> 
	<div data-role="controlgroup" data-type="horizontal"  data-mini="true">
	<a href="#popupSearch" data-role="button"  data-rel="popup" data-icon="search" data-position-to="window" data-transition="pop"  data-mini="true">搜索</a>
	<div data-role="popup" id="popupSearch" data-theme="e" data-overlay-theme="a"  class="ui-corner-all">
		<div data-role="collapsible-set" data-theme="b" data-content-theme="c" data-collapsed-icon="arrow-r" data-expanded-icon="arrow-d" style="margin:0;  padding: 10px">
			<h3 class="margin_10">功能开发中...</h3>
			<button data-theme="a" onclick="javascript:history.go(-1)" data-rel="back" data-mini="true" data-icon="delete">关闭 Cancel</button>			
		</div>
	</div>
	<?php if(is_single()):?>
	<a href="#popupComment" data-rel="popup" data-role="button"  data-position-to="window" data-transition="pop" data-inline="true" data-icon="star">评论</a>	
	<div data-role="popup" id="popupComment" data-theme="e" data-overlay-theme="a"  class="ui-corner-all">
		<div data-role="collapsible-set" data-theme="b" data-content-theme="c" data-collapsed-icon="arrow-r" data-expanded-icon="arrow-d" style="margin:0; padding: 10px">
			<h3 class="margin_10">功能开发中...</h3>
			<button data-theme="a" onclick="javascript:history.go(-1)" data-rel="back" data-mini="true" data-icon="delete">关闭 Cancel</button>			
		</div>
	</div>
	<?php endif;?>			
	
	<?php 
	if(is_home()||is_category())
	{
		mobile_par_pagenavi($query_string);
	}		
	?>
	</div>	
	<h4 class="font_12 font_normal">Copyright &copy;2011-2012 <?php bloginfo('name');?></h4> 
</div> 
</div>
<?php wp_footer();?>
<?php echo $options['pbo_a5code'];?>
</body>
</html>
<?php else:?>
<div id="footer">
		<div class="mbox">
				<p>Copyright &copy;2011-2012 <?php bloginfo('name');?></p>
				<p>Powered by <a href="http://wordpress.org/" target="_blank">WordPress</a>. Theme by <a href="http://www.waaqi.com/" target="_blank">WaaQi.com</a>.
				<?php global $options; echo $options['pbo_trackcode'];?> 	
				</p>
				<a class="gotop" href="javascript:;">回到顶部</a>				
		</div>
</div>
<?php wp_footer();?>
<script src="<?php bloginfo('template_url');?>/script/jquery.lavalamp-1.3.4.js" type="text/javascript"></script>
<script src="<?php bloginfo('template_url');?>/script/theme_script.js" type="text/javascript"></script>
<?php if($options['pbo_a5show']):?>
<?php echo $options['pbo_a5code'];?>
<script>
function cf(){
    $("#f1").slideUp();
}
$(document).ready(function(){
    setTimeout("cf()",15000);
	$('.wumii-related-items-div').find('div').last().remove();
});    
    
</script>
<?php endif;?>
</body>
</html>
<?php endif;?>
