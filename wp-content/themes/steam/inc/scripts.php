<script type="text/javascript">
	jQuery.noConflict(); 
	
	"use strict";
	
	//DOCUMENT.READY
	jQuery(document).ready(function() { 
		//hide various jQuery elements until they are loaded
		jQuery('.revolution-slider ul').show();
		jQuery('.it-widget-tabs').show();
		//revolution slider
		<?php		
		$it_featured_layout=it_get_setting('featured_layout');
		$minisite = it_get_minisite($post->ID);
		if($minisite) $it_featured_layout = $minisite->featured_layout;
		$int = it_get_setting('featured_interval');
		if(empty($int)) $int = 0;

		# setup featured layout variables
		$startheight=435;
		$startwidth=840;
		switch ($it_featured_layout) {
			case 'small':
				$startheight=348;
				$startwidth=672;
			break;
			case 'large':
				$startheight=600;
				$startwidth=1158;
			break;	
		}		
		?>			
		if (jQuery.fn.cssOriginal!=undefined)
		jQuery.fn.css = jQuery.fn.cssOriginal;
		
		jQuery('.revolution-slider').revolution(
			{    
			delay:<?php echo $int; ?>000,                                                
			startheight:<?php echo $startheight; ?>,                            
			startwidth:<?php echo $startwidth; ?>,
			
			hideThumbs:200,
			
			thumbWidth:100,                            
			thumbHeight:50,
			thumbAmount:5,
			
			navigationType:"none",               
			navigationArrows:"solo",      
			navigationStyle:"round",               
										
			navigationHAlign:"center",             
			navigationVAlign:"bottom",                 
			navigationHOffset:0,
			navigationVOffset:20,
			
			soloArrowLeftHalign:"left",
			soloArrowLeftValign:"center",
			soloArrowLeftHOffset:20,
			soloArrowLeftVOffset:0,
			
			soloArrowRightHalign:"right",
			soloArrowRightValign:"center",
			soloArrowRightHOffset:20,
			soloArrowRightVOffset:0,
			touchenabled:"on",                      
			onHoverStop:"on",                        
			
			navOffsetHorizontal:0,
			navOffsetVertical:20,
			
			hideCaptionAtLimit:420,
			hideAllCaptionAtLilmit:0,
			hideSliderAtLimit:0,
			
			<?php if($int==0) { ?>
				stopAtSlide:1,
				stopAfterLoops:0,
			<?php } else { ?>
				stopAtSlide:-1,
				stopAfterLoops:-1,
			<?php } ?>			
			
			shadow:0,
			fullWidth:"off" ,
			fullScreen:"off",   
											
		});		
	
		//superfish
		jQuery('#top-menu ul').superfish({
			hoverClass:  'over',
			delay:       500,
			animation:   {height:'show'},
			speed:       160,
			disableHI:   true,
			autoArrows:  false
		});
		jQuery('#section-menu ul').superfish({
			hoverClass:  'over',
			delay:       300,
			speed:       100,
			disableHI:   true,
			autoArrows:  false
		});
		jQuery('#sub-menu ul').superfish({
			hoverClass:  'over',
			delay:       500,
			animation:   {height:'show'},
			speed:       160,
			disableHI:   true,
			autoArrows:  false
		});
		jQuery('.bar-selector ul').superfish({
			hoverClass:  'over',
			delay:       400,
			animation:   {height:'show'},
			speed:       100,
			disableHI:   true,
			autoArrows:  false
		});
		
		//hide scrollers until fully loaded
		jQuery('.bar-slider').show();
		jQuery('#steam').show();
		
		//simplyscroll sliders (standard carousel for IE8 and opera)		
		var isIE8 = jQuery.browser.msie && +jQuery.browser.version === 8;
		var isOpera = jQuery.browser.opera;
		//if ( isIE8 || isOpera ) {
		if ( isIE8 ) {
			jQuery('#top-ten-slider').wrapInner('<div id="#top-ten-inner" class="the-bar carousel-inner" />');
			jQuery('#top-ten-slider').carousel({
				interval: 3500
			});
			jQuery('#trending-slider').wrapInner('<div id="#trending-inner" class="the-bar carousel-inner" />');
			jQuery('#trending-slider').carousel({
				interval: 3500
			});
		} else {					
			jQuery("#top-ten-slider").simplyScroll({
				customClass: 'the-bar',
				orientation: 'horizontal', 
				direction: 'forwards',
				pauseOnHover: true,
				frameRate: 48,
				speed: 2		
			});	
			jQuery("#trending-slider").simplyScroll({
				customClass: 'the-bar',
				orientation: 'horizontal', 
				direction: 'forwards',
				pauseOnHover: true,
				frameRate: 48,
				speed: 2		
			});					
		}
		jQuery(".sidecar").simplyScroll({
			customClass: 'sidecar-vertical',
			orientation: 'vertical',
			auto: false,
			manualMode: 'loop',
			frameRate: 48,
			speed: 9		
		});	
		jQuery(".steam-content").simplyScroll({
			customClass: 'steam',
			orientation: 'horizontal',
			auto: false,
			direction: 'forwards',
			manualMode: 'loop',
			frameRate: 48,
			speed: 12		
		});	
		
		//jquery ui slider
		<?php # get variables based on current minisite
		global $post;
		$minisite = it_get_minisite($post->ID);
		$metric = '';
		if(isset($minisite->rating_metric))	$metric = $minisite->rating_metric;
		switch($metric) {
			case 'number':
				$value = 5;
				$min = 0;
				$max = 10;
				$step = .1;
			break;
			case 'percentage':
				$value = 50;
				$min = 0;
				$max = 100;
				$step = 1;
			break;
			case 'letter':
				$value = 7;
				$min = 1;
				$max = 14;
				$step = 1;
			break;
			case 'stars':
				$value = 2.5;
				$min = 0;
				$max = 5;
				$step = .5;
			break;
			default:
				$value = 5;
				$min = 0;
				$max = 10;
				$step = .1;
			break;
		}
		?>
		jQuery('.form-selector').slider({
			value: <?php echo $value; ?>,
			min: <?php echo $min; ?>,
			max: <?php echo $max; ?>,
			step: <?php echo $step; ?>,
			orientation: "horizontal",
			range: "min",
			animate: true,
			slide: function( event, ui ) {
				var rating = ui.value;
				<?php if($metric=='letter') { ?>				
					var numbers = {'1':'F', '2':'F+', '3':'D-', '4':'D', '5':'D+', '6':'C-', '7':'C', '8':'C+', '9':'B-', '10':'B', '11':'B+', '12':'A-', '13':'A', '14':'A+'};					
					var rating = numbers[rating];
				<?php } elseif($metric=='percentage') { ?>	
					var rating = rating + '<span class="percentage">&#37;</span>';
				<?php } ?>			
				jQuery(this).siblings('.rating-value').html( rating );
			}
		});
		
		//HD images		
		if (window.devicePixelRatio == 2) {	
			var images = jQuery("img.hires");		
			// loop through the images and make them hi-res
			for(var i = 0; i < images.length; i++) {		
				// create new image name
				var imageType = images[i].src.substr(-4);
				var imageName = images[i].src.substr(0, images[i].src.length - 4);
				imageName += "@2x" + imageType;		
				//rename image
				images[i].src = imageName;
			}
		}			
		
		//add bootstrap classes to wordpress generated elements
		jQuery('.avatar-70, .avatar-50').addClass('img-circle');
		jQuery('.comment-reply-link').addClass('btn');
		jQuery('#reply-form input#submit').addClass('btn');
		
		<?php if(!it_get_setting('colorbox_disable')) { ?>			
			jQuery('a.featured-image').colorbox();
			jQuery('.colorbox').colorbox();
			jQuery(".the-content a[href$='.jpg'],a[href$='.png'],a[href$='.gif']").colorbox(); 
			<?php if(it_get_setting('colorbox_slideshow')) { ?>
				jQuery('.the-content .gallery a').colorbox({rel:'gallery',slideshow:true});
			<?php } else { ?>
				jQuery('.the-content .gallery a').colorbox({rel:'gallery'});
			<?php } ?>
		<?php } ?> 
		
		//placeholder text for IE9
		jQuery('input, textarea').placeholder();
		
		//functions that need to run after ajax buttons are clicked
		dynamicElements();	
		
		//menu hover fx
		menuHovers();	
				
	});
	
	//applied to elements within ajax panels
	function dynamicElements() {
		//boxes mouseovers
		jQuery("#boxes .box-link").hover(
			function() {
				jQuery(this).siblings(".box-layer").stop().animate({
					'opacity':'0.75'
				}, 100);
			},
			function() {
				jQuery(this).siblings(".box-layer").stop().animate({
					'opacity':'0.65'
				}, 300);
			}
		);
		jQuery(".post-list .box-link, .steam .box-link").hover(
			function() {
				jQuery(this).siblings(".box-layer").stop().animate({
					'opacity':'0.5'
				}, 100);
			},
			function() {
				jQuery(this).siblings(".box-layer").stop().animate({
					'opacity':'0.4'
				}, 300);
			}
		);
		//trending mouseovers
		jQuery(".trending-link").hover(			
			function() {
				jQuery(this).siblings(".trending-color").children(".trending-hover").stop().animate({
					'opacity':'1'
				}, 100);
			},
			function() {
				jQuery(this).siblings(".trending-color").children(".trending-hover").stop().animate({
					'opacity':'0'
				}, 300);
			}
		);
		//more link hover effect
		jQuery(".hover-link").hover(
			function() {
				jQuery(this).siblings('.hover-text').addClass("active");
				jQuery(this).parent().find('img').stop().animate({ opacity: .3 }, 150);
			},
			function() {
				jQuery(this).siblings('.hover-text').removeClass("active");
				jQuery(this).parent().find('img').stop().animate({ opacity: 1.0 }, 500);
			}
		);		
		//review directory hover effect
		jQuery(".directory-panel .listing a").hover(
			function() {
				jQuery(this).parent().addClass("active");
				jQuery(this).children('img').stop().animate({ opacity: .6 }, 400);
			},
			function() {
				jQuery(this).parent().removeClass("active");
				jQuery(this).children('img').stop().animate({ opacity: 1.0 }, 800);
			}
		);	
		//jQuery tooltips				
		jQuery('.info').tooltip();		
		jQuery('.info-bottom').tooltip({ placement: 'bottom' });
		jQuery('.info-left').tooltip({ placement: 'left' });
		jQuery('.info-right').tooltip({ placement: 'right' });
		//jQuery popovers
		jQuery('.popthis').popover();
		//jQuery alert dismissals
		jQuery(".alert").alert();
		//jQuery fitvids
		jQuery('.video_frame').fitVids();
		//equal height columns
		equalHeightColumns(jQuery("#articles .panel"));
		equalHeightColumns(jQuery("#mixed .widgets"));
		equalHeightColumns(jQuery("#content .content-inner, #content-wrapper .widgets-wrapper"));
	}
	
	//call equal height columns when window is resized
	jQuery(window).resize(function() {
		equalHeightColumns(jQuery("#articles .panel"));
		equalHeightColumns(jQuery("#mixed .widgets"));
		equalHeightColumns(jQuery("#content .content-inner, #content-wrapper .widgets-wrapper"));
	});
	
	//call equal height columns when main content is resized
	jQuery("#articles").resize(function(e){
		equalHeightColumns(jQuery("#articles .panel"));
	});
	
	//call equal height columns when mixed is resized
	jQuery("#mixed").resize(function(e){
		equalHeightColumns(jQuery("#mixed .widgets"));
	});
	
	//call equal height columns when main content is resized
	jQuery("#content .content-inner > div").resize(function(e){
		equalHeightColumns(jQuery("#content .content-inner, #content-wrapper .widgets-wrapper"));
	});
	
	//call equal height columns when sidebar is resized
	jQuery("#content-wrapper .widgets-wrapper").resize(function(e){
		equalHeightColumns(jQuery("#content .content-inner, #content-wrapper .widgets-wrapper"));
	});
	
	//call equal height columns when main menu items are hovered since sub menus are
	//hidden and don't have heights until visible
	jQuery('body').on('mouseover', '#section-menu-full a.parent-item', function(e){
		equalHeightColumns(jQuery("#section-menu-full ul.term-list, #section-menu-full li.post-list"));
	});
	//equal height columns
	function equalHeightColumns(group) {
		tallest = 0;
		width = jQuery(window).width();							
		group.each(function() {
			jQuery(this).removeAttr('style');			
			thisHeight = jQuery(this).height();
			if(thisHeight > tallest) {
				tallest = thisHeight;
			}
		});
		if(width > 767) {
			group.height(tallest);	
			//alert('it ran');
		}
	}
	//menu hovers
	function menuHovers() {
		jQuery(".menu .post-list a").hover(
			function() {
				jQuery(this).children('img').stop().animate({ opacity: .3 }, 150);
			},
			function() {
				jQuery(this).children('img').stop().animate({ opacity: 1.0 }, 500);
			}
		);	
	}
	//show search box		
	jQuery("#menu-search-button").click(
		function() {
			jQuery('#menu-search').fadeToggle("fast");
			jQuery(this).toggleClass('active');
		}
	);
	//search form submission
	jQuery("#searchformtop input").keypress(function(event) {
		if (event.which == 13) {
			event.preventDefault();
			jQuery("#searchformtop").submit();
		}
	});
	//email subscribe form submission
	jQuery("#feedburner_subscribe button").click(function() {		
		jQuery("#feedburner_subscribe").submit();		
	});
	//show login form
	jQuery("#sticky-login").click(function() {
		jQuery('#sticky-login-form').animate({				 
			height: 'toggle'				 
		}, 100, 'linear' );	
		jQuery('#sticky-register-form').hide();	
		jQuery('#sticky-register').removeClass('active');
		jQuery(this).toggleClass('active');
	});
	//show register form
	jQuery("#sticky-register").click(function() {
		jQuery('#sticky-register-form').animate({				 
			height: 'toggle'				 
		}, 100, 'linear' );	
		jQuery('#sticky-login-form').hide();	
		jQuery('#sticky-login').removeClass('active');
		jQuery(this).toggleClass('active');
	});
	//submit button hover effects
	jQuery(".sticky-submit").hover(function() {
		jQuery(this).toggleClass("active");
	});
	//login form submission
	jQuery(".sticky-login-form #user_pass").keypress(function(event) {
		if (event.which == 13) {
			jQuery("#sticky-login-form .loading").show();
			jQuery("form.sticky-login-form").animate({opacity: "0.15"}, 0);
			event.preventDefault();
			jQuery(".sticky-login-form").submit();
		}		
	});
	jQuery("#sticky-login-submit").click(function() {
		jQuery("#sticky-login-form .loading").show();
		jQuery("form.sticky-login-form").animate({opacity: "0.15"}, 0);
		jQuery(".sticky-login-form").submit();
	});
	//register form submission
	jQuery(".sticky-register-form #user_email").keypress(function(event) {
		if (event.which == 13) {
			jQuery("#sticky-register-form .loading").show();
			jQuery("form.sticky-register-form").animate({opacity: "0.15"}, 0);
			event.preventDefault();
			jQuery(".sticky-register-form").submit();
		}
	});
	jQuery("#sticky-register-submit").click(function() {
		jQuery("#sticky-register-form .loading").show();
		jQuery("form.sticky-register-form").animate({opacity: "0.15"}, 0);
		jQuery(".sticky-register-form").submit();
	});
	//hide check password message
	jQuery(".check-password").click(function() {
		jQuery(this).animate({				 
			height: 'toggle'				 
		}, 100, 'linear' );	
	});
	//show back to top arrow after page is scrolled
	jQuery(window).scroll(function() {
		if (jQuery(this).scrollTop() < 150) {
			jQuery("#back-to-top").fadeOut();
		}
		else {
			jQuery("#back-to-top").fadeIn();
		}
	});
	//scroll all #top elements to top
	jQuery("a[href='#top']").click(function() {
		jQuery("html, body").animate({ scrollTop: 0 }, "slow");
		return false;
	});
	//show new articles
	jQuery("#new-articles .selector").click(function() {
		jQuery('#new-articles .post-container').animate({				 
			height: 'toggle'				 
		}, 100, 'linear' );
		jQuery('#new-articles .selector').toggleClass('active');
	});	
	//sidecar mouseovers
	jQuery(".sidecar-panel .sidecar-link").hover(
		function() {
			jQuery(this).siblings(".sidecar-layer").stop().animate({
				'opacity':'0.70'
			}, 100);
		},
		function() {
			jQuery(this).siblings(".sidecar-layer").stop().animate({
				'opacity':'0.60'
			}, 300);
		}
	);
	//sortbar mouseovers
	jQuery(".sortbar-hidden").hover(
		function() {
			jQuery(this).children(".sort-buttons").stop().fadeIn("fast");
		},
		function() {
			jQuery(this).children(".sort-buttons").stop().fadeOut("slow");	
		}
	);
	//image darkening
	jQuery('body').on('mouseenter', '.darken', function(e) {
		jQuery(this).find('img').stop().animate({ opacity: .3 }, 150);
	}).on('mouseleave', '.darken', function(e) {
		jQuery(this).find('img').stop().animate({ opacity: 1.0 }, 500);
	});	
	// minisite cloud tabs
	jQuery('body').on('click', '.section-buttons .sort-buttons a', function(e){
		jQuery(this).parent().siblings().find('.minisite-icon').removeClass('white');
		jQuery(this).children('.minisite-icon').addClass('white');			
	});
	//postnav mouseovers
	jQuery("#postnav a").hover(
		function() {
			jQuery(this).siblings('.inner-content').addClass('active');
		},
		function() {
			jQuery(this).siblings('.inner-content').removeClass('active');
		}
	);
	//rating animations
	function animateRating(pos,delay,eid) {
		jQuery('#' + eid + ' .rating-meter').delay(delay).animate({
			opacity:1,
			left: pos + '%'
		}, 2500, 'easeOutCubic');	
	}
	
	//pinterest
	(function(d){
		var f = d.getElementsByTagName('SCRIPT')[0], p = d.createElement('SCRIPT');
		p.type = 'text/javascript';
		p.async = true;
		p.src = '//assets.pinterest.com/js/pinit.js';
		f.parentNode.insertBefore(p, f);
	}(document));
	
	//facebook
	(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&status=0";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));
		
	//WINDOW.LOAD
	jQuery(window).load(function() {		
		
		//flickr
		<?php #deal with default values
		$flickr_count = it_get_setting('flickr_number');
		if(empty($flickr_count)) $flickr_count=9;
		?>
		jQuery('.flickr').jflickrfeed({
			limit: <?php echo $flickr_count; ?>,
			qstrings: {
				id: '<?php echo it_get_setting('flickr_id'); ?>'
			},
			itemTemplate: '<li>'+
							'<a rel="colorbox" class="darken small" href="{{image}}" title="{{title}}">' +
								'<img src="{{image_s}}" alt="{{title}}" width="75" height="75" />' +
							'</a>' +
						  '</li>'
		}, function(data) {
		});	
		
		//tabs - these must go in window.load so pinterest will work inside a tab
		jQuery('.widgets-wrapper .it-clouds').tabs({ fx: { opacity: 'toggle', duration: 150 } });
		jQuery('#footer .it-clouds').tabs({ fx: { opacity: 'toggle', duration: 150 } });
		jQuery('.widgets-wrapper .it-social-tabs').tabs({ fx: { opacity: 'toggle', duration: 150 } });
		jQuery('#footer .it-social-tabs').tabs({ fx: { opacity: 'toggle', duration: 150 } });
		
		//third-party vendors (like Facebook) take a while to run sometimes
		function adjustColumnsDelayed() {
			equalHeightColumns(jQuery("#articles .panel"));
			equalHeightColumns(jQuery("#mixed .widgets"));
			equalHeightColumns(jQuery("#content .content-inner, #content-wrapper .widgets-wrapper"));
		}
		setTimeout(adjustColumnsDelayed, 1000)
	});	
	
	jQuery.noConflict();
	
	<?php if(it_get_setting('show_demo_panel')) { ?>
	
	jQuery(document).ready(function() {
		
		jQuery('.accent-color').wpColorPicker({defaultColor: false, change: function(event, ui){changeAccentColor(ui)}, clear: function() {}, hide: true, palettes: true});
		jQuery('.background-color').wpColorPicker({defaultColor: false, change: function(event, ui){changeBackgroundColor(ui)}, clear: function() {}, hide: true, palettes: true});	
	
		jQuery(".toggle-demo").click(function(){
			jQuery(".demo-wrapper").animate({
				left: "0px"
			}, "fast");
			jQuery(".toggle-demo").toggle();
		});	
		jQuery(".hide-demo").click(function(){
			jQuery(".demo-wrapper").animate({
				left: "-161px"
			}, "fast");
		});
		jQuery('#menu-fonts').change(function(){
			var fontval = jQuery("#menu-fonts option:selected").val();
			var fontname = jQuery("#menu-fonts option:selected").text();
			jQuery('link#menu-fonts-link').attr({href:'http://fonts.googleapis.com/css?family=' + fontval});
			jQuery('style#menu-fonts-style').text('#section-menu a, #highlight-menu a, #top-menu a, #sub-menu a { font-family:' + fontname + ', sans-serif; }');
		});	
		jQuery('#content-header-fonts').change(function(){
			var fontval = jQuery("#content-header-fonts option:selected").val();
			var fontname = jQuery("#content-header-fonts option:selected").text();
			jQuery('link#content-header-fonts-link').attr({href:'http://fonts.googleapis.com/css?family=' + fontval});
			jQuery('style#content-header-fonts-style').text('.single-page .main-content h1, .main-content h1, .main-content h2, .main-content h3, .main-content h4, .main-content h5, .main-content h6, #exclusive ul li a, .articles h2 a, .box-info { font-family:' + fontname + ', sans-serif; }');
		});	
		jQuery('#section-header-fonts').change(function(){
			var fontval = jQuery("#section-header-fonts option:selected").val();
			var fontname = jQuery("#section-header-fonts option:selected").text();
			jQuery('link#section-header-fonts-link').attr({href:'http://fonts.googleapis.com/css?family=' + fontval});
			jQuery('style#section-header-fonts-style').text('.widgets .header, .bar-label .label-text, .exclusive-label .label-top, .connect-label .label-top, .sortbar .sortbar-title, .sortbar .sortbar-prefix, .trending-bar .title, .revolution-slider .slider-label, .revolution-slider .category { font-family:' + fontname + ', sans-serif; }');
		});	
		jQuery('#body-fonts').change(function(){
			var fontval = jQuery("#body-fonts option:selected").val();
			var fontname = jQuery("#body-fonts option:selected").text();
			jQuery('link#body-fonts-link').attr({href:'http://fonts.googleapis.com/css?family=' + fontval});
			jQuery('style#body-fonts-style').text('body, .the-content { font-family:' + fontname + ', sans-serif; }');
		});	
		jQuery('#widget-fonts').change(function(){
			var fontval = jQuery("#widget-fonts option:selected").val();
			var fontname = jQuery("#widget-fonts option:selected").text();
			jQuery('link#widget-fonts-link').attr({href:'http://fonts.googleapis.com/css?family=' + fontval});
			jQuery('style#widget-fonts-style').text('.widget, .widget a, .post-list .list-item a.title, .topten-articles .panel a.title { font-family:' + fontname + ', sans-serif; }');
		});
		
		jQuery("select#menu-fonts, select#body-fonts, select#widget-fonts, select#content-header-fonts, select#section-header-fonts").selectBox();
		
	});
	
	function changeAccentColor(ui) {
		jQuery('#sizzlin-header, #sticky-controls a.active, .bar-selected .selector-icon, .connect-counts .social-counts .panel span, .social-counts .panel span, .ratings .rating-value .stars span, .single-page .sortbar .minisite-wrapper, .single-page .main-content a, .hover-text.active a, .sticky-post .icon-pin').css('color',ui.color.toString());	
		jQuery('a, #top-menu-selector, #sticky-controls a, .loop h2 a, #exclusive ul li a, .connect-counts .social-counts a, .widgets #wp-calendar a, .social-counts a, .single-page .main-content a, .single-page.template-authors .main-content a, #footer a, .main-content a').hover(
			function() {
				jQuery(this).css('color',ui.color.toString());
			},
			function () {
				jQuery(this).css('color','#000000');
			}
		);
		jQuery('.bar-label, .exclusive-label, #recommended .filterbar .sort-buttons .bottom-arrow, .trending-color').css('background-color',ui.color.toString());	
		jQuery('.sticky-form .sticky-submit, #new-articles .selector.active, .revolution-slider .slider-label, #recommended .filterbar .sort-buttons .active, #comments .comment-rating, #comments .filterbar .sort-buttons span.current, #respond .ratings .ui-slider-range, #postnav .active').css('background',ui.color.toString());	
	};
	
	function changeBackgroundColor(ui) {
		jQuery('body').css('background-color',ui.color.toString());
	};
	
	<?php } ?>
	
</script>