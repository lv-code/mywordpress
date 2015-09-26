<script type="text/javascript">
	jQuery.noConflict(); 
	
	"use strict";
	
	// AJAX SORTING BUTTONS
	
	// trending mixed widget
	jQuery('body').on('click', '#mixed .trending-wrapper .sort-buttons a', function(e){
		jQuery("#mixed .trending-wrapper .loading").show();
		jQuery("#mixed .trending-wrapper .loop").animate({opacity: "0.2"}, 0);
		jQuery("#mixed .trending-wrapper .loop, #mixed .trending-wrapper .sortbar-title, #mixed .trending-wrapper .sortbar span:first-child, #mixed .trending-wrapper .sortbar .sortbar-arrow").animate({opacity: "0.15"}, 0);	
		jQuery(this).addClass('active');
		jQuery(this).siblings().removeClass('active');
		
		var sorter = jQuery(this).data('sorter');
		var loop = jQuery(this).parent().data('loop');
		var numarticles = jQuery(this).parent().data('numarticles');
		var timeperiod = jQuery(this).parent().data('timeperiod');
		var currentquery = jQuery("#mixed .trending-wrapper").data('currentquery');
		var action = 'sort';
		
		jQuery.ajax({
			url: '<?php echo get_template_directory_uri(); ?>/functions/ajax.php',
			data: { sorter: sorter, loop: loop, action: action, numarticles: numarticles, currentquery: currentquery, timeperiod: timeperiod },
			type: 'POST',
			dataType: 'json',
			success: function (data) {			 
				jQuery("#mixed .trending-wrapper .loading").hide();
				jQuery("#mixed .trending-wrapper .loop, #mixed .trending-wrapper .sortbar-title, #mixed .trending-wrapper .sortbar span:first-child, #mixed .trending-wrapper .sortbar .sortbar-arrow").animate({opacity: "1"}, 500);
				jQuery("#mixed .trending-wrapper .loop").html(data.content);
				//jQuery("#mixed .trending-wrapper .sortbar span:first-child").removeClass().addClass("icon-" + sorter);
				jQuery('#ajax-error').hide();
				dynamicElements();
			},
			error: function (jxhr, msg, err) {
				jQuery("#mixed .trending-wrapper .loading").hide();
				jQuery("#mixed .trending-wrapper .loop").animate({opacity: "1"}, 500);	
				jQuery('#ajax-error').show();
				jQuery('#ajax-error').html(msg);
			}
		});
	});
	// trending sidebar widget
	jQuery('body').on('click', '#content-wrapper .trending-wrapper .sort-buttons a', function(e){
		jQuery("#content-wrapper .trending-wrapper .loading").show();
		jQuery("#content-wrapper .trending-wrapper .loop").animate({opacity: "0.2"}, 0);
		jQuery("#content-wrapper .trending-wrapper .loop, #content-wrapper .trending-wrapper .sortbar-title, #content-wrapper .trending-wrapper .sortbar span:first-child, #content-wrapper .trending-wrapper .sortbar .sortbar-arrow").animate({opacity: "0.15"}, 0);	
		jQuery(this).addClass('active');
		jQuery(this).siblings().removeClass('active');
		
		var sorter = jQuery(this).data('sorter');
		var loop = jQuery(this).parent().data('loop');
		var numarticles = jQuery(this).parent().data('numarticles');
		var timeperiod = jQuery(this).parent().data('timeperiod');
		var currentquery = jQuery("#content-wrapper .trending-wrapper").data('currentquery');
		var action = 'sort';
		
		jQuery.ajax({
			url: '<?php echo get_template_directory_uri(); ?>/functions/ajax.php',
			data: { sorter: sorter, loop: loop, action: action, numarticles: numarticles, currentquery: currentquery, timeperiod: timeperiod },
			type: 'POST',
			dataType: 'json',
			success: function (data) {			 
				jQuery("#content-wrapper .trending-wrapper .loading").hide();
				jQuery("#content-wrapper .trending-wrapper .loop, #content-wrapper .trending-wrapper .sortbar-title, #content-wrapper .trending-wrapper .sortbar span:first-child, #content-wrapper .trending-wrapper .sortbar .sortbar-arrow").animate({opacity: "1"}, 500);
				jQuery("#content-wrapper .trending-wrapper .loop").html(data.content);
				//jQuery("#content-wrapper .trending-wrapper .sortbar span:first-child").removeClass().addClass("icon-" + sorter);
				jQuery('#ajax-error').hide();
				dynamicElements();
			},
			error: function (jxhr, msg, err) {
				jQuery("#content-wrapper .trending-wrapper .loading").hide();
				jQuery("#content-wrapper .trending-wrapper .loop").animate({opacity: "1"}, 500);	
				jQuery('#ajax-error').show();
				jQuery('#ajax-error').html(msg);
			}
		});
	});
	// trending footer widget
	jQuery('body').on('click', '#footer .trending-wrapper .sort-buttons a', function(e){
		jQuery("#footer .trending-wrapper .loading").show();
		jQuery("#footer .trending-wrapper .loop").animate({opacity: "0.2"}, 0);
		jQuery("#footer .trending-wrapper .loop, #footer .trending-wrapper .sortbar-title, #footer .trending-wrapper .sortbar span:first-child, #footer .trending-wrapper .sortbar .sortbar-arrow").animate({opacity: "0.15"}, 0);	
		jQuery(this).addClass('active');
		jQuery(this).siblings().removeClass('active');
		
		var sorter = jQuery(this).data('sorter');
		var loop = jQuery(this).parent().data('loop');
		var numarticles = jQuery(this).parent().data('numarticles');
		var timeperiod = jQuery(this).parent().data('timeperiod');
		var currentquery = jQuery("#footer .trending-wrapper").data('currentquery');
		var action = 'sort';
		
		jQuery.ajax({
			url: '<?php echo get_template_directory_uri(); ?>/functions/ajax.php',
			data: { sorter: sorter, loop: loop, action: action, numarticles: numarticles, currentquery: currentquery, timeperiod: timeperiod },
			type: 'POST',
			dataType: 'json',
			success: function (data) {			 
				jQuery("#footer .trending-wrapper .loading").hide();
				jQuery("#footer .trending-wrapper .loop, #footer .trending-wrapper .sortbar-title, #footer .trending-wrapper .sortbar span:first-child, #footer .trending-wrapper .sortbar .sortbar-arrow").animate({opacity: "1"}, 500);
				jQuery("#footer .trending-wrapper .loop").html(data.content);
				//jQuery("#footer .trending-wrapper .sortbar span:first-child").removeClass().addClass("icon-" + sorter);
				jQuery('#ajax-error').hide();
				dynamicElements();
			},
			error: function (jxhr, msg, err) {
				jQuery("#footer .trending-wrapper .loading").hide();
				jQuery("#footer .trending-wrapper .loop").animate({opacity: "1"}, 500);	
				jQuery('#ajax-error').show();
				jQuery('#ajax-error').html(msg);
			}
		});
	});
	
	// bar sliders
	jQuery('body').on('click', '.bar-selector a.clickable', function(e){
		jQuery(this).closest(".bar-slider").find(".loading").show();
		jQuery(this).closest(".bar-slider").find(".slide").animate({opacity: "0"}, 0);			
		
		var sorter = jQuery(this).data('sorter');
		var label = jQuery(this).data('label');
		var loop = jQuery(this).parent().parent().data('loop');
		var location = jQuery(this).parent().parent().data('location');
		var timeperiod = jQuery(this).parent().parent().data('timeperiod');
		var currentquery = jQuery(this).closest(".bar-slider").data('currentquery');
		var action = 'sort';
		var _this = this;
		
		jQuery.ajax({
			url: '<?php echo get_template_directory_uri(); ?>/functions/ajax.php',
			data: { sorter: sorter, loop: loop, location: location, action: action, timeperiod: timeperiod, currentquery: currentquery },
			type: 'POST',
			dataType: 'json',
			success: function (data) {			 
				jQuery(_this).closest(".bar-slider").find(".loading").hide();		
				jQuery(_this).closest(".bar-selector").find(".bar-selected a").html(label);
				jQuery(_this).closest(".bar-selector").find(".bar-selected .selector-icon span").removeClass().addClass('icon-'+sorter);
				jQuery(_this).closest(".bar-selector").find('li').removeClass('over');
				jQuery(_this).closest(".bar-selector").find('ul li ul').hide();
				jQuery(_this).closest(".bar-slider").find(".slide").animate({opacity: "1"}, 500);
				jQuery(_this).closest(".bar-slider").find(".slide").html(data.content);
				//simply scroll plugin (standard carousel for IE8)		
				var isIE8 = jQuery.browser.msie && +jQuery.browser.version === 8;
				if ( isIE8 ) {
					jQuery(_this).closest(".bar-slider").find(".slide").carousel({
						interval: 3500
					});
				} else {			
					jQuery(_this).closest(".bar-slider").find(".slide").simplyScroll({
						customClass: 'the-bar',
						orientation: 'horizontal', 
						direction: 'forwards',
						pauseOnHover: true,
						frameRate: 48,
						speed: 1		
					});	
				}
				jQuery('#ajax-error').hide();
				dynamicElements();
			},
			error: function (jxhr, msg, err) {
				jQuery(_this).closest(".bar-slider").find(".loading").hide();
				jQuery(_this).closest(".bar-slider").find(".slide").animate({opacity: "1"}, 500);	
				jQuery('#ajax-error').show();
				jQuery('#ajax-error').html(msg);
			}
		});
	});
	// top ten mixed widget
	jQuery('body').on('click', '#mixed .topten-articles .sort-buttons a', function(e){
		jQuery("#mixed .topten-articles .loading").show();
		jQuery("#mixed .topten-articles .loop").animate({opacity: "0"}, 0);			
		
		var sorter = jQuery(this).data('sorter');
		var loop = jQuery(this).parent().data('loop');
		var timeperiod = jQuery(this).parent().data('timeperiod');
		var currentquery = jQuery("#mixed .topten-articles").data('currentquery');
		var action = 'sort';
		
		jQuery.ajax({
			url: '<?php echo get_template_directory_uri(); ?>/functions/ajax.php',
			data: { sorter: sorter, loop: loop, action: action, timeperiod: timeperiod, currentquery: currentquery },
			type: 'POST',
			dataType: 'json',
			success: function (data) {			 
				jQuery("#mixed .topten-articles .loading").hide();
				jQuery("#mixed .topten-articles .sortbar span:first-child").removeClass().addClass("icon-" + sorter);
				jQuery("#mixed .topten-articles .loop").animate({opacity: "1"}, 500);	
				jQuery("#mixed .topten-articles .loop").html(data.content);
				jQuery('#ajax-error').hide();
				dynamicElements();
			},
			error: function (jxhr, msg, err) {
				jQuery("#mixed .topten-articles .loading").hide();
				jQuery("#mixed .topten-articles .loop").animate({opacity: "1"}, 500);	
				jQuery('#ajax-error').show();
				jQuery('#ajax-error').html(msg);
			}
		});
	});
	// top ten sidebar widget
	jQuery('body').on('click', '#content-wrapper .topten-articles .sort-buttons a', function(e){
		jQuery("#content-wrapper .topten-articles .loading").show();
		jQuery("#content-wrapper .topten-articles .loop").animate({opacity: "0"}, 0);			
		
		var sorter = jQuery(this).data('sorter');
		var loop = jQuery(this).parent().data('loop');
		var timeperiod = jQuery(this).parent().data('timeperiod');
		var currentquery = jQuery("#content-wrapper .topten-articles").data('currentquery');
		var action = 'sort';
		
		jQuery.ajax({
			url: '<?php echo get_template_directory_uri(); ?>/functions/ajax.php',
			data: { sorter: sorter, loop: loop, action: action, timeperiod: timeperiod, currentquery: currentquery },
			type: 'POST',
			dataType: 'json',
			success: function (data) {			 
				jQuery("#content-wrapper .topten-articles .loading").hide();
				jQuery("#content-wrapper .topten-articles .sortbar span:first-child").removeClass().addClass("icon-" + sorter);
				jQuery("#content-wrapper .topten-articles .loop").animate({opacity: "1"}, 500);	
				jQuery("#content-wrapper .topten-articles .loop").html(data.content);
				jQuery('#ajax-error').hide();
				dynamicElements();
			},
			error: function (jxhr, msg, err) {
				jQuery("#content-wrapper .topten-articles .loading").hide();
				jQuery("#content-wrapper .topten-articles .loop").animate({opacity: "1"}, 500);	
				jQuery('#ajax-error').show();
				jQuery('#ajax-error').html(msg);
			}
		});
	});
	// top ten footer widget
	jQuery('body').on('click', '#footer .topten-articles .sort-buttons a', function(e){
		jQuery("#footer .topten-articles .loading").show();
		jQuery("#footer .topten-articles .loop").animate({opacity: "0"}, 0);			
		
		var sorter = jQuery(this).data('sorter');
		var loop = jQuery(this).parent().data('loop');
		var timeperiod = jQuery(this).parent().data('timeperiod');
		var currentquery = jQuery("#footer .topten-articles").data('currentquery');
		var action = 'sort';
		
		jQuery.ajax({
			url: '<?php echo get_template_directory_uri(); ?>/functions/ajax.php',
			data: { sorter: sorter, loop: loop, action: action, timeperiod: timeperiod, currentquery: currentquery },
			type: 'POST',
			dataType: 'json',
			success: function (data) {			 
				jQuery("#footer .topten-articles .loading").hide();
				jQuery("#footer .topten-articles .sortbar span:first-child").removeClass().addClass("icon-" + sorter);
				jQuery("#footer .topten-articles .loop").animate({opacity: "1"}, 500);	
				jQuery("#footer .topten-articles .loop").html(data.content);
				jQuery('#ajax-error').hide();
				dynamicElements();
			},
			error: function (jxhr, msg, err) {
				jQuery("#footer .topten-articles .loading").hide();
				jQuery("#footer .topten-articles .loop").animate({opacity: "1"}, 500);	
				jQuery('#ajax-error').show();
				jQuery('#ajax-error').html(msg);
			}
		});
	});
	
	// main loop sorting
	jQuery('body').on('click', '.sortbar .sort-buttons a', function(e){	
		jQuery(this).addClass('active');
		jQuery(this).siblings().removeClass('active');		
		
		var view = jQuery(this).parent().data('view');
		var loop = jQuery(this).parent().data('loop');
		var location = jQuery(this).parent().data('location');
		var container = jQuery(this).parent().data('container');
		var thumbnail = jQuery(this).parent().data('thumbnail');
		var rating = jQuery(this).parent().data('rating');
		var meta = jQuery(this).parent().data('meta');
		var sorter = jQuery(this).data('sorter');
		var columns = jQuery(this).parent().data('columns');
		var numarticles = jQuery(this).parent().data('numarticles');
		var paginated = jQuery(this).parent().data('paginated');
		var title = jQuery(this).data('original-title');
		var currentquery = jQuery("#" + container).data('currentquery');
		var action = 'sort';
		var _this = this;
		
		jQuery("#" + container + " .loading").show();
		jQuery("#" + container + " .loop, #" + container + " .sortbar-title, #" + container + " .sortbar span:first-child, #" + container + " .sortbar .sortbar-arrow").animate({opacity: "0.15"}, 0);	
				
		// update loop content
		jQuery.ajax({
			url: '<?php echo get_template_directory_uri(); ?>/functions/ajax.php',
			data: { sorter: sorter, loop: loop, location: location, action: action, view: view, columns: columns, numarticles: numarticles, paginated: paginated, currentquery: currentquery, container: container, thumbnail: thumbnail, rating: rating, meta: meta },
			type: 'POST',
			dataType: 'json',
			success: function (data) {			 
				jQuery("#" + container + " .loading").hide();
				jQuery("#" + container + " .loop, #" + container + " .sortbar-title, #" + container + " .sortbar span:first-child, #" + container + " .sortbar .sortbar-arrow").animate({opacity: "1"}, 500);
				jQuery("#" + container + " .loop").html(data.content);
				if(data.updatepagination==1) {
					jQuery("#" + container + " .pagination-wrapper").html(data.pagination);
					jQuery("#" + container + " .pagination-wrapper.mobile").html(data.paginationmobile);
				}
				jQuery("#" + container + " .sortbar-title").html(title);
				jQuery("#" + container + " .sortbar span:first-child").removeClass().addClass("icon-" + sorter);
				jQuery("#" + container + " .pagination").data("sorter", sorter);
				jQuery("#ajax-error").hide();
				dynamicElements();
			},
			error: function (jxhr, msg, err) {
				jQuery("#" + container + " .loading").hide();
				jQuery("#" + container + " .loop, #" + container + " .sortbar-title, #" + container + " .sortbar span:first-child, #" + container + " .sortbar .sortbar-arrow").animate({opacity: "1"}, 500);
				jQuery("#ajax-error").show();
				jQuery("#ajax-error").html(msg);
			}
		});
	});
	// main loop pagination
	jQuery('body').on('click', '.pagination a', function(e){
		jQuery(this).addClass('active');
		jQuery(this).siblings().removeClass('active');
		
		jQuery('html, body').animate({
			scrollTop: jQuery(this).parent().parent().parent().offset().top - 60
		}, 300);
		
		var view = jQuery(this).parent().data('view');
		var loop = jQuery(this).parent().data('loop');
		var location = jQuery(this).parent().data('location');
		var container = jQuery(this).parent().data('container');
		var sorter = jQuery(this).parent().data('sorter');
		var columns = jQuery(this).parent().data('columns');
		var thumbnail = jQuery(this).parent().data('thumbnail');
		var rating = jQuery(this).parent().data('rating');
		var meta = jQuery(this).parent().data('meta');
		var numarticles = jQuery(this).parent().data('numarticles');
		var paginated = jQuery(this).data('paginated');
		var currentquery = jQuery("#" + container).data('currentquery');
		var action = 'sort';
		var _this = this;
		
		jQuery("#" + container + " .loading").show();
		jQuery("#" + container + " .loop").animate({opacity: "0.15"}, 0);	
		
		jQuery.ajax({
			url: '<?php echo get_template_directory_uri(); ?>/functions/ajax.php',
			data: { sorter: sorter, location: location, loop: loop, action: action, view: view, columns: columns, numarticles: numarticles, paginated: paginated, currentquery: currentquery, container: container, thumbnail: thumbnail, rating: rating, meta: meta },
			type: 'POST',
			dataType: 'json',
			success: function (data) {			 
				jQuery("#" + container + " .loading").hide();
				jQuery("#" + container + " .loop").animate({opacity: "1"}, 500);
				jQuery("#" + container + " .loop").html(data.content);
				if(data.updatepagination==1) {
					jQuery("#" + container + " .pagination-wrapper").html(data.pagination);
					jQuery("#" + container + " .pagination-wrapper.mobile").html(data.paginationmobile);
				}
				jQuery('#' + container + ' .sortbar .sort-buttons').data('paginated', paginated);
				jQuery('#ajax-error').hide();
				dynamicElements();
			},
			error: function (jxhr, msg, err) {
				jQuery("#" + container + " .loading").hide();
				jQuery("#" + container + " .loop").animate({opacity: "1"}, 500);
				jQuery("#ajax-error").show();
				jQuery("#ajax-error").html(msg);
			}
		});
	});
	// sections mixed filtering
	jQuery('body').on('click', '#mixed .sections-wrapper .sort-buttons a', function(e){
		jQuery("#mixed .sections-wrapper .loading").show();
		jQuery("#mixed .sections-wrapper .post-list").animate({opacity: "0.15"}, 0);
		jQuery(this).siblings().children('.minisite-icon').removeClass('white');
		jQuery(this).children('.minisite-icon').addClass('white');	
		jQuery(this).addClass('active');
		jQuery(this).siblings().removeClass('active');
		
		var loop = jQuery(this).parent().data('loop');
		var location = jQuery(this).parent().data('location');
		var thumbnail = jQuery(this).parent().data('thumbnail');
		var rating = jQuery(this).parent().data('rating');
		var ratingsmall = jQuery(this).parent().data('rating-small');
		var numarticles = jQuery(this).parent().data('numarticles');
		var meta = jQuery(this).parent().data('meta');
		var award = jQuery(this).parent().data('award');
		var articleformat = jQuery(this).parent().data('article-format');
		var width = jQuery(this).parent().data('width');
		var height = jQuery(this).parent().data('height');
		var size = jQuery(this).parent().data('size');
		var sorter = jQuery(this).data('sorter');
		var action = 'sort';
		
		// update loop content
		jQuery.ajax({
			url: '<?php echo get_template_directory_uri(); ?>/functions/ajax.php',
			data: { sorter: sorter, loop: loop, location: location, action: action, thumbnail: thumbnail, rating: rating, ratingsmall: ratingsmall, numarticles: numarticles, meta: meta, award: award, articleformat: articleformat, width: width, height: height, size: size },
			type: 'POST',
			dataType: 'json',
			success: function (data) {			 
				jQuery("#mixed .sections-wrapper .loading").hide();
				jQuery("#mixed .sections-wrapper .post-list").animate({opacity: "1"}, 500);
				jQuery("#mixed .sections-wrapper .post-list").html(data.content);
				jQuery('#ajax-error').hide();
				dynamicElements();
			},
			error: function (jxhr, msg, err) {
				jQuery("#mixed .sections-wrapper .loading").hide();
				jQuery("#mixed .sections-wrapper .post-list").animate({opacity: "1"}, 500);
				jQuery('#ajax-error').show();
				jQuery('#ajax-error').html(msg);
			}
		});
	});
	// sections sidebar filtering
	jQuery('body').on('click', '#content-wrapper .sections-wrapper .sort-buttons a', function(e){
		jQuery("#content-wrapper .sections-wrapper .loading").show();
		jQuery("#content-wrapper .sections-wrapper .post-list").animate({opacity: "0.15"}, 0);
		jQuery(this).siblings().children('.minisite-icon').removeClass('white');
		jQuery(this).children('.minisite-icon').addClass('white');	
		jQuery(this).addClass('active');
		jQuery(this).siblings().removeClass('active');
		
		var loop = jQuery(this).parent().data('loop');
		var location = jQuery(this).parent().data('location');
		var thumbnail = jQuery(this).parent().data('thumbnail');
		var rating = jQuery(this).parent().data('rating');
		var ratingsmall = jQuery(this).parent().data('rating-small');
		var numarticles = jQuery(this).parent().data('numarticles');
		var meta = jQuery(this).parent().data('meta');
		var award = jQuery(this).parent().data('award');
		var articleformat = jQuery(this).parent().data('article-format');
		var width = jQuery(this).parent().data('width');
		var height = jQuery(this).parent().data('height');
		var size = jQuery(this).parent().data('size');
		var sorter = jQuery(this).data('sorter');
		var action = 'sort';
		
		// update loop content
		jQuery.ajax({
			url: '<?php echo get_template_directory_uri(); ?>/functions/ajax.php',
			data: { sorter: sorter, loop: loop, location: location, action: action, thumbnail: thumbnail, rating: rating, ratingsmall: ratingsmall, numarticles: numarticles, meta: meta, award: award, articleformat: articleformat, width: width, height: height, size: size },
			type: 'POST',
			dataType: 'json',
			success: function (data) {			 
				jQuery("#content-wrapper .sections-wrapper .loading").hide();
				jQuery("#content-wrapper .sections-wrapper .post-list").animate({opacity: "1"}, 500);
				jQuery("#content-wrapper .sections-wrapper .post-list").html(data.content);
				jQuery('#ajax-error').hide();
				dynamicElements();
			},
			error: function (jxhr, msg, err) {
				jQuery("#content-wrapper .sections-wrapper .loading").hide();
				jQuery("#content-wrapper .sections-wrapper .post-list").animate({opacity: "1"}, 500);
				jQuery('#ajax-error').show();
				jQuery('#ajax-error').html(msg);
			}
		});
	});
	// sections footer filtering
	jQuery('body').on('click', '#footer .sections-wrapper .sort-buttons a', function(e){
		jQuery("#footer .sections-wrapper .loading").show();
		jQuery("#footer .sections-wrapper .post-list").animate({opacity: "0.15"}, 0);
		jQuery(this).siblings().children('.minisite-icon').removeClass('white');
		jQuery(this).children('.minisite-icon').addClass('white');	
		jQuery(this).addClass('active');
		jQuery(this).siblings().removeClass('active');
		
		var loop = jQuery(this).parent().data('loop');
		var location = jQuery(this).parent().data('location');
		var thumbnail = jQuery(this).parent().data('thumbnail');
		var rating = jQuery(this).parent().data('rating');
		var ratingsmall = jQuery(this).parent().data('rating-small');
		var numarticles = jQuery(this).parent().data('numarticles');
		var meta = jQuery(this).parent().data('meta');
		var award = jQuery(this).parent().data('award');
		var articleformat = jQuery(this).parent().data('article-format');
		var width = jQuery(this).parent().data('width');
		var height = jQuery(this).parent().data('height');
		var size = jQuery(this).parent().data('size');
		var sorter = jQuery(this).data('sorter');
		var action = 'sort';
		
		// update loop content
		jQuery.ajax({
			url: '<?php echo get_template_directory_uri(); ?>/functions/ajax.php',
			data: { sorter: sorter, loop: loop, location: location, action: action, thumbnail: thumbnail, rating: rating, ratingsmall: ratingsmall, numarticles: numarticles, meta: meta, award: award, articleformat: articleformat, width: width, height: height, size: size },
			type: 'POST',
			dataType: 'json',
			success: function (data) {			 
				jQuery("#footer .sections-wrapper .loading").hide();
				jQuery("#footer .sections-wrapper .post-list").animate({opacity: "1"}, 500);
				jQuery("#footer .sections-wrapper .post-list").html(data.content);
				jQuery('#ajax-error').hide();
				dynamicElements();
			},
			error: function (jxhr, msg, err) {
				jQuery("#footer .sections-wrapper .loading").hide();
				jQuery("#footer .sections-wrapper .post-list").animate({opacity: "1"}, 500);
				jQuery('#ajax-error').show();
				jQuery('#ajax-error').html(msg);
			}
		});
	});
	
	// like button
	jQuery('body').on('click', 'a.do-like', function(e){
		 jQuery(this).removeClass('do-like');
		 var postID = jQuery(this).data('postid');
		 var likeaction = jQuery(this).data('likeaction');
		 var location = jQuery("#content").data('location');
		 var action = 'like';
		 var _this = this;
		 jQuery.ajax({
			 url: '<?php echo get_template_directory_uri(); ?>/functions/ajax.php',
			 data: { id: postID, action: action, likeaction: likeaction, location: location },
			 type: 'POST',
			 dataType: 'json',
			 success: function (data) {
				 jQuery(_this).addClass('do-like');
				 jQuery('a.like-button.' + postID + ' .numcount').html(data.content);
				 if(likeaction=='like') {
					 jQuery('a.like-button.' + postID + ' .icon').removeClass('like').addClass('unlike');
					 jQuery('a.like-button.' + postID).data('likeaction', 'unlike');
				 } else {
					 jQuery('a.like-button.' + postID + ' .icon').removeClass('unlike').addClass('like');
					 jQuery('a.like-button.' + postID).data('likeaction', 'like');
				 }
				 jQuery('#ajax-error').hide();
			 },
			 error: function (jxhr, msg, err) {
				 jQuery(_this).addClass('do-like');
				 jQuery('#ajax-error').show();
				 jQuery('#ajax-error').html(msg);
			 }
		 });
	 });
	// user rating panel display
	jQuery('body').on('mouseover', '.user-rating .rating-wrapper.single', function(e) {				
		jQuery(this).children('.rating-bar').addClass('over');	
		jQuery(this).children('.rating-bar').children('.rating-meter').hide();	
		jQuery(this).children().children('.form-selector').show();		
	});
	jQuery('body').on('mouseleave', '.user-rating .rating-wrapper', function(e) {				
		jQuery(this).children('.rating-bar').removeClass('over');	
		jQuery(this).children().children('.form-selector').hide();
		jQuery(this).children('.rating-bar').children('.rating-meter').show();			
	});	
	// update user ratings
	jQuery( ".user-rating .form-selector" ).on( "slidestop", function( event, ui ) {
		var meta = jQuery(this).parent().data('meta');
		var divID = jQuery(this).parent().attr("id");
		var action = 'rate';
		<?php # get variables based on current minisite
		global $post;
		$minisite = it_get_minisite($post->ID, true);
		$metric = '';
		if(!empty($minisite)) $metric = $minisite->rating_metric;
		?>
		var postID = '<?php echo $post->ID; ?>';
		var rating = ui.value;
		var metric = '<?php echo $metric; ?>';		
		jQuery.ajax({
			 url: '<?php echo get_template_directory_uri(); ?>/functions/ajax.php',
			 data: { id: postID, action: action, meta: meta, rating: rating, metric: metric, divID: divID },
			 type: 'POST',
			 dataType: 'json',
			 success: function (data) {
				 jQuery('.user-rating .rated-legend').addClass('active');
				 if(data.unlimitedratings != 1) {
				 	jQuery('#' + data.divID + '_wrapper').removeClass('single');
				 }
				 jQuery('#' + data.divID + ' .rating-value').hide(100)
				 	.delay(300)
					.queue(function(n) {
						jQuery(this).html(data.newrating);
						n();
					}).show(150);
				 jQuery('.user-rating .rating-wrapper.total .rating-value').delay(200)
				 	.hide(200)
				 	.delay(400)
					.queue(function(n) {
						jQuery(this).html(data.totalrating);
						n();
					}).show(400);
				 jQuery('#' + data.divID + ' .icon-check').delay(100).fadeIn(100);	
				 var left = -(100 - data.normalized);
				 animateRating(left, 400, data.divID);
				 // hide comment ratings after top ratings are added
				 jQuery('#respond .rating-wrapper').hide();
				 jQuery('.hidden-rating-value').val('');
			 },
			 error: function (jxhr, msg, err) {
				 jQuery('#ajax-error').show();
				 jQuery('#ajax-error').html(msg);
			 }
		 });
	});
	// user comment rating
	jQuery( "#respond .form-selector" ).on( "slidestop", function( event, ui ) {
		var divID = jQuery(this).parent().attr("id");	
		var rating = jQuery(this).siblings('.rating-value').html();
		jQuery('#' + divID + ' .icon-check').delay(100).fadeIn(100);
		jQuery('#' + divID + ' .hidden-rating-value').val(rating);
	});
	// star user ratings
	jQuery('.rating-wrapper .rateit').bind('rated reset', function (e) {
		 var ri = jQuery(this);
		
		 var noupdate = ri.data('noupdate');
		 var rating = ri.rateit('value');
		 var postID = ri.data('postid');
		 var meta = ri.data('meta');
		 var divID = ri.parent().parent().attr('id');
		 var action = 'rate';
		 var metric = 'stars';
		 var unlimitedratings = ri.data('unlimitedratings');
	
		 //disable rating ability after user submits rating
		 if(unlimitedratings != 1) {
		 	ri.rateit('readonly', true);
		 }
		 
		 if(noupdate==1) {
			 var divID = jQuery(this).parent().parent().attr("id");
			 jQuery('#' + divID + ' .hidden-rating-value').val(rating);
		 } else {	
			 jQuery.ajax({
				 url: '<?php echo get_template_directory_uri(); ?>/functions/ajax.php',
				 data: { id: postID, action: action, meta: meta, rating: rating, metric: metric, divID: divID },
				 type: 'POST',
				 dataType: 'json',
				 success: function (data) {
					 jQuery('.user-rating .rated-legend').addClass('active');
					 jQuery('.user-rating .rating-wrapper.total .rating-value').delay(200)
						.hide(200)
						.queue(function(n) {
							jQuery(this).html(data.totalrating);
							n();
						}).show(400);
					 var left = -(100 - data.normalized);
					 jQuery('#' + data.divID + ' .icon-check').delay(100).fadeIn(100);
					 animateRating(left, 400, data.divID);
					 // hide comment ratings after top ratings are added
				 	 jQuery('#respond .rating-wrapper').hide();
					 jQuery('.hidden-rating-value').val('');
				 },
				 error: function (jxhr, msg, err) {
					 jQuery('#ajax-error').show();
					 jQuery('#ajax-error').html(msg);
				 }
			 });
		 }
	 });
	 // recommended filtering
	jQuery('body').on('click', '#recommended .filterbar .sort-buttons a', function(e){
		jQuery("#recommended .loading").show();
		jQuery("#recommended .post-list").animate({opacity: "0.15"}, 0);	
		jQuery(this).addClass('active');
		jQuery(this).siblings().removeClass('active');
		
		var loop = jQuery(this).parent().data('loop');
		var location = jQuery(this).parent().data('location');		
		var thumbnail = jQuery(this).parent().data('thumbnail');
		var icon = jQuery(this).parent().data('icon');
		var columns = jQuery(this).parent().data('columns');
		var container = jQuery(this).parent().data('container');
		var rating = jQuery(this).parent().data('rating');
		var numarticles = jQuery(this).parent().data('numarticles');
		var targeted = jQuery(this).parent().data('targeted');
		var sorter = jQuery(this).data('sorter');
		var method = jQuery(this).data('method');
		var taxonomy = jQuery(this).data('taxonomy');
		var action = 'sort';
		
		<?php global $post; ?>
		var postID = '<?php echo $post->ID; ?>';
		
		// update loop content
		jQuery.ajax({
			url: '<?php echo get_template_directory_uri(); ?>/functions/ajax.php',
			data: { id: postID, sorter: sorter, taxonomy: taxonomy, loop: loop, location: location, method: method, action: action, thumbnail: thumbnail, rating: rating, numarticles: numarticles, icon: icon, targeted: targeted, container: container, columns: columns },
			type: 'POST',
			dataType: 'json',
			success: function (data) {			 
				jQuery("#recommended .loading").hide();
				jQuery("#recommended .post-list").animate({opacity: "1"}, 500);
				jQuery("#recommended .post-list").html(data.content);
				jQuery('#ajax-error').hide();
				dynamicElements();
			},
			error: function (jxhr, msg, err) {
				jQuery("#recommended .loading").hide();
				jQuery("#recommended .post-list").animate({opacity: "1"}, 500);
				jQuery('#ajax-error').show();
				jQuery('#ajax-error').html(msg);
			}
		});
	});
	var timeout;
	// menu top level item mouseovers
	jQuery('body').on('mouseover', '#section-menu li.unloaded a.parent-item', function(e) {
		
		var loop = jQuery(this).parent().data('loop');
		var method = jQuery(this).parent().data('method');
		var thumbnail = jQuery(this).parent().data('thumbnail');
		var numarticles = jQuery(this).parent().data('numarticles');
		var minisite = jQuery(this).parent().data('minisite');
		var object = jQuery(this).parent().data('object');
		var object_name = jQuery(this).parent().data('object_name');
		var type = jQuery(this).parent().data('type');
		var sorter = jQuery(this).parent().data('sorter');
		var action = 'menu_terms';
		var _this = this;
		
		timeout = setTimeout(function(){
		
			jQuery(_this).siblings(".loading-placeholder").show();
			jQuery(_this).parent().addClass('loaded').removeClass('unloaded');
			
			// update loop content
			jQuery.ajax({
				url: '<?php echo get_template_directory_uri(); ?>/functions/ajax.php',
				data: { sorter: sorter, object: object, object_name: object_name, loop: loop, method: method, thumbnail: thumbnail, action: action, numarticles: numarticles, minisite: minisite, type: type },
				type: 'POST',
				dataType: 'json',
				success: function (data) {
					jQuery(_this).siblings(".dropdown-placeholder").html(data.content);				
					jQuery('#ajax-error').hide();
					equalHeightColumns(jQuery("#section-menu-full ul.term-list, #section-menu-full li.post-list"));	
					jQuery(_this).siblings(".loading-placeholder").hide();
					menuHovers();			
				},
				error: function (jxhr, msg, err) {
					jQuery('#ajax-error').show();
					jQuery('#ajax-error').html(msg);
					jQuery(_this).siblings(".loading-placeholder").hide();	
				}
			});
			
		 }, 400);
	});
	jQuery('body').on('mouseleave', '#section-menu li.unloaded a.parent-item', function(e) {
		clearTimeout(timeout);
	});
	// menu second-level item mouseovers
	jQuery('body').on('mouseover', '#section-menu-full li.inactive a.list-item', function(e) {
		
		var loop = jQuery(this).parent().parent().parent().parent().data('loop');
		var method = jQuery(this).parent().parent().parent().parent().data('method');
		var thumbnail = jQuery(this).parent().parent().parent().parent().data('thumbnail');
		var numarticles = jQuery(this).parent().parent().parent().parent().data('numarticles');
		var minisite = jQuery(this).parent().parent().parent().parent().data('minisite');
		var object = jQuery(this).parent().parent().parent().parent().data('object');
		var object_name = jQuery(this).parent().parent().parent().parent().data('object_name');
		var sorter = jQuery(this).data('sorter');
		var action = 'sort';
		var _this = this;
		
		timeout = setTimeout(function(){
		
			jQuery("#section-menu-full ul.term-list .loading").show();
			jQuery("#section-menu-full .post-list a").animate({opacity: "0.15"}, 0);	
			jQuery(_this).parent().addClass('active').removeClass('inactive');
			jQuery(_this).parent().siblings().addClass('inactive').removeClass('active');
			
			// update loop content
			jQuery.ajax({
				url: '<?php echo get_template_directory_uri(); ?>/functions/ajax.php',
				data: { sorter: sorter, object: object, object_name: object_name, loop: loop, method: method, thumbnail: thumbnail, action: action, numarticles: numarticles, minisite: minisite },
				type: 'POST',
				dataType: 'json',
				success: function (data) {
					jQuery(_this).parent().siblings(".post-list").html(data.content);				
					jQuery('#ajax-error').hide();
					equalHeightColumns(jQuery("#section-menu-full ul.term-list, #section-menu-full li.post-list"));	
					jQuery("#section-menu-full ul.term-list .loading").hide();
					jQuery("#section-menu-full .post-list a").animate({opacity: "1"}, 500);	
					menuHovers();			
				},
				error: function (jxhr, msg, err) {
					jQuery('#ajax-error').show();
					jQuery('#ajax-error').html(msg);
					jQuery("#section-menu-full ul.term-list .loading").hide();
					jQuery("#section-menu-full .post-list a").animate({opacity: "1"}, 500);	
				}
			});
			
		 }, 400);
	});
	jQuery('body').on('mouseleave', '#section-menu-full li.inactive a.list-item', function(e) {
		clearTimeout(timeout);
	});
	
	// comment pagination - NOT CURRENTLY USED
	jQuery('body').on('click', '#comments .sort-buttons a.sort-button', function(e){
		jQuery("#comments .loading").show();
		jQuery("#comments .comment-list").animate({opacity: "0.15"}, 0);	
		jQuery(this).addClass('active');
		jQuery(this).siblings().removeClass('active');
		
		var commentsperpage = jQuery(this).parent().data('number');
		var type = jQuery(this).parent().data('type');	
		var offset = jQuery(this).data('offset');	
		var action = 'paginate_comments';
		
		<?php global $post; ?>
		var postID = '<?php echo $post->ID; ?>';
		
		// update loop content
		jQuery.ajax({
			url: '<?php echo get_template_directory_uri(); ?>/functions/ajax.php',
			data: { id: postID, action: action, commentsperpage: commentsperpage, offset: offset, type: type },
			type: 'POST',
			dataType: 'json',
			success: function (data) {			 
				jQuery("#comments .loading").hide();
				jQuery("#comments .comment-list").animate({opacity: "1"}, 500);
				jQuery("#comments .comment-list").html(data.content);
				jQuery('#ajax-error').hide();
			},
			error: function (jxhr, msg, err) {
				jQuery("#comments .loading").hide();
				jQuery("#comments .comment-list").animate({opacity: "1"}, 500);
				jQuery('#ajax-error').show();
				jQuery('#ajax-error').html(msg);
			}
		});
	});
	
</script>