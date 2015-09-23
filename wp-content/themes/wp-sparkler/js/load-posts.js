jQuery(document).ready(function($) {

	// The number of the next page to load (/page/x/).
	var pageNum = parseInt(pbd_alp.startPage) + 1;

	// The maximum number of pages the current query can return.
	var max = parseInt(pbd_alp.maxPages);

	// Google Adsense code.
	//var gaCode = pbd_alp.ga_code;

	// The link of the next page of posts.
	var nextLink = pbd_alp.nextLink;

	// Localization
	var showMore = ( typeof ct_blog_localization != 'undefined' || ct_blog_localization != null ) ? ct_blog_localization.show_more : "Show older posts";
		loadingPosts = ( typeof ct_blog_localization != 'undefined' || ct_blog_localization != null ) ? ct_blog_localization.loading_posts : "Loading posts...";

		//blog_type = ( typeof ct_blog_localization != 'undefined' || ct_blog_localization != null ) ? ct_blog_localization.blog_type : "";
	/**
	* Replace the traditional navigation with our own,
	* but only if there is at least one page of new posts to load.
	*/
	if(pageNum <= max) {
		// Insert the "More Posts" link.
		$('#blog-entry')
			.append('<div class="pbd-alp-placeholder-'+ pageNum +'"></div>')
			//.append('<div id="pbd-alp-load-posts"><a href="#">'+ showMore +'</a></div>');

/*		if ( blog_type == 'widget' ) {
			$('.ct-blog-widget')
				.append('<div id="pbd-alp-load-posts"><a href="#">'+ showMore +'</a></div>');
		} else {
*/			$('.ct-blog-widget')
				.append('<div id="pbd-alp-load-posts"><a href="#">'+ showMore +'</a></div>');
//		}

		// Remove the traditional navigation.
		$('.pagination').remove();
	}


	/**
	 * Load new posts when the link is clicked.
	 */
	$('#pbd-alp-load-posts a').click(function() {

		// Are there more posts to load?
		if(pageNum <= max) {

			// Show that we're working.
			$(this).text(loadingPosts);
			$('#pbd-alp-load-posts a').append('<i class="fa fa-spinner fa-spin"></i>');

			var $container = $('#blog-entry');
			$container.imagesLoaded(function(){

				$('.pbd-alp-placeholder-'+ pageNum).load(nextLink + ' .post',
					function() {

						jQuery(".post-like a").click(function(){
							heart = jQuery(this);

							post_id = heart.data("post_id");

							jQuery.ajax({
								type: "post",
								url: ajax_var.url,
								data: "action=post-like&nonce="+ajax_var.nonce+"&post_like=&post_id="+post_id,
								success: function(count){
									if(count != "already") {
										heart.addClass("voted");
										heart.siblings(".count").text(count);
									}
								}
							});

							return false;
						})

						noPosts = ( typeof ct_blog_localization != 'undefined' || ct_blog_localization != null ) ? ct_blog_localization.no_posts : "No more posts to show.";
						// Update page number and nextLink.

						// Display Google Ads
						//if ( gaCode != 0 ) $('.pbd-alp-placeholder-'+ pageNum).after( gaCode );

						$('.pbd-alp-placeholder-'+ pageNum + ' article').unwrap();

						pageNum++;
						nextLink = nextLink.replace(/\/page\/[0-9]*/, '/page/'+ pageNum);

						//$( ".fa-spinner" ).remove();

						// Add a new placeholder, for when user clicks again.
						$('#blog-entry')
							.append('<div class="pbd-alp-placeholder-'+ pageNum +'"></div>')

						// Update the button message.
						if(pageNum <= max) {
							$('#pbd-alp-load-posts a').text(showMore);
						} else {
							$('#pbd-alp-load-posts a').text(noPosts);
							//$('#pbd-alp-load-posts a').css('display','none');
							$('#pbd-alp-load-posts a').remove();
							$('#pbd-alp-load-posts').append('<div class="pbd-no-posts">'+noPosts+'</div>');
						}
					}
				);
			});
		} else {
			$('#pbd-alp-load-posts a').append('.');
		}

		return false;
	});
});