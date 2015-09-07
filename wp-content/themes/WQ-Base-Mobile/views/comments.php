<li id="comment-<?php comment_ID() ?>" <?php comment_class('commenttips', $comment_id, $comment_post_ID);?> >
<div class="comment-body">
        <div class="commenttext">
                <div class="gravatar"> <a href="<?php comment_author_url(); ?>" target="_blank"> <?php echo get_avatar(get_comment_author_email(), '32');   ?></a> </div>
                <!-- comment-author -->
                <div class="comment-meta"> <span class="commentid">
                        <?php comment_author(); ?>                          
                        </span> <span class="commenttime">　(
                        <?php comment_date('Y.m.j') ?>
                        <?php comment_time('H:i');  ?>
                        ) </span> <span class="editpost">
                        <?php edit_comment_link(' [edit]'); ?>
                        </span> <span class="commentidnext"> : </span>
                        <?php if (is_page('Guestbook')):?>
                        <?php else: ?>
                        <span class="commentcount"><a href="#comment-<?php comment_ID() ?>">
                        <?php if (!$parent_id = $comment -> comment_parent) {
                        printf('#%1$s', ++$commentcount);} ?>
                        </a></span>
                        <?php endif;?>
                </div>
                <!--comment-meta-->
                <div class="commentp">
                        <?php if ($comment -> comment_approved == '0') : ?>
                        <em> <span class="moderation">
                        <?php _e('Your comment is awaiting moderation.') ?>
                        </span> </em> <br />
                        <?php endif;            ?>
                        <?php comment_text() ?>
                        <span class="reply">
                        <?php comment_reply_link(array_merge($args, array('reply_text' => 'Reply', 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
                        </span> </div>
        </div>
        <!-- commenttext -->
        <div class="clearline"></div>
</div>
<!-- [div-comment] -->