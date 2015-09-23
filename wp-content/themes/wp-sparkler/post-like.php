<?php
$wp_scripts = new WP_Scripts();

$timebeforerevote = 744; // = 30 days

add_action('wp_ajax_nopriv_post-like', 'post_like');
add_action('wp_ajax_post-like', 'post_like');

function post_like()
{
	$nonce = $_POST['nonce'];

    if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) )
        die ( 'Busted!');

	if(isset($_POST['post_like']))
	{
		$ip = $_SERVER['REMOTE_ADDR'];
		$post_id = $_POST['post_id'];

		$meta_IP = get_post_meta($post_id, "voted_IP");

	if(isset($meta_IP[0]))
	{
		$voted_IP = $meta_IP[0];
		if(!is_array($voted_IP))
			$voted_IP = array();}

		$meta_count = get_post_meta($post_id, "votes_count", true);

		if(!hasAlreadyVoted($post_id))
		{
			$voted_IP[$ip] = time();

			update_post_meta($post_id, "voted_IP", $voted_IP);
			update_post_meta($post_id, "votes_count", ++$meta_count);

			echo esc_html( $meta_count );
		}
		else
			echo "already";
	}
	exit;
}

function hasAlreadyVoted($post_id)
{

	global $timebeforerevote;
	$time = '';

	$meta_IP = get_post_meta($post_id, "voted_IP");

	if ( !isset($meta_IP[0]) ) $meta_IP[0] = '0';

	if(isset($meta_IP[0]))
	{
		$voted_IP = $meta_IP[0];

	if(!is_array($voted_IP))
		$voted_IP = array();
	$ip = $_SERVER['REMOTE_ADDR'];

	if(in_array($ip, array_keys($voted_IP)))
	{
		if ( isset( $voted_IP[$ip] ) ) {
			$time = $voted_IP[$ip];
		}

		$now = time();

		if(round(($now - $time) / 3600 ) > $timebeforerevote)
			return false;

		return true;
	}}
	return false;
}

function getPostLikeLink($post_id)
{

	$vote_count = get_post_meta($post_id, "votes_count", true);
	if ( empty($vote_count)) $vote_count = 0;

	echo '<span class="post-like">'."\n";
	if(hasAlreadyVoted($post_id))
		echo '<span title="'.esc_html__('I like this article', 'color-theme-framework').'" class="ct-like fa fa-heart alreadyvoted"></span>'."\n";
	else
		echo '<a href="#" data-post_id="'.$post_id.'">' ."\n".'<span  title="'.esc_html__('I like this article', 'color-theme-framework').'" class="ct-like fa fa-heart-o"></span></a>'."\n";

		if ( $vote_count == 0 ) {
			echo '<span class="count">'.esc_html__( 'I like it','color-theme-framework'). ' ' . '</span><!-- .likes-count -->' ."\n".'</span><!-- .post-like -->'."\n";
		} else {
			if ( $vote_count == 1 ) {
				echo '<span class="count">'.$vote_count. ' ' . '<span class="likes-word">'.esc_html__( 'Like','color-theme-framework').'</span></span><!-- .likes-count -->' ."\n".'</span><!-- .post-like -->'."\n";
			} else {
				echo '<span class="count">'.$vote_count. ' ' . '<span class="likes-word">'.esc_html__( 'Likes','color-theme-framework').'</span></span><!-- .likes-count -->' ."\n".'</span><!-- .post-like -->'."\n";
			}
		}

}

function getLikeCount($post_id)
{
	$vote_count = get_post_meta($post_id, "votes_count", true);
	if ( empty($vote_count)) $vote_count = 0;

	if ( $vote_count != 0 ) :
		if ( $vote_count == 1 ) {
			echo  '<span class="like-count">'. $vote_count .'</span>'. esc_html( '&nbsp;Like', 'color-theme-framework' ) . "\n";
		} else {
			echo  '<span class="like-count">'. $vote_count .'</span>'. esc_html( '&nbsp;Likes', 'color-theme-framework' ) . "\n";
		}

	endif;
}

function getLikeCount_Widget($post_id)
{
	$vote_count = get_post_meta($post_id, "votes_count", true);
	if ( empty($vote_count)) $vote_count = 0;

	if ( $vote_count != 0 ) :
		if ( $vote_count == 1 ) {
			echo  '<span class="like-count"><i class="fa fa-heart"></i>'. $vote_count .'</span>'. "\n";
		} else {
			echo  '<span class="like-count"><i class="fa fa-heart"></i>'. $vote_count .'</span>'. "\n";
		}

	endif;
}