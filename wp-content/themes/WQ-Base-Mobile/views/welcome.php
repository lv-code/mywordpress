<?php if($options['pbo_isshowtop']):?>
<div id="t_box" class="cbx">
		<div id="welcome">
			<?php
			global $post;
			$args = array( 'numberposts' => $options['pbo_maxshow'], 'category' => $options['pbo_showtopid'], 'orderby'=> 'post_date','order'=>'DESC' );
			$myposts = get_posts( $args );
			foreach( $myposts as $post ) :	setup_postdata($post); ?>
			<li><a href="<?php the_permalink(); ?>">
					<?php the_title(); ?>
					</a></li>
			<?php endforeach; ?>
		</div>
		<script>
			var c, _ = Function;
			with( o = document.getElementById("welcome")) {
				innerHTML += innerHTML;
				onmouseover = _("c=1");
				onmouseout = _("c=0");
			}( F = _("if(#%27||!c)#++,#%=o.scrollHeight>>1;setTimeout(F,#%27?10:5000);".replace(/#/g, "o.scrollTop")))();
		</script>
		<div id="t_share"> <a href="<?php echo $options['pbo_rssaddress'];?>" target="_blank">订阅 RSS Feed</a> </div>
		<div class="clear"></div>
</div>
<?php endif;?>