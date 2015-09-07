<div id="sidebar">
		<div id="hot-posts" class="cbx" style="margin-top:7px;">
				<h3 id="menu1" onclick="setTab(1,3)">Hot Posts 热门文章</h3>
				<div class="ctx" id="con_1">
						<ul>
								<?php if (function_exists('get_most_viewed')): ?>
								<?php get_most_viewed(); ?>
								<?php else: ?>
								<?php
								global $post;
								$args = array( 'numberposts' => 10, 'orderby'=> 'rand' );
								$myposts = get_posts( $args );
								foreach( $myposts as $post ) :	setup_postdata($post); ?>
								<li><a href="<?php the_permalink(); ?>">
										<?php the_title(); ?>
										</a></li>
								<?php endforeach; ?>
								<?php endif;?>
						</ul>
				</div>
				<h3 id="menu2" onclick="setTab(2,3)">Random Posts 随机文章</h3>
				<div class="ctx" id="con_2">
						<ul>
								<?php
								global $post;
								$args = array( 'numberposts' => 10, 'orderby'=> 'rand' );
								$myposts = get_posts( $args );
								foreach( $myposts as $post ) :	setup_postdata($post); ?>
								<li><a href="<?php the_permalink(); ?>">
										<?php the_title(); ?>
										</a></li>
								<?php endforeach; ?>
						</ul>
				</div>
				<?php if(is_home()):?>
				<h3 id="menu3" onclick="setTab(3,3)">Month Rank 本月排行</h3>
				<div class="ctx" id="con_3" >
						<ul>
								<?php the_most_views(30,10); ?>								
						</ul>
				</div>
				<?php else:?>
				<h3 id="menu3" onclick="setTab(3,3)">Recent Posts 最新文章</h3>
				<div class="ctx" id="con_3" >
						<ul>
								<?php
								global $post;
								$args = array( 'numberposts' => 10, 'orderby'=> 'post_date','order'=>'DESC' );
								$myposts = get_posts( $args );
								foreach( $myposts as $post ) :	setup_postdata($post); ?>
								<li><a href="<?php the_permalink(); ?>">
										<?php the_title(); ?>
										</a></li>
								<?php endforeach; ?>
						</ul>
				</div>
				<?php endif;?>
		</div>
		<?php global $options; if($options['pbo_a3show']):?>
		<div id="sidead"  class="cbx">
		    <?php echo $options['pbo_a3code'];?>		   	    
		</div>		
		<?php endif;?>
		<div id="categories-post" class="cbx list2">
				<h3>Categories 分类目录</h3>
				<div class="ctx">
						<ul>
								<?php wp_list_categories('&title_li='); ?>
								<div class="clear"></div>
						</ul>
				</div>
		</div>
<!--
		<div id="recent-comments" class="cbx">
				<h3>Recent Comments 最新评论</h3>
				<div class="ctx">
						<ul>
					<?php
/*
					$limit_num = '10'; //这里定义显示的评论数量
				///	$my_email = "'" . get_bloginfo ('admin_email') . "'";//这里是自动检测博主的邮件，实现博主的评论不显示
					$rc_comms = $wpdb->get_results("
					 SELECT ID, post_title, comment_ID, comment_author,comment_author_email, comment_content
					 FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts
					 ON ($wpdb->comments.comment_post_ID  = $wpdb->posts.ID)
					 WHERE comment_approved = '1'
					 AND comment_type = ''
					 AND post_password = ''
					 
					 ORDER BY comment_date_gmt
					 DESC LIMIT $limit_num
					 ");
					$rc_comments = '';
					foreach ($rc_comms as $rc_comm) { //get_avatar($rc_comm,$size='50')
					$rc_comments .= "<li><a href='"
					. get_permalink($rc_comm->ID) . "#comment-" . $rc_comm->comment_ID
					//. htmlspecialchars(get_comment_link(  $rc_comm->comment_ID, array('type' => 'comment'))) // 可取代上一行, 会显示评论分页ID, 但较耗资源
					. "' title='在 " . $rc_comm->post_title . " 发表的评论'><span class='comer'>".$rc_comm->comment_author." : </span>".strcut(strip_tags($rc_comm->comment_content),30)."</a></li>\n";
					}
					echo $rc_comments;
*/
					?>
						</ul>
				</div>				
		</div>
-->
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar') ) : ?>
				<?php endif; ?>
</div>
