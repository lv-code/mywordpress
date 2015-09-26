/*
 * Superfish v1.4.8 - jQuery menu widget
 * Copyright (c) 2008 Joel Birch
 *
 * Dual licensed under the MIT and GPL licenses:
 * 	http://www.opensource.org/licenses/mit-license.php
 * 	http://www.gnu.org/licenses/gpl.html
 *
 * CHANGELOG: http://users.tpg.com.au/j_birch/plugins/superfish/changelog.txt
 */

;(function($){
	$.fn.superfish = function(op){

		var sf = $.fn.superfish,
			c = sf.c,
			$arrow = $(['<span class="',c.arrowClass,'"> &#187;</span>'].join('')),
			over = function(){
				var $$ = $(this), menu = getMenu($$);
				clearTimeout(menu.sfTimer);
				$$.showSuperfishUl().siblings().hideSuperfishUl();
			},
			out = function(){
				var $$ = $(this), menu = getMenu($$), o = sf.op;
				clearTimeout(menu.sfTimer);
				menu.sfTimer=setTimeout(function(){
					o.retainPath=($.inArray($$[0],o.$path)>-1);
					$$.hideSuperfishUl();
					if (o.$path.length && $$.parents(['li.',o.hoverClass].join('')).length<1){over.call(o.$path);}
				},o.delay);	
			},
			getMenu = function($menu){
				var menu = $menu.parents(['ul.',c.menuClass,':first'].join(''))[0];
				sf.op = sf.o[menu.serial];
				return menu;
			},
			addArrow = function($a){ $a.addClass(c.anchorClass).append($arrow.clone()); };
			
		return this.each(function() {
			var s = this.serial = sf.o.length;
			var o = $.extend({},sf.defaults,op);
			o.$path = $('li.'+o.pathClass,this).slice(0,o.pathLevels).each(function(){
				$(this).addClass([o.hoverClass,c.bcClass].join(' '))
					.filter('li:has(ul)').removeClass(o.pathClass);
			});
			sf.o[s] = sf.op = o;
			
			$('li:has(ul)',this)[($.fn.hoverIntent && !o.disableHI) ? 'hoverIntent' : 'hover'](over,out).each(function() {
				if (o.autoArrows) addArrow( $('>a:first-child',this) );
			})
			.not('.'+c.bcClass)
				.hideSuperfishUl();
			
			var $a = $('a',this);
			$a.each(function(i){
				var $li = $a.eq(i).parents('li');
				$a.eq(i).focus(function(){over.call($li);}).blur(function(){out.call($li);});
			});
			o.onInit.call(this);
			
		}).each(function() {
			var menuClasses = [c.menuClass];
			if (sf.op.dropShadows  && !($.browser.msie && $.browser.version < 7)) menuClasses.push(c.shadowClass);
			$(this).addClass(menuClasses.join(' '));
		});
	};

	var sf = $.fn.superfish;
	sf.o = [];
	sf.op = {};
	sf.IE7fix = function(){
		var o = sf.op;
		if ($.browser.msie && $.browser.version > 6 && o.dropShadows && o.animation.opacity!=undefined)
			this.toggleClass(sf.c.shadowClass+'-off');
		};
	sf.c = {
		bcClass     : 'sf-breadcrumb',
		menuClass   : 'sf-js-enabled',
		anchorClass : 'sf-with-ul',
		arrowClass  : 'sf-sub-indicator',
		shadowClass : 'sf-shadow'
	};
	sf.defaults = {
		hoverClass	: 'sfHover',
		pathClass	: 'overideThisToUse',
		pathLevels	: 1,
		delay		: 800,
		animation	: {opacity:'show'},
		speed		: 'normal',
		autoArrows	: true,
		dropShadows : true,
		disableHI	: false,		// true disables hoverIntent detection
		onInit		: function(){}, // callback functions
		onBeforeShow: function(){},
		onShow		: function(){},
		onHide		: function(){}
	};
	$.fn.extend({
		hideSuperfishUl : function(){
			var o = sf.op,
				not = (o.retainPath===true) ? o.$path : '';
			o.retainPath = false;
			var $ul = $(['li.',o.hoverClass].join(''),this).add(this).not(not).removeClass(o.hoverClass)
					.find('>ul').hide().css('visibility','hidden');
			o.onHide.call($ul);
			return this;
		},
		showSuperfishUl : function(){
			var o = sf.op,
				sh = sf.c.shadowClass+'-off',
				$ul = this.addClass(o.hoverClass)
					.find('>ul:hidden').css('visibility','visible');
			sf.IE7fix.call($ul);
			o.onBeforeShow.call($ul);
			$ul.animate(o.animation,o.speed,function(){ sf.IE7fix.call($ul); o.onShow.call($ul); });
			return this;
		}
	});

})(jQuery);
/*
 *  jQuery selectBox - A cosmetic, styleable replacement for SELECT elements
 *
 *  Copyright 2012 Cory LaViska for A Beautiful Site, LLC.
 *
 *  https://github.com/claviska/jquery-selectBox
 *
 *  Licensed under both the MIT license and the GNU GPLv2 (same as jQuery: http://jquery.org/license)
 *
 */
if (jQuery)(function($) {
	$.extend($.fn, {
		selectBox: function(method, data) {
			var typeTimer, typeSearch = '',
				isMac = navigator.platform.match(/mac/i);
			//
			// Private methods
			//
			var init = function(select, data) {
					var options;
					// Disable for iOS devices (their native controls are more suitable for a touch device)
					if (navigator.userAgent.match(/iPad|iPhone|Android|IEMobile|BlackBerry/i)) return false;
					// Element must be a select control
					if (select.tagName.toLowerCase() !== 'select') return false;
					select = $(select);
					if (select.data('selectBox-control')) return false;
					var control = $('<a class="selectBox" />'),
						inline = select.attr('multiple') || parseInt(select.attr('size')) > 1;
					var settings = data || {};
					control.width(select.outerWidth()).addClass(select.attr('class')).attr('title', select.attr('title') || '').attr('tabindex', parseInt(select.attr('tabindex'))).css('display', 'inline-block').bind('focus.selectBox', function() {
						if (this !== document.activeElement && document.body !== document.activeElement) $(document.activeElement).blur();
						if (control.hasClass('selectBox-active')) return;
						control.addClass('selectBox-active');
						select.trigger('focus');
					}).bind('blur.selectBox', function() {
						if (!control.hasClass('selectBox-active')) return;
						control.removeClass('selectBox-active');
						select.trigger('blur');
					});
					if (!$(window).data('selectBox-bindings')) {
						$(window).data('selectBox-bindings', true).bind('scroll.selectBox', hideMenus).bind('resize.selectBox', hideMenus);
					}
					if (select.attr('disabled')) control.addClass('selectBox-disabled');
					// Focus on control when label is clicked
					select.bind('click.selectBox', function(event) {
						control.focus();
						event.preventDefault();
					});
					// Generate control
					if (inline) {
						//
						// Inline controls
						//
						options = getOptions(select, 'inline');
						control.append(options).data('selectBox-options', options).addClass('selectBox-inline selectBox-menuShowing').bind('keydown.selectBox', function(event) {
							handleKeyDown(select, event);
						}).bind('keypress.selectBox', function(event) {
							handleKeyPress(select, event);
						}).bind('mousedown.selectBox', function(event) {
							if ($(event.target).is('A.selectBox-inline')) event.preventDefault();
							if (!control.hasClass('selectBox-focus')) control.focus();
						}).insertAfter(select);
						// Auto-height based on size attribute
						if (!select[0].style.height) {
							var size = select.attr('size') ? parseInt(select.attr('size')) : 5;
							// Draw a dummy control off-screen, measure, and remove it
							var tmp = control.clone().removeAttr('id').css({
								position: 'absolute',
								top: '-9999em'
							}).show().appendTo('body');
							tmp.find('.selectBox-options').html('<li><a>\u00A0</a></li>');
							var optionHeight = parseInt(tmp.find('.selectBox-options A:first').html('&nbsp;').outerHeight());
							tmp.remove();
							control.height(optionHeight * size);
						}
						disableSelection(control);
					} else {
						//
						// Dropdown controls
						//
						var label = $('<span class="selectBox-label" />'),
							arrow = $('<span class="selectBox-arrow" />');
						// Update label
						label.attr('class', getLabelClass(select)).text(getLabelText(select));
						options = getOptions(select, 'dropdown');
						options.appendTo('BODY');
						control.data('selectBox-options', options).addClass('selectBox-dropdown').append(label).append(arrow).bind('mousedown.selectBox', function(event) {
							if (control.hasClass('selectBox-menuShowing')) {
								hideMenus();
							} else {
								event.stopPropagation();
								// Webkit fix to prevent premature selection of options
								options.data('selectBox-down-at-x', event.screenX).data('selectBox-down-at-y', event.screenY);
								showMenu(select);
							}
						}).bind('keydown.selectBox', function(event) {
							handleKeyDown(select, event);
						}).bind('keypress.selectBox', function(event) {
							handleKeyPress(select, event);
						}).bind('open.selectBox', function(event, triggerData) {
							if (triggerData && triggerData._selectBox === true) return;
							showMenu(select);
						}).bind('close.selectBox', function(event, triggerData) {
							if (triggerData && triggerData._selectBox === true) return;
							hideMenus();
						}).insertAfter(select);
						// Set label width
						var labelWidth = control.width() - arrow.outerWidth() - parseInt(label.css('paddingLeft')) - parseInt(label.css('paddingLeft'));
						label.width(labelWidth);
						disableSelection(control);
					}
					// Store data for later use and show the control
					select.addClass('selectBox').data('selectBox-control', control).data('selectBox-settings', settings).hide();
				};
			var getOptions = function(select, type) {
					var options;
					// Private function to handle recursion in the getOptions function.
					var _getOptions = function(select, options) {
							// Loop through the set in order of element children.
							select.children('OPTION, OPTGROUP').each(function() {
								// If the element is an option, add it to the list.
								if ($(this).is('OPTION')) {
									// Check for a value in the option found.
									if ($(this).length > 0) {
										// Create an option form the found element.
										generateOptions($(this), options);
									} else {
										// No option information found, so add an empty.
										options.append('<li>\u00A0</li>');
									}
								} else {
									// If the element is an option group, add the group and call this function on it.
									var optgroup = $('<li class="selectBox-optgroup" />');
									optgroup.text($(this).attr('label'));
									options.append(optgroup);
									options = _getOptions($(this), options);
								}
							});
							// Return the built strin
							return options;
						};
					switch (type) {
					case 'inline':
						options = $('<ul class="selectBox-options" />');
						options = _getOptions(select, options);
						options.find('A').bind('mouseover.selectBox', function(event) {
							addHover(select, $(this).parent());
						}).bind('mouseout.selectBox', function(event) {
							removeHover(select, $(this).parent());
						}).bind('mousedown.selectBox', function(event) {
							event.preventDefault(); // Prevent options from being "dragged"
							if (!select.selectBox('control').hasClass('selectBox-active')) select.selectBox('control').focus();
						}).bind('mouseup.selectBox', function(event) {
							hideMenus();
							selectOption(select, $(this).parent(), event);
						});
						disableSelection(options);
						return options;
					case 'dropdown':
						options = $('<ul class="selectBox-dropdown-menu selectBox-options" />');
						options = _getOptions(select, options);
						options.data('selectBox-select', select).css('display', 'none').appendTo('BODY').find('A').bind('mousedown.selectBox', function(event) {
							event.preventDefault(); // Prevent options from being "dragged"
							if (event.screenX === options.data('selectBox-down-at-x') && event.screenY === options.data('selectBox-down-at-y')) {
								options.removeData('selectBox-down-at-x').removeData('selectBox-down-at-y');
								hideMenus();
							}
						}).bind('mouseup.selectBox', function(event) {
							if (event.screenX === options.data('selectBox-down-at-x') && event.screenY === options.data('selectBox-down-at-y')) {
								return;
							} else {
								options.removeData('selectBox-down-at-x').removeData('selectBox-down-at-y');
							}
							selectOption(select, $(this).parent());
							hideMenus();
						}).bind('mouseover.selectBox', function(event) {
							addHover(select, $(this).parent());
						}).bind('mouseout.selectBox', function(event) {
							removeHover(select, $(this).parent());
						});
						// Inherit classes for dropdown menu
						var classes = select.attr('class') || '';
						if (classes !== '') {
							classes = classes.split(' ');
							for (var i in classes) options.addClass(classes[i] + '-selectBox-dropdown-menu');
						}
						disableSelection(options);
						return options;
					}
				};
			var getLabelClass = function(select) {
					var selected = $(select).find('OPTION:selected');
					return ('selectBox-label ' + (selected.attr('class') || '')).replace(/\s+$/, '');
				};
			var getLabelText = function(select) {
					var selected = $(select).find('OPTION:selected');
					return selected.text() || '\u00A0';
				};
			var setLabel = function(select) {
					select = $(select);
					var control = select.data('selectBox-control');
					if (!control) return;
					control.find('.selectBox-label').attr('class', getLabelClass(select)).text(getLabelText(select));
				};
			var destroy = function(select) {
					select = $(select);
					var control = select.data('selectBox-control');
					if (!control) return;
					var options = control.data('selectBox-options');
					options.remove();
					control.remove();
					select.removeClass('selectBox').removeData('selectBox-control').data('selectBox-control', null).removeData('selectBox-settings').data('selectBox-settings', null).show();
				};
			var refresh = function(select) {
					select = $(select);
					select.selectBox('options', select.html());
				};
			var showMenu = function(select) {
					select = $(select);
					var control = select.data('selectBox-control'),
						settings = select.data('selectBox-settings'),
						options = control.data('selectBox-options');
					if (control.hasClass('selectBox-disabled')) return false;
					hideMenus();
					var borderBottomWidth = isNaN(control.css('borderBottomWidth')) ? 0 : parseInt(control.css('borderBottomWidth'));
					// Menu position
					options.width(control.innerWidth()).css({
						top: control.offset().top + control.outerHeight() - borderBottomWidth,
						left: control.offset().left
					});
					if (select.triggerHandler('beforeopen')) return false;
					var dispatchOpenEvent = function() {
							select.triggerHandler('open', {
								_selectBox: true
							});
						};
					// Show menu
					switch (settings.menuTransition) {
					case 'fade':
						options.fadeIn(settings.menuSpeed, dispatchOpenEvent);
						break;
					case 'slide':
						options.slideDown(settings.menuSpeed, dispatchOpenEvent);
						break;
					default:
						options.show(settings.menuSpeed, dispatchOpenEvent);
						break;
					}
					if (!settings.menuSpeed) dispatchOpenEvent();
					// Center on selected option
					var li = options.find('.selectBox-selected:first');
					keepOptionInView(select, li, true);
					addHover(select, li);
					control.addClass('selectBox-menuShowing');
					$(document).bind('mousedown.selectBox', function(event) {
						if ($(event.target).parents().andSelf().hasClass('selectBox-options')) return;
						hideMenus();
					});
				};
			var hideMenus = function() {
					if ($(".selectBox-dropdown-menu:visible").length === 0) return;
					$(document).unbind('mousedown.selectBox');
					$(".selectBox-dropdown-menu").each(function() {
						var options = $(this),
							select = options.data('selectBox-select'),
							control = select.data('selectBox-control'),
							settings = select.data('selectBox-settings');
						if (select.triggerHandler('beforeclose')) return false;
						var dispatchCloseEvent = function() {
								select.triggerHandler('close', {
									_selectBox: true
								});
							};
						if (settings) {
							switch (settings.menuTransition) {
							case 'fade':
								options.fadeOut(settings.menuSpeed, dispatchCloseEvent);
								break;
							case 'slide':
								options.slideUp(settings.menuSpeed, dispatchCloseEvent);
								break;
							default:
								options.hide(settings.menuSpeed, dispatchCloseEvent);
								break;
							}
							if (!settings.menuSpeed) dispatchCloseEvent();
							control.removeClass('selectBox-menuShowing');
						} else {
							$(this).hide();
							$(this).triggerHandler('close', {
								_selectBox: true
							});
							$(this).removeClass('selectBox-menuShowing');
						}
					});
				};
			var selectOption = function(select, li, event) {
					select = $(select);
					li = $(li);
					var control = select.data('selectBox-control'),
						settings = select.data('selectBox-settings');
					if (control.hasClass('selectBox-disabled')) return false;
					if (li.length === 0 || li.hasClass('selectBox-disabled')) return false;
					if (select.attr('multiple')) {
						// If event.shiftKey is true, this will select all options between li and the last li selected
						if (event.shiftKey && control.data('selectBox-last-selected')) {
							li.toggleClass('selectBox-selected');
							var affectedOptions;
							if (li.index() > control.data('selectBox-last-selected').index()) {
								affectedOptions = li.siblings().slice(control.data('selectBox-last-selected').index(), li.index());
							} else {
								affectedOptions = li.siblings().slice(li.index(), control.data('selectBox-last-selected').index());
							}
							affectedOptions = affectedOptions.not('.selectBox-optgroup, .selectBox-disabled');
							if (li.hasClass('selectBox-selected')) {
								affectedOptions.addClass('selectBox-selected');
							} else {
								affectedOptions.removeClass('selectBox-selected');
							}
						} else if ((isMac && event.metaKey) || (!isMac && event.ctrlKey)) {
							li.toggleClass('selectBox-selected');
						} else {
							li.siblings().removeClass('selectBox-selected');
							li.addClass('selectBox-selected');
						}
					} else {
						li.siblings().removeClass('selectBox-selected');
						li.addClass('selectBox-selected');
					}
					if (control.hasClass('selectBox-dropdown')) {
						control.find('.selectBox-label').text(li.text());
					}
					// Update original control's value
					var i = 0,
						selection = [];
					if (select.attr('multiple')) {
						control.find('.selectBox-selected A').each(function() {
							selection[i++] = $(this).attr('rel');
						});
					} else {
						selection = li.find('A').attr('rel');
					}
					// Remember most recently selected item
					control.data('selectBox-last-selected', li);
					// Change callback
					if (select.val() !== selection) {
						select.val(selection);
						setLabel(select);
						select.trigger('change');
					}
					return true;
				};
			var addHover = function(select, li) {
					select = $(select);
					li = $(li);
					var control = select.data('selectBox-control'),
						options = control.data('selectBox-options');
					options.find('.selectBox-hover').removeClass('selectBox-hover');
					li.addClass('selectBox-hover');
				};
			var removeHover = function(select, li) {
					select = $(select);
					li = $(li);
					var control = select.data('selectBox-control'),
						options = control.data('selectBox-options');
					options.find('.selectBox-hover').removeClass('selectBox-hover');
				};
			var keepOptionInView = function(select, li, center) {
					if (!li || li.length === 0) return;
					select = $(select);
					var control = select.data('selectBox-control'),
						options = control.data('selectBox-options'),
						scrollBox = control.hasClass('selectBox-dropdown') ? options : options.parent(),
						top = parseInt(li.offset().top - scrollBox.position().top),
						bottom = parseInt(top + li.outerHeight());
					if (center) {
						scrollBox.scrollTop(li.offset().top - scrollBox.offset().top + scrollBox.scrollTop() - (scrollBox.height() / 2));
					} else {
						if (top < 0) {
							scrollBox.scrollTop(li.offset().top - scrollBox.offset().top + scrollBox.scrollTop());
						}
						if (bottom > scrollBox.height()) {
							scrollBox.scrollTop((li.offset().top + li.outerHeight()) - scrollBox.offset().top + scrollBox.scrollTop() - scrollBox.height());
						}
					}
				};
			var handleKeyDown = function(select, event) {
					//
					// Handles open/close and arrow key functionality
					//
					select = $(select);
					var control = select.data('selectBox-control'),
						options = control.data('selectBox-options'),
						settings = select.data('selectBox-settings'),
						totalOptions = 0,
						i = 0;
					if (control.hasClass('selectBox-disabled')) return;
					switch (event.keyCode) {
					case 8:
						// backspace
						event.preventDefault();
						typeSearch = '';
						break;
					case 9:
						// tab
					case 27:
						// esc
						hideMenus();
						removeHover(select);
						break;
					case 13:
						// enter
						if (control.hasClass('selectBox-menuShowing')) {
							selectOption(select, options.find('LI.selectBox-hover:first'), event);
							if (control.hasClass('selectBox-dropdown')) hideMenus();
						} else {
							showMenu(select);
						}
						break;
					case 38:
						// up
					case 37:
						// left
						event.preventDefault();
						if (control.hasClass('selectBox-menuShowing')) {
							var prev = options.find('.selectBox-hover').prev('LI');
							totalOptions = options.find('LI:not(.selectBox-optgroup)').length;
							i = 0;
							while (prev.length === 0 || prev.hasClass('selectBox-disabled') || prev.hasClass('selectBox-optgroup')) {
								prev = prev.prev('LI');
								if (prev.length === 0) {
									if (settings.loopOptions) {
										prev = options.find('LI:last');
									} else {
										prev = options.find('LI:first');
									}
								}
								if (++i >= totalOptions) break;
							}
							addHover(select, prev);
							selectOption(select, prev, event);
							keepOptionInView(select, prev);
						} else {
							showMenu(select);
						}
						break;
					case 40:
						// down
					case 39:
						// right
						event.preventDefault();
						if (control.hasClass('selectBox-menuShowing')) {
							var next = options.find('.selectBox-hover').next('LI');
							totalOptions = options.find('LI:not(.selectBox-optgroup)').length;
							i = 0;
							while (next.length === 0 || next.hasClass('selectBox-disabled') || next.hasClass('selectBox-optgroup')) {
								next = next.next('LI');
								if (next.length === 0) {
									if (settings.loopOptions) {
										next = options.find('LI:first');
									} else {
										next = options.find('LI:last');
									}
								}
								if (++i >= totalOptions) break;
							}
							addHover(select, next);
							selectOption(select, next, event);
							keepOptionInView(select, next);
						} else {
							showMenu(select);
						}
						break;
					}
				};
			var handleKeyPress = function(select, event) {
					//
					// Handles type-to-find functionality
					//
					select = $(select);
					var control = select.data('selectBox-control'),
						options = control.data('selectBox-options');
					if (control.hasClass('selectBox-disabled')) return;
					switch (event.keyCode) {
					case 9:
						// tab
					case 27:
						// esc
					case 13:
						// enter
					case 38:
						// up
					case 37:
						// left
					case 40:
						// down
					case 39:
						// right
						// Don't interfere with the keydown event!
						break;
					default:
						// Type to find
						if (!control.hasClass('selectBox-menuShowing')) showMenu(select);
						event.preventDefault();
						clearTimeout(typeTimer);
						typeSearch += String.fromCharCode(event.charCode || event.keyCode);
						options.find('A').each(function() {
							if ($(this).text().substr(0, typeSearch.length).toLowerCase() === typeSearch.toLowerCase()) {
								addHover(select, $(this).parent());
								keepOptionInView(select, $(this).parent());
								return false;
							}
						});
						// Clear after a brief pause
						typeTimer = setTimeout(function() {
							typeSearch = '';
						}, 1000);
						break;
					}
				};
			var enable = function(select) {
					select = $(select);
					select.attr('disabled', false);
					var control = select.data('selectBox-control');
					if (!control) return;
					control.removeClass('selectBox-disabled');
				};
			var disable = function(select) {
					select = $(select);
					select.attr('disabled', true);
					var control = select.data('selectBox-control');
					if (!control) return;
					control.addClass('selectBox-disabled');
				};
			var setValue = function(select, value) {
					select = $(select);
					select.val(value);
					value = select.val(); // IE9's select would be null if it was set with a non-exist options value
					if (value === null) { // So check it here and set it with the first option's value if possible
						value = select.children().first().val();
						select.val(value);
					}
					var control = select.data('selectBox-control');
					if (!control) return;
					var settings = select.data('selectBox-settings'),
						options = control.data('selectBox-options');
					// Update label
					setLabel(select);
					// Update control values
					options.find('.selectBox-selected').removeClass('selectBox-selected');
					options.find('A').each(function() {
						if (typeof(value) === 'object') {
							for (var i = 0; i < value.length; i++) {
								if ($(this).attr('rel') == value[i]) {
									$(this).parent().addClass('selectBox-selected');
								}
							}
						} else {
							if ($(this).attr('rel') == value) {
								$(this).parent().addClass('selectBox-selected');
							}
						}
					});
					if (settings.change) settings.change.call(select);
				};
			var setOptions = function(select, options) {
					select = $(select);
					var control = select.data('selectBox-control'),
						settings = select.data('selectBox-settings');
					switch (typeof(data)) {
					case 'string':
						select.html(data);
						break;
					case 'object':
						select.html('');
						for (var i in data) {
							if (data[i] === null) continue;
							if (typeof(data[i]) === 'object') {
								var optgroup = $('<optgroup label="' + i + '" />');
								for (var j in data[i]) {
									optgroup.append('<option value="' + j + '">' + data[i][j] + '</option>');
								}
								select.append(optgroup);
							} else {
								var option = $('<option value="' + i + '">' + data[i] + '</option>');
								select.append(option);
							}
						}
						break;
					}
					if (!control) return;
					// Remove old options
					control.data('selectBox-options').remove();
					// Generate new options
					var type = control.hasClass('selectBox-dropdown') ? 'dropdown' : 'inline';
					options = getOptions(select, type);
					control.data('selectBox-options', options);
					switch (type) {
					case 'inline':
						control.append(options);
						break;
					case 'dropdown':
						// Update label
						setLabel(select);
						$("BODY").append(options);
						break;
					}
				};
			var disableSelection = function(selector) {
					$(selector).css('MozUserSelect', 'none').bind('selectstart', function(event) {
						event.preventDefault();
					});
				};
			var generateOptions = function(self, options) {
					var li = $('<li />'),
						a = $('<a />');
					li.addClass(self.attr('class'));
					li.data(self.data());
					a.attr('rel', self.val()).text(self.text());
					li.append(a);
					if (self.attr('disabled')) li.addClass('selectBox-disabled');
					if (self.attr('selected')) li.addClass('selectBox-selected');
					options.append(li);
				};
			//
			// Public methods
			//
			switch (method) {
			case 'control':
				return $(this).data('selectBox-control');
			case 'settings':
				if (!data) return $(this).data('selectBox-settings');
				$(this).each(function() {
					$(this).data('selectBox-settings', $.extend(true, $(this).data('selectBox-settings'), data));
				});
				break;
			case 'options':
				// Getter
				if (data === undefined) return $(this).data('selectBox-control').data('selectBox-options');
				// Setter
				$(this).each(function() {
					setOptions(this, data);
				});
				break;
			case 'value':
				// Empty string is a valid value
				if (data === undefined) return $(this).val();
				$(this).each(function() {
					setValue(this, data);
				});
				break;
			case 'refresh':
				$(this).each(function() {
					refresh(this);
				});
				break;
			case 'enable':
				$(this).each(function() {
					enable(this);
				});
				break;
			case 'disable':
				$(this).each(function() {
					disable(this);
				});
				break;
			case 'destroy':
				$(this).each(function() {
					destroy(this);
				});
				break;
			default:
				$(this).each(function() {
					init(this, method);
				});
				break;
			}
			return $(this);
		}
	});
})(jQuery);

/*
 * simplyScroll 2 - a scroll-tastic jQuery plugin
 *
 * http://logicbox.net/jquery/simplyscroll/
 *
 * Copyright (c) 2009-2012 Will Kelly - http://logicbox.net
 *
 * Dual licensed under the MIT and GPL licenses.
 *
 * Version: 2.0.5 Last revised: 10/05/2012
 *
 */

(function($,window,undefined) {

$.fn.simplyScroll = function(options) {
	return this.each(function() {
		new $.simplyScroll(this,options);
	});
};

var defaults = {
	customClass: 'simply-scroll',
	frameRate: 24, //No of movements per second
	speed: 1, //No of pixels per frame
	orientation: 'horizontal', //'horizontal or 'vertical' - not to be confused with device orientation
	auto: true,
	autoMode: 'loop', //auto = true, 'loop' or 'bounce',
	manualMode: 'end', //auto = false, 'loop' or 'end'
	direction: 'forwards', //'forwards' or 'backwards'.
	pauseOnHover: true, //autoMode = loop|bounce only
	pauseOnTouch: true, //" touch device only
	pauseButton: false, //" generates an extra element to allow manual pausing 
	startOnLoad: false //use this to delay starting of plugin until all page assets have loaded
};
	
$.simplyScroll = function(el,options) {
	
	var self = this;
	
	this.o = $.extend({}, defaults, options || {});
	this.isAuto = this.o.auto!==false && this.o.autoMode.match(/^loop|bounce$/)!==null;
	this.isHorizontal = this.o.orientation.match(/^horizontal|vertical$/)!==null && this.o.orientation==defaults.orientation; 
	this.isRTL = this.isHorizontal && $("html").attr('dir') == 'rtl';
	this.isForwards = !this.isAuto  || (this.isAuto && this.o.direction.match(/^forwards|backwards$/)!==null && this.o.direction==defaults.direction) && !this.isRTL;
	this.isLoop = this.isAuto && this.o.autoMode == 'loop' || !this.isAuto && this.o.manualMode == 'loop';
	
	this.supportsTouch = ('createTouch' in document);
	
	this.events = this.supportsTouch ? 
		{start:'touchstart MozTouchDown',move:'touchmove MozTouchMove',end:'touchend touchcancel MozTouchRelease'} : 
		{start:'mouseenter',end:'mouseleave'};
	
	this.$list = $(el); //called on ul/ol/div etc
	var $items = this.$list.children();
	
	//generate extra markup
	this.$list.addClass('simply-scroll-list')
		.wrap('<div class="simply-scroll-clip"></div>')
		.parent().wrap('<div class="' + this.o.customClass + ' simply-scroll-container"></div>');
	
	if (!this.isAuto) { //button placeholders
		this.$list.parent().parent()
		.prepend('<div class="simply-scroll-forward"></div>')
		.prepend('<div class="simply-scroll-back"></div>');
	} else {
		if (this.o.pauseButton) {
			this.$list.parent().parent()
			.prepend('<div class="simply-scroll-btn simply-scroll-btn-pause"></div>');
			this.o.pauseOnHover = false;
		}
	}
	
	//wrap an extra div around the whole lot if elements scrolled aren't equal
	if ($items.length > 1) {
		
		var extra_wrap = false,
			total = 0;
			
		if (this.isHorizontal) {
			$items.each(function() { total+=$(this).outerWidth(true); });
			extra_wrap = $items.eq(0).outerWidth(true) * $items.length !== total;
		} else {
			$items.each(function() { total+=$(this).outerHeight(true); });
			extra_wrap = $items.eq(0).outerHeight(true) * $items.length !== total;
		}
		
		if (extra_wrap) {
			this.$list = this.$list.wrap('<div></div>').parent().addClass('simply-scroll-list');
			if (this.isHorizontal) {
				this.$list.children().css({"float":'left',width: total + 'px'});	
			} else {
				this.$list.children().css({height: total + 'px'});
			}
		}
	}
	
	if (!this.o.startOnLoad) {
		this.init();
	} else {
		//wait for load before completing setup
		$(window).load(function() { self.init();  });
	}
		
};
	
$.simplyScroll.fn = $.simplyScroll.prototype = {};

$.simplyScroll.fn.extend = $.simplyScroll.extend = $.extend;

$.simplyScroll.fn.extend({
	init: function() {

		this.$items = this.$list.children();
		this.$clip = this.$list.parent(); //this is the element that scrolls
		this.$container = this.$clip.parent();
		this.$btnBack = $('.simply-scroll-back',this.$container);
		this.$btnForward = $('.simply-scroll-forward',this.$container);

		if (!this.isHorizontal) {
			this.itemMax = this.$items.eq(0).outerHeight(true); 
			this.clipMax = this.$clip.height();
			this.dimension = 'height';			
			this.moveBackClass = 'simply-scroll-btn-up';
			this.moveForwardClass = 'simply-scroll-btn-down';
			this.scrollPos = 'Top';
		} else {
			this.itemMax = this.$items.eq(0).outerWidth(true);
			this.clipMax = this.$clip.width();			
			this.dimension = 'width';
			this.moveBackClass = 'simply-scroll-btn-left';
			this.moveForwardClass = 'simply-scroll-btn-right';
			this.scrollPos = 'Left';
		}
		
		this.posMin = 0;
		
		this.posMax = this.$items.length * this.itemMax;
		
		var addItems = Math.ceil(this.clipMax / this.itemMax);
		
		//auto scroll loop & manual scroll bounce or end(to-end)
		if (this.isAuto && this.o.autoMode=='loop') {
			
			this.$list.css(this.dimension,this.posMax+(this.itemMax*addItems) +'px');
			
			this.posMax += (this.clipMax - this.o.speed);
			
			if (this.isForwards) {
				this.$items.slice(0,addItems).clone(true).appendTo(this.$list);
				this.resetPosition = 0;
				
			} else {
				this.$items.slice(-addItems).clone(true).prependTo(this.$list);
				this.resetPosition = this.$items.length * this.itemMax;
				//due to inconsistent RTL implementation force back to LTR then fake
				if (this.isRTL) {
					this.$clip[0].dir = 'ltr';
					//based on feedback seems a good idea to force float right
					this.$items.css('float','right');
				}
			}
		
		//manual and loop
		} else if (!this.isAuto && this.o.manualMode=='loop') {
			
			this.posMax += this.itemMax * addItems;
			
			this.$list.css(this.dimension,this.posMax+(this.itemMax*addItems) +'px');
			
			this.posMax += (this.clipMax - this.o.speed);
			
			var items_append  = this.$items.slice(0,addItems).clone(true).appendTo(this.$list);
			var items_prepend = this.$items.slice(-addItems).clone(true).prependTo(this.$list);
			
			this.resetPositionForwards = this.resetPosition = addItems * this.itemMax;
			this.resetPositionBackwards = this.$items.length * this.itemMax;
			
			//extra events to force scroll direction change
			var self = this;
			
			this.$btnBack.bind(this.events.start,function() {
				self.isForwards = false;
				self.resetPosition = self.resetPositionBackwards;
			});
			
			this.$btnForward.bind(this.events.start,function() {
				self.isForwards = true;
				self.resetPosition = self.resetPositionForwards;
			});
			
		} else { //(!this.isAuto && this.o.manualMode=='end') 
			
			this.$list.css(this.dimension,this.posMax +'px');
			
			if (this.isForwards) {
				this.resetPosition = 0;
				
			} else {
				this.resetPosition = this.$items.length * this.itemMax;
				//due to inconsistent RTL implementation force back to LTR then fake
				if (this.isRTL) {
					this.$clip[0].dir = 'ltr';
					//based on feedback seems a good idea to force float right
					this.$items.css('float','right');
				}
			}
		}
		
		this.resetPos() //ensure scroll position is reset
		
		this.interval = null;	
		this.intervalDelay = Math.floor(1000 / this.o.frameRate);
		
		if (!(!this.isAuto && this.o.manualMode=='end')) { //loop mode
			//ensure that speed is divisible by item width. Helps to always make images even not odd widths!
			while (this.itemMax % this.o.speed !== 0) {
				this.o.speed--;
				if (this.o.speed===0) {
					this.o.speed=1; break;	
				}
			}
		}
		
		var self = this;
		this.trigger = null;
		this.funcMoveBack = function(e) { 
			if (e !== undefined) {
				e.preventDefault();
			}
			self.trigger = !self.isAuto && self.o.manualMode=='end' ? this : null;
			if (self.isAuto) {
				self.isForwards ? self.moveBack() : self.moveForward(); 
			} else {
				self.moveBack();	
			}
		};
		this.funcMoveForward = function(e) { 
			if (e !== undefined) {
				e.preventDefault();
			}
			self.trigger = !self.isAuto && self.o.manualMode=='end' ? this : null;
			if (self.isAuto) {
				self.isForwards ? self.moveForward() : self.moveBack(); 
			} else {
				self.moveForward();	
			}
		};
		this.funcMovePause = function() { self.movePause(); };
		this.funcMoveStop = function() { self.moveStop(); };
		this.funcMoveResume = function() { self.moveResume(); };
		
		
		
		if (this.isAuto) {
			
			this.paused = false;
			
			function togglePause() {
				if (self.paused===false) {
					self.paused=true;
					self.funcMovePause();
				} else {
					self.paused=false;
					self.funcMoveResume();
				}
				return self.paused;
			};
			
			//disable pauseTouch when links are present
			if (this.supportsTouch && this.$items.find('a').length) {
				this.supportsTouch=false;
			}
			
			if (this.isAuto && this.o.pauseOnHover && !this.supportsTouch) {
				this.$clip.bind(this.events.start,this.funcMovePause).bind(this.events.end,this.funcMoveResume);
			} else if (this.isAuto && this.o.pauseOnTouch && !this.o.pauseButton && this.supportsTouch) {
				
				var touchStartPos, scrollStartPos;
				
				this.$clip.bind(this.events.start,function(e) {
					togglePause();
					var touch = e.originalEvent.touches[0];
					touchStartPos = self.isHorizontal ? touch.pageX : touch.pageY;
					scrollStartPos = self.$clip[0]['scroll' + self.scrollPos];
					e.stopPropagation();
					e.preventDefault();
					
				}).bind(this.events.move,function(e) {
					
					e.stopPropagation();
					e.preventDefault();
					
					var touch = e.originalEvent.touches[0],
						endTouchPos = self.isHorizontal ? touch.pageX : touch.pageY,
						pos = (touchStartPos - endTouchPos) + scrollStartPos;
					
					if (pos < 0) pos = 0;
					else if (pos > self.posMax) pos = self.posMax;
					
					self.$clip[0]['scroll' + self.scrollPos] = pos;
					
					//force pause
					self.funcMovePause();
					self.paused = true;
				});	
			} else {
				if (this.o.pauseButton) {
					
					this.$btnPause = $(".simply-scroll-btn-pause",this.$container)
						.bind('click',function(e) {
							e.preventDefault();
							togglePause() ? $(this).addClass('active') : $(this).removeClass('active');
					});
				}
			}
			this.funcMoveForward();
		} else {

			this.$btnBack 
				.addClass('simply-scroll-btn' + ' ' + this.moveBackClass)
				.bind(this.events.start,this.funcMoveBack).bind(this.events.end,this.funcMoveStop);
			this.$btnForward
				.addClass('simply-scroll-btn' + ' ' + this.moveForwardClass)
				.bind(this.events.start,this.funcMoveForward).bind(this.events.end,this.funcMoveStop);
				
			if (this.o.manualMode == 'end') {
				!this.isRTL ? this.$btnBack.addClass('disabled') : this.$btnForward.addClass('disabled');	
			}
		}
	},
	moveForward: function() {
		var self = this;
		this.movement = 'forward';
		if (this.trigger !== null) {
			this.$btnBack.removeClass('disabled');
		}
		self.interval = setInterval(function() {
			if (self.$clip[0]['scroll' + self.scrollPos] < (self.posMax-self.clipMax)) {
				self.$clip[0]['scroll' + self.scrollPos] += self.o.speed;
			} else if (self.isLoop) {
				self.resetPos();
			} else {
				self.moveStop(self.movement);
			}
		},self.intervalDelay);
	},
	moveBack: function() {
		var self = this;
		this.movement = 'back';
		if (this.trigger !== null) {
			this.$btnForward.removeClass('disabled');
		}
		self.interval = setInterval(function() {
			if (self.$clip[0]['scroll' + self.scrollPos] > self.posMin) {
				self.$clip[0]['scroll' + self.scrollPos] -= self.o.speed;
			} else if (self.isLoop) {
				self.resetPos();
			} else {
				self.moveStop(self.movement);
			}
		},self.intervalDelay);
	},
	movePause: function() {
		clearInterval(this.interval);	
	},
	moveStop: function(moveDir) {
		this.movePause();
		if (this.trigger!==null) {
			if (typeof moveDir !== 'undefined') {
				$(this.trigger).addClass('disabled');
			}
			this.trigger = null;
		}
		if (this.isAuto) {
			if (this.o.autoMode=='bounce') {
				moveDir == 'forward' ? this.moveBack() : this.moveForward();
			}
		}
	},
	moveResume: function() {
		this.movement=='forward' ? this.moveForward() : this.moveBack();
	},
	resetPos: function() {
		this.$clip[0]['scroll' + this.scrollPos] = this.resetPosition;
	}
});
		  
})(jQuery,window);

/*global jQuery */
/*jshint multistr:true browser:true */
/*!
* FitVids 1.0
*
* Copyright 2011, Chris Coyier - http://css-tricks.com + Dave Rupert - http://daverupert.com
* Credit to Thierry Koblentz - http://www.alistapart.com/articles/creating-intrinsic-ratios-for-video/
* Released under the WTFPL license - http://sam.zoy.org/wtfpl/
*
* Date: Thu Sept 01 18:00:00 2011 -0500
*/

(function( $ ){

  "use strict";

  $.fn.fitVids = function( options ) {
    var settings = {
      customSelector: null
    };

    var div = document.createElement('div'),
        ref = document.getElementsByTagName('base')[0] || document.getElementsByTagName('script')[0];

    div.className = 'fit-vids-style';
    div.innerHTML = '&shy;<style>         \
      .fluid-width-video-wrapper {        \
         width: 100%;                     \
         position: relative;              \
         padding: 0;                      \
      }                                   \
                                          \
      .fluid-width-video-wrapper iframe,  \
      .fluid-width-video-wrapper object,  \
      .fluid-width-video-wrapper embed {  \
         position: absolute;              \
         top: 0;                          \
         left: 0;                         \
         width: 100%;                     \
         height: 100%;                    \
      }                                   \
    </style>';

    ref.parentNode.insertBefore(div,ref);

    if ( options ) {
      $.extend( settings, options );
    }

    return this.each(function(){
      var selectors = [
        "iframe[src*='player.vimeo.com']",
        "iframe[src*='www.youtube.com']",
        "iframe[src*='www.youtube-nocookie.com']",
        "iframe[src*='www.kickstarter.com']",
        "object",
        "embed"
      ];

      if (settings.customSelector) {
        selectors.push(settings.customSelector);
      }

      var $allVideos = $(this).find(selectors.join(','));

      $allVideos.each(function(){
        var $this = $(this);
        if (this.tagName.toLowerCase() === 'embed' && $this.parent('object').length || $this.parent('.fluid-width-video-wrapper').length) { return; }
        var height = ( this.tagName.toLowerCase() === 'object' || ($this.attr('height') && !isNaN(parseInt($this.attr('height'), 10))) ) ? parseInt($this.attr('height'), 10) : $this.height(),
            width = !isNaN(parseInt($this.attr('width'), 10)) ? parseInt($this.attr('width'), 10) : $this.width(),
            aspectRatio = height / width;
        if(!$this.attr('id')){
          var videoID = 'fitvid' + Math.floor(Math.random()*999999);
          $this.attr('id', videoID);
        }
        $this.wrap('<div class="fluid-width-video-wrapper"></div>').parent('.fluid-width-video-wrapper').css('padding-top', (aspectRatio * 100)+"%");
        $this.removeAttr('height').removeAttr('width');
      });
    });
  };
})( jQuery );

/*
* Copyright (C) 2009 Joel Sutherland
* Licenced under the MIT license
* http://www.newmediacampaigns.com/page/jquery-flickr-plugin
*
* Available tags for templates:
* title, link, date_taken, description, published, author, author_id, tags, image*
*/
(function($){$.fn.jflickrfeed=function(settings,callback){settings=$.extend(true,{flickrbase:'http://api.flickr.com/services/feeds/',feedapi:'photos_public.gne',limit:20,qstrings:{lang:'en-us',format:'json',jsoncallback:'?'},cleanDescription:true,useTemplate:true,itemTemplate:'',itemCallback:function(){}},settings);var url=settings.flickrbase+settings.feedapi+'?';var first=true;for(var key in settings.qstrings){if(!first)
url+='&';url+=key+'='+settings.qstrings[key];first=false;}
return $(this).each(function(){var $container=$(this);var container=this;$.getJSON(url,function(data){$.each(data.items,function(i,item){if(i<settings.limit){if(settings.cleanDescription){var regex=/<p>(.*?)<\/p>/g;var input=item.description;if(regex.test(input)){item.description=input.match(regex)[2]
if(item.description!=undefined)
item.description=item.description.replace('<p>','').replace('</p>','');}}
item['image_s']=item.media.m.replace('_m','_s');item['image_t']=item.media.m.replace('_m','_t');item['image_m']=item.media.m.replace('_m','_m');item['image']=item.media.m.replace('_m','');item['image_b']=item.media.m.replace('_m','_b');delete item.media;if(settings.useTemplate){var template=settings.itemTemplate;for(var key in item){var rgx=new RegExp('{{'+key+'}}','g');template=template.replace(rgx,item[key]);}
$container.append(template)}
settings.itemCallback.call(container,item);}});if($.isFunction(callback)){callback.call(container,data);}});});}})(jQuery);

/*
    RateIt
    version 1.0.9
    10/31/2012
    http://rateit.codeplex.com
    Twitter: @gjunge

*/
(function ($) {
    $.fn.rateit = function (p1, p2) {
        //quick way out.
        var options = {}; var mode = 'init';
        var capitaliseFirstLetter = function (string) {
            return string.charAt(0).toUpperCase() + string.substr(1);
        };

        if (this.length == 0) return this;


        var tp1 = $.type(p1);
        if (tp1 == 'object' || p1 === undefined || p1 == null) {
            options = $.extend({}, $.fn.rateit.defaults, p1); //wants to init new rateit plugin(s).
        }
        else if (tp1 == 'string' && p2 === undefined) {
            return this.data('rateit' + capitaliseFirstLetter(p1)); //wants to get a value.
        }
        else if (tp1 == 'string') {
            mode = 'setvalue'
        }

        return this.each(function () {
            var item = $(this);

            //shorten all the item.data('rateit-XXX'), will save space in closure compiler, will be like item.data('XXX') will become x('XXX')
            var itemdata = function (key, value) {
                arguments[0] = 'rateit' + capitaliseFirstLetter(key);
                return item.data.apply(item, arguments); ////Fix for WI: 523
            };

            //add the rate it class.
            if (!item.hasClass('rateit')) item.addClass('rateit');

            var ltr = item.css('direction') != 'rtl';

            // set value mode
            if (mode == 'setvalue') {
                if (!itemdata('init')) throw 'Can\'t set value before init';


                //if readonly now and it wasn't readonly, remove the eventhandlers.
                if (p1 == 'readonly' && !itemdata('readonly')) {
                    item.find('.rateit-range').unbind();
                    itemdata('wired', false);
                }
                if (p1 == 'value' && p2 == null) p2 = itemdata('min'); //when we receive a null value, reset the score to its min value.

                if (itemdata('backingfld')) {
                    //if we have a backing field, check which fields we should update. 
                    //In case of input[type=range], although we did read its attributes even in browsers that don't support it (using fld.attr())
                    //we only update it in browser that support it (&& fld[0].min only works in supporting browsers), not only does it save us from checking if it is range input type, it also is unnecessary.
                    var fld = $(itemdata('backingfld'));
                    if (p1 == 'value') fld.val(p2);
                    if (p1 == 'min' && fld[0].min) fld[0].min = p2;
                    if (p1 == 'max' && fld[0].max) fld[0].max = p2;
                    if (p1 == 'step' && fld[0].step) fld[0].step = p2;
                }

                itemdata(p1, p2);
            }

            //init rateit plugin
            if (!itemdata('init')) {

                //get our values, either from the data-* html5 attribute or from the options.
                itemdata('min', itemdata('min') || options.min);
                itemdata('max', itemdata('max') || options.max);
                itemdata('step', itemdata('step') || options.step);
                itemdata('readonly', itemdata('readonly') !== undefined ? itemdata('readonly') : options.readonly);
                itemdata('resetable', itemdata('resetable') !== undefined ? itemdata('resetable') : options.resetable);
                itemdata('backingfld', itemdata('backingfld') || options.backingfld);
                itemdata('starwidth', itemdata('starwidth') || options.starwidth);
                itemdata('starheight', itemdata('starheight') || options.starheight);
                itemdata('value', itemdata('value') || options.value || options.min);
                itemdata('ispreset', itemdata('ispreset') !== undefined ? itemdata('ispreset') : options.ispreset);
                //are we LTR or RTL?

                if (itemdata('backingfld')) {
                    //if we have a backing field, hide it, and get its value, and override defaults if range.
                    var fld = $(itemdata('backingfld'));
                    itemdata('value', fld.hide().val());

                    if (fld.attr('disabled') || fld.attr('readonly')) 
                        itemdata('readonly', true); //http://rateit.codeplex.com/discussions/362055 , if a backing field is disabled or readonly at instantiation, make rateit readonly.


                    if (fld[0].nodeName == 'INPUT') {
                        if (fld[0].type == 'range' || fld[0].type == 'text') { //in browsers not support the range type, it defaults to text

                            itemdata('min', parseInt(fld.attr('min')) || itemdata('min')); //if we would have done fld[0].min it wouldn't have worked in browsers not supporting the range type.
                            itemdata('max', parseInt(fld.attr('max')) || itemdata('max'));
                            itemdata('step', parseInt(fld.attr('step')) || itemdata('step'));
                        }
                    }
                    if (fld[0].nodeName == 'SELECT' && fld[0].options.length > 1) {
                        itemdata('min', Number(fld[0].options[0].value));
                        itemdata('max', Number(fld[0].options[fld[0].length - 1].value));
                        itemdata('step', Number(fld[0].options[1].value) - Number(fld[0].options[0].value));
                    }
                }

                //Create the necessary tags.
                item.append('<div class="rateit-reset"></div><div class="rateit-range"><div class="rateit-selected" style="height:' + itemdata('starheight') + 'px"></div><div class="rateit-hover" style="height:' + itemdata('starheight') + 'px"></div></div>');

                //if we are in RTL mode, we have to change the float of the "reset button"
                if (!ltr) {
                    item.find('.rateit-reset').css('float', 'right');
                    item.find('.rateit-selected').addClass('rateit-selected-rtl');
                    item.find('.rateit-hover').addClass('rateit-hover-rtl');
                }

                itemdata('init', true);
            }


            //set the range element to fit all the stars.
            var range = item.find('.rateit-range');
            range.width(itemdata('starwidth') * (itemdata('max') - itemdata('min'))).height(itemdata('starheight'));

            //add/remove the preset class
            var presetclass = 'rateit-preset' + ((ltr) ? '' : '-rtl');
            if (itemdata('ispreset'))
                item.find('.rateit-selected').addClass(presetclass);
            else
                item.find('.rateit-selected').removeClass(presetclass);

            //set the value if we have it.
            if (itemdata('value') != null) {
                var score = (itemdata('value') - itemdata('min')) * itemdata('starwidth');
                item.find('.rateit-selected').width(score);
            }

            var resetbtn = item.find('.rateit-reset');
            if (resetbtn.data('wired') !== true) {
                resetbtn.click(function () {
                    itemdata('value', itemdata('min'));
                    range.find('.rateit-hover').hide().width(0);
                    range.find('.rateit-selected').width(0).show();
                    if (itemdata('backingfld')) $(itemdata('backingfld')).val(itemdata('min'));
                    item.trigger('reset');
                }).data('wired', true);
                
            }
            

            var calcRawScore = function (element, event) {
                var pageX = (event.changedTouches) ? event.changedTouches[0].pageX : event.pageX;

                var offsetx = pageX - $(element).offset().left;
                if (!ltr) offsetx = range.width() - offsetx;
                if (offsetx > range.width()) offsetx = range.width();
                if (offsetx < 0) offsetx = 0;

                return score = Math.ceil(offsetx / itemdata('starwidth') * (1 / itemdata('step')));
            };


            //

            if (!itemdata('readonly')) {
                //if we are not read only, add all the events

                //if we have a reset button, set the event handler.
                if (!itemdata('resetable')) 
                    resetbtn.hide();

                //when the mouse goes over the range div, we set the "hover" stars.
                if (!itemdata('wired')) {
                    range.bind('touchmove touchend', touchHandler); //bind touch events
                    range.mousemove(function (e) {
                        var score = calcRawScore(this, e);
                        var w = score * itemdata('starwidth') * itemdata('step');
                        var h = range.find('.rateit-hover');
                        if (h.data('width') != w) {
                            range.find('.rateit-selected').hide();
                            h.width(w).show().data('width', w);
                            var data = [(score * itemdata('step')) + itemdata('min')];
                            item.trigger('hover', data).trigger('over', data);
                        }
                    });
                    //when the mouse leaves the range, we have to hide the hover stars, and show the current value.
                    range.mouseleave(function (e) {
                        range.find('.rateit-hover').hide().width(0).data('width', '');
                        item.trigger('hover', [null]).trigger('over', [null]);
                        range.find('.rateit-selected').show();
                    });
                    //when we click on the range, we have to set the value, hide the hover.
                    range.mouseup(function (e) {
                        var score = calcRawScore(this, e);

                        var newvalue = (score * itemdata('step')) + itemdata('min');
                        itemdata('value', newvalue);
                        if (itemdata('backingfld')) {
                            $(itemdata('backingfld')).val(newvalue);
                        }
                        if (itemdata('ispreset')) { //if it was a preset value, unset that.
                            range.find('.rateit-selected').removeClass(presetclass);
                            itemdata('ispreset', false);
                        }
                        range.find('.rateit-hover').hide();
                        range.find('.rateit-selected').width(score * itemdata('starwidth') * itemdata('step')).show();
                        item.trigger('hover', [null]).trigger('over', [null]).trigger('rated', [newvalue]);
                    });

                    itemdata('wired', true);
                }
                if (itemdata('resetable')) {
                    resetbtn.show();
                }
            }
            else {
                resetbtn.hide();
            }
        });
    };

    //touch converter http://ross.posterous.com/2008/08/19/iphone-touch-events-in-javascript/
    function touchHandler(event) {

        var touches = event.originalEvent.changedTouches,
                first = touches[0],
                type = "";
        switch (event.type) {
            case "touchmove": type = "mousemove"; break;
            case "touchend": type = "mouseup"; break;
            default: return;
        }

        var simulatedEvent = document.createEvent("MouseEvent");
        simulatedEvent.initMouseEvent(type, true, true, window, 1,
                              first.screenX, first.screenY,
                              first.clientX, first.clientY, false,
                              false, false, false, 0/*left*/, null);

        first.target.dispatchEvent(simulatedEvent);
        event.preventDefault();
    };

    //some default values.
    $.fn.rateit.defaults = { min: 0, max: 5, step: 0.5, starwidth: 16, starheight: 16, readonly: false, resetable: true, ispreset: false };

    //invoke it on all div.rateit elements. This could be removed if not wanted.
    $(function () { $('div.rateit').rateit(); });

})(jQuery);

/********************************************
	-	THEMEPUNCH TOOLS Ver. 1.0     -
	 Last Update of Tools 28.03.2013
*********************************************/

/*!
 * jQuery Transit - CSS3 transitions and transformations
 * Copyright(c) 2011 Rico Sta. Cruz <rico@ricostacruz.com>
 * MIT Licensed.
 *
 * http://ricostacruz.com/jquery.transit
 * http://github.com/rstacruz/jquery.transit
 */

/*!
jQuery WaitForImages

Copyright (c) 2012 Alex Dickson

Permission is hereby granted, free of charge, to any person
obtaining a copy of this software and associated documentation
files (the "Software"), to deal in the Software without
restriction, including without limitation the rights to use,
copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the
Software is furnished to do so, subject to the following
conditions:

The above copyright notice and this permission notice shall be
included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
OTHER DEALINGS IN THE SOFTWARE.


https://github.com/alexanderdickson/waitForImages


 */

// WAIT FOR IMAGES
/*
 * waitForImages 1.4
 * -----------------
 * Provides a callback when all images have loaded in your given selector.
 * http://www.alexanderdickson.com/
 *
 *
 * Copyright (c) 2011 Alex Dickson
 * Licensed under the MIT licenses.
 * See website for more info.
 *
 */

// EASINGS

/*!
 * jQuery Transit - CSS3 transitions and transformations
 * (c) 2011-2012 Rico Sta. Cruz <rico@ricostacruz.com>
 * MIT Licensed.
 *
 * http://ricostacruz.com/jquery.transit
 * http://github.com/rstacruz/jquery.transit
 */
(function(jQuery) {
  jQuery.transit = {
    version: "0.9.9",

    // Map of jQuery.css() keys to values for 'transitionProperty'.
    // See https://developer.mozilla.org/en/CSS/CSS_transitions#Properties_that_can_be_animated
    propertyMap: {
      marginLeft    : 'margin',
      marginRight   : 'margin',
      marginBottom  : 'margin',
      marginTop     : 'margin',
      paddingLeft   : 'padding',
      paddingRight  : 'padding',
      paddingBottom : 'padding',
      paddingTop    : 'padding'
    },

    // Will simply transition "instantly" if false
    enabled: true,

    // Set this to false if you don't want to use the transition end property.
    useTransitionEnd: false
  };

  var div = document.createElement('div');
  var support = {};

  // Helper function to get the proper vendor property name.
  // (`transition` => `WebkitTransition`)
  function getVendorPropertyName(prop) {
    // Handle unprefixed versions (FF16+, for example)
    if (prop in div.style) return prop;

    var prefixes = ['Moz', 'Webkit', 'O', 'ms'];
    var prop_ = prop.charAt(0).toUpperCase() + prop.substr(1);

    if (prop in div.style) { return prop; }

    for (var i=0; i<prefixes.length; ++i) {
      var vendorProp = prefixes[i] + prop_;
      if (vendorProp in div.style) { return vendorProp; }
    }
  }

  // Helper function to check if transform3D is supported.
  // Should return true for Webkits and Firefox 10+.
  function checkTransform3dSupport() {
    div.style[support.transform] = '';
    div.style[support.transform] = 'rotateY(90deg)';
    return div.style[support.transform] !== '';
  }

  var isChrome = navigator.userAgent.toLowerCase().indexOf('chrome') > -1;

  // Check for the browser's transitions support.
  support.transition      = getVendorPropertyName('transition');
  support.transitionDelay = getVendorPropertyName('transitionDelay');
  support.transform       = getVendorPropertyName('transform');
  support.transformOrigin = getVendorPropertyName('transformOrigin');
  support.transform3d     = checkTransform3dSupport();

  var eventNames = {
    'transition':       'transitionEnd',
    'MozTransition':    'transitionend',
    'OTransition':      'oTransitionEnd',
    'WebkitTransition': 'webkitTransitionEnd',
    'msTransition':     'MSTransitionEnd'
  };

  // Detect the 'transitionend' event needed.
  var transitionEnd = support.transitionEnd = eventNames[support.transition] || null;

  // Populate jQuery's `jQuery.support` with the vendor prefixes we know.
  // As per [jQuery's cssHooks documentation](http://api.jquery.com/jQuery.cssHooks/),
  // we set jQuery.support.transition to a string of the actual property name used.
  for (var key in support) {
    if (support.hasOwnProperty(key) && typeof jQuery.support[key] === 'undefined') {
      jQuery.support[key] = support[key];
    }
  }

  // Avoid memory leak in IE.
  div = null;

  // ## jQuery.cssEase
  // List of easing aliases that you can use with `jQuery.fn.transition`.
  jQuery.cssEase = {
    '_default':       'ease',
    'in':             'ease-in',
    'out':            'ease-out',
    'in-out':         'ease-in-out',
    'snap':           'cubic-bezier(0,1,.5,1)',
    // Penner equations
    'easeInCubic':    'cubic-bezier(.55, .055, .675, .19)',
    'easeOutCubic':   'cubic-bezier(.215,.61,.355,1)',
    'easeInOutCubic': 'cubic-bezier(.645,.045,.355,1)',
    'easeInCirc':     'cubic-bezier(.6,.04,.98,.335)',
    'easeOutCirc':    'cubic-bezier(.075,.82,.165,1)',
    'easeInOutCirc':  'cubic-bezier(.785,.135,.15,.86)',
    'easeInExpo':     'cubic-bezier(.95,.05,.795,.035)',
    'easeOutExpo':    'cubic-bezier(.19,1,.22,1)',
    'easeInOutExpo':  'cubic-bezier(1,0,0,1)',
    'easeInQuad':     'cubic-bezier(.55,.085,.68,.53)',
    'easeOutQuad':    'cubic-bezier(.25,.46,.45,.94)',
    'easeInOutQuad':  'cubic-bezier(.455,.03,.515,.955)',
    'easeInQuart':    'cubic-bezier(.895,.03,.685,.22)',
    'easeOutQuart':   'cubic-bezier(.165,.84,.44,1)',
    'easeInOutQuart': 'cubic-bezier(.77,0,.175,1)',
    'easeInQuint':    'cubic-bezier(.755,.05,.855,.06)',
    'easeOutQuint':   'cubic-bezier(.23,1,.32,1)',
    'easeInOutQuint': 'cubic-bezier(.86,0,.07,1)',
    'easeInSine':     'cubic-bezier(.47,0,.745,.715)',
    'easeOutSine':    'cubic-bezier(.39,.575,.565,1)',
    'easeInOutSine':  'cubic-bezier(.445,.05,.55,.95)',
    'easeInBack':     'cubic-bezier(.6,-.28,.735,.045)',
    'easeOutBack':    'cubic-bezier(.175, .885,.32,1.275)',
    'easeInOutBack':  'cubic-bezier(.68,-.55,.265,1.55)'
  };

  // ## 'transform' CSS hook
  // Allows you to use the `transform` property in CSS.
  //
  //     jQuery("#hello").css({ transform: "rotate(90deg)" });
  //
  //     jQuery("#hello").css('transform');
  //     //=> { rotate: '90deg' }
  //
  jQuery.cssHooks['transit:transform'] = {
    // The getter returns a `Transform` object.
    get: function(elem) {
      return jQuery(elem).data('transform') || new Transform();
    },

    // The setter accepts a `Transform` object or a string.
    set: function(elem, v) {
      var value = v;

      if (!(value instanceof Transform)) {
        value = new Transform(value);
      }

      // We've seen the 3D version of Scale() not work in Chrome when the
      // element being scaled extends outside of the viewport.  Thus, we're
      // forcing Chrome to not use the 3d transforms as well.  Not sure if
      // translate is affectede, but not risking it.  Detection code from
      // http://davidwalsh.name/detecting-google-chrome-javascript
      if (support.transform === 'WebkitTransform' && !isChrome) {
        elem.style[support.transform] = value.toString(true);
      } else {
        elem.style[support.transform] = value.toString();
      }

      jQuery(elem).data('transform', value);
    }
  };

  // Add a CSS hook for `.css({ transform: '...' })`.
  // In jQuery 1.8+, this will intentionally override the default `transform`
  // CSS hook so it'll play well with Transit. (see issue #62)
  jQuery.cssHooks.transform = {
    set: jQuery.cssHooks['transit:transform'].set
  };

  // jQuery 1.8+ supports prefix-free transitions, so these polyfills will not
  // be necessary.
  if (jQuery.fn.jquery < "1.8") {
    // ## 'transformOrigin' CSS hook
    // Allows the use for `transformOrigin` to define where scaling and rotation
    // is pivoted.
    //
    //     jQuery("#hello").css({ transformOrigin: '0 0' });
    //
    jQuery.cssHooks.transformOrigin = {
      get: function(elem) {
        return elem.style[support.transformOrigin];
      },
      set: function(elem, value) {
        elem.style[support.transformOrigin] = value;
      }
    };

    // ## 'transition' CSS hook
    // Allows you to use the `transition` property in CSS.
    //
    //     jQuery("#hello").css({ transition: 'all 0 ease 0' });
    //
    jQuery.cssHooks.transition = {
      get: function(elem) {
        return elem.style[support.transition];
      },
      set: function(elem, value) {
        elem.style[support.transition] = value;
      }
    };
  }

  // ## Other CSS hooks
  // Allows you to rotate, scale and translate.
  registerCssHook('scale');
  registerCssHook('translate');
  registerCssHook('rotate');
  registerCssHook('rotateX');
  registerCssHook('rotateY');
  registerCssHook('rotate3d');
  registerCssHook('perspective');
  registerCssHook('skewX');
  registerCssHook('skewY');
  registerCssHook('x', true);
  registerCssHook('y', true);

  // ## Transform class
  // This is the main class of a transformation property that powers
  // `jQuery.fn.css({ transform: '...' })`.
  //
  // This is, in essence, a dictionary object with key/values as `-transform`
  // properties.
  //
  //     var t = new Transform("rotate(90) scale(4)");
  //
  //     t.rotate             //=> "90deg"
  //     t.scale              //=> "4,4"
  //
  // Setters are accounted for.
  //
  //     t.set('rotate', 4)
  //     t.rotate             //=> "4deg"
  //
  // Convert it to a CSS string using the `toString()` and `toString(true)` (for WebKit)
  // functions.
  //
  //     t.toString()         //=> "rotate(90deg) scale(4,4)"
  //     t.toString(true)     //=> "rotate(90deg) scale3d(4,4,0)" (WebKit version)
  //
  function Transform(str) {
    if (typeof str === 'string') { this.parse(str); }
    return this;
  }

  Transform.prototype = {
    // ### setFromString()
    // Sets a property from a string.
    //
    //     t.setFromString('scale', '2,4');
    //     // Same as set('scale', '2', '4');
    //
    setFromString: function(prop, val) {
      var args =
        (typeof val === 'string')  ? val.split(',') :
        (val.constructor === Array) ? val :
        [ val ];

      args.unshift(prop);

      Transform.prototype.set.apply(this, args);
    },

    // ### set()
    // Sets a property.
    //
    //     t.set('scale', 2, 4);
    //
    set: function(prop) {
      var args = Array.prototype.slice.apply(arguments, [1]);
      if (this.setter[prop]) {
        this.setter[prop].apply(this, args);
      } else {
        this[prop] = args.join(',');
      }
    },

    get: function(prop) {
      if (this.getter[prop]) {
        return this.getter[prop].apply(this);
      } else {
        return this[prop] || 0;
      }
    },

    setter: {
      // ### rotate
      //
      //     .css({ rotate: 30 })
      //     .css({ rotate: "30" })
      //     .css({ rotate: "30deg" })
      //     .css({ rotate: "30deg" })
      //
      rotate: function(theta) {
        this.rotate = unit(theta, 'deg');
      },

      rotateX: function(theta) {
        this.rotateX = unit(theta, 'deg');
      },

      rotateY: function(theta) {
        this.rotateY = unit(theta, 'deg');
      },

      // ### scale
      //
      //     .css({ scale: 9 })      //=> "scale(9,9)"
      //     .css({ scale: '3,2' })  //=> "scale(3,2)"
      //
      scale: function(x, y) {
        if (y === undefined) { y = x; }
        this.scale = x + "," + y;
      },

      // ### skewX + skewY
      skewX: function(x) {
        this.skewX = unit(x, 'deg');
      },

      skewY: function(y) {
        this.skewY = unit(y, 'deg');
      },

      // ### perspectvie
      perspective: function(dist) {
        this.perspective = unit(dist, 'px');
      },

      // ### x / y
      // Translations. Notice how this keeps the other value.
      //
      //     .css({ x: 4 })       //=> "translate(4px, 0)"
      //     .css({ y: 10 })      //=> "translate(4px, 10px)"
      //
      x: function(x) {
        this.set('translate', x, null);
      },

      y: function(y) {
        this.set('translate', null, y);
      },

      // ### translate
      // Notice how this keeps the other value.
      //
      //     .css({ translate: '2, 5' })    //=> "translate(2px, 5px)"
      //
      translate: function(x, y) {
        if (this._translateX === undefined) { this._translateX = 0; }
        if (this._translateY === undefined) { this._translateY = 0; }

        if (x !== null && x !== undefined) { this._translateX = unit(x, 'px'); }
        if (y !== null && y !== undefined) { this._translateY = unit(y, 'px'); }

        this.translate = this._translateX + "," + this._translateY;
      }
    },

    getter: {
      x: function() {
        return this._translateX || 0;
      },

      y: function() {
        return this._translateY || 0;
      },

      scale: function() {
        var s = (this.scale || "1,1").split(',');
        if (s[0]) { s[0] = parseFloat(s[0]); }
        if (s[1]) { s[1] = parseFloat(s[1]); }

        // "2.5,2.5" => 2.5
        // "2.5,1" => [2.5,1]
        return (s[0] === s[1]) ? s[0] : s;
      },

      rotate3d: function() {
        var s = (this.rotate3d || "0,0,0,0deg").split(',');
        for (var i=0; i<=3; ++i) {
          if (s[i]) { s[i] = parseFloat(s[i]); }
        }
        if (s[3]) { s[3] = unit(s[3], 'deg'); }

        return s;
      }
    },

    // ### parse()
    // Parses from a string. Called on constructor.
    parse: function(str) {
      var self = this;
      str.replace(/([a-zA-Z0-9]+)\((.*?)\)/g, function(x, prop, val) {
        self.setFromString(prop, val);
      });
    },

    // ### toString()
    // Converts to a `transition` CSS property string. If `use3d` is given,
    // it converts to a `-webkit-transition` CSS property string instead.
    toString: function(use3d) {
      var re = [];

      for (var i in this) {
        if (this.hasOwnProperty(i)) {
          // Don't use 3D transformations if the browser can't support it.
          if ((!support.transform3d) && (
            (i === 'rotateX') ||
            (i === 'rotateY') ||
            (i === 'perspective') ||
            (i === 'transformOrigin'))) { continue; }

          if (i[0] !== '_') {
            if (use3d && (i === 'scale')) {
              re.push(i + "3d(" + this[i] + ",1)");
            } else if (use3d && (i === 'translate')) {
              re.push(i + "3d(" + this[i] + ",0)");
            } else {
              re.push(i + "(" + this[i] + ")");
            }
          }
        }
      }

      return re.join(" ");
    }
  };

  function callOrQueue(self, queue, fn) {
    if (queue === true) {
      self.queue(fn);
    } else if (queue) {
      self.queue(queue, fn);
    } else {
      fn();
    }
  }

  // ### getProperties(dict)
  // Returns properties (for `transition-property`) for dictionary `props`. The
  // value of `props` is what you would expect in `jQuery.css(...)`.
  function getProperties(props) {
    var re = [];

    jQuery.each(props, function(key) {
      key = jQuery.camelCase(key); // Convert "text-align" => "textAlign"
      key = jQuery.transit.propertyMap[key] || jQuery.cssProps[key] || key;
      key = uncamel(key); // Convert back to dasherized

      if (jQuery.inArray(key, re) === -1) { re.push(key); }
    });

    return re;
  }

  // ### getTransition()
  // Returns the transition string to be used for the `transition` CSS property.
  //
  // Example:
  //
  //     getTransition({ opacity: 1, rotate: 30 }, 500, 'ease');
  //     //=> 'opacity 500ms ease, -webkit-transform 500ms ease'
  //
  function getTransition(properties, duration, easing, delay) {
    // Get the CSS properties needed.
    var props = getProperties(properties);

    // Account for aliases (`in` => `ease-in`).
    if (jQuery.cssEase[easing]) { easing = jQuery.cssEase[easing]; }

    // Build the duration/easing/delay attributes for it.
    var attribs = '' + toMS(duration) + ' ' + easing;
    if (parseInt(delay, 10) > 0) { attribs += ' ' + toMS(delay); }

    // For more properties, add them this way:
    // "margin 200ms ease, padding 200ms ease, ..."
    var transitions = [];
    jQuery.each(props, function(i, name) {
      transitions.push(name + ' ' + attribs);
    });

    return transitions.join(', ');
  }

  // ## jQuery.fn.transition
  // Works like jQuery.fn.animate(), but uses CSS transitions.
  //
  //     jQuery("...").transition({ opacity: 0.1, scale: 0.3 });
  //
  //     // Specific duration
  //     jQuery("...").transition({ opacity: 0.1, scale: 0.3 }, 500);
  //
  //     // With duration and easing
  //     jQuery("...").transition({ opacity: 0.1, scale: 0.3 }, 500, 'in');
  //
  //     // With callback
  //     jQuery("...").transition({ opacity: 0.1, scale: 0.3 }, function() { ... });
  //
  //     // With everything
  //     jQuery("...").transition({ opacity: 0.1, scale: 0.3 }, 500, 'in', function() { ... });
  //
  //     // Alternate syntax
  //     jQuery("...").transition({
  //       opacity: 0.1,
  //       duration: 200,
  //       delay: 40,
  //       easing: 'in',
  //       complete: function() { /* ... */ }
  //      });
  //
  jQuery.fn.transition = jQuery.fn.transit = function(properties, duration, easing, callback) {
    var self  = this;
    var delay = 0;
    var queue = true;

    var theseProperties = jQuery.extend(true, {}, properties);

    // Account for `.transition(properties, callback)`.
    if (typeof duration === 'function') {
      callback = duration;
      duration = undefined;
    }

    // Account for `.transition(properties, options)`.
    if (typeof duration === 'object') {
      easing = duration.easing;
      delay = duration.delay || 0;
      queue = duration.queue || true;
      callback = duration.complete;
      duration = duration.duration;
    }

    // Account for `.transition(properties, duration, callback)`.
    if (typeof easing === 'function') {
      callback = easing;
      easing = undefined;
    }

    // Alternate syntax.
    if (typeof theseProperties.easing !== 'undefined') {
      easing = theseProperties.easing;
      delete theseProperties.easing;
    }

    if (typeof theseProperties.duration !== 'undefined') {
      duration = theseProperties.duration;
      delete theseProperties.duration;
    }

    if (typeof theseProperties.complete !== 'undefined') {
      callback = theseProperties.complete;
      delete theseProperties.complete;
    }

    if (typeof theseProperties.queue !== 'undefined') {
      queue = theseProperties.queue;
      delete theseProperties.queue;
    }

    if (typeof theseProperties.delay !== 'undefined') {
      delay = theseProperties.delay;
      delete theseProperties.delay;
    }

    // Set defaults. (`400` duration, `ease` easing)
    if (typeof duration === 'undefined') { duration = jQuery.fx.speeds._default; }
    if (typeof easing === 'undefined')   { easing = jQuery.cssEase._default; }

    duration = toMS(duration);

    // Build the `transition` property.
    var transitionValue = getTransition(theseProperties, duration, easing, delay);

    // Compute delay until callback.
    // If this becomes 0, don't bother setting the transition property.
    var work = jQuery.transit.enabled && support.transition;
    var i = work ? (parseInt(duration, 10) + parseInt(delay, 10)) : 0;

    // If there's nothing to do...
    if (i === 0) {
      var fn = function(next) {
        self.css(theseProperties);
        if (callback) { callback.apply(self); }
        if (next) { next(); }
      };

      callOrQueue(self, queue, fn);
      return self;
    }

    // Save the old transitions of each element so we can restore it later.
    var oldTransitions = {};

    var run = function(nextCall) {
      var bound = false;

      // Prepare the callback.
      var cb = function() {
        if (bound) { self.unbind(transitionEnd, cb); }

        if (i > 0) {
          self.each(function() {
            this.style[support.transition] = (oldTransitions[this] || null);
          });
        }

        if (typeof callback === 'function') { callback.apply(self); }
        if (typeof nextCall === 'function') { nextCall(); }
      };

      if ((i > 0) && (transitionEnd) && (jQuery.transit.useTransitionEnd)) {
        // Use the 'transitionend' event if it's available.
        bound = true;
        self.bind(transitionEnd, cb);
      } else {
        // Fallback to timers if the 'transitionend' event isn't supported.
        window.setTimeout(cb, i);
      }

      // Apply transitions.
      self.each(function() {
        if (i > 0) {
          this.style[support.transition] = transitionValue;
        }
        jQuery(this).css(properties);
      });
    };

    // Defer running. This allows the browser to paint any pending CSS it hasn't
    // painted yet before doing the transitions.
    var deferredRun = function(next) {
        this.offsetWidth; // force a repaint
        run(next);
    };

    // Use jQuery's fx queue.
    callOrQueue(self, queue, deferredRun);

    // Chainability.
    return this;
  };

  function registerCssHook(prop, isPixels) {
    // For certain properties, the 'px' should not be implied.
    if (!isPixels) { jQuery.cssNumber[prop] = true; }

    jQuery.transit.propertyMap[prop] = support.transform;

    jQuery.cssHooks[prop] = {
      get: function(elem) {
        var t = jQuery(elem).css('transit:transform');
        return t.get(prop);
      },

      set: function(elem, value) {
        var t = jQuery(elem).css('transit:transform');
        t.setFromString(prop, value);

        jQuery(elem).css({ 'transit:transform': t });
      }
    };

  }

  // ### uncamel(str)
  // Converts a camelcase string to a dasherized string.
  // (`marginLeft` => `margin-left`)
  function uncamel(str) {
    return str.replace(/([A-Z])/g, function(letter) { return '-' + letter.toLowerCase(); });
  }

  // ### unit(number, unit)
  // Ensures that number `number` has a unit. If no unit is found, assume the
  // default is `unit`.
  //
  //     unit(2, 'px')          //=> "2px"
  //     unit("30deg", 'rad')   //=> "30deg"
  //
  function unit(i, units) {
    if ((typeof i === "string") && (!i.match(/^[\-0-9\.]+$/))) {
      return i;
    } else {
      return "" + i + units;
    }
  }

  // ### toMS(duration)
  // Converts given `duration` to a millisecond string.
  //
  // toMS('fast') => jQuery.fx.speeds[i] => "200ms"
  // toMS('normal') //=> jQuery.fx.speeds._default => "400ms"
  // toMS(10) //=> '10ms'
  // toMS('100ms') //=> '100ms'
  //
  function toMS(duration) {
    var i = duration;

    // Allow string durations like 'fast' and 'slow', without overriding numeric values.
    if (typeof i === 'string' && (!i.match(/^[\-0-9\.]+/))) { i = jQuery.fx.speeds[i] || jQuery.fx.speeds._default; }

    return unit(i, 'ms');
  }

  // Export some functions for testable-ness.
  jQuery.transit.getTransitionValue = getTransition;
})(jQuery);

(function(e,t){
	jQuery.easing["jswing"]=jQuery.easing["swing"];
	jQuery.extend(jQuery.easing,{def:"easeOutQuad",swing:function(e,t,n,r,i){return jQuery.easing[jQuery.easing.def](e,t,n,r,i)},easeInQuad:function(e,t,n,r,i){return r*(t/=i)*t+n},easeOutQuad:function(e,t,n,r,i){return-r*(t/=i)*(t-2)+n},easeInOutQuad:function(e,t,n,r,i){if((t/=i/2)<1)return r/2*t*t+n;return-r/2*(--t*(t-2)-1)+n},easeInCubic:function(e,t,n,r,i){return r*(t/=i)*t*t+n},easeOutCubic:function(e,t,n,r,i){return r*((t=t/i-1)*t*t+1)+n},easeInOutCubic:function(e,t,n,r,i){if((t/=i/2)<1)return r/2*t*t*t+n;return r/2*((t-=2)*t*t+2)+n},easeInQuart:function(e,t,n,r,i){return r*(t/=i)*t*t*t+n},easeOutQuart:function(e,t,n,r,i){return-r*((t=t/i-1)*t*t*t-1)+n},easeInOutQuart:function(e,t,n,r,i){if((t/=i/2)<1)return r/2*t*t*t*t+n;return-r/2*((t-=2)*t*t*t-2)+n},easeInQuint:function(e,t,n,r,i){return r*(t/=i)*t*t*t*t+n},easeOutQuint:function(e,t,n,r,i){return r*((t=t/i-1)*t*t*t*t+1)+n},easeInOutQuint:function(e,t,n,r,i){if((t/=i/2)<1)return r/2*t*t*t*t*t+n;return r/2*((t-=2)*t*t*t*t+2)+n},easeInSine:function(e,t,n,r,i){return-r*Math.cos(t/i*(Math.PI/2))+r+n},easeOutSine:function(e,t,n,r,i){return r*Math.sin(t/i*(Math.PI/2))+n},easeInOutSine:function(e,t,n,r,i){return-r/2*(Math.cos(Math.PI*t/i)-1)+n},easeInExpo:function(e,t,n,r,i){return t==0?n:r*Math.pow(2,10*(t/i-1))+n},easeOutExpo:function(e,t,n,r,i){return t==i?n+r:r*(-Math.pow(2,-10*t/i)+1)+n},easeInOutExpo:function(e,t,n,r,i){if(t==0)return n;if(t==i)return n+r;if((t/=i/2)<1)return r/2*Math.pow(2,10*(t-1))+n;return r/2*(-Math.pow(2,-10*--t)+2)+n},easeInCirc:function(e,t,n,r,i){return-r*(Math.sqrt(1-(t/=i)*t)-1)+n},easeOutCirc:function(e,t,n,r,i){return r*Math.sqrt(1-(t=t/i-1)*t)+n},easeInOutCirc:function(e,t,n,r,i){if((t/=i/2)<1)return-r/2*(Math.sqrt(1-t*t)-1)+n;return r/2*(Math.sqrt(1-(t-=2)*t)+1)+n},easeInElastic:function(e,t,n,r,i){var s=1.70158;var o=0;var u=r;if(t==0)return n;if((t/=i)==1)return n+r;if(!o)o=i*.3;if(u<Math.abs(r)){u=r;var s=o/4}else var s=o/(2*Math.PI)*Math.asin(r/u);return-(u*Math.pow(2,10*(t-=1))*Math.sin((t*i-s)*2*Math.PI/o))+n},easeOutElastic:function(e,t,n,r,i){var s=1.70158;var o=0;var u=r;if(t==0)return n;if((t/=i)==1)return n+r;if(!o)o=i*.3;if(u<Math.abs(r)){u=r;var s=o/4}else var s=o/(2*Math.PI)*Math.asin(r/u);return u*Math.pow(2,-10*t)*Math.sin((t*i-s)*2*Math.PI/o)+r+n},easeInOutElastic:function(e,t,n,r,i){var s=1.70158;var o=0;var u=r;if(t==0)return n;if((t/=i/2)==2)return n+r;if(!o)o=i*.3*1.5;if(u<Math.abs(r)){u=r;var s=o/4}else var s=o/(2*Math.PI)*Math.asin(r/u);if(t<1)return-.5*u*Math.pow(2,10*(t-=1))*Math.sin((t*i-s)*2*Math.PI/o)+n;return u*Math.pow(2,-10*(t-=1))*Math.sin((t*i-s)*2*Math.PI/o)*.5+r+n},easeInBack:function(e,t,n,r,i,s){if(s==undefined)s=1.70158;return r*(t/=i)*t*((s+1)*t-s)+n},easeOutBack:function(e,t,n,r,i,s){if(s==undefined)s=1.70158;return r*((t=t/i-1)*t*((s+1)*t+s)+1)+n},easeInOutBack:function(e,t,n,r,i,s){if(s==undefined)s=1.70158;if((t/=i/2)<1)return r/2*t*t*(((s*=1.525)+1)*t-s)+n;return r/2*((t-=2)*t*(((s*=1.525)+1)*t+s)+2)+n},easeInBounce:function(e,t,n,r,i){return r-jQuery.easing.easeOutBounce(e,i-t,0,r,i)+n},easeOutBounce:function(e,t,n,r,i){if((t/=i)<1/2.75){return r*7.5625*t*t+n}else if(t<2/2.75){return r*(7.5625*(t-=1.5/2.75)*t+.75)+n}else if(t<2.5/2.75){return r*(7.5625*(t-=2.25/2.75)*t+.9375)+n}else{return r*(7.5625*(t-=2.625/2.75)*t+.984375)+n}},easeInOutBounce:function(e,t,n,r,i){if(t<i/2)return jQuery.easing.easeInBounce(e,t*2,0,r,i)*.5+n;return jQuery.easing.easeOutBounce(e,t*2-i,0,r,i)*.5+r*.5+n}});
					e.waitForImages={hasImageProperties:["backgroundImage","listStyleImage","borderImage","borderCornerImage"]};e.expr[":"].uncached=function(t){var n=document.createElement("img");n.src=t.src;return e(t).is('img[src!=""]')&&!n.complete};e.fn.waitForImages=function(t,n,r){if(e.isPlainObject(arguments[0])){n=t.each;r=t.waitForAll;t=t.finished}t=t||e.noop;n=n||e.noop;r=!!r;if(!e.isFunction(t)||!e.isFunction(n)){throw new TypeError("An invalid callback was supplied.")}return this.each(function(){var i=e(this),s=[];if(r){var o=e.waitForImages.hasImageProperties||[],u=/url\((['"]?)(.*?)\1\)/g;i.find("*").each(function(){var t=e(this);if(t.is("img:uncached")){s.push({src:t.attr("src"),element:t[0]})}e.each(o,function(e,n){var r=t.css(n);if(!r){return true}var i;while(i=u.exec(r)){s.push({src:i[2],element:t[0]})}})})}else{i.find("img:uncached").each(function(){s.push({src:this.src,element:this})})}var f=s.length,l=0;if(f==0){t.call(i[0])}e.each(s,function(r,s){var o=new Image;e(o).bind("load error",function(e){l++;n.call(s.element,l,f,e.type=="load");if(l==f){t.call(i[0]);return false}});o.src=s.src})})};
					e.fn.swipe=function(t){if(!this)return false;var n={fingers:1,threshold:75,swipe:null,swipeLeft:null,swipeRight:null,swipeUp:null,swipeDown:null,swipeStatus:null,click:null,triggerOnTouchEnd:true,allowPageScroll:"auto"};var r="left";var i="right";var s="up";var o="down";var u="none";var f="horizontal";var l="vertical";var c="auto";var h="start";var p="move";var d="end";var v="cancel";var m="ontouchstart"in window,g=m?"touchstart":"mousedown",y=m?"touchmove":"mousemove",b=m?"touchend":"mouseup",w="touchcancel";var E="start";if(t.allowPageScroll==undefined&&(t.swipe!=undefined||t.swipeStatus!=undefined))t.allowPageScroll=u;if(t)e.extend(n,t);return this.each(function(){function t(){var e=S();if(e<=45&&e>=0)return r;else if(e<=360&&e>=315)return r;else if(e>=135&&e<=225)return i;else if(e>45&&e<135)return o;else return s}function S(){var e=H.x-B.x;var t=B.y-H.y;var n=Math.atan2(t,e);var r=Math.round(n*180/Math.PI);if(r<0)r=360-Math.abs(r);return r}function x(){return Math.round(Math.sqrt(Math.pow(B.x-H.x,2)+Math.pow(B.y-H.y,2)))}function T(e,t){if(n.allowPageScroll==u){e.preventDefault()}else{var a=n.allowPageScroll==c;switch(t){case r:if(n.swipeLeft&&a||!a&&n.allowPageScroll!=f)e.preventDefault();break;case i:if(n.swipeRight&&a||!a&&n.allowPageScroll!=f)e.preventDefault();break;case s:if(n.swipeUp&&a||!a&&n.allowPageScroll!=l)e.preventDefault();break;case o:if(n.swipeDown&&a||!a&&n.allowPageScroll!=l)e.preventDefault();break}}}function N(e,t){if(n.swipeStatus)n.swipeStatus.call(_,e,t,direction||null,distance||0);if(t==v){if(n.click&&(P==1||!m)&&(isNaN(distance)||distance==0))n.click.call(_,e,e.target)}if(t==d){if(n.swipe){n.swipe.call(_,e,direction,distance)}switch(direction){case r:if(n.swipeLeft)n.swipeLeft.call(_,e,direction,distance);break;case i:if(n.swipeRight)n.swipeRight.call(_,e,direction,distance);break;case s:if(n.swipeUp)n.swipeUp.call(_,e,direction,distance);break;case o:if(n.swipeDown)n.swipeDown.call(_,e,direction,distance);break}}}function C(e){P=0;H.x=0;H.y=0;B.x=0;B.y=0;F.x=0;F.y=0}function L(e){e.preventDefault();distance=x();direction=t();if(n.triggerOnTouchEnd){E=d;if((P==n.fingers||!m)&&B.x!=0){if(distance>=n.threshold){N(e,E);C(e)}else{E=v;N(e,E);C(e)}}else{E=v;N(e,E);C(e)}}else if(E==p){E=v;N(e,E);C(e)}M.removeEventListener(y,A,false);M.removeEventListener(b,L,false)}function A(e){if(E==d||E==v)return;var r=m?e.touches[0]:e;B.x=r.pageX;B.y=r.pageY;direction=t();if(m){P=e.touches.length}E=p;T(e,direction);if(P==n.fingers||!m){distance=x();if(n.swipeStatus)N(e,E,direction,distance);if(!n.triggerOnTouchEnd){if(distance>=n.threshold){E=d;N(e,E);C(e)}}}else{E=v;N(e,E);C(e)}}function O(e){var t=m?e.touches[0]:e;E=h;if(m){P=e.touches.length}distance=0;direction=null;if(P==n.fingers||!m){H.x=B.x=t.pageX;H.y=B.y=t.pageY;if(n.swipeStatus)N(e,E)}else{C(e)}M.addEventListener(y,A,false);M.addEventListener(b,L,false)}var M=this;var _=e(this);var D=null;var P=0;var H={x:0,y:0};var B={x:0,y:0};var F={x:0,y:0};try{this.addEventListener(g,O,false);this.addEventListener(w,C)}catch(I){}})}
	})(jQuery);

// SOME ERROR MESSAGES IN CASE THE PLUGIN CAN NOT BE LOADED
function revslider_showDoubleJqueryError(sliderID) {
	var errorMessage = "Revolution Slider Error: You have some jquery.js library include that comes after the revolution files js include.";
	errorMessage += "<br> This includes make eliminates the revolution slider libraries, and make it not work.";
	errorMessage += "<br><br> To fix it you can:<br>&nbsp;&nbsp;&nbsp; 1. In the Slider Settings -> Troubleshooting set option:  <strong><b>Put JS Includes To Body</b></strong> option to true.";
	errorMessage += "<br>&nbsp;&nbsp;&nbsp; 2. Find the double jquery.js include and remove it.";
	errorMessage = "<span style='font-size:16px;color:#BC0C06;'>" + errorMessage + "</span>"
		jQuery(sliderID).show().html(errorMessage);
}



/**************************************************************************
 * jquery.themepunch.revolution.js - jQuery Plugin for Revolution Slider
 * @version: 3.0.8 (06.08.2013)
 * @requires jQuery v1.7 or later (tested on 1.9)
 * @author ThemePunch
**************************************************************************/


(function(jQuery,undefined){


	////////////////////////////////////////
	// THE REVOLUTION PLUGIN STARTS HERE //
	///////////////////////////////////////

	jQuery.fn.extend({

		// OUR PLUGIN HERE :)
		revolution: function(options) {



				////////////////////////////////
				// SET DEFAULT VALUES OF ITEM //
				////////////////////////////////
				jQuery.fn.revolution.defaults = {
					delay:9000,
					startheight:500,
					startwidth:960,

					hideThumbs:200,

					thumbWidth:100,							// Thumb With and Height and Amount (only if navigation Tyope set to thumb !)
					thumbHeight:50,
					thumbAmount:5,

					navigationType:"bullet",				// bullet, thumb, none
					navigationArrows:"withbullet",			// nextto, solo, none

					navigationStyle:"round",				// round,square,navbar,round-old,square-old,navbar-old, or any from the list in the docu (choose between 50+ different item),

					navigationHAlign:"center",				// Vertical Align top,center,bottom
					navigationVAlign:"bottom",					// Horizontal Align left,center,right
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

					touchenabled:"on",						// Enable Swipe Function : on/off
					onHoverStop:"on",						// Stop Banner Timet at Hover on Slide on/off


					stopAtSlide:-1,							// Stop Timer if Slide "x" has been Reached. If stopAfterLoops set to 0, then it stops already in the first Loop at slide X which defined. -1 means do not stop at any slide. stopAfterLoops has no sinn in this case.
					stopAfterLoops:-1,						// Stop Timer if All slides has been played "x" times. IT will stop at THe slide which is defined via stopAtSlide:x, if set to -1 slide never stop automatic

					hideCaptionAtLimit:0,					// It Defines if a caption should be shown under a Screen Resolution ( Basod on The Width of Browser)
					hideAllCaptionAtLilmit:0,				// Hide all The Captions if Width of Browser is less then this value
					hideSliderAtLimit:0,					// Hide the whole slider, and stop also functions if Width of Browser is less than this value

					shadow:1,								//0 = no Shadow, 1,2,3 = 3 Different Art of Shadows  (No Shadow in Fullwidth Version !)
					fullWidth:"off",						// Turns On or Off the Fullwidth Image Centering in FullWidth Modus
					fullScreen:"off",

				};

					options = jQuery.extend({}, jQuery.fn.revolution.defaults, options);




					return this.each(function() {

						var opt=options;
						var container=jQuery(this);
						if (!container.hasClass("revslider-initialised")) {

									container.addClass("revslider-initialised");
									if (container.attr('id')==undefined) container.attr('id',"revslider-"+Math.round(Math.random()*1000+5));

									// CHECK IF FIREFOX 13 IS ON WAY.. IT HAS A STRANGE BUG, CSS ANIMATE SHOULD NOT BE USED



									opt.firefox13 = false;
									opt.ie = !jQuery.support.opacity;
									opt.ie9 = (document.documentMode == 9);


									// CHECK THE jQUERY VERSION
									var version = jQuery.fn.jquery.split('.'),
										versionTop = parseFloat(version[0]),
										versionMinor = parseFloat(version[1]),
										versionIncrement = parseFloat(version[2] || '0');

									if (versionTop==1 && versionMinor < 7) {
										container.html('<div style="text-align:center; padding:40px 0px; font-size:20px; color:#992222;"> The Current Version of jQuery:'+version+' <br>Please update your jQuery Version to min. 1.7 in Case you wish to use the Revolution Slider Plugin</div>');
									}

									if (versionTop>1) opt.ie=false;


									// Delegate .transition() calls to .animate()
									// if the browser can't do CSS transitions.
									if (!jQuery.support.transition)
										jQuery.fn.transition = jQuery.fn.animate;




									jQuery.cssEase['Bounce'] = 'cubic-bezier(0,1,0.5,1.3)';

									// CATCH THE CONTAINER
									//var container=jQuery(this);
									//container.css({'display':'block'});

									 // LOAD THE YOUTUBE API IF NECESSARY

									container.find('.caption').each(function() { jQuery(this).addClass('tp-caption')});
									
									if (is_mobile()) {
										container.find('.tp-caption').each(function() {
											if (jQuery(this).data('autoplay')==true) jQuery(this).data('autoplay',false);
										})
									}
									
									
									var addedyt=0;
									var addedvim=0;
									var addedvid=0;
									container.find('.tp-caption iframe').each(function(i) {
										try {

												if (jQuery(this).attr('src').indexOf('you')>0 && addedyt==0) {
													addedyt=1;
													var s = document.createElement("script");
													s.src = "http://www.youtube.com/player_api"; /* Load Player API*/
													var before = document.getElementsByTagName("script")[0];
													before.parentNode.insertBefore(s, before);
												}
											} catch(e) {}
									});



									 // LOAD THE VIMEO API
									 container.find('.tp-caption iframe').each(function(i) {
										try{
												if (jQuery(this).attr('src').indexOf('vim')>0 && addedvim==0) {
													addedvim=1;
													var f = document.createElement("script");
													f.src = "http://a.vimeocdn.com/js/froogaloop2.min.js"; /* Load Player API*/
													var before = document.getElementsByTagName("script")[0];
													before.parentNode.insertBefore(f, before);
												}
											} catch(e) {}
									});

									// LOAD THE VIDEO.JS API IF NEEDED
									container.find('.tp-caption video').each(function(i) {
										try{
												if (jQuery(this).hasClass('video-js') && addedvid==0) {
													addedvid=1;
													var f = document.createElement("script");
													f.src = opt.videoJsPath+"video.js"; /* Load Player API*/
													var before = document.getElementsByTagName("script")[0];
													before.parentNode.insertBefore(f, before);
													jQuery('head').append('<link rel="stylesheet" type="text/css" href="'+opt.videoJsPath+'video-js.min.css" media="screen" />');
													jQuery('head').append('<script> videojs.options.flash.swf = "'+opt.videoJsPath+'video-js.swf";</script>');
												}
											} catch(e) {}
									});

									// SHUFFLE MODE
									if (opt.shuffle=="on") {
										for (var u=0;u<container.find('>ul:first-child >li').length;u++) {
											var it = Math.round(Math.random()*container.find('>ul:first-child >li').length);
											container.find('>ul:first-child >li:eq('+it+')').prependTo(container.find('>ul:first-child'));
										}
									}


									// CREATE SOME DEFAULT OPTIONS FOR LATER
									opt.slots=4;
									opt.act=-1;
									opt.next=0;

									// IF START SLIDE IS SET
									if (opt.startWithSlide !=undefined) opt.next=opt.startWithSlide;

									// IF DEEPLINK HAS BEEN SET
									var deeplink = getUrlVars("#")[0];
									if (deeplink.length<9) {
										if (deeplink.split('slide').length>1) {
											var dslide=parseInt(deeplink.split('slide')[1],0);
											if (dslide<1) dslide=1;
											if (dslide>container.find('>ul:first >li').length) dslide=container.find('>ul:first >li').length;
											opt.next=dslide-1;
										}
									}


									opt.origcd=opt.delay;

									opt.firststart=1;






									// BASIC OFFSET POSITIONS OF THE BULLETS
									if (opt.navigationHOffset==undefined) opt.navOffsetHorizontal=0;
									if (opt.navigationVOffset==undefined) opt.navOffsetVertical=0;





									container.append('<div class="tp-loader"></div>');

									// RESET THE TIMER
									if (container.find('.tp-bannertimer').length==0) container.append('<div class="tp-bannertimer" style="visibility:hidden"></div>');
									var bt=container.find('.tp-bannertimer');
									if (bt.length>0) {
										bt.css({'width':'0%'});
									};


									// WE NEED TO ADD A BASIC CLASS FOR SETTINGS.CSS
									container.addClass("tp-simpleresponsive");
									opt.container=container;

									//if (container.height()==0) container.height(opt.startheight);

									// AMOUNT OF THE SLIDES
									opt.slideamount = container.find('>ul:first >li').length;


									// A BASIC GRID MUST BE DEFINED. IF NO DEFAULT GRID EXIST THAN WE NEED A DEFAULT VALUE, ACTUAL SIZE OF CONAINER
									if (container.height()==0) container.height(opt.startheight);
									if (opt.startwidth==undefined || opt.startwidth==0) opt.startwidth=container.width();
									if (opt.startheight==undefined || opt.startheight==0) opt.startheight=container.height();

									// OPT WIDTH && HEIGHT SHOULD BE SET
									opt.width=container.width();
									opt.height=container.height();


									// DEFAULT DEPENDECIES
									opt.bw = opt.startwidth / container.width();
									opt.bh = opt.startheight / container.height();

									// IF THE ITEM ALREADY IN A RESIZED FORM
									if (opt.width!=opt.startwidth) {

										opt.height = Math.round(opt.startheight * (opt.width/opt.startwidth));
										container.height(opt.height);

									}

									// LETS SEE IF THERE IS ANY SHADOW
									if (opt.shadow!=0) {
										container.parent().append('<div class="tp-bannershadow tp-shadow'+opt.shadow+'"></div>');

										container.parent().find('.tp-bannershadow').css({'width':opt.width});
									}


									container.find('ul').css({'display':'none'});


									if (opt.lazyLoad!="on") {
										  // IF IMAGES HAS BEEN LOADED
										  container.waitForImages(function() {
												// PREPARE THE SLIDES
												container.find('ul').css({'display':'block'});
												prepareSlides(container,opt);

												// CREATE BULLETS
												if (opt.slideamount >1) createBullets(container,opt);
												if (opt.slideamount >1) createThumbs(container,opt);
												if (opt.slideamount >1) createArrows(container,opt);

												jQuery('#unvisible_button').click(function() {

														opt.navigationArrows=jQuery('.selectnavarrows').val();
														opt.navigationType=jQuery('.selectnavtype').val();
														opt.navigationStyle = jQuery('.selectnavstyle').val();
														opt.soloArrowStyle = "default";

														jQuery('.tp-bullets').remove();
														jQuery('.tparrows').remove();

														if (opt.slideamount >1) createBullets(container,opt);
														if (opt.slideamount >1) createThumbs(container,opt);
														if (opt.slideamount >1) createArrows(container,opt);

												});


												swipeAction(container,opt);

												if (opt.hideThumbs>0) hideThumbs(container,opt);


												container.waitForImages(function() {
													// START THE FIRST SLIDE

													container.find('.tp-loader').fadeOut(600);
													setTimeout(function() {

														swapSlide(container,opt);
														// START COUNTDOWN
														if (opt.slideamount >1) countDown(container,opt);
														container.trigger('revolution.slide.onloaded');
													},600);

												});


											});
									} else {		// IF LAZY LOAD IS ACTIVATED
											var fli = container.find('ul >li >img').first();
											if (fli.data('lazyload')!=undefined) fli.attr('src',fli.data('lazyload'));
											fli.data('lazydone',1);
											fli.parent().waitForImages(function() {

												// PREPARE THE SLIDES
												container.find('ul').css({'display':'block'});
												prepareSlides(container,opt);

												// CREATE BULLETS
												if (opt.slideamount >1) createBullets(container,opt);
												if (opt.slideamount >1) createThumbs(container,opt);
												if (opt.slideamount >1) createArrows(container,opt);

												swipeAction(container,opt);

												if (opt.hideThumbs>0) hideThumbs(container,opt);

												fli.parent().waitForImages(function() {
													// START THE FIRST SLIDE

													container.find('.tp-loader').fadeOut(600);
													setTimeout(function() {

														swapSlide(container,opt);
														// START COUNTDOWN
														if (opt.slideamount >1) countDown(container,opt);
														container.trigger('revolution.slide.onloaded');
													},600);
												});
											});
									}



									// IF RESIZED, NEED TO STOP ACTUAL TRANSITION AND RESIZE ACTUAL IMAGES
									jQuery(window).resize(function() {
										if (jQuery('body').find(container)!=0)
											if (container.outerWidth(true)!=opt.width) {
													containerResized(container,opt);
											}
									});


									// CHECK IF THE CAPTION IS A "SCROLL ME TO POSITION" CAPTION IS
									//if (opt.fullScreen=="on") {
										container.find('.tp-scrollbelowslider').on('click',function() {
												var off=0;
												try{
												 	off = jQuery('body').find(opt.fullScreenOffsetContainer).height();
												 } catch(e) {}
												try{
												 	off = off - jQuery(this).data('scrolloffset');
												 } catch(e) {}

												jQuery('body,html').animate(
													{scrollTop:(container.offset().top+(container.find('>ul >li').height())-off)+"px"},{duration:400});
											});
									//}
						}

					})
				},


		// METHODE PAUSE
		revscroll: function(oy) {
					return this.each(function() {
						var container=jQuery(this);
						jQuery('body,html').animate(
							{scrollTop:(container.offset().top+(container.find('>ul >li').height())-oy)+"px"},{duration:400});
					})
				},

		// METHODE PAUSE
		revpause: function(options) {

					return this.each(function() {
						var container=jQuery(this);
						container.data('conthover',1);
						container.data('conthover-changed',1);
						container.trigger('revolution.slide.onpause');
						var bt = container.parent().find('.tp-bannertimer');
						bt.stop();

					})


				},

		// METHODE RESUME
		revresume: function(options) {
					return this.each(function() {
						var container=jQuery(this);
						container.data('conthover',0);
						container.data('conthover-changed',1);
						container.trigger('revolution.slide.onresume');
						var bt = container.parent().find('.tp-bannertimer');
						var opt = bt.data('opt');

						bt.animate({'width':"100%"},{duration:((opt.delay-opt.cd)-100),queue:false, easing:"linear"});
					})

				},

		// METHODE NEXT
		revnext: function(options) {
					return this.each(function() {
						// CATCH THE CONTAINER
						var container=jQuery(this);
						container.parent().find('.tp-rightarrow').click();


					})

				},

		// METHODE RESUME
		revprev: function(options) {
					return this.each(function() {
						// CATCH THE CONTAINER
						var container=jQuery(this);
						container.parent().find('.tp-leftarrow').click();
					})

				},

		// METHODE LENGTH
		revmaxslide: function(options) {
						// CATCH THE CONTAINER
						return jQuery(this).find('>ul:first-child >li').length;
				},


		// METHODE CURRENT
		revcurrentslide: function(options) {
						// CATCH THE CONTAINER
						var container=jQuery(this);
						var bt = container.parent().find('.tp-bannertimer');
						var opt = bt.data('opt');
						return opt.act;
				},

		// METHODE CURRENT
		revlastslide: function(options) {
						// CATCH THE CONTAINER
						var container=jQuery(this);
						var bt = container.parent().find('.tp-bannertimer');
						var opt = bt.data('opt');
						return opt.lastslide;
				},


		// METHODE JUMP TO SLIDE
		revshowslide: function(slide) {
					return this.each(function() {
						// CATCH THE CONTAINER
						var container=jQuery(this);
						container.data('showus',slide);
						container.parent().find('.tp-rightarrow').click();
					})

				}


})


		///////////////////////////
		// GET THE URL PARAMETER //
		///////////////////////////
		function getUrlVars(hashdivider)
			{
				var vars = [], hash;
				var hashes = window.location.href.slice(window.location.href.indexOf(hashdivider) + 1).split('_');
				for(var i = 0; i < hashes.length; i++)
				{
					hashes[i] = hashes[i].replace('%3D',"=");
					hash = hashes[i].split('=');
					vars.push(hash[0]);
					vars[hash[0]] = hash[1];
				}
				return vars;
			}

		//////////////////////////
		//	CONTAINER RESIZED	//
		/////////////////////////
		function containerResized(container,opt) {


			container.find('.defaultimg').each(function(i) {
						var img = jQuery(this);
						

						if ((img.data('lazyload') !=undefined && img.data('lazydone') ==1) || img.data('lazyload') ===undefined) 						
								setSize(img,opt);							

						opt.height = Math.round(opt.startheight * (opt.width/opt.startwidth));

						container.height(opt.height);

						if ((img.data('lazyload') !=undefined && img.data('lazydone') ==1) || img.data('lazyload') ===undefined) 
								setSize(img,opt);


						try{
							container.parent().find('.tp-bannershadow').css({'width':opt.width});
						} catch(e) {}

						var actsh = container.find('>ul >li:eq('+opt.act+') .slotholder');
						var nextsh = container.find('>ul >li:eq('+opt.next+') .slotholder');
						removeSlots(container,opt);
						nextsh.find('.defaultimg').css({'opacity':0});
						actsh.find('.defaultimg').css({'opacity':1});

						setCaptionPositions(container,opt);

						var nextli = container.find('>ul >li:eq('+opt.next+')');
						container.find('.tp-caption').each(function() { jQuery(this).stop(true,true);});
						animateTheCaptions(nextli, opt);

						restartBannerTimer(opt,container);

				});
		}


		//////////////////
		// IS MOBILE ?? //
		//////////////////
		function is_mobile() {
		    var agents = ['android', 'webos', 'iphone', 'ipad', 'blackberry','Android', 'webos', ,'iPod', 'iPhone', 'iPad', 'Blackberry', 'BlackBerry'];
			var ismobile=false;
		    for(i in agents) {

			    if (navigator.userAgent.split(agents[i]).length>1) {
		            ismobile = true;
        				
		          }
		    }
		    return ismobile;
		}


		////////////////////////////////
		//	RESTART THE BANNER TIMER //
		//////////////////////////////
		function restartBannerTimer(opt,container) {
						opt.cd=0;
						if (opt.videoplaying !=true) {
							var bt=	container.find('.tp-bannertimer');
								if (bt.length>0) {
									bt.stop();
									bt.css({'width':'0%'});
									bt.animate({'width':"100%"},{duration:(opt.delay-100),queue:false, easing:"linear"});
								}
							clearTimeout(opt.thumbtimer);
							opt.thumbtimer = setTimeout(function() {
								moveSelectedThumb(container);
								setBulPos(container,opt);
							},200);
						}
		}

		////////////////////////////////
		//	RESTART THE BANNER TIMER //
		//////////////////////////////
		function killBannerTimer(opt,container) {
						opt.cd=0;

							var bt=	container.find('.tp-bannertimer');
								if (bt.length>0) {
									bt.stop(true,true);
									bt.css({'width':'0%'});
									//bt.animate({'width':"100%"},{duration:(opt.delay-100),queue:false, easing:"linear"});
								}
							clearTimeout(opt.thumbtimer);

		}

		function callingNewSlide(opt,container) {
						opt.cd=0;
						swapSlide(container,opt);

						// STOP TIMER AND RESCALE IT
							var bt=	container.find('.tp-bannertimer');
							if (bt.length>0) {
								bt.stop();
								bt.css({'width':'0%'});
								bt.animate({'width':"100%"},{duration:(opt.delay-100),queue:false, easing:"linear"});
							}
		}



		////////////////////////////////
		//	-	CREATE THE BULLETS -  //
		////////////////////////////////
		function createThumbs(container,opt) {

			var cap=container.parent();

			if (opt.navigationType=="thumb" || opt.navsecond=="both") {
						cap.append('<div class="tp-bullets tp-thumbs '+opt.navigationStyle+'"><div class="tp-mask"><div class="tp-thumbcontainer"></div></div></div>');
			}
			var bullets = cap.find('.tp-bullets.tp-thumbs .tp-mask .tp-thumbcontainer');
			var bup = bullets.parent();

			bup.width(opt.thumbWidth*opt.thumbAmount);
			bup.height(opt.thumbHeight);
			bup.parent().width(opt.thumbWidth*opt.thumbAmount);
			bup.parent().height(opt.thumbHeight);

			container.find('>ul:first >li').each(function(i) {
							var li= container.find(">ul:first >li:eq("+i+")");
							if (li.data('thumb') !=undefined)
								var src= li.data('thumb')
							else
								var src=li.find("img:first").attr('src');
							bullets.append('<div class="bullet thumb"><img src="'+src+'"></div>');
							var bullet= bullets.find('.bullet:first');
				});
			//bullets.append('<div style="clear:both"></div>');
			var minwidth=100;


			// ADD THE BULLET CLICK FUNCTION HERE
			bullets.find('.bullet').each(function(i) {
				var bul = jQuery(this);

				if (i==opt.slideamount-1) bul.addClass('last');
				if (i==0) bul.addClass('first');
				bul.width(opt.thumbWidth);
				bul.height(opt.thumbHeight);
				if (minwidth>bul.outerWidth(true)) minwidth=bul.outerWidth(true);

				bul.click(function() {
					if (opt.transition==0 && bul.index() != opt.act) {
						opt.next = bul.index();
						callingNewSlide(opt,container);
					}
				});
			});


			var max=minwidth*container.find('>ul:first >li').length;

			var thumbconwidth=bullets.parent().width();
			opt.thumbWidth = minwidth;



				////////////////////////
				// SLIDE TO POSITION  //
				////////////////////////
				if (thumbconwidth<max) {
					jQuery(document).mousemove(function(e) {
						jQuery('body').data('mousex',e.pageX);
					});



					// ON MOUSE MOVE ON THE THUMBNAILS EVERYTHING SHOULD MOVE :)

					bullets.parent().mouseenter(function() {
							var $this=jQuery(this);
							$this.addClass("over");
							var offset = $this.offset();
							var x = jQuery('body').data('mousex')-offset.left;
							var thumbconwidth=$this.width();
							var minwidth=$this.find('.bullet:first').outerWidth(true);
							var max=minwidth*container.find('>ul:first >li').length;
							var diff=(max- thumbconwidth)+15;
							var steps = diff / thumbconwidth;
							x=x-30;
							//if (x<30) x=0;
							//if (x>thumbconwidth-30) x=thumbconwidth;

							//ANIMATE TO POSITION
							var pos=(0-((x)*steps));
							if (pos>0) pos =0;
							if (pos<0-max+thumbconwidth) pos=0-max+thumbconwidth;
							moveThumbSliderToPosition($this,pos,200);
					});

					bullets.parent().mousemove(function() {

									var $this=jQuery(this);

									//if (!$this.hasClass("over")) {
											var offset = $this.offset();
											var x = jQuery('body').data('mousex')-offset.left;
											var thumbconwidth=$this.width();
											var minwidth=$this.find('.bullet:first').outerWidth(true);
											var max=minwidth*container.find('>ul:first >li').length;
											var diff=(max- thumbconwidth)+15;
											var steps = diff / thumbconwidth;
											x=x-30;
											//if (x<30) x=0;
											//if (x>thumbconwidth-30) x=thumbconwidth;

											//ANIMATE TO POSITION
											var pos=(0-((x)*steps));
											if (pos>0) pos =0;
											if (pos<0-max+thumbconwidth) pos=0-max+thumbconwidth;
											moveThumbSliderToPosition($this,pos,0);
									//} else {
										//$this.removeClass("over");
									//}

					});

					bullets.parent().mouseleave(function() {
									var $this=jQuery(this);
									$this.removeClass("over");
									moveSelectedThumb(container);
					});
				}


		}


		///////////////////////////////
		//	SelectedThumbInPosition //
		//////////////////////////////
		function moveSelectedThumb(container) {

									var bullets=container.parent().find('.tp-bullets.tp-thumbs .tp-mask .tp-thumbcontainer');
									var $this=bullets.parent();
									var offset = $this.offset();
									var minwidth=$this.find('.bullet:first').outerWidth(true);

									var x = $this.find('.bullet.selected').index() * minwidth;
									var thumbconwidth=$this.width();
									var minwidth=$this.find('.bullet:first').outerWidth(true);
									var max=minwidth*container.find('>ul:first >li').length;
									var diff=(max- thumbconwidth);
									var steps = diff / thumbconwidth;

									//ANIMATE TO POSITION
									var pos=0-x;

									if (pos>0) pos =0;
									if (pos<0-max+thumbconwidth) pos=0-max+thumbconwidth;
									if (!$this.hasClass("over")) {
										moveThumbSliderToPosition($this,pos,200);
									}
		}


		////////////////////////////////////
		//	MOVE THUMB SLIDER TO POSITION //
		///////////////////////////////////
		function moveThumbSliderToPosition($this,pos,speed) {
			$this.stop();
			$this.find('.tp-thumbcontainer').animate({'left':pos+'px'},{duration:speed,queue:false});
		}



		////////////////////////////////
		//	-	CREATE THE BULLETS -  //
		////////////////////////////////
		function createBullets(container,opt) {

			if (opt.navigationType=="bullet"  || opt.navigationType=="both") {
						container.parent().append('<div class="tp-bullets simplebullets '+opt.navigationStyle+'"></div>');
			}


			var bullets = container.parent().find('.tp-bullets');

			container.find('>ul:first >li').each(function(i) {
							var src=container.find(">ul:first >li:eq("+i+") img:first").attr('src');
							bullets.append('<div class="bullet"></div>');
							var bullet= bullets.find('.bullet:first');


				});

			// ADD THE BULLET CLICK FUNCTION HERE
			bullets.find('.bullet').each(function(i) {
				var bul = jQuery(this);
				if (i==opt.slideamount-1) bul.addClass('last');
				if (i==0) bul.addClass('first');

				bul.click(function() {
					var sameslide = false;
					if (opt.navigationArrows=="withbullet" || opt.navigationArrows=="nexttobullets") {
						if (bul.index()-1 == opt.act) sameslide=true;
					} else {
						if (bul.index() == opt.act) sameslide=true;
					}

					if (opt.transition==0 && !sameslide) {

					if (opt.navigationArrows=="withbullet" || opt.navigationArrows=="nexttobullets") {
							opt.next = bul.index()-1;
					} else {
							opt.next = bul.index();
					}

						callingNewSlide(opt,container);
					}
				});

			});

			bullets.append('<div class="tpclear"></div>');



			setBulPos(container,opt);





		}

		//////////////////////
		//	CREATE ARROWS	//
		/////////////////////
		function createArrows(container,opt) {

						var bullets = container.find('.tp-bullets');

						var hidden="";
						var arst= opt.navigationStyle;
						if (opt.navigationArrows=="none") hidden="visibility:none";
						opt.soloArrowStyle = "default";

						if (opt.navigationArrows!="none" && opt.navigationArrows!="nexttobullets") arst = opt.soloArrowStyle;

						container.parent().append('<div style="'+hidden+'" class="tp-leftarrow tparrows '+arst+'"></div>');
						container.parent().append('<div style="'+hidden+'" class="tp-rightarrow tparrows '+arst+'"></div>');

						// 	THE LEFT / RIGHT BUTTON CLICK !	 //
						container.parent().find('.tp-rightarrow').click(function() {

							if (opt.transition==0) {
									if (container.data('showus') !=undefined && container.data('showus') != -1)
										opt.next = container.data('showus')-1;
									else
										opt.next = opt.next+1;
									container.data('showus',-1);
									if (opt.next >= opt.slideamount) opt.next=0;
									if (opt.next<0) opt.next=0;

									if (opt.act !=opt.next)
										callingNewSlide(opt,container);
							}
						});

						container.parent().find('.tp-leftarrow').click(function() {
							if (opt.transition==0) {
									opt.next = opt.next-1;
									opt.leftarrowpressed=1;
									if (opt.next < 0) opt.next=opt.slideamount-1;
									callingNewSlide(opt,container);
							}
						});

						setBulPos(container,opt);

		}

		////////////////////////////
		// SET THE SWIPE FUNCTION //
		////////////////////////////
		function swipeAction(container,opt) {
			// TOUCH ENABLED SCROLL

				if (opt.touchenabled=="on")
						container.swipe( {data:container,
										swipeRight:function()
												{

													if (opt.transition==0) {
															opt.next = opt.next-1;
															opt.leftarrowpressed=1;
															if (opt.next < 0) opt.next=opt.slideamount-1;
															callingNewSlide(opt,container);
													}
												},
										swipeLeft:function()
												{

													if (opt.transition==0) {
															opt.next = opt.next+1;
															if (opt.next == opt.slideamount) opt.next=0;
															callingNewSlide(opt,container);
													}
												},
									allowPageScroll:"auto"} );
		}




		////////////////////////////////////////////////////////////////
		// SHOW AND HIDE THE THUMBS IF MOUE GOES OUT OF THE BANNER  ///
		//////////////////////////////////////////////////////////////
		function hideThumbs(container,opt) {

			var bullets = container.parent().find('.tp-bullets');
			var ca = container.parent().find('.tparrows');

			if (bullets==null) {
				container.append('<div class=".tp-bullets"></div>');
				var bullets = container.parent().find('.tp-bullets');
			}

			if (ca==null) {
				container.append('<div class=".tparrows"></div>');
				var ca = container.parent().find('.tparrows');
			}


			//var bp = (thumbs.parent().outerHeight(true) - opt.height)/2;

			//	ADD THUMBNAIL IMAGES FOR THE BULLETS //
			container.data('hidethumbs',opt.hideThumbs);

			bullets.addClass("hidebullets");
			ca.addClass("hidearrows");

			bullets.hover(function() {
				bullets.addClass("hovered");
				clearTimeout(container.data('hidethumbs'));
				bullets.removeClass("hidebullets");
				ca.removeClass("hidearrows");
			},
			function() {

				bullets.removeClass("hovered");
				if (!container.hasClass("hovered") && !bullets.hasClass("hovered"))
					container.data('hidethumbs', setTimeout(function() {
					bullets.addClass("hidebullets");
					ca.addClass("hidearrows");
					},opt.hideThumbs));
			});


			ca.hover(function() {
				bullets.addClass("hovered");
				clearTimeout(container.data('hidethumbs'));
				bullets.removeClass("hidebullets");
				ca.removeClass("hidearrows");

			},
			function() {

				bullets.removeClass("hovered");
				/*if (!container.hasClass("hovered") && !bullets.hasClass("hovered"))
					container.data('hidethumbs', setTimeout(function() {
							bullets.addClass("hidebullets");
							ca.addClass("hidearrows");
					},opt.hideThumbs));*/
			});



			container.on('mouseenter', function() {
				container.addClass("hovered");
				clearTimeout(container.data('hidethumbs'));
				bullets.removeClass("hidebullets");
				ca.removeClass("hidearrows");
			});

			container.on('mouseleave', function() {
				container.removeClass("hovered");
				if (!container.hasClass("hovered") && !bullets.hasClass("hovered"))
					container.data('hidethumbs', setTimeout(function() {
							bullets.addClass("hidebullets");
							ca.addClass("hidearrows");
					},opt.hideThumbs));
			});

		}







		//////////////////////////////
		//	SET POSITION OF BULLETS	//
		//////////////////////////////
		function setBulPos(container,opt) {
			var topcont=container.parent();
			var bullets=topcont.find('.tp-bullets');
			var tl = topcont.find('.tp-leftarrow');
			var tr = topcont.find('.tp-rightarrow');

			if (opt.navigationType=="thumb" && opt.navigationArrows=="nexttobullets") opt.navigationArrows="solo";
			// IM CASE WE HAVE NAVIGATION BULLETS TOGETHER WITH ARROWS
			if (opt.navigationArrows=="nexttobullets") {
				tl.prependTo(bullets).css({'float':'left'});
				tr.insertBefore(bullets.find('.tpclear')).css({'float':'left'});
			}


			if (opt.navigationArrows!="none" && opt.navigationArrows!="nexttobullets") {

				tl.css({'position':'absolute'});
				tr.css({'position':'absolute'});

				if (opt.soloArrowLeftValign=="center")	tl.css({'top':'50%','marginTop':(opt.soloArrowLeftVOffset-Math.round(tl.innerHeight()/2))+"px"});
				if (opt.soloArrowLeftValign=="bottom")	tl.css({'top':'auto','bottom':(0+opt.soloArrowLeftVOffset)+"px"});
				if (opt.soloArrowLeftValign=="top")	 	tl.css({'bottom':'auto','top':(0+opt.soloArrowLeftVOffset)+"px"});
				if (opt.soloArrowLeftHalign=="center")	tl.css({'left':'50%','marginLeft':(opt.soloArrowLeftHOffset-Math.round(tl.innerWidth()/2))+"px"});
				if (opt.soloArrowLeftHalign=="left")	tl.css({'left':(0+opt.soloArrowLeftHOffset)+"px"});
				if (opt.soloArrowLeftHalign=="right")	tl.css({'right':(0+opt.soloArrowLeftHOffset)+"px"});

				if (opt.soloArrowRightValign=="center")	tr.css({'top':'50%','marginTop':(opt.soloArrowRightVOffset-Math.round(tr.innerHeight()/2))+"px"});
				if (opt.soloArrowRightValign=="bottom")	tr.css({'top':'auto','bottom':(0+opt.soloArrowRightVOffset)+"px"});
				if (opt.soloArrowRightValign=="top")	tr.css({'bottom':'auto','top':(0+opt.soloArrowRightVOffset)+"px"});
				if (opt.soloArrowRightHalign=="center")	tr.css({'left':'50%','marginLeft':(opt.soloArrowRightHOffset-Math.round(tr.innerWidth()/2))+"px"});
				if (opt.soloArrowRightHalign=="left")	tr.css({'left':(0+opt.soloArrowRightHOffset)+"px"});
				if (opt.soloArrowRightHalign=="right")	tr.css({'right':(0+opt.soloArrowRightHOffset)+"px"});


				if (tl.position()!=null)
					tl.css({'top':Math.round(parseInt(tl.position().top,0))+"px"});

				if (tr.position()!=null)
					tr.css({'top':Math.round(parseInt(tr.position().top,0))+"px"});
			}

			if (opt.navigationArrows=="none") {
				tl.css({'visibility':'hidden'});
				tr.css({'visibility':'hidden'});
			}

			// SET THE POSITIONS OF THE BULLETS // THUMBNAILS


			if (opt.navigationVAlign=="center")	 bullets.css({'top':'50%','marginTop':(opt.navigationVOffset-Math.round(bullets.innerHeight()/2))+"px"});
			if (opt.navigationVAlign=="bottom")	 bullets.css({'bottom':(0+opt.navigationVOffset)+"px"});
			if (opt.navigationVAlign=="top")	 bullets.css({'top':(0+opt.navigationVOffset)+"px"});


			if (opt.navigationHAlign=="center")	bullets.css({'left':'50%','marginLeft':(opt.navigationHOffset-Math.round(bullets.innerWidth()/2))+"px"});
			if (opt.navigationHAlign=="left")	bullets.css({'left':(0+opt.navigationHOffset)+"px"});
			if (opt.navigationHAlign=="right")	bullets.css({'right':(0+opt.navigationHOffset)+"px"});



		}



		//////////////////////////////////////////////////////////
		//	-	SET THE IMAGE SIZE TO FIT INTO THE CONTIANER -  //
		////////////////////////////////////////////////////////
		function setSize(img,opt) {


						
						opt.width=parseInt(opt.container.width(),0);
						opt.height=parseInt(opt.container.height(),0);


						opt.bw = (opt.width / opt.startwidth);

						if (opt.fullScreen=="on") {
							opt.height = opt.bw * opt.startheight;
						}
						opt.bh = (opt.height / opt.startheight);



							 if (opt.bh>1) {
											opt.bh=1;
											opt.bw=1;
									}


						// IF IMG IS ALREADY PREPARED, WE RESET THE SIZE FIRST HERE

						if ((img.data('lazyload') !=undefined && img.data('lazydone') ==1) || img.data('lazyload') ===undefined) {
							if (img.data('orgw')!=undefined && img.data('orgw')!=0) {
								img.width(img.data('orgw'));
								img.height(img.data('orgh'));
							}
						}

						var fw = opt.width / img.width();
						var fh = opt.height / img.height();


						opt.fw = fw;
						opt.fh = fh;


						if ((img.data('lazyload') !=undefined && img.data('lazydone') ==1) || img.data('lazyload') ===undefined) {
							if (img.data('orgw')==undefined || img.data('orgw')==0) {
								

								img.data('orgw',img.width());
								img.data('orgh',img.height());

							}
						}




						if (opt.fullWidth=="on" && opt.fullScreen!="on") {

								var cow = opt.container.parent().width();
								var coh = opt.container.parent().height();
								var ffh = coh / img.data('orgh');
								var ffw = cow / img.data('orgw');


								if ((img.data('lazyload') !=undefined && img.data('lazydone') ==1) || img.data('lazyload') ===undefined) {
									img.width(img.width()*ffh);
									img.height(coh);
								}

								if (img.width()<cow) {
									img.width(cow+50);
									var ffw = img.width() / img.data('orgw');
									img.height(img.data('orgh')*ffw);

								}

								if (img.width()>cow) {
									img.data("fxof",(cow/2 - img.width()/2));
									img.css({'position':'absolute','left':img.data('fxof')+"px"});

								}


								if (img.height()<=coh) {
									img.data('fyof',0);
									img.data("fxof",(cow/2 - img.width()/2));
									img.css({'position':'absolute','top':img.data('fyof')+"px",'left':img.data('fxof')+"px"});

								}


								if (img.height()>coh && img.data('fullwidthcentering')=="on") {
									img.data('fyof',(coh/2 - img.height()/2));
									img.data("fxof",(cow/2 - img.width()/2));
									img.css({'position':'absolute','top':img.data('fyof')+"px",'left':img.data('fxof')+"px"});

								 }
								 


						} else

					    if (opt.fullScreen=="on") {

								var cow = opt.container.parent().width();


								var coh = jQuery(window).height();

								// IF THE DEFAULT GRID IS HIGHER THEN THE CALCULATED SLIDER HEIGHT, WE NEED TO RESIZE THE SLIDER HEIGHT
								var offsety = coh/2 - (opt.startheight*opt.bh)/2;
								if (offsety<0) coh=opt.startheight*opt.bh;


								if (opt.fullScreenOffsetContainer!=undefined) {
									try{
										coh = coh - jQuery(opt.fullScreenOffsetContainer).outerHeight(true);
									} catch(e) {}
								}


								opt.container.parent().height(coh);
								opt.container.css({'height':'100%'});

								opt.height=coh;


								var ffh = coh / img.data('orgh');
								var ffw = cow / img.data('orgw');


								if ((img.data('lazyload') !=undefined && img.data('lazydone') ==1) || img.data('lazyload') ===undefined) {
									img.width(img.width()*ffh);
									img.height(coh);
								}


								if (img.width()<cow) {
									img.width(cow+50);
									var ffw = img.width() / img.data('orgw');
									img.height(img.data('orgh')*ffw);

								}

								if (img.width()>cow) {
									img.data("fxof",(cow/2 - img.width()/2));
									img.css({'position':'absolute','left':img.data('fxof')+"px"});

								}


								if (img.height()<=coh) {
									img.data('fyof',0);
									img.data("fxof",(cow/2 - img.width()/2));
									img.css({'position':'absolute','top':img.data('fyof')+"px",'left':img.data('fxof')+"px"});

								}


								if (img.height()>coh && img.data('fullwidthcentering')=="on") {
									img.data('fyof',(coh/2 - img.height()/2));
									img.data("fxof",(cow/2 - img.width()/2));
									img.css({'position':'absolute','top':img.data('fyof')+"px",'left':img.data('fxof')+"px"});

								 }

								 

								 
						}  else {
								if ((img.data('lazyload') !=undefined && img.data('lazydone') ==1) || img.data('lazyload') ===undefined) {
									img.width(opt.width);
									img.height(img.height()*fw);
								}

								if (img.height()<opt.height && img.height()!=0 && img.height()!=null) {

									if ((img.data('lazyload') !=undefined && img.data('lazydone') ==1) || img.data('lazyload') ===undefined) {
										img.height(opt.height);
										img.width(img.data('orgw')*fh);
									}
								}
								

						}



					
						
						if ((img.data('lazyload') !=undefined && img.data('lazydone') ==1) || img.data('lazyload') ===undefined) {

							img.data('neww',img.width());
							img.data('newh',img.height());
						}
						
						if (opt.fullWidth=="on") {
							opt.slotw=Math.ceil(img.width()/opt.slots);
						} else {
							opt.slotw=Math.ceil(opt.width/opt.slots);
						}

						if (opt.fullSreen=="on")
							opt.sloth=Math.ceil(jQuery(window).height()/opt.slots);
						else
							opt.sloth=Math.ceil(opt.height/opt.slots);

		}




		/////////////////////////////////////////
		//	-	PREPARE THE SLIDES / SLOTS -  //
		///////////////////////////////////////
		function prepareSlides(container,opt) {

			container.find('.tp-caption').each(function() { jQuery(this).addClass(jQuery(this).data('transition')); jQuery(this).addClass('start') });
			// PREPARE THE UL CONTAINER TO HAVEING MAX HEIGHT AND HEIGHT FOR ANY SITUATION
			container.find('>ul:first').css({overflow:'hidden',width:'100%',height:'100%',maxHeight:container.parent().css('maxHeight')});

			container.find('>ul:first >li').each(function(j) {
				var li=jQuery(this);

				// MAKE LI OVERFLOW HIDDEN FOR FURTHER ISSUES
				li.css({'width':'100%','height':'100%','overflow':'hidden'});

				if (li.data('link')!=undefined) {
					var link = li.data('link');
					var target="_self";
					var zindex=2;
					if (li.data('slideindex')=="back") zindex=0;

					var linktoslide=li.data('linktoslide');
					if (li.data('target')!=undefined) target=li.data('target');

					if (link=="slide") {
						li.append('<div class="tp-caption sft slidelink" style="z-index:'+zindex+';" data-x="0" data-y="0" data-linktoslide="'+linktoslide+'" data-start="0"><a><div></div></a></div>');
					} else {
						linktoslide="no";
						li.append('<div class="tp-caption sft slidelink" style="z-index:'+zindex+';" data-x="0" data-y="0" data-linktoslide="'+linktoslide+'" data-start="0"><a target="'+target+'" href="'+link+'"><div></div></a></div>');
					}

				}
			});

			// RESOLVE OVERFLOW HIDDEN OF MAIN CONTAINER
			container.parent().css({'overflow':'visible'});


			container.find('>ul:first >li >img').each(function(j) {

				var img=jQuery(this);
				img.addClass('defaultimg');
				if (img.data('lazyload')!=undefined && img.data('lazydone') != 1) {

				} else {

					setSize(img,opt);

					setSize(img,opt);
				}
				img.wrap('<div class="slotholder"></div>');
				img.css({'opacity':0});
				img.data('li-id',j);

			});
		}


		///////////////////////
		// PREPARE THE SLIDE //
		//////////////////////
		function prepareOneSlide(slotholder,opt,visible) {

				var sh=slotholder;
				var img = sh.find('img')

				setSize(img,opt)
				var src = img.attr('src');
				var bgcolor=img.css('background-color');

				var w = img.data('neww');
				var h = img.data('newh');
				var fulloff = img.data("fxof");
				if (fulloff==undefined) fulloff=0;

				var fullyoff=img.data("fyof");
				if (img.data('fullwidthcentering')!="on" || fullyoff==undefined) fullyoff=0;

				var off=0;


				if (!visible)
					var off=0-opt.slotw;

				for (var i=0;i<opt.slots;i++)
					sh.append('<div class="slot" style="position:absolute;top:'+(0+fullyoff)+'px;left:'+(fulloff+i*opt.slotw)+'px;overflow:hidden;width:'+opt.slotw+'px;height:'+h+'px"><div class="slotslide" style="position:absolute;top:0px;left:'+off+'px;width:'+opt.slotw+'px;height:'+h+'px;overflow:hidden;"><img style="background-color:'+bgcolor+';position:absolute;top:0px;left:'+(0-(i*opt.slotw))+'px;width:'+w+'px;height:'+h+'px" src="'+src+'"></div></div>');

		}


		///////////////////////
		// PREPARE THE SLIDE //
		//////////////////////
		function prepareOneSlideV(slotholder,opt,visible) {

				var sh=slotholder;
				var img = sh.find('img')

				setSize(img,opt)
				var src = img.attr('src');
				var bgcolor=img.css('background-color');
				var w = img.data('neww');
				var h = img.data('newh');
				var fulloff = img.data("fxof");
				if (fulloff==undefined) fulloff=0;

				var fullyoff=img.data("fyof");
				if (img.data('fullwidthcentering')!="on" || fullyoff==undefined) fullyoff=0;

				var off=0;



				if (!visible)
					var off=0-opt.sloth;

				//alert(fullyoff+"  "+opt.sloth+" "opt.slots+"  "+)

				for (var i=0;i<opt.slots+2;i++)
					sh.append('<div class="slot" style="position:absolute;'+
												 'top:'+(fullyoff+(i*opt.sloth))+'px;'+
												 'left:'+(fulloff)+'px;'+
												 'overflow:hidden;'+
												 'width:'+w+'px;'+
												 'height:'+(opt.sloth)+'px"'+
												 '><div class="slotslide" style="position:absolute;'+
												 'top:'+(off)+'px;'+
												 'left:0px;width:'+w+'px;'+
												 'height:'+opt.sloth+'px;'+
												 'overflow:hidden;"><img style="position:absolute;'+
												 'background-color:'+bgcolor+';'+
												 'top:'+(0-(i*opt.sloth))+'px;'+
												 'left:0px;width:'+w+'px;'+
												 'height:'+h+'px" src="'+src+'"></div></div>');

		}


		///////////////////////
		// PREPARE THE SLIDE //
		//////////////////////
		function prepareOneSlideBox(slotholder,opt,visible) {

				var sh=slotholder;
				var img = sh.find('img');

				setSize(img,opt)
				var src = img.attr('src');
				var bgcolor=img.css('background-color');

				var w = img.data('neww');
				var h = img.data('newh');
				var fulloff = img.data("fxof");
				if (fulloff==undefined) fulloff=0;

				var fullyoff=img.data("fyof");
				if (img.data('fullwidthcentering')!="on" || fullyoff==undefined) fullyoff=0;



				var off=0;




				// SET THE MINIMAL SIZE OF A BOX
				var basicsize = 0;
				if (opt.sloth>opt.slotw)
					basicsize=opt.sloth
				else
					basicsize=opt.slotw;


				if (!visible) {
					var off=0-basicsize;
				}

				opt.slotw = basicsize;
				opt.sloth = basicsize;
				var x=0;
				var y=0;



				for (var j=0;j<opt.slots;j++) {

					y=0;
					for (var i=0;i<opt.slots;i++) 	{


						sh.append('<div class="slot" '+
								  'style="position:absolute;'+
											'top:'+(fullyoff+y)+'px;'+
											'left:'+(fulloff+x)+'px;'+
											'width:'+basicsize+'px;'+
											'height:'+basicsize+'px;'+
											'overflow:hidden;">'+

								  '<div class="slotslide" data-x="'+x+'" data-y="'+y+'" '+
								  'style="position:absolute;'+
											'top:'+(0)+'px;'+
											'left:'+(0)+'px;'+
											'width:'+basicsize+'px;'+
											'height:'+basicsize+'px;'+
											'overflow:hidden;">'+

								  '<img style="position:absolute;'+
											'top:'+(0-y)+'px;'+
											'left:'+(0-x)+'px;'+
											'width:'+w+'px;'+
											'height:'+h+'px'+
											'background-color:'+bgcolor+';"'+
								  'src="'+src+'"></div></div>');
						y=y+basicsize;
					}
					x=x+basicsize;
				}
		}





		///////////////////////
		//	REMOVE SLOTS	//
		/////////////////////
		function removeSlots(container,opt,time) {
			if (time==undefined)
				time==80

			setTimeout(function() {
				container.find('.slotholder .slot').each(function() {
					clearTimeout(jQuery(this).data('tout'));
					jQuery(this).remove();
				});
				opt.transition = 0;
			},time);
		}


		////////////////////////
		//	CAPTION POSITION  //
		///////////////////////
		function setCaptionPositions(container,opt) {

			// FIND THE RIGHT CAPTIONS
			var actli = container.find('>li:eq('+opt.act+')');
			var nextli = container.find('>li:eq('+opt.next+')');

			// SET THE NEXT CAPTION AND REMOVE THE LAST CAPTION
			var nextcaption=nextli.find('.tp-caption');

			if (nextcaption.find('iframe')==0) {

				// MOVE THE CAPTIONS TO THE RIGHT POSITION
				if (nextcaption.hasClass('hcenter'))
					nextcaption.css({'height':opt.height+"px",'top':'0px','left':(opt.width/2 - nextcaption.outerWidth()/2)+'px'});
				else
					if (nextcaption.hasClass('vcenter'))
						nextcaption.css({'width':opt.width+"px",'left':'0px','top':(opt.height/2 - nextcaption.outerHeight()/2)+'px'});
			}
		}


		//////////////////////////////
		//                         //
		//	-	SWAP THE SLIDES -  //
		//                        //
		////////////////////////////
		function swapSlide(container,opt) {
			try{
				var actli = container.find('>ul:first-child >li:eq('+opt.act+')');
			} catch(e) {
				var actli=container.find('>ul:first-child >li:eq(1)');
			}
			opt.lastslide=opt.act;
			var nextli = container.find('>ul:first-child >li:eq('+opt.next+')');

			var defimg= nextli.find('.defaultimg');

			if (defimg.data('lazyload') !=undefined && defimg.data('lazydone') !=1 ) {
				defimg.attr('src',nextli.find('.defaultimg').data('lazyload')),

				defimg.data('orgw',0);
					container.find('.tp-loader').css({'display':'block'}).transition({opacity:1,duration:300});
					setTimeout(function() { killBannerTimer(opt,container)},180);

						nextli.waitForImages(function() {
								defimg.data('lazydone',1);
								setTimeout(function() {restartBannerTimer(opt,container)},190);
								
								setSize(defimg,opt);
								setBulPos(container,opt);
								
								setSize(defimg,opt);
								swapSlideProgress(container,opt);
								container.find('.tp-loader').transition({opacity:0,duration:300});

								setTimeout(function() {
									container.find('.tp-loader').css({'display':'none'});

								},2200)
													});

			} else {
			   	swapSlideProgress(container,opt);
			}
		}


		function swapSlideProgress(container,opt) {


			container.trigger('revolution.slide.onbeforeswap');


			opt.transition = 1;
			opt.videoplaying = false;
			//console.log("VideoPlay set to False due swapSlideProgress");

			try{
				var actli = container.find('>ul:first-child >li:eq('+opt.act+')');
			} catch(e) {
				var actli=container.find('>ul:first-child >li:eq(1)');
			}

			opt.lastslide=opt.act;

			var nextli = container.find('>ul:first-child >li:eq('+opt.next+')');

			var actsh = actli.find('.slotholder');
			var nextsh = nextli.find('.slotholder');
			actli.css({'visibility':'visible'});
			nextli.css({'visibility':'visible'});

			if (opt.ie) {
				if (comingtransition=="boxfade") comingtransition = "boxslide";
				if (comingtransition=="slotfade-vertical") comingtransition = "slotzoom-vertical";
				if (comingtransition=="slotfade-horizontal") comingtransition = "slotzoom-horizontal";
			}


			// IF DELAY HAS BEEN SET VIA THE SLIDE, WE TAKE THE NEW VALUE, OTHER WAY THE OLD ONE...
			if (nextli.data('delay')!=undefined) {
						opt.cd=0;
						opt.delay=nextli.data('delay');
			} else {
				opt.delay=opt.origcd;
			}

			// RESET POSITION AND FADES OF LI'S
			actli.css({'left':'0px','top':'0px'});
			nextli.css({'left':'0px','top':'0px'});


			// IF THERE IS AN OTHER FIRST SLIDE START HAS BEED SELECTED
			if (nextli.data('differentissplayed') =='prepared') {
				nextli.data('differentissplayed','done');
				nextli.data('transition',nextli.data('savedtransition'));
				nextli.data('slotamount',nextli.data('savedslotamount'));
				nextli.data('masterspeed',nextli.data('savedmasterspeed'));
			}


			if (nextli.data('fstransition') != undefined && nextli.data('differentissplayed') !="done") {
				nextli.data('savedtransition',nextli.data('transition'));
				nextli.data('savedslotamount',nextli.data('slotamount'));
				nextli.data('savedmasterspeed',nextli.data('masterspeed'));

				nextli.data('transition',nextli.data('fstransition'));
				nextli.data('slotamount',nextli.data('fsslotamount'));
				nextli.data('masterspeed',nextli.data('fsmasterspeed'));

				nextli.data('differentissplayed','prepared');
			}

			///////////////////////////////////////
			// TRANSITION CHOOSE - RANDOM EFFECTS//
			///////////////////////////////////////
			var nexttrans = 0;


			var transtext = nextli.data('transition').split(",");
			var curtransid = nextli.data('nexttransid');
			if (curtransid == undefined) {
			  curtransid=0;
			  nextli.data('nexttransid',curtransid);
			} else {
				curtransid=curtransid+1;
				if (curtransid==transtext.length) curtransid=0;
				nextli.data('nexttransid',curtransid);

			}



			var comingtransition = transtext[curtransid];

			if (comingtransition=="boxslide") nexttrans = 0
			else
				if (comingtransition=="boxfade") nexttrans = 1
			else
				if (comingtransition=="slotslide-horizontal") nexttrans = 2
			else
				if (comingtransition=="slotslide-vertical") nexttrans = 3
			else
				if (comingtransition=="curtain-1") nexttrans = 4
			else
				if (comingtransition=="curtain-2") nexttrans = 5
			else
				if (comingtransition=="curtain-3") nexttrans = 6
			else
				if (comingtransition=="slotzoom-horizontal") nexttrans = 7
			else
				if (comingtransition=="slotzoom-vertical")  nexttrans = 8
			else
				if (comingtransition=="slotfade-horizontal")  nexttrans = 9
			else
				if (comingtransition=="slotfade-vertical") nexttrans = 10
			else
				if (comingtransition=="fade") nexttrans = 11
			else
				if (comingtransition=="slideleft")  nexttrans = 12
			else
				if (comingtransition=="slideup") nexttrans = 13
			else
				if (comingtransition=="slidedown") nexttrans = 14
			else
				if (comingtransition=="slideright") nexttrans = 15;
			else
				if (comingtransition=="papercut") nexttrans = 16;
			else
				if (comingtransition=="3dcurtain-horizontal") nexttrans = 17;
			else
				if (comingtransition=="3dcurtain-vertical") nexttrans = 18;
			else
				if (comingtransition=="cubic" || comingtransition=="cube") nexttrans = 19;
			else
				if (comingtransition=="flyin") nexttrans = 20;
			else
				if (comingtransition=="turnoff") nexttrans = 21;
			else {
				nexttrans=Math.round(Math.random()*21);
				nextli.data('slotamount',Math.round(Math.random()*12+4));
			}

			if (comingtransition=="random-static")   {
						nexttrans=Math.round(Math.random()*16);
						if (nexttrans>15) nexttrans=15;
						if (nexttrans<0) nexttrans=0;
			}

			if (comingtransition=="random-premium")   {
						nexttrans=Math.round(Math.random()*6+16);
						if (nexttrans>21) nexttrans=21;
						if (nexttrans<16) nexttrans=16;
			}



		    var direction=-1;
			if (opt.leftarrowpressed==1 || opt.act>opt.next) direction=1;

			if (comingtransition=="slidehorizontal") {
						nexttrans = 12
					if (opt.leftarrowpressed==1)
						nexttrans = 15
				}

			if (comingtransition=="slidevertical") {
						nexttrans = 13
					if (opt.leftarrowpressed==1)
						nexttrans = 14
				}

			opt.leftarrowpressed=0;



			if (nexttrans>21) nexttrans = 21;
			if (nexttrans<0) nexttrans = 0;

			if ((opt.ie || opt.ie9) && nexttrans >18) {
					nexttrans=Math.round(Math.random()*16);
					nextli.data('slotamount',Math.round(Math.random()*12+4));
			};
			if (opt.ie && (nexttrans==17 || nexttrans==16 || nexttrans==2 || nexttrans==3 || nexttrans==9 || nexttrans==10 )) nexttrans=Math.round(Math.random()*3+12);


			if (opt.ie9 && (nexttrans==3)) nexttrans = 4;




			//jQuery('body').find('.debug').html("Transition:"+nextli.data('transition')+"  id:"+nexttrans);

			// DEFINE THE MASTERSPEED FOR THE SLIDE //
			var masterspeed=300;
			if (nextli.data('masterspeed')!=undefined && nextli.data('masterspeed')>99 && nextli.data('masterspeed')<4001)
				masterspeed = nextli.data('masterspeed');



			/////////////////////////////////////////////
			// SET THE BULLETS SELECTED OR UNSELECTED  //
			/////////////////////////////////////////////


			container.parent().find(".bullet").each(function() {
				var bul = jQuery(this);
				bul.removeClass("selected");


				if (opt.navigationArrows=="withbullet" || opt.navigationArrows=="nexttobullets") {
					if (bul.index()-1 == opt.next) bul.addClass('selected');

				} else {

					if (bul.index() == opt.next)  bul.addClass('selected');

				}
			});


			//////////////////////////////////////////////////////////////////
			// 		SET THE NEXT CAPTION AND REMOVE THE LAST CAPTION		//
			//////////////////////////////////////////////////////////////////

					container.find('>li').each(function() {
						var li = jQuery(this);
						if (li.index!=opt.act && li.index!=opt.next) li.css({'z-index':16});
					});

					actli.css({'z-index':18});
					nextli.css({'z-index':20});
					nextli.css({'opacity':0});


			///////////////////////////
			//	ANIMATE THE CAPTIONS //
			///////////////////////////
			if (actli.index() != nextli.index()) {
				removeTheCaptions(actli,opt);

			}
			animateTheCaptions(nextli, opt);




			/////////////////////////////////////////////
			//	SET THE ACTUAL AMOUNT OF SLIDES !!     //
			//  SET A RANDOM AMOUNT OF SLOTS          //
			///////////////////////////////////////////
						if (nextli.data('slotamount')==undefined || nextli.data('slotamount')<1) {
							opt.slots=Math.round(Math.random()*12+4);
							if (comingtransition=="boxslide")
								opt.slots=Math.round(Math.random()*6+3);
						 } else {
							opt.slots=nextli.data('slotamount');

						}

			/////////////////////////////////////////////
			//	SET THE ACTUAL AMOUNT OF SLIDES !!     //
			//  SET A RANDOM AMOUNT OF SLOTS          //
			///////////////////////////////////////////
						if (nextli.data('rotate')==undefined)
							opt.rotate = 0
						 else
							if (nextli.data('rotate')==999)
								opt.rotate=Math.round(Math.random()*360);
							 else
							    opt.rotate=nextli.data('rotate');
						if (!jQuery.support.transition  || opt.ie || opt.ie9) opt.rotate=0;



			//////////////////////////////
			//	FIRST START 			//
			//////////////////////////////

			if (opt.firststart==1) {
					actli.css({'opacity':0});
					opt.firststart=0;
			}


			/////////////////////////////////////
			// THE SLOTSLIDE - TRANSITION I.  //
			////////////////////////////////////
			if (nexttrans==0) {								// BOXSLIDE

						masterspeed = masterspeed + 100;
						if (opt.slots>10) opt.slots=10;

						nextli.css({'opacity':1});

						// PREPARE THE SLOTS HERE
						prepareOneSlideBox(actsh,opt,true);
						prepareOneSlideBox(nextsh,opt,false);

						//SET DEFAULT IMG UNVISIBLE
						nextsh.find('.defaultimg').css({'opacity':0});
						//actsh.find('.defaultimg').css({'opacity':0});


						// ALL NEW SLOTS SHOULD BE SLIDED FROM THE LEFT TO THE RIGHT


						nextsh.find('.slotslide').each(function(j) {
							var ss=jQuery(this);
							if (opt.ie9)
								ss.transition({top:(0-opt.sloth),left:(0-opt.slotw)},0);
							else
								ss.transition({top:(0-opt.sloth),left:(0-opt.slotw), rotate:opt.rotate},0);
							setTimeout(function() {
											ss.transition({top:0, left:0, scale:1, rotate:0},masterspeed*1.5,function() {

																	if (j==(opt.slots*opt.slots)-1) {
																		removeSlots(container,opt);
																		nextsh.find('.defaultimg').css({'opacity':1});

																		if (nextli.index()!=actli.index()) actsh.find('.defaultimg').css({'opacity':0});
																		opt.act=opt.next;
																	moveSelectedThumb(container);

																	}
															});
							},j*15);
						});
			}



			/////////////////////////////////////
			// THE SLOTSLIDE - TRANSITION I.  //
			////////////////////////////////////
			if (nexttrans==1) {


						if (opt.slots>5) opt.slots=5;
						nextli.css({'opacity':1});

						// PREPARE THE SLOTS HERE
						//prepareOneSlideBox(actsh,opt,true);
						prepareOneSlideBox(nextsh,opt,false);

						//SET DEFAULT IMG UNVISIBLE
						nextsh.find('.defaultimg').css({'opacity':0});
						//actsh.find('.defaultimg').css({'opacity':0});


						// ALL NEW SLOTS SHOULD BE SLIDED FROM THE LEFT TO THE RIGHT

						nextsh.find('.slotslide').each(function(j) {
							var ss=jQuery(this);
							ss.css({'opacity':0});
							ss.find('img').css({'opacity':0});
							if (opt.ie9)
								ss.find('img').transition({'top':(Math.random()*opt.slotw-opt.slotw)+"px",'left':(Math.random()*opt.slotw-opt.slotw)+"px"},0);
							else
								ss.find('img').transition({'top':(Math.random()*opt.slotw-opt.slotw)+"px",'left':(Math.random()*opt.slotw-opt.slotw)+"px", rotate:opt.rotate},0);

							var rand=Math.random()*1000+(masterspeed + 200);
							if (j==(opt.slots*opt.slots)-1) rand=1500;

									ss.find('img').transition({'opacity':1,'top':(0-ss.data('y'))+"px",'left':(0-ss.data('x'))+'px', rotate:0},rand);
									ss.transition({'opacity':1},rand,function() {
															if (j==(opt.slots*opt.slots)-1) {
																removeSlots(container,opt);
																nextsh.find('.defaultimg').css({'opacity':1});
																if (nextli.index()!=actli.index()) actsh.find('.defaultimg').css({'opacity':0});
																opt.act=opt.next;

																moveSelectedThumb(container);
															}

									});


						});
			}


			/////////////////////////////////////
			// THE SLOTSLIDE - TRANSITION I.  //
			////////////////////////////////////
			if (nexttrans==2) {


						masterspeed = masterspeed + 200;

						nextli.css({'opacity':1});

						// PREPARE THE SLOTS HERE
						prepareOneSlide(actsh,opt,true);
						prepareOneSlide(nextsh,opt,false);

						//SET DEFAULT IMG UNVISIBLE
						nextsh.find('.defaultimg').css({'opacity':0});
						//actsh.find('.defaultimg').css({'opacity':0});


						// ALL OLD SLOTS SHOULD BE SLIDED TO THE RIGHT
						actsh.find('.slotslide').each(function() {
							var ss=jQuery(this);


									//ss.animate({'left':opt.slotw+'px'},{duration:masterspeed,queue:false,complete:function() {
									ss.transit({'left':opt.slotw+'px',rotate:(0-opt.rotate)},masterspeed,function() {
															removeSlots(container,opt);
															nextsh.find('.defaultimg').css({'opacity':1});
															if (nextli.index()!=actli.index()) actsh.find('.defaultimg').css({'opacity':0});
															opt.act=opt.next;
															moveSelectedThumb(container);

									});

						});

						// ALL NEW SLOTS SHOULD BE SLIDED FROM THE LEFT TO THE RIGHT
						nextsh.find('.slotslide').each(function() {
							var ss=jQuery(this);
							if (opt.ie9)
								ss.transit({'left':(0-opt.slotw)+"px"},0);
							else
								ss.transit({'left':(0-opt.slotw)+"px",rotate:opt.rotate},0);

									ss.transit({'left':'0px',rotate:0},masterspeed,function() {
															removeSlots(container,opt);
															nextsh.find('.defaultimg').css({'opacity':1});
															if (nextli.index()!=actli.index()) actsh.find('.defaultimg').css({'opacity':0});
															if (opt.ie) actsh.find('.defaultimg').css({'opacity':1});
															opt.act=opt.next;

																		moveSelectedThumb(container);

									});

						});
			}



			/////////////////////////////////////
			// THE SLOTSLIDE - TRANSITION I.  //
			////////////////////////////////////
			if (nexttrans==3) {


						masterspeed = masterspeed + 200;
						nextli.css({'opacity':1});

						// PREPARE THE SLOTS HERE
						prepareOneSlideV(actsh,opt,true);
						prepareOneSlideV(nextsh,opt,false);

						//SET DEFAULT IMG UNVISIBLE
						nextsh.find('.defaultimg').css({'opacity':0});
						//actsh.find('.defaultimg').css({'opacity':0});

						// ALL OLD SLOTS SHOULD BE SLIDED TO THE RIGHT
						actsh.find('.slotslide').each(function() {
							var ss=jQuery(this);

									ss.transit({'top':opt.sloth+'px',rotate:opt.rotate},masterspeed,function() {
															removeSlots(container,opt);
															nextsh.find('.defaultimg').css({'opacity':1});
															if (nextli.index()!=actli.index()) actsh.find('.defaultimg').css({'opacity':0});
															opt.act=opt.next;
															moveSelectedThumb(container);

									});

						});

						// ALL NEW SLOTS SHOULD BE SLIDED FROM THE LEFT TO THE RIGHT
						nextsh.find('.slotslide').each(function() {
							var ss=jQuery(this);
								if (opt.ie9)
									ss.transit({'top':(0-opt.sloth)+"px"},0);
								else
									ss.transit({'top':(0-opt.sloth)+"px",rotate:opt.rotate},0);
								ss.transit({'top':'0px',rotate:0},masterspeed,function() {
													removeSlots(container,opt);
													nextsh.find('.defaultimg').css({'opacity':1});
													if (nextli.index()!=actli.index()) actsh.find('.defaultimg').css({'opacity':0});
													opt.act=opt.next;
													moveSelectedThumb(container);

								});

						});
			}



			/////////////////////////////////////
			// THE SLOTSLIDE - TRANSITION I.  //
			////////////////////////////////////
			if (nexttrans==4) {



						nextli.css({'opacity':1});

						// PREPARE THE SLOTS HERE
						prepareOneSlide(actsh,opt,true);
						prepareOneSlide(nextsh,opt,true);

						//SET DEFAULT IMG UNVISIBLE
						nextsh.find('.defaultimg').css({'opacity':0});
						actsh.find('.defaultimg').css({'opacity':0});


						// ALL NEW SLOTS SHOULD BE SLIDED FROM THE LEFT TO THE RIGHT
						actsh.find('.slotslide').each(function(i) {
							var ss=jQuery(this);

							ss.transit({'top':(0+(opt.height))+"px",'opacity':1,rotate:opt.rotate},masterspeed+(i*(70-opt.slots)));
						});

						// ALL NEW SLOTS SHOULD BE SLIDED FROM THE LEFT TO THE RIGHT
						nextsh.find('.slotslide').each(function(i) {
							var ss=jQuery(this);
								if (opt.ie9)
										ss.transition({'top':(0-(opt.height))+"px",'opacity':0},0);
									else
										ss.transition({'top':(0-(opt.height))+"px",'opacity':0,rotate:opt.rotate},0);

									ss.transition({'top':'0px','opacity':1,rotate:0},masterspeed+(i*(70-opt.slots)),function() {
															if (i==opt.slots-1) {
																removeSlots(container,opt);
																nextsh.find('.defaultimg').css({'opacity':1});
																if (nextli.index()!=actli.index()) actsh.find('.defaultimg').css({'opacity':0});
																opt.act=opt.next;
																moveSelectedThumb(container);
															}

									});

						});
			}


			/////////////////////////////////////
			// THE SLOTSLIDE - TRANSITION I.  //
			////////////////////////////////////
			if (nexttrans==5) {



						nextli.css({'opacity':1});

						// PREPARE THE SLOTS HERE
						prepareOneSlide(actsh,opt,true);
						prepareOneSlide(nextsh,opt,true);

						//SET DEFAULT IMG UNVISIBLE
						nextsh.find('.defaultimg').css({'opacity':0});
						actsh.find('.defaultimg').css({'opacity':0});

						// ALL NEW SLOTS SHOULD BE SLIDED FROM THE LEFT TO THE RIGHT
						actsh.find('.slotslide').each(function(i) {
							var ss=jQuery(this);

									ss.transition({'top':(0+(opt.height))+"px",'opacity':1,rotate:opt.rotate},masterspeed+((opt.slots-i)*(70-opt.slots)));

						});

						// ALL NEW SLOTS SHOULD BE SLIDED FROM THE LEFT TO THE RIGHT
						nextsh.find('.slotslide').each(function(i) {
							var ss=jQuery(this);
									if (opt.ie9)
										ss.transition({'top':(0-(opt.height))+"px",'opacity':0},0);
									else
										ss.transition({'top':(0-(opt.height))+"px",'opacity':0,rotate:opt.rotate},0);

									ss.transition({'top':'0px','opacity':1,rotate:0},masterspeed+((opt.slots-i)*(70-opt.slots)),function() {
															if (i==0) {
																removeSlots(container,opt);
																nextsh.find('.defaultimg').css({'opacity':1});
																if (nextli.index()!=actli.index()) actsh.find('.defaultimg').css({'opacity':0});
																opt.act=opt.next;
																moveSelectedThumb(container);
															}

									});

						});
			}


			/////////////////////////////////////
			// THE SLOTSLIDE - TRANSITION I.  //
			////////////////////////////////////
			if (nexttrans==6) {



						nextli.css({'opacity':1});
						if (opt.slots<2) opt.slots=2;
						// PREPARE THE SLOTS HERE
						prepareOneSlide(actsh,opt,true);
						prepareOneSlide(nextsh,opt,true);

						//SET DEFAULT IMG UNVISIBLE
						nextsh.find('.defaultimg').css({'opacity':0});
						actsh.find('.defaultimg').css({'opacity':0});


						actsh.find('.slotslide').each(function(i) {
							var ss=jQuery(this);

							if (i<opt.slots/2)
								var tempo = (i+2)*60;
							else
								var tempo = (2+opt.slots-i)*60;


									ss.transition({'top':(0+(opt.height))+"px",'opacity':1},masterspeed+tempo);

						});

						// ALL NEW SLOTS SHOULD BE SLIDED FROM THE LEFT TO THE RIGHT
						nextsh.find('.slotslide').each(function(i) {
							var ss=jQuery(this);
							if (opt.ie9)
								ss.transition({'top':(0-(opt.height))+"px",'opacity':0},0);
							else
								ss.transition({'top':(0-(opt.height))+"px",'opacity':0,rotate:opt.rotate},0);
							if (i<opt.slots/2)
								var tempo = (i+2)*60;
							else
								var tempo = (2+opt.slots-i)*60;


									ss.transition({'top':'0px','opacity':1,rotate:0},masterspeed+tempo,function() {
															if (i==Math.round(opt.slots/2)) {
																removeSlots(container,opt);
																nextsh.find('.defaultimg').css({'opacity':1});
																if (nextli.index()!=actli.index()) actsh.find('.defaultimg').css({'opacity':0});
																opt.act=opt.next;
																moveSelectedThumb(container);
															}

									});

						});
			}


			////////////////////////////////////
			// THE SLOTSZOOM - TRANSITION II. //
			////////////////////////////////////
			if (nexttrans==7) {

						masterspeed = masterspeed * 3;
						nextli.css({'opacity':1});

						// PREPARE THE SLOTS HERE
						prepareOneSlide(actsh,opt,true);
						prepareOneSlide(nextsh,opt,true);

						//SET DEFAULT IMG UNVISIBLE
						nextsh.find('.defaultimg').css({'opacity':0});
						//actsh.find('.defaultimg').css({'opacity':0});

						// ALL OLD SLOTS SHOULD BE SLIDED TO THE RIGHT
						actsh.find('.slotslide').each(function() {
							var ss=jQuery(this).find('img');

									ss.transition({'left':(0-opt.slotw/2)+'px',
												   'top':(0-opt.height/2)+'px',
												   'width':(opt.slotw*2)+"px",
												   'height':(opt.height*2)+"px",
												   opacity:0,
												   rotate:opt.rotate
													},masterspeed,function() {
															removeSlots(container,opt);
															nextsh.find('.defaultimg').css({'opacity':1});
															if (nextli.index()!=actli.index()) actsh.find('.defaultimg').css({'opacity':0});
															opt.act = opt.next;
															moveSelectedThumb(container);
													});

						});

/						//////////////////////////////////////////////////////////////
						// ALL NEW SLOTS SHOULD BE SLIDED FROM THE LEFT TO THE RIGHT //
						///////////////////////////////////////////////////////////////
						nextsh.find('.slotslide').each(function(i) {
							var ss=jQuery(this).find('img');

									if (opt.ie9)
										ss.transition({'left':(0)+'px','top':(0)+'px',opacity:0},0);
									else
										ss.transition({'left':(0)+'px','top':(0)+'px',opacity:0,rotate:opt.rotate},0);
									ss.transition({'left':(0-i*opt.slotw)+'px',
												   'top':(0)+'px',
												   'width':(nextsh.find('.defaultimg').data('neww'))+"px",
												   'height':(nextsh.find('.defaultimg').data('newh'))+"px",
												   opacity:1,rotate:0

													},masterspeed,function() {
															removeSlots(container,opt);
															nextsh.find('.defaultimg').css({'opacity':1});
															if (nextli.index()!=actli.index()) actsh.find('.defaultimg').css({'opacity':0});
															opt.act = opt.next;
															moveSelectedThumb(container);
													});


						});
			}




			////////////////////////////////////
			// THE SLOTSZOOM - TRANSITION II. //
			////////////////////////////////////
			if (nexttrans==8) {

						masterspeed = masterspeed * 3;
						nextli.css({'opacity':1});

						// PREPARE THE SLOTS HERE
						prepareOneSlideV(actsh,opt,true);
						prepareOneSlideV(nextsh,opt,true);

						//SET DEFAULT IMG UNVISIBLE
						nextsh.find('.defaultimg').css({'opacity':0});
						//actsh.find('.defaultimg').css({'opacity':0});

						// ALL OLD SLOTS SHOULD BE SLIDED TO THE RIGHT
						actsh.find('.slotslide').each(function() {
							var ss=jQuery(this).find('img');

									ss.transition({'left':(0-opt.width/2)+'px',
												   'top':(0-opt.sloth/2)+'px',
												   'width':(opt.width*2)+"px",
												   'height':(opt.sloth*2)+"px",
												   opacity:0,rotate:opt.rotate
													},masterspeed,function() {
															removeSlots(container,opt);
															nextsh.find('.defaultimg').css({'opacity':1});
															if (nextli.index()!=actli.index()) actsh.find('.defaultimg').css({'opacity':0});

															opt.act = opt.next;
															moveSelectedThumb(container);
													});

						});


						// ALL NEW SLOTS SHOULD BE SLIDED FROM THE LEFT TO THE RIGHT //
						///////////////////////////////////////////////////////////////
						nextsh.find('.slotslide').each(function(i) {
							var ss=jQuery(this).find('img');
									if (opt.ie9)
										ss.transition({'left':(0)+'px','top':(0)+'px',opacity:0},0);
									else
										ss.transition({'left':(0)+'px','top':(0)+'px',opacity:0,rotate:opt.rotate},0);
									ss.transition({'left':(0)+'px',
												   'top':(0-i*opt.sloth)+'px',
												   'width':(nextsh.find('.defaultimg').data('neww'))+"px",
												   'height':(nextsh.find('.defaultimg').data('newh'))+"px",
												   opacity:1,rotate:0
													},masterspeed,function() {
															removeSlots(container,opt);
															nextsh.find('.defaultimg').css({'opacity':1});
															if (nextli.index()!=actli.index()) actsh.find('.defaultimg').css({'opacity':0});

															opt.act = opt.next;
															moveSelectedThumb(container);
													});

						});
			}


			////////////////////////////////////////
			// THE SLOTSFADE - TRANSITION III.   //
			//////////////////////////////////////
			if (nexttrans==9) {



						nextli.css({'opacity':1});

						opt.slots = opt.width/20;

						prepareOneSlide(nextsh,opt,true);


						//actsh.find('.defaultimg').css({'opacity':0});
						nextsh.find('.defaultimg').css({'opacity':0});

						var ssamount=0;
						// ALL NEW SLOTS SHOULD BE SLIDED FROM THE LEFT TO THE RIGHT
						nextsh.find('.slotslide').each(function(i) {
							var ss=jQuery(this);
							ssamount++;
							ss.transition({'opacity':0,x:0,y:0},0);
							ss.data('tout',setTimeout(function() {
											ss.transition({x:0,y:0,'opacity':1},masterspeed);

											},i*4)
									);

						});

						//nextsh.find('.defaultimg').transition({'opacity':1},(masterspeed+(ssamount*4)));

						setTimeout(function() {
									removeSlots(container,opt);
									nextsh.find('.defaultimg').css({'opacity':1});
									if (nextli.index()!=actli.index()) actsh.find('.defaultimg').css({'opacity':0});
									if (opt.ie) actsh.find('.defaultimg').css({'opacity':1});

									opt.act = opt.next;
									moveSelectedThumb(container);
							},(masterspeed+(ssamount*4)));
			}




			////////////////////////////////////////
			// THE SLOTSFADE - TRANSITION III.   //
			//////////////////////////////////////
			if (nexttrans==10) {



						nextli.css({'opacity':1});

						opt.slots = opt.height/20;

						prepareOneSlideV(nextsh,opt,true);


						//actsh.find('.defaultimg').css({'opacity':0});
						nextsh.find('.defaultimg').css({'opacity':0});

						var ssamount=0;
						// ALL NEW SLOTS SHOULD BE SLIDED FROM THE LEFT TO THE RIGHT
						nextsh.find('.slotslide').each(function(i) {
							var ss=jQuery(this);
							ssamount++;
							ss.transition({'opacity':0,x:0,y:0},0);
							ss.data('tout',setTimeout(function() {
											ss.transition({x:0,y:0,'opacity':1},masterspeed);

											},i*4)
									);

						});

						//nextsh.find('.defaultimg').transition({'opacity':1},(masterspeed+(ssamount*4)));

						setTimeout(function() {
									removeSlots(container,opt);
									nextsh.find('.defaultimg').css({'opacity':1});
									if (nextli.index()!=actli.index()) actsh.find('.defaultimg').css({'opacity':0});
									if (opt.ie) actsh.find('.defaultimg').css({'opacity':1});

									opt.act = opt.next;
									moveSelectedThumb(container);
							},(masterspeed+(ssamount*4)));
			}


			///////////////////////////
			// SIMPLE FADE ANIMATION //
			///////////////////////////

			if (nexttrans==11) {



						nextli.css({'opacity':1});

						opt.slots = 1;

						prepareOneSlide(nextsh,opt,true);


						//actsh.find('.defaultimg').css({'opacity':0});
						nextsh.find('.defaultimg').css({'opacity':0,'position':'relative'});

						var ssamount=0;
						// ALL NEW SLOTS SHOULD BE SLIDED FROM THE LEFT TO THE RIGHT

						nextsh.find('.slotslide').each(function(i) {
							var ss=jQuery(this);
							ssamount++;

							if (opt.ie9 ||opt.ie) {
								if (opt.ie) nextli.css({'opacity':'0'});
								ss.css({'opacity':0});

							} else
								ss.transition({'opacity':0,rotate:opt.rotate},0);


							setTimeout(function() {
								if (opt.ie9 ||opt.ie) {
									if (opt.ie)
										nextli.animate({'opacity':1},{duration:masterspeed});
									 else
									 	ss.transition({'opacity':1},masterspeed);

								} else {
									ss.transition({'opacity':1,rotate:0},masterspeed);
								}
							},10);
						});

						setTimeout(function() {
									removeSlots(container,opt);
									nextsh.find('.defaultimg').css({'opacity':1});
									if (nextli.index()!=actli.index()) actsh.find('.defaultimg').css({'opacity':0});
									if (opt.ie) actsh.find('.defaultimg').css({'opacity':1});

									opt.act = opt.next;
									moveSelectedThumb(container);
							},masterspeed+15);
			}






			if (nexttrans==12 || nexttrans==13 || nexttrans==14 || nexttrans==15) {

						masterspeed = masterspeed * 3;
						nextli.css({'opacity':1});

						opt.slots = 1;

						prepareOneSlide(nextsh,opt,true);
						prepareOneSlide(actsh,opt,true);


						actsh.find('.defaultimg').css({'opacity':0});
						nextsh.find('.defaultimg').css({'opacity':0});

						var oow = opt.width;
						var ooh = opt.height;


						// ALL NEW SLOTS SHOULD BE SLIDED FROM THE LEFT TO THE RIGHT
						var ssn=nextsh.find('.slotslide')

						if (opt.fullWidth=="on" || opt.fullSreen=="on") {
							oow=ssn.width();
							ooh=ssn.height();
						}

						if (nexttrans==12)
							if (opt.ie9) {
								ssn.transition({'left':oow+"px"},0);

							 } else {
								ssn.transition({'left':oow+"px",rotate:opt.rotate},0);

							}
						else
							if (nexttrans==15)
								if (opt.ie9)
									ssn.transition({'left':(0-oow)+"px"},0);
								else
									ssn.transition({'left':(0-oow)+"px",rotate:opt.rotate},0);
							else
								if (nexttrans==13)
									if (opt.ie9)
										ssn.transition({'top':(ooh)+"px"},0);
									else
										ssn.transition({'top':(ooh)+"px",rotate:opt.rotate},0);
								else
									if (nexttrans==14)
										if (opt.ie9)
											ssn.transition({'top':(0-ooh)+"px"},0);
										else
											ssn.transition({'top':(0-ooh)+"px",rotate:opt.rotate},0);


										ssn.transition({'left':'0px','top':'0px',opacity:1,rotate:0},masterspeed,function() {


														removeSlots(container,opt,0);
														if (nextli.index()!=actli.index()) actsh.find('.defaultimg').css({'opacity':0});
														nextsh.find('.defaultimg').css({'opacity':1});
														opt.act = opt.next;
														moveSelectedThumb(container);
												});



						var ssa=actsh.find('.slotslide');

								if (nexttrans==12)
									ssa.transition({'left':(0-oow)+'px',opacity:1,rotate:0},masterspeed);
								else
									if (nexttrans==15)
										ssa.transition({'left':(oow)+'px',opacity:1,rotate:0},masterspeed);
									else
										if (nexttrans==13)
											ssa.transition({'top':(0-ooh)+'px',opacity:1,rotate:0},masterspeed);
										else
											if (nexttrans==14)
												ssa.transition({'top':(ooh)+'px',opacity:1,rotate:0},masterspeed);



			}


			//////////////////////////////////////
			// THE SLOTSLIDE - TRANSITION XVI.  //
			//////////////////////////////////////
			if (nexttrans==16) {						// PAPERCUT

					if (masterspeed<600) masterspeed=600;
					
					actli.css({'position':'absolute','z-index':20});
					nextli.css({'position':'absolute','z-index':15});
					// PREPARE THE CUTS
					actli.wrapInner('<div class="tp-half-one"></div>');
					actli.find('.tp-half-one').clone(true).appendTo(actli).addClass("tp-half-two");
					actli.find('.tp-half-two').removeClass('tp-half-one');
					actli.find('.tp-half-two').wrapInner('<div class="tp-offset"></div>');

					var oow = opt.width;
					var ooh = opt.height;
					if (opt.fullWidth=="on" || opt.fullSreen=="on") {
						oow=opt.container.parent().width();
						ooh=opt.container.parent().height();
					}


					// ANIMATE THE CUTS
					var img=actli.find('.defaultimg');
					if (img.length>0 && img.data("fullwidthcentering")=="on") {
						var imgh=ooh/2;
						var to=img.position().top;
					} else {

						var imgh=ooh/2;
						var to=0;
					}
					actli.find('.tp-half-one').css({'width':oow+"px",'height':(imgh)+"px",'overflow':'hidden','position':'absolute','top':'0px','left':'0px'});
					actli.find('.tp-half-two').css({'width':oow+"px",'height':(imgh)+"px",'overflow':'hidden','position':'absolute','top':(imgh)+'px','left':'0px'});
					actli.find('.tp-half-two .tp-offset').css({'position':'absolute','top':(0-imgh)+'px','left':'0px'});

				


					// Delegate .transition() calls to .animate()
					// if the browser can't do CSS transitions.
					if (!jQuery.support.transition) {

						actli.find('.tp-half-one').animate({'opacity':0,'top':(0-ooh/2)+"px"},{duration: masterspeed,queue:false});
						actli.find('.tp-half-two').animate({'opacity':0,'top':(ooh)+"px"},{duration: masterspeed,queue:false});
					} else {
						var ro1=Math.round(Math.random()*40-20);
						var ro2=Math.round(Math.random()*40-20);
						var sc1=Math.random()*1+1;
						var sc2=Math.random()*1+1;
						actli.find('.tp-half-one').transition({opacity:1, scale:sc1, rotate:ro1,y:(0-ooh/1.4)+"px"},masterspeed,'in');
						actli.find('.tp-half-two').transition({opacity:1, scale:sc2, rotate:ro2,y:(0+ooh/1.4)+"px"},masterspeed,'in');

						if (actli.html()!=null) nextli.transition({scale:0.8,x:opt.width*0.1, y:ooh*0.1, rotate:ro1},0).transition({rotate:0, scale:1,x:0,y:0},(masterspeed-100),'snap');
					}
					nextsh.find('.defaultimg').css({'opacity':1});
					setTimeout(function() {


								// CLEAN UP BEFORE WE START
								actli.css({'position':'absolute','z-index':18});
								nextli.css({'position':'absolute','z-index':20});
								nextsh.find('.defaultimg').css({'opacity':1});
								actsh.find('.defaultimg').css({'opacity':0});
								if (actli.find('.tp-half-one').length>0)  {
									actli.find('.tp-half-one >img, .tp-half-one >div').unwrap();

								}
								actli.find('.tp-half-two').remove();
								opt.transition = 0;
								opt.act = opt.next;

					},masterspeed);
					nextli.css({'opacity':1});

			}

			////////////////////////////////////////
			// THE SLOTSLIDE - TRANSITION XVII.  //
			///////////////////////////////////////
			if (nexttrans==17) {								// 3D CURTAIN HORIZONTAL

						masterspeed = masterspeed + 100;
						if (opt.slots>10) opt.slots=10;

						nextli.css({'opacity':1});

						// PREPARE THE SLOTS HERE
						prepareOneSlideV(actsh,opt,true);
						prepareOneSlideV(nextsh,opt,false);

						//SET DEFAULT IMG UNVISIBLE
						nextsh.find('.defaultimg').css({'opacity':0});
						//actsh.find('.defaultimg').css({'opacity':0});


						// ALL NEW SLOTS SHOULD BE SLIDED FROM THE LEFT TO THE RIGHT


						nextsh.find('.slotslide').each(function(j) {
							var ss=jQuery(this);
							ss.transition({ opacity:0, rotateY:350 ,rotateX:40, perspective:'1400px'},0);
							setTimeout(function() {
											ss.transition({opacity:1, top:0, left:0, scale:1, perspective:'150px', rotate:0,rotateY:0, rotateX:0},masterspeed*2,function() {

																	if (j==opt.slots-1) {
																		removeSlots(container,opt);
																		nextsh.find('.defaultimg').css({'opacity':1});

																		if (nextli.index()!=actli.index()) actsh.find('.defaultimg').css({'opacity':0});
																		opt.act=opt.next;
																		moveSelectedThumb(container);

																	}
															});
							},j*100);
						});
			}



			////////////////////////////////////////
			// THE SLOTSLIDE - TRANSITION XVIII.  //
			///////////////////////////////////////
			if (nexttrans==18) {								// 3D CURTAIN VERTICAL

						masterspeed = masterspeed + 100;
						if (opt.slots>10) opt.slots=10;

						nextli.css({'opacity':1});

						// PREPARE THE SLOTS HERE
						prepareOneSlide(actsh,opt,true);
						prepareOneSlide(nextsh,opt,false);

						//SET DEFAULT IMG UNVISIBLE
						nextsh.find('.defaultimg').css({'opacity':0});
						//actsh.find('.defaultimg').css({'opacity':0});


						// ALL NEW SLOTS SHOULD BE SLIDED FROM THE LEFT TO THE RIGHT


						nextsh.find('.slotslide').each(function(j) {
							var ss=jQuery(this);
							ss.transition({  rotateX:10 ,rotateY:310, perspective:'1400px', rotate:0,opacity:0},0);
							setTimeout(function() {
											ss.transition({top:0, left:0, scale:1, perspective:'150px', rotate:0,rotateY:0, rotateX:0,opacity:1},masterspeed*2,function() {

																	if (j==opt.slots-1) {
																		removeSlots(container,opt);
																		nextsh.find('.defaultimg').css({'opacity':1});

																		if (nextli.index()!=actli.index()) actsh.find('.defaultimg').css({'opacity':0});
																		opt.act=opt.next;
																		moveSelectedThumb(container);

																	}
															});
							},j*100);
						});
			}

			////////////////////////////////////////
			// THE SLOTSLIDE - TRANSITION XIX.  //
			///////////////////////////////////////
			if (nexttrans==19) {								// CUBIC VERTICAL
						masterspeed = masterspeed + 100;
						if (opt.slots>10) opt.slots=10;
						nextli.css({'opacity':1});

						// PREPARE THE SLOTS HERE
						prepareOneSlide(actsh,opt,true);
						prepareOneSlide(nextsh,opt,false);

						//SET DEFAULT IMG UNVISIBLE
						nextsh.find('.defaultimg').css({'opacity':0});
						//actsh.find('.defaultimg').css({'opacity':0});
						var chix=nextli.css('z-index');
						var chix2=actli.css('z-index');

						//actli.css({'z-index':22});



						// ALL NEW SLOTS SHOULD BE SLIDED FROM THE LEFT TO THE RIGHT


						nextsh.find('.slotslide').each(function(j) {
							var ss=jQuery(this);
							//ss.css({'overflow':'visible'});
							ss.parent().css({'overflow':'visible'});
							ss.css({'background':'#333'});
							if (direction==1)
								ss.transition({  opacity:0,left:0,top:opt.height/2,rotate3d:'1, 0, 0, -90deg '},0);
							else
								ss.transition({ opacity:0,left:0,top:0-opt.height/2,rotate3d:'1, 0, 0, 90deg '},0);

							setTimeout(function() {

											ss.transition({opacity:1,top:0,perspective:opt.height*2,rotate3d:' 1, 0, 0, 0deg '},masterspeed*2,function() {

																	if (j==opt.slots-1) {
																		removeSlots(container,opt);
																		nextsh.find('.defaultimg').css({'opacity':1});

																		if (nextli.index()!=actli.index()) actsh.find('.defaultimg').css({'opacity':0});
																		opt.act=opt.next;
																		moveSelectedThumb(container);

																	}
															});
							},j*150);

						});

						actsh.find('.slotslide').each(function(j) {
							var ss=jQuery(this);
							ss.parent().css({'overflow':'visible'});
							ss.css({'background':'#333'});
							ss.transition({ top:0,rotate3d: '1, 0, 0, 0deg'},0);
							actsh.find('.defaultimg').css({'opacity':0});
							setTimeout(function() {
											if (direction==1)
												ss.transition({opacity:0.6,left:0,perspective: opt.height*2,top:0-opt.height/2,rotate3d: '1, 0, 0, 90deg'},masterspeed*2,function() {});
											else
												ss.transition({opacity:0.6,left:0,perspective: opt.height*2,top:(0+opt.height/2),rotate3d: '1, 0, 0, -90deg'},masterspeed*2,function() {});
							},j*150);
						});
			}

			////////////////////////////////////////
			// THE SLOTSLIDE - TRANSITION XX.  //
			///////////////////////////////////////
			if (nexttrans==20) {								// FLYIN
						masterspeed = masterspeed + 100;
						if (opt.slots>10) opt.slots=10;



						nextli.css({'opacity':1});

						// PREPARE THE SLOTS HERE
						prepareOneSlideV(actsh,opt,true);
						prepareOneSlideV(nextsh,opt,false);

						//SET DEFAULT IMG UNVISIBLE
						nextsh.find('.defaultimg').css({'opacity':0});
						//actsh.find('.defaultimg').css({'opacity':0});


						// ALL NEW SLOTS SHOULD BE SLIDED FROM THE LEFT TO THE RIGHT


						nextsh.find('.slotslide').each(function(j) {
							var ss=jQuery(this);
							ss.parent().css({'overflow':'visible'});

							if (direction==1)
								ss.transition({ scale:0.8,top:0,left:0-opt.width,rotate3d: '2, 5, 0, 110deg'},0);
							else
								ss.transition({ scale:0.8,top:0,left:0+opt.width,rotate3d: '2, 5, 0, -110deg'},0);
							setTimeout(function() {
											ss.transition({ scale:0.8,left:0,perspective: opt.width,rotate3d: '1, 5, 0, 0deg'},masterspeed*2,'ease').transition({scale:1},200,'out',function() {

																	if (j==opt.slots-1) {
																		removeSlots(container,opt);
																		nextsh.find('.defaultimg').css({'opacity':1});

																		if (nextli.index()!=actli.index()) actsh.find('.defaultimg').css({'opacity':0});
																		opt.act=opt.next;
																		moveSelectedThumb(container);

																	}
															});
							},j*100);
						});

						actsh.find('.slotslide').each(function(j) {
							var ss=jQuery(this);
							ss.transition({ scale:0.5,left:0,rotate3d: '1, 5, 0, 5deg'},300,'in-out');
							actsh.find('.defaultimg').css({'opacity':0});
							setTimeout(function() {
											if (direction==1)
												ss.transition({top:0,left:opt.width/2,perspective: opt.width,rotate3d: '0, -3, 0, 70deg',opacity:0},masterspeed*2,'out',function() {});
											else
												ss.transition({top:0,left:0-opt.width/2,perspective: opt.width,rotate3d: '0, -3, 0, -70deg',opacity:0},masterspeed*2,'out',function() {});
							},j*100);
						});
			}


			////////////////////////////////////////
			// THE SLOTSLIDE - TRANSITION XX.  //
			///////////////////////////////////////
			if (nexttrans==21) {								// TURNOFF
						masterspeed = masterspeed + 100;
						if (opt.slots>10) opt.slots=10;

						nextli.css({'opacity':1});

						// PREPARE THE SLOTS HERE
						prepareOneSlideV(actsh,opt,true);
						prepareOneSlideV(nextsh,opt,false);

						//SET DEFAULT IMG UNVISIBLE
						nextsh.find('.defaultimg').css({'opacity':0});
						//actsh.find('.defaultimg').css({'opacity':0});


						// ALL NEW SLOTS SHOULD BE SLIDED FROM THE LEFT TO THE RIGHT


						nextsh.find('.slotslide').each(function(j) {
							var ss=jQuery(this);
							if (direction==1)
								ss.transition({ top:0,left:0-(opt.width),rotate3d: '0, 1, 0, 90deg'},0);
							else
								ss.transition({ top:0,left:0+(opt.width),rotate3d: '0, 1, 0, -90deg'},0);
							setTimeout(function() {
											ss.transition({left:0,perspective: opt.width*2,rotate3d: '0, 0, 0, 0deg'},masterspeed*2,function() {

																	if (j==opt.slots-1) {
																		removeSlots(container,opt);
																		nextsh.find('.defaultimg').css({'opacity':1});

																		if (nextli.index()!=actli.index()) actsh.find('.defaultimg').css({'opacity':0});
																		opt.act=opt.next;
																		moveSelectedThumb(container);

																	}
															});
							},j*100);
						});

						actsh.find('.slotslide').each(function(j) {
							var ss=jQuery(this);
							ss.transition({ left:0,rotate3d: '0, 0, 0, 0deg'},0);
							actsh.find('.defaultimg').css({'opacity':0});
							setTimeout(function() {
										if (direction==1)
											ss.transition({top:0,left:(opt.width/2),perspective: opt.width,rotate3d: '0, 1, 0, -90deg'},masterspeed*1.5,function() {});
										else
											ss.transition({top:0,left:(0-opt.width/2),perspective: opt.width,rotate3d: '0, 1, 0, +90deg'},masterspeed*1.5,function() {});

							},j*100);
						});
			}


			var data={};
			data.slideIndex=opt.next+1;
			container.trigger('revolution.slide.onchange',data);
			setTimeout(function() { container.trigger('revolution.slide.onafterswap'); },masterspeed);
			container.trigger('revolution.slide.onvideostop');


		}




				function onYouTubePlayerAPIReady() {

							}


				//////////////////////////////////////////
				// CHANG THE YOUTUBE PLAYER STATE HERE //
				////////////////////////////////////////
				 function onPlayerStateChange(event) {

					 var embedCode = event.target.getVideoEmbedCode();
					 var container = jQuery('#'+embedCode.split('id="')[1].split('"')[0]).closest('.tp-simpleresponsive');

					if (event.data == YT.PlayerState.PLAYING) {

						var bt = container.find('.tp-bannertimer');
						var opt = bt.data('opt');
						bt.stop();

						opt.videoplaying=true;
						//console.log("VideoPlay set to True due onPlayerStateChange PLAYING");
						opt.videostartednow=1;

					} else {
						var bt = container.find('.tp-bannertimer');
						var opt = bt.data('opt');

						if (event.data!=-1) {
							if (opt.conthover==0)
								bt.animate({'width':"100%"},{duration:((opt.delay-opt.cd)-100),queue:false, easing:"linear"});
							opt.videoplaying=false;
							opt.videostoppednow=1;
							//console.log("VideoPlay set to False due onPlayerStateChange PAUSE");
						}

					}
					if (event.data==0 && opt.nextslideatend==true)
						opt.container.revnext();


				  }

				  ///////////////////////////////
				  //	YOUTUBE VIDEO AUTOPLAY //
				  ///////////////////////////////
				   function onPlayerReady(event) {
						event.target.playVideo();
					}

				 ////////////////////////
				// VIMEO ADD EVENT /////
				////////////////////////
				function addEvent(element, eventName, callback) {

							if (element.addEventListener) {

								element.addEventListener(eventName, callback, false);
							}
							else {

								element.attachEvent(eventName, callback, false);
							}


						}

				//////////////////////////////////////////
				// CHANGE THE YOUTUBE PLAYER STATE HERE //
				////////////////////////////////////////
				  function vimeoready(player_id) {

						var froogaloop = $f(player_id);
						var container = jQuery('#'+player_id).closest('.tp-simpleresponsive');

						//jQuery('#debug').html(jQuery('#debug').html()+" <br>Frooga Func"+Math.round(Math.random()*100));

						froogaloop.addEvent('ready', function(data) {
								//jQuery('#debug').html(jQuery('#debug').html()+" <br>Ready"+Math.round(Math.random()*100));
								froogaloop.addEvent('play', function(data) {
									//jQuery('#debug').html(jQuery('#debug').html()+" <br>Play"+Math.round(Math.random()*100));

									var bt = container.find('.tp-bannertimer');
									var opt = bt.data('opt');
									bt.stop();
									opt.videoplaying=true;
									//console.log("VideoPlay set to True due vimeoready PLAYING");
								});

								froogaloop.addEvent('finish', function(data) {
										var bt = container.find('.tp-bannertimer');
										var opt = bt.data('opt');
										if (opt.conthover==0)
											bt.animate({'width':"100%"},{duration:((opt.delay-opt.cd)-100),queue:false, easing:"linear"});
										opt.videoplaying=false;
										//console.log("VideoPlay set to False due vimeoready FINNSIH");
										opt.videostartednow=1;
										if (opt.nextslideatend==true)
											opt.container.revnext();

								});

								froogaloop.addEvent('pause', function(data) {
										var bt = container.find('.tp-bannertimer');
										var opt = bt.data('opt');
										if (opt.conthover==0)
											bt.animate({'width':"100%"},{duration:((opt.delay-opt.cd)-100),queue:false, easing:"linear"});
										opt.videoplaying=false;
										//console.log("VideoPlay set to False due vimeoready PAUSE");
										opt.videostoppednow=1;
								});
						});




					}

				/////////////////////////////////////
				// EVENT HANDLING FOR VIMEO VIDEOS //
				/////////////////////////////////////

					function vimeoready_auto(player_id) {

						var froogaloop = $f(player_id);
						var container = jQuery('#'+player_id).closest('.tp-simpleresponsive');

						froogaloop.addEvent('ready', function(data) {
							froogaloop.api('play');
						});

						froogaloop.addEvent('play', function(data) {
							var bt = container.find('.tp-bannertimer');
							var opt = bt.data('opt');
							bt.stop();
							opt.videoplaying=true;
							//console.log("VideoPlay set to True due vimeoready_auto PLAYING");
						});

						froogaloop.addEvent('finish', function(data) {
								var bt = container.find('.tp-bannertimer');
								var opt = bt.data('opt');
								if (opt.conthover==0)
									bt.animate({'width':"100%"},{duration:((opt.delay-opt.cd)-100),queue:false, easing:"linear"});
								opt.videoplaying=false;
							//console.log("VideoPlay set to False due vimeoready_auto FINISH");
								opt.videostartednow=1;
								if (opt.nextslideatend==true)
									opt.container.revnext();

						});

						froogaloop.addEvent('pause', function(data) {
								var bt = container.find('.tp-bannertimer');
								var opt = bt.data('opt');
								if (opt.conthover==0)
									bt.animate({'width':"100%"},{duration:((opt.delay-opt.cd)-100),queue:false, easing:"linear"});
								opt.videoplaying=false;
							//console.log("VideoPlay set to False due vimeoready_auto PAUSE");
								opt.videostoppednow=1;
						});
					}


					///////////////////////////////////////
					// EVENT HANDLING FOR VIDEO JS VIDEOS //
					////////////////////////////////////////
					function html5vidready(myPlayer) {

						myPlayer.on("play",function() {
							var bt = jQuery('body').find('.tp-bannertimer');
							var opt = bt.data('opt');
							bt.stop();
							try{
								opt.videoplaying=true;
							} catch(e) {}
							//console.log("VideoPlay set to True due html5vidready PLAYING");
						});

						myPlayer.on("pause",function() {
							    var bt = jQuery('body').find('.tp-bannertimer');
								var opt = bt.data('opt');
								if (opt.conthover==0)
									bt.animate({'width':"100%"},{duration:((opt.delay-opt.cd)-100),queue:false, easing:"linear"});
								opt.videoplaying=false;
								//console.log("VideoPlay set to False due html5vidready pause");
								opt.videostoppednow=1;
						});

						myPlayer.on("ended",function() {
								var bt = jQuery('body').find('.tp-bannertimer');
								var opt = bt.data('opt');
								if (opt.conthover==0)
									bt.animate({'width':"100%"},{duration:((opt.delay-opt.cd)-100),queue:false, easing:"linear"});
								opt.videoplaying=false;
								//console.log("VideoPlay set to False due html5vidready pause");
								opt.videostoppednow=1;
								if (opt.nextslideatend==true)
									opt.container.revnext();
						});

					}




				////////////////////////
				// SHOW THE CAPTION  //
				///////////////////////
				function animateTheCaptions(nextli, opt,actli) {


						//if (jQuery("body").find('#debug').length==0)
						//		jQuery("body").append('<div id="debug" style="background:#000;z-index:1000;position:fixed;top:5px;left:5px;width:100px;height:500px;color:#fff;font-size:10px;font-family:Arial;"</div>');


						var offsetx=0;
						var offsety=0;

						nextli.find('.tp-caption').each(function(i) {

								offsetx = opt.width/2 - opt.startwidth/2;



								if (opt.bh>1) {
									opt.bw=1;
									opt.bh=1;
								}

								if (opt.bw>1) {
									opt.bw=1;
									opt.bh=1;
								}

								var xbw = opt.bw;
								var xbh = opt.bh;


								if (opt.fullScreen=="on")
								  offsety = opt.height/2 - (opt.startheight*opt.bh)/2;

								if (offsety<0) offsety=0;



								var nextcaption=nextli.find('.tp-caption:eq('+i+')');

								var handlecaption=0;

								// HIDE CAPTION IF RESOLUTION IS TOO LOW
								if (opt.width<opt.hideCaptionAtLimit && nextcaption.data('captionhidden')=="on") {
									nextcaption.addClass("tp-hidden-caption")
									handlecaption=1;
								} else {
									if (opt.width<opt.hideAllCaptionAtLilmit)	{
										nextcaption.addClass("tp-hidden-caption")
										handlecaption=1;
									} else {
										nextcaption.removeClass("tp-hidden-caption")
									}
								}




								nextcaption.stop(true,true);
								if (handlecaption==0) {
											if (nextcaption.data('linktoslide')!=undefined) {
												nextcaption.css({'cursor':'pointer'});
												if (nextcaption.data('linktoslide')!="no") {
													nextcaption.click(function() {
														var nextcaption=jQuery(this);
														var dir = nextcaption.data('linktoslide');
														if (dir!="next" && dir!="prev") {
															opt.container.data('showus',dir);
															opt.container.parent().find('.tp-rightarrow').click();
														} else
															if (dir=="next")
																opt.container.parent().find('.tp-rightarrow').click();
														else
															if (dir=="prev")
																opt.container.parent().find('.tp-leftarrow').click();
													});
												}
											}


											if (nextcaption.hasClass("coloredbg")) offsetx=0;
											if (offsetx<0) offsetx=0;

											//var offsety = 0; //opt.height/2 - (opt.startheight*xbh)/2;

											clearTimeout(nextcaption.data('timer'));
											clearTimeout(nextcaption.data('timer-end'));



											// YOUTUBE AND VIMEO LISTENRES INITIALISATION

											var frameID = "iframe"+Math.round(Math.random()*1000+1);

											if (nextcaption.find('iframe').length>0) {

											  nextcaption.find('iframe').each(function() {
												var ifr=jQuery(this);

												if (ifr.attr('src').toLowerCase().indexOf('youtube')>=0) {
														 opt.nextslideatend = nextcaption.data('nextslideatend');
														 if (!ifr.hasClass("HasListener")) {
															try {
																ifr.attr('id',frameID);

																var player;
																if (nextcaption.data('autoplay')==true)
																	player = new YT.Player(frameID, {
																		events: {
																			"onStateChange": onPlayerStateChange,
																			'onReady': onPlayerReady
																		}
																	});
																else
																	player = new YT.Player(frameID, {
																		events: {
																			"onStateChange": onPlayerStateChange
																		}
																	});
																ifr.addClass("HasListener");

																nextcaption.data('player',player);

																if (nextcaption.data('autoplay')==true) {
																		var bt=jQuery('body').find('#'+opt.container.attr('id')).find('.tp-bannertimer');
																		setTimeout(function(){
																					bt.stop();
																					opt.videoplaying=true;
																				},200);


																		//console.log("VideoPlay set to True due youtube 1st load AutoPlay");
																}
															} catch(e) {}
													 } else {
														if (nextcaption.data('autoplay')==true) {


																var player=nextcaption.data('player');
																nextcaption.data('timerplay',setTimeout(function() {
																			player.playVideo();
																		},nextcaption.data('start')));

																var bt=jQuery('body').find('#'+opt.container.attr('id')).find('.tp-bannertimer');
																setTimeout(function(){
																			bt.stop();
																			opt.videoplaying=true;
																		},200);


																//console.log("VideoPlay set to True due youtube 2nd load AutoPlay");
														}
													 }

												} else {
													if (ifr.attr('src').toLowerCase().indexOf('vimeo')>=0) {
														  opt.nextslideatend = nextcaption.data('nextslideatend');
														   if (!ifr.hasClass("HasListener")) {
																ifr.addClass("HasListener");
																ifr.attr('id',frameID);
																var isrc = ifr.attr('src');
																var queryParameters = {}, queryString = isrc,
																re = /([^&=]+)=([^&]*)/g, m;
																// Creates a map with the query string parameters
																while (m = re.exec(queryString)) {
																	queryParameters[decodeURIComponent(m[1])] = decodeURIComponent(m[2]);
																}


																if (queryParameters['player_id']!=undefined) {

																	isrc = isrc.replace(queryParameters['player_id'],frameID);
																} else {
																	isrc=isrc+"&player_id="+frameID;
																}

																try{
																		isrc = isrc.replace('api=0','api=1');
																	} catch(e) {}

																isrc=isrc+"&api=1";



																ifr.attr('src',isrc);
																var player = nextcaption.find('iframe')[0];
																if (nextcaption.data('autoplay')==true) {

																	$f(player).addEvent('ready', vimeoready_auto);
																	//console.log('#'+opt.container.attr('id'));
																	var bt=jQuery('body').find('#'+opt.container.attr('id')).find('.tp-bannertimer');
																		setTimeout(function(){
																			bt.stop();
																			opt.videoplaying=true;
																		},200);


																		//console.log("VideoPlay set to True due vimeo 1st load AutoPlay");
																} else {
																	$f(player).addEvent('ready', vimeoready);
																}


															   } else {
																	if (nextcaption.data('autoplay')==true) {

																		var ifr = nextcaption.find('iframe');
																		var id = ifr.attr('id');
																		var froogaloop = $f(id);
																		nextcaption.data('timerplay',setTimeout(function() {
																			froogaloop.api("play");
																		},nextcaption.data('start')));
																		var bt=jQuery('body').find('#'+opt.container.attr('id')).find('.tp-bannertimer');
																		setTimeout(function(){
																			bt.stop();
																			opt.videoplaying=true;
																		},200);


																		//console.log("VideoPlay set to True due youtube 2nd load AutoPlay");
																	}
															   }

														}
													}
												});
											}

										// IF HTML5 VIDEO IS EMBEDED
										if (nextcaption.find('video').length>0) {
											nextcaption.find('video').each(function(i) {
												var html5vid = jQuery(this).parent();

												if (html5vid.hasClass("video-js")) {
													opt.nextslideatend = nextcaption.data('nextslideatend');
													if (!html5vid.hasClass("HasListener")) {
														html5vid.addClass("HasListener");
														var videoID = "videoid_"+Math.round(Math.random()*1000+1);
														html5vid.attr('id',videoID);
														videojs(videoID).ready(function(){
															html5vidready(this)
														});
													} else {
														videoID = html5vid.attr('id');
													}
													if (nextcaption.data('autoplay')==true) {

														var bt=jQuery('body').find('#'+opt.container.attr('id')).find('.tp-bannertimer');
														setTimeout(function(){
															bt.stop();
															opt.videoplaying=true;
														},200);

														//console.log("VideoPlay set to True due HTML5 VIDEO 1st/2nd load AutoPlay");

														videojs(videoID).ready(function(){
															var myPlayer = this;
															html5vid.data('timerplay',setTimeout(function() {
																myPlayer.play();
															},nextcaption.data('start')));
														});
													}


													if (html5vid.data('ww') == undefined) html5vid.data('ww',html5vid.width());
													if (html5vid.data('hh') == undefined) html5vid.data('hh',html5vid.height());

													videojs(videoID).ready(function(){
														if (!nextcaption.hasClass("fullscreenvideo")) {
															var myPlayer = videojs(videoID);

															try{
																myPlayer.width(html5vid.data('ww')*opt.bw);
																myPlayer.height(html5vid.data('hh')*opt.bh);
															} catch(e) {}
														}
													});


												 }

											});
										} // END OF VIDEO JS FUNCTIONS



										if (nextcaption.hasClass("randomrotate") && (opt.ie || opt.ie9)) nextcaption.removeClass("randomrotate").addClass("sfb");
											nextcaption.removeClass('noFilterClass');



										   var imw =0;
										   var imh = 0;

													if (nextcaption.find('img').length>0) {
														var im = nextcaption.find('img');
														if (im.data('ww') == undefined) im.data('ww',im.width());
														if (im.data('hh') == undefined) im.data('hh',im.height());

														var ww = im.data('ww');
														var hh = im.data('hh');


														im.width(ww*opt.bw);
														im.height(hh*opt.bh);
														imw = im.width();
														imh = im.height();
													} else {

														if (nextcaption.find('iframe').length>0) {

															var im = nextcaption.find('iframe');
															if (nextcaption.data('ww') == undefined) {
																nextcaption.data('ww',im.width());
															}
															if (nextcaption.data('hh') == undefined) nextcaption.data('hh',im.height());

															var ww = nextcaption.data('ww');
															var hh = nextcaption.data('hh');

															var nc =nextcaption;
																if (nc.data('fsize') == undefined) nc.data('fsize',parseInt(nc.css('font-size'),0) || 0);
																if (nc.data('pt') == undefined) nc.data('pt',parseInt(nc.css('paddingTop'),0) || 0);
																if (nc.data('pb') == undefined) nc.data('pb',parseInt(nc.css('paddingBottom'),0) || 0);
																if (nc.data('pl') == undefined) nc.data('pl',parseInt(nc.css('paddingLeft'),0) || 0);
																if (nc.data('pr') == undefined) nc.data('pr',parseInt(nc.css('paddingRight'),0) || 0);

																if (nc.data('mt') == undefined) nc.data('mt',parseInt(nc.css('marginTop'),0) || 0);
																if (nc.data('mb') == undefined) nc.data('mb',parseInt(nc.css('marginBottom'),0) || 0);
																if (nc.data('ml') == undefined) nc.data('ml',parseInt(nc.css('marginLeft'),0) || 0);
																if (nc.data('mr') == undefined) nc.data('mr',parseInt(nc.css('marginRight'),0) || 0);

																if (nc.data('bt') == undefined) nc.data('bt',parseInt(nc.css('borderTop'),0) || 0);
																if (nc.data('bb') == undefined) nc.data('bb',parseInt(nc.css('borderBottom'),0) || 0);
																if (nc.data('bl') == undefined) nc.data('bl',parseInt(nc.css('borderLeft'),0) || 0);
																if (nc.data('br') == undefined) nc.data('br',parseInt(nc.css('borderRight'),0) || 0);

																if (nc.data('lh') == undefined) nc.data('lh',parseInt(nc.css('lineHeight'),0) || 0);

																var fvwidth=opt.width;
																var fvheight=opt.height;
																if (fvwidth>opt.startwidth) fvwidth=opt.startwidth;
																if (fvheight>opt.startheight) fvheight=opt.startheight;

																if (!nextcaption.hasClass('fullscreenvideo'))
																			nextcaption.css({

																				 'font-size': (nc.data('fsize') * opt.bw)+"px",

																				 'padding-top': (nc.data('pt') * opt.bh) + "px",
																				 'padding-bottom': (nc.data('pb') * opt.bh) + "px",
																				 'padding-left': (nc.data('pl') * opt.bw) + "px",
																				 'padding-right': (nc.data('pr') * opt.bw) + "px",

																				 'margin-top': (nc.data('mt') * opt.bh) + "px",
																				 'margin-bottom': (nc.data('mb') * opt.bh) + "px",
																				 'margin-left': (nc.data('ml') * opt.bw) + "px",
																				 'margin-right': (nc.data('mr') * opt.bw) + "px",

																				 'border-top': (nc.data('bt') * opt.bh) + "px",
																				 'border-bottom': (nc.data('bb') * opt.bh) + "px",
																				 'border-left': (nc.data('bl') * opt.bw) + "px",
																				 'border-right': (nc.data('br') * opt.bw) + "px",

																				 'line-height': (nc.data('lh') * opt.bh) + "px",
																				 'height':(hh*opt.bh)+'px',
																				 'white-space':"nowrap"
																				});
																	else  {
																		   offsetx=0; offsety=0;
																			nextcaption.css({
																				'width':opt.width,
																				'height':opt.height
																			});
																		}


															im.width(ww*opt.bw);
															im.height(hh*opt.bh);
															imw = im.width();
															imh = im.height();
														} else {


																nextcaption.find('.tp-resizeme, .tp-resizeme *').each(function() {
																		calcCaptionResponsive(jQuery(this),opt);
																});

																if (nextcaption.hasClass("tp-resizeme")) {
																	nextcaption.find('*').each(function() {
																		calcCaptionResponsive(jQuery(this),opt);
																	});
																}

																calcCaptionResponsive(nextcaption,opt);

																imh=nextcaption.outerHeight(true);
																imw=nextcaption.outerWidth(true);

																// NEXTCAPTION FRONTCORNER CHANGES
																var ncch = nextcaption.outerHeight();
																var bgcol = nextcaption.css('backgroundColor');
																nextcaption.find('.frontcorner').css({
																				'borderWidth':ncch+"px",
																				'left':(0-ncch)+'px',
																				'borderRight':'0px solid transparent',
																				'borderTopColor':bgcol
																});

																nextcaption.find('.frontcornertop').css({
																				'borderWidth':ncch+"px",
																				'left':(0-ncch)+'px',
																				'borderRight':'0px solid transparent',
																				'borderBottomColor':bgcol
																});

																// NEXTCAPTION BACKCORNER CHANGES
																nextcaption.find('.backcorner').css({
																				'borderWidth':ncch+"px",
																				'right':(0-ncch)+'px',
																				'borderLeft':'0px solid transparent',
																				'borderBottomColor':bgcol
																});

																// NEXTCAPTION BACKCORNER CHANGES
																nextcaption.find('.backcornertop').css({
																				'borderWidth':ncch+"px",
																				'right':(0-ncch)+'px',
																				'borderLeft':'0px solid transparent',
																				'borderTopColor':bgcol
																});

															}
													}

											if (nextcaption.data('voffset')==undefined) nextcaption.data('voffset',0);
											if (nextcaption.data('hoffset')==undefined) nextcaption.data('hoffset',0);

											var vofs= nextcaption.data('voffset')*xbw;
											var hofs= nextcaption.data('hoffset')*xbw;

											var crw = opt.startwidth*xbw;
											var crh = opt.startheight*xbw;


											// CENTER THE CAPTION HORIZONTALLY
											if (nextcaption.data('x')=="center" || nextcaption.data('xcenter')=='center') {
												nextcaption.data('xcenter','center');
												nextcaption.data('x',(crw/2 - nextcaption.outerWidth(true)/2)/xbw+  hofs);

											}

											// ALIGN LEFT THE CAPTION HORIZONTALLY
											if (nextcaption.data('x')=="left" || nextcaption.data('xleft')=='left') {
												nextcaption.data('xleft','left');
												nextcaption.data('x',(0)/xbw+hofs);

											}

											// ALIGN RIGHT THE CAPTION HORIZONTALLY
											if (nextcaption.data('x')=="right" || nextcaption.data('xright')=='right') {
												nextcaption.data('xright','right');
												nextcaption.data('x',((crw - nextcaption.outerWidth(true))+hofs)/xbw);
												//console.log("crw:"+crw+"  width:"+nextcaption.outerWidth(true)+"  xbw:"+xbw);
												//console.log("x-pos:"+nextcaption.data('x'))
											}


											// CENTER THE CAPTION VERTICALLY
											if (nextcaption.data('y')=="center" || nextcaption.data('ycenter')=='center') {
												nextcaption.data('ycenter','center');
												nextcaption.data('y',(crh/2 - nextcaption.outerHeight(true)/2)/opt.bh + vofs);

											}

											// ALIGN TOP THE CAPTION VERTICALLY
											if (nextcaption.data('y')=="top" || nextcaption.data('ytop')=='top') {
												nextcaption.data('ytop','top');
												nextcaption.data('y',(0)/opt.bh+vofs);

											}

											// ALIGN BOTTOM THE CAPTION VERTICALLY
											if (nextcaption.data('y')=="bottom" || nextcaption.data('ybottom')=='bottom') {
												nextcaption.data('ybottom','bottom');
												nextcaption.data('y',((crh - nextcaption.outerHeight(true))+vofs)/xbw);
											}


											if (nextcaption.hasClass('fade')) {

												nextcaption.css({'opacity':0,'left':(xbw*nextcaption.data('x')+offsetx)+'px','top':(opt.bh*nextcaption.data('y')+offsety)+"px"});
											}

											if (nextcaption.hasClass("randomrotate")) {

														nextcaption.css({'left':(xbw*nextcaption.data('x')+offsetx)+'px','top':((xbh*nextcaption.data('y'))+offsety)+"px" });
														var sc=Math.random()*2+1;
														var ro=Math.round(Math.random()*200-100);
														var xx=Math.round(Math.random()*200-100);
														var yy=Math.round(Math.random()*200-100);
														nextcaption.data('repx',xx);
														nextcaption.data('repy',yy);
														nextcaption.data('repo',nextcaption.css('opacity'));
														nextcaption.data('rotate',ro);
														nextcaption.data('scale',sc);

														nextcaption.transition({opacity:0, scale:sc, rotate:ro, x:xx, y: yy,duration: '0ms'});
											} else {
												if (opt.ie || opt.ie9 )
													{}
												else {
												if (nextcaption.find('iframe').length==0)
													nextcaption.transition({ scale:1, rotate:0});
												}
											}

											if (nextcaption.hasClass('lfr')) {

												nextcaption.css({'opacity':1,'left':(15+opt.width)+'px','top':(opt.bh*nextcaption.data('y')+offsety)+"px"});

											}

											if (nextcaption.hasClass('lfl')) {

												nextcaption.css({'opacity':1,'left':(-15-imw)+'px','top':(opt.bh*nextcaption.data('y')+offsety)+"px"});

											}

											if (nextcaption.hasClass('sfl')) {

												nextcaption.css({'opacity':0,'left':((xbw*nextcaption.data('x'))-50+offsetx)+'px','top':(opt.bh*nextcaption.data('y')+offsety)+"px"});
											}

											if (nextcaption.hasClass('sfr')) {
												nextcaption.css({'opacity':0,'left':((xbw*nextcaption.data('x'))+50+offsetx)+'px','top':(opt.bh*nextcaption.data('y')+offsety)+"px"});
											}




											if (nextcaption.hasClass('lft')) {

												nextcaption.css({'opacity':1,'left':(xbw*nextcaption.data('x')+offsetx)+'px','top':(-25 - imh)+"px"});

											}

											if (nextcaption.hasClass('lfb')) {
												nextcaption.css({'opacity':1,'left':(xbw*nextcaption.data('x')+offsetx)+'px','top':(25+opt.height)+"px"});

											}

											if (nextcaption.hasClass('sft')) {
												nextcaption.css({'opacity':0,'left':(xbw*nextcaption.data('x')+offsetx)+'px','top':((opt.bh*nextcaption.data('y')+offsety)-50)+"px"});
											}

											if (nextcaption.hasClass('sfb')) {
												nextcaption.css({'opacity':0,'left':(xbw*nextcaption.data('x')+offsetx)+'px','top':((opt.bh*nextcaption.data('y')+offsety)+50)+"px"});
											}


											if (nextcaption.data('start') == undefined) nextcaption.data('start',1000);



											nextcaption.data('timer',setTimeout(function() {
													var easetype=nextcaption.data('easing');
													if (easetype==undefined) easetype="linear";

													if (nextcaption.hasClass("fullscreenvideo"))
														nextcaption.css({'display':'block'});



													nextcaption.css({'visibility':'visible'});
													if (nextcaption.hasClass('fade')) {
														nextcaption.data('repo',nextcaption.css('opacity'));

														//nextcaption.animate({'opacity':1},{duration:nextcaption.data('speed'),complete:function() { if (opt.ie) jQuery(this).addClass('noFilterClass');}});
														nextcaption.transition({'opacity':1,duration:nextcaption.data('speed')});
														//if (opt.ie) nextcaption.addClass('noFilterClass');
													}

													if (nextcaption.hasClass("randomrotate")) {

														easetype = easetype.replace('Elastic','Back');
														easetype = easetype.replace('Bounce','Back');
														nextcaption.transition({opacity:1, scale:1, 'left':(xbw*nextcaption.data('x')+offsetx)+'px','top':(xbh*(nextcaption.data('y'))+offsety)+"px", rotate:0, x:0, y:0,duration: nextcaption.data('speed'), easing:easetype});
														if (opt.ie) nextcaption.addClass('noFilterClass');
													}

													if (nextcaption.hasClass('lfr') ||
														nextcaption.hasClass('lfl') ||
														nextcaption.hasClass('sfr') ||
														nextcaption.hasClass('sfl') ||
														nextcaption.hasClass('lft') ||
														nextcaption.hasClass('lfb') ||
														nextcaption.hasClass('sft') ||
														nextcaption.hasClass('sfb')
														)
													{

														nextcaption.data('repx',nextcaption.position().left);
														nextcaption.data('repy',nextcaption.position().top);

														nextcaption.data('repo',nextcaption.css('opacity'));
														if (easetype.indexOf("Bounce")>=0 || easetype.indexOf("Elastic")>=0)
														  nextcaption.animate({'opacity':1,'left':(xbw*nextcaption.data('x')+offsetx)+'px','top':opt.bh*(nextcaption.data('y'))+offsety+"px"},{duration:nextcaption.data('speed'), easing:easetype,complete:function() { if (opt.ie) jQuery(this).addClass('noFilterClass');}});
														else
														  nextcaption.transition({'opacity':1,'left':(xbw*nextcaption.data('x')+offsetx)+'px','top':opt.bh*(nextcaption.data('y'))+offsety+"px",duration:nextcaption.data('speed'), easing:easetype});
														//if (opt.ie) nextcaption.addClass('noFilterClass');
													}
											},nextcaption.data('start')));


											// IF THERE IS ANY EXIT ANIM DEFINED
											if (nextcaption.data('end')!=undefined)

												nextcaption.data('timer-end',setTimeout(function() {

														if ((opt.ie || opt.ie9) && (nextcaption.hasClass("randomrotate") || nextcaption.hasClass("randomrotateout"))) {
															nextcaption.removeClass("randomrotate").removeClass("randomrotateout").addClass('fadeout');
														}

														endMoveCaption(nextcaption,opt);

												},nextcaption.data('end')));
									}
						})

						var bt=jQuery('body').find('#'+opt.container.attr('id')).find('.tp-bannertimer');
						bt.data('opt',opt);
				}



				/////////////////////////////////////////////////////////////////
				//	-	CALCULATE THE RESPONSIVE SIZES OF THE CAPTIONS	-	  //
				/////////////////////////////////////////////////////////////////
				function calcCaptionResponsive(nc,opt) {
								if (nc.data('fsize') == undefined) nc.data('fsize',parseInt(nc.css('font-size'),0) || 0);
								if (nc.data('pt') == undefined) nc.data('pt',parseInt(nc.css('paddingTop'),0) || 0);
								if (nc.data('pb') == undefined) nc.data('pb',parseInt(nc.css('paddingBottom'),0) || 0);
								if (nc.data('pl') == undefined) nc.data('pl',parseInt(nc.css('paddingLeft'),0) || 0);
								if (nc.data('pr') == undefined) nc.data('pr',parseInt(nc.css('paddingRight'),0) || 0);

								if (nc.data('mt') == undefined) nc.data('mt',parseInt(nc.css('marginTop'),0) || 0);
								if (nc.data('mb') == undefined) nc.data('mb',parseInt(nc.css('marginBottom'),0) || 0);
								if (nc.data('ml') == undefined) nc.data('ml',parseInt(nc.css('marginLeft'),0) || 0);
								if (nc.data('mr') == undefined) nc.data('mr',parseInt(nc.css('marginRight'),0) || 0);

								if (nc.data('bt') == undefined) nc.data('bt',parseInt(nc.css('borderTopWidth'),0) || 0);
								if (nc.data('bb') == undefined) nc.data('bb',parseInt(nc.css('borderBottomWidth'),0) || 0);
								if (nc.data('bl') == undefined) nc.data('bl',parseInt(nc.css('borderLeftWidth'),0) || 0);
								if (nc.data('br') == undefined) nc.data('br',parseInt(nc.css('borderRightWidth'),0) || 0);

								if (nc.data('lh') == undefined) nc.data('lh',parseInt(nc.css('lineHeight'),0) || 0);
								if (nc.data('minwidth') == undefined) nc.data('minwidth',parseInt(nc.css('minWidth'),0) || 0);
								if (nc.data('minheight') == undefined) nc.data('minheight',parseInt(nc.css('minHeight'),0) || 0);
								if (nc.data('maxwidth') == undefined) nc.data('maxwidth',parseInt(nc.css('maxWidth'),0) || "none");
								if (nc.data('maxheight') == undefined) nc.data('maxheight',parseInt(nc.css('maxHeight'),0) || "none");


								nc.css({
												 'font-size': Math.round((nc.data('fsize') * opt.bw))+"px",

												 'padding-top': Math.round((nc.data('pt') * opt.bh)) + "px",
												 'padding-bottom': Math.round((nc.data('pb') * opt.bh)) + "px",
												 'padding-left': Math.round((nc.data('pl') * opt.bw)) + "px",
												 'padding-right': Math.round((nc.data('pr') * opt.bw)) + "px",

												 'margin-top': (nc.data('mt') * opt.bh) + "px",
												 'margin-bottom': (nc.data('mb') * opt.bh) + "px",
												 'margin-left': (nc.data('ml') * opt.bw) + "px",
												 'margin-right': (nc.data('mr') * opt.bw) + "px",

												 'borderTopWidth': Math.round((nc.data('bt') * opt.bh)) + "px",
												 'borderBottomWidth': Math.round((nc.data('bb') * opt.bh)) + "px",
												 'borderLeftWidth': Math.round((nc.data('bl') * opt.bw)) + "px",
												 'borderRightWidth': Math.round((nc.data('br') * opt.bw)) + "px",

												 'line-height': Math.round((nc.data('lh') * opt.bh)) + "px",
												 'white-space':"nowrap",
												 'minWidth':(nc.data('minwidth') * opt.bw) + "px",
												 'minHeight':(nc.data('minheight') * opt.bh) + "px",
								});

								//console.log(nc.data('maxwidth')+"  "+nc.data('maxheight'));
								if (nc.data('maxheight')!='none')
									nc.css({'maxHeight':(nc.data('maxheight') * opt.bh) + "px"});


								if (nc.data('maxwidth')!='none')
									nc.css({'maxWidth':(nc.data('maxwidth') * opt.bw) + "px"});
						}


				//////////////////////////
				//	REMOVE THE CAPTIONS //
				/////////////////////////
				function removeTheCaptions(actli,opt) {

						actli.find('.tp-caption').each(function(i) {
							var nextcaption=actli.find('.tp-caption:eq('+i+')');
							nextcaption.stop(true,true);
							clearTimeout(nextcaption.data('timer'));
							clearTimeout(nextcaption.data('timer-end'));

							var easetype=nextcaption.data('easing');
							easetype="easeInOutSine";
							var ll = nextcaption.data('repx');
							var tt = nextcaption.data('repy');
							var oo = nextcaption.data('repo');
							var rot = nextcaption.data('rotate');
							var sca = nextcaption.data('scale');


							if (nextcaption.find('iframe').length>0) {
															// VIMEO VIDEO PAUSE
															try {
																var ifr = nextcaption.find('iframe');
																var id = ifr.attr('id');
																var froogaloop = $f(id);
																froogaloop.api("pause");
																clearTimeout(nextcaption.data('timerplay'));
															} catch(e) {}
															//YOU TUBE PAUSE
															try {
																var player=nextcaption.data('player');
																player.stopVideo();
																clearTimeout(nextcaption.data('timerplay'));
															} catch(e) {}
														}

							// IF HTML5 VIDEO IS EMBEDED
							if (nextcaption.find('video').length>0) {
											try{
												nextcaption.find('video').each(function(i) {
													var html5vid = jQuery(this).parent();
													var videoID =html5vid.attr('id');
													clearTimeout(html5vid.data('timerplay'));
													videojs(videoID).ready(function(){
														var myPlayer = this;
														myPlayer.pause();
													});
												})
											}catch(e) {}
										} // END OF VIDEO JS FUNCTIONS
							try {
									/*if (rot!=undefined || sca!=undefined)
										{
											if (rot==undefined) rot=0;
											if (sca==undefined) sca=1;
												nextcaption.transition({'rotate':rot, 'scale':sca, 'opacity':0,'left':ll+'px','top':tt+"px"},(nextcaption.data('speed')+10), function() { nextcaption.removeClass('noFilterClass');nextcaption.css({'visibility':'hidden'})});
										} else {

											nextcaption.animate({'opacity':0,'left':ll+'px','top':tt+"px"},{duration:(nextcaption.data('speed')+10), easing:easetype, complete:function() { nextcaption.removeClass('noFilterClass');nextcaption.css({'visibility':'hidden'})}});
										}*/
									endMoveCaption(nextcaption,opt);
								} catch(e) {}



						});
				}

				//////////////////////////
				//	MOVE OUT THE CAPTIONS //
				/////////////////////////
				function endMoveCaption(nextcaption,opt) {


														if (nextcaption.hasClass("randomrotate") && (opt.ie || opt.ie9)) nextcaption.removeClass("randomrotate").addClass("sfb");
														if (nextcaption.hasClass("randomrotateout") && (opt.ie || opt.ie9)) nextcaption.removeClass("randomrotateout").addClass("stb");

														var endspeed=nextcaption.data('endspeed');
														if (endspeed==undefined) endspeed=nextcaption.data('speed');

														var xx=nextcaption.data('repx');
														var yy=nextcaption.data('repy');
														var oo=nextcaption.data('repo');

														if (opt.ie) {
															nextcaption.css({'opacity':'inherit','filter':'inherit'});
														}

														if (nextcaption.hasClass('ltr') ||
															nextcaption.hasClass('ltl') ||
															nextcaption.hasClass('str') ||
															nextcaption.hasClass('stl') ||
															nextcaption.hasClass('ltt') ||
															nextcaption.hasClass('ltb') ||
															nextcaption.hasClass('stt') ||
															nextcaption.hasClass('stb')
															)
														{

															xx=nextcaption.position().left;
															yy=nextcaption.position().top;

															if (nextcaption.hasClass('ltr'))
																xx=opt.width+60;
															else if (nextcaption.hasClass('ltl'))
																xx=0-nextcaption.width()-60;
															else if (nextcaption.hasClass('ltt'))
																yy=0-nextcaption.height()-60;
															else if (nextcaption.hasClass('ltb'))
																yy=opt.height+60;
															else if (nextcaption.hasClass('str')) {
																xx=xx+50;oo=0;
															} else if (nextcaption.hasClass('stl')) {
																xx=xx-50;oo=0;
															} else if (nextcaption.hasClass('stt')) {
																yy=yy-50;oo=0;
															} else if (nextcaption.hasClass('stb')) {
																yy=yy+50;oo=0;
															}

															var easetype=nextcaption.data('endeasing');
															if (easetype==undefined) easetype="linear";
															if (easetype.indexOf("Bounce")>=0 || easetype.indexOf("Elastic")>=0)
															  nextcaption.animate({'opacity':oo,'left':xx+'px','top':yy+"px"},{duration:nextcaption.data('endspeed'), easing:easetype,complete:function() { jQuery(this).css({visibility:'hidden'})}});
															else
  															  nextcaption.transition({'opacity':oo,'left':xx+'px','top':yy+"px",duration:nextcaption.data('endspeed'), easing:easetype});
															if (opt.ie) nextcaption.removeClass('noFilterClass');

														}

														else

														if ( nextcaption.hasClass("randomrotateout")) {

															nextcaption.transition({opacity:0, scale:Math.random()*2+0.3, 'left':Math.random()*opt.width+'px','top':Math.random()*opt.height+"px", rotate:Math.random()*40, duration: endspeed, easing:easetype, complete:function() { jQuery(this).css({visibility:'hidden'})}});
															if (opt.ie) nextcaption.removeClass('noFilterClass');

														}

														else

														if (nextcaption.hasClass('fadeout')) {
															if (opt.ie) nextcaption.removeClass('noFilterClass');
															nextcaption.transition({'opacity':0,duration:200});
															//nextcaption.animate({'opacity':0},{duration:200,complete:function() { jQuery(this).css({visibility:'hidden'})}});

														}

														else

														if (nextcaption.hasClass('lfr') ||
															nextcaption.hasClass('lfl') ||
															nextcaption.hasClass('sfr') ||
															nextcaption.hasClass('sfl') ||
															nextcaption.hasClass('lft') ||
															nextcaption.hasClass('lfb') ||
															nextcaption.hasClass('sft') ||
															nextcaption.hasClass('sfb')
															)
														{

															if (nextcaption.hasClass('lfr'))
																xx=opt.width+60;
															else  if (nextcaption.hasClass('lfl'))
																xx=0-nextcaption.width()-60;
															else if (nextcaption.hasClass('lft'))
																yy=0-nextcaption.height()-60;
															else if (nextcaption.hasClass('lfb'))
																yy=opt.height+60;


															var easetype=nextcaption.data('endeasing');
															if (easetype==undefined) easetype="linear";
															if (easetype.indexOf("Bounce")>=0 || easetype.indexOf("Elastic")>=0)
																	nextcaption.animate({'opacity':oo,'left':xx+'px','top':yy+"px"},{duration:nextcaption.data('endspeed'), easing:easetype, complete:function() { jQuery(this).css({visibility:'hidden'})}});
															else
																	nextcaption.transition({'opacity':oo,'left':xx+'px','top':yy+"px",duration:nextcaption.data('endspeed'), easing:easetype});
															if (opt.ie) nextcaption.removeClass('noFilterClass');

														}

														else

														if (nextcaption.hasClass('fade')) {

															//nextcaption.animate({'opacity':0},{duration:endspeed,complete:function() { jQuery(this).css({visibility:'hidden'})} });
															nextcaption.transition({'opacity':0,duration:endspeed });
															if (opt.ie) nextcaption.removeClass('noFilterClass');

														}

														else

														if (nextcaption.hasClass("randomrotate")) {

															nextcaption.transition({opacity:0, scale:Math.random()*2+0.3, 'left':Math.random()*opt.width+'px','top':Math.random()*opt.height+"px", rotate:Math.random()*40, duration: endspeed, easing:easetype });
															if (opt.ie) nextcaption.removeClass('noFilterClass');

														}
				}

		///////////////////////////
		//	REMOVE THE LISTENERS //
		///////////////////////////
		function removeAllListeners(container,opt) {
			container.children().each(function() {
			  try{ jQuery(this).die('click'); } catch(e) {}
			  try{ jQuery(this).die('mouseenter');} catch(e) {}
			  try{ jQuery(this).die('mouseleave');} catch(e) {}
			  try{ jQuery(this).unbind('hover');} catch(e) {}
			})
			try{ container.die('click','mouseenter','mouseleave');} catch(e) {}
			clearInterval(opt.cdint);
			container=null;



		}

		///////////////////////////
		//	-	COUNTDOWN	-	//
		/////////////////////////
		function countDown(container,opt) {
			opt.cd=0;
			opt.loop=0;
			if (opt.stopAfterLoops!=undefined && opt.stopAfterLoops>-1)
					opt.looptogo=opt.stopAfterLoops;
			else
				opt.looptogo=9999999;

			if (opt.stopAtSlide!=undefined && opt.stopAtSlide>-1)
					opt.lastslidetoshow=opt.stopAtSlide;
			else
					opt.lastslidetoshow=999;

			opt.stopLoop="off";

			if (opt.looptogo==0) opt.stopLoop="on";



			if (opt.slideamount >1 && !(opt.stopAfterLoops==0 && opt.stopAtSlide==1) ) {
					var bt=container.find('.tp-bannertimer');
					if (bt.length>0) {
						bt.css({'width':'0%'});
						bt.animate({'width':"100%"},{duration:(opt.delay-100),queue:false, easing:"linear"});

					}

					bt.data('opt',opt);


					opt.cdint=setInterval(function() {

						if (jQuery('body').find(container).length==0) removeAllListeners(container,opt);
						if (container.data('conthover-changed') == 1) {
							opt.conthover=	container.data('conthover');
							container.data('conthover-changed',0);
						}

						if (opt.conthover!=1 && opt.videoplaying!=true && opt.width>opt.hideSliderAtLimit) opt.cd=opt.cd+100;


						if (opt.fullWidth!="on")
							if (opt.width>opt.hideSliderAtLimit)
								container.parent().removeClass("tp-hide-revslider")
							else
								container.parent().addClass("tp-hide-revslider")
						// EVENT TRIGGERING IN CASE VIDEO HAS BEEN STARTED
						if (opt.videostartednow==1) {
							container.trigger('revolution.slide.onvideoplay');
							opt.videostartednow=0;
						}

						// EVENT TRIGGERING IN CASE VIDEO HAS BEEN STOPPED
						if (opt.videostoppednow==1) {
							container.trigger('revolution.slide.onvideostop');
							opt.videostoppednow=0;
						}


						if (opt.cd>=opt.delay) {
							opt.cd=0;
							// SWAP TO NEXT BANNER
							opt.act=opt.next;
							opt.next=opt.next+1;
							if (opt.next>container.find('>ul >li').length-1) {
									opt.next=0;
									opt.looptogo=opt.looptogo-1;

									if (opt.looptogo<=0) {
											opt.stopLoop="on";

									}
								}

							// STOP TIMER IF NO LOOP NO MORE NEEDED.

							if (opt.stopLoop=="on" && opt.next==opt.lastslidetoshow-1) {
									clearInterval(opt.cdint);
									container.find('.tp-bannertimer').css({'visibility':'hidden'});
									container.trigger('revolution.slide.onstop');
							}

							// SWAP THE SLIDES
							swapSlide(container,opt);


							// Clear the Timer
							if (bt.length>0) {
								bt.css({'width':'0%'});
								bt.animate({'width':"100%"},{duration:(opt.delay-100),queue:false, easing:"linear"});
							}
						}
					},100);


					container.hover(
						function() {

							if (opt.onHoverStop=="on") {
									opt.conthover=1;
								bt.stop();
								container.trigger('revolution.slide.onpause');
							}
						},
						function() {
							if (container.data('conthover')!=1) {
								container.trigger('revolution.slide.onresume');
								opt.conthover=0;
								if (opt.onHoverStop=="on" && opt.videoplaying!=true) {
									bt.animate({'width':"100%"},{duration:((opt.delay-opt.cd)-100),queue:false, easing:"linear"});
								}
							}
						});
			}
		}



})(jQuery);

/*!
 * jQuery resize event - v1.1 - 3/14/2010
 * http://benalman.com/projects/jquery-resize-plugin/
 * 
 * Copyright (c) 2010 "Cowboy" Ben Alman
 * Dual licensed under the MIT and GPL licenses.
 * http://benalman.com/about/license/
 */

// Script: jQuery resize event
//
// *Version: 1.1, Last updated: 3/14/2010*
// 
// Project Home - http://benalman.com/projects/jquery-resize-plugin/
// GitHub       - http://github.com/cowboy/jquery-resize/
// Source       - http://github.com/cowboy/jquery-resize/raw/master/jquery.ba-resize.js
// (Minified)   - http://github.com/cowboy/jquery-resize/raw/master/jquery.ba-resize.min.js (1.0kb)
// 
// About: License
// 
// Copyright (c) 2010 "Cowboy" Ben Alman,
// Dual licensed under the MIT and GPL licenses.
// http://benalman.com/about/license/
// 
// About: Examples
// 
// This working example, complete with fully commented code, illustrates a few
// ways in which this plugin can be used.
// 
// resize event - http://benalman.com/code/projects/jquery-resize/examples/resize/
// 
// About: Support and Testing
// 
// Information about what version or versions of jQuery this plugin has been
// tested with, what browsers it has been tested in, and where the unit tests
// reside (so you can test it yourself).
// 
// jQuery Versions - 1.3.2, 1.4.1, 1.4.2
// Browsers Tested - Internet Explorer 6-8, Firefox 2-3.6, Safari 3-4, Chrome, Opera 9.6-10.1.
// Unit Tests      - http://benalman.com/code/projects/jquery-resize/unit/
// 
// About: Release History
// 
// 1.1 - (3/14/2010) Fixed a minor bug that was causing the event to trigger
//       immediately after bind in some circumstances. Also changed $.fn.data
//       to $.data to improve performance.
// 1.0 - (2/10/2010) Initial release

(function($,window,undefined){
  '$:nomunge'; // Used by YUI compressor.
  
  // A jQuery object containing all non-window elements to which the resize
  // event is bound.
  var elems = $([]),
    
    // Extend $.resize if it already exists, otherwise create it.
    jq_resize = $.resize = $.extend( $.resize, {} ),
    
    timeout_id,
    
    // Reused strings.
    str_setTimeout = 'setTimeout',
    str_resize = 'resize',
    str_data = str_resize + '-special-event',
    str_delay = 'delay',
    str_throttle = 'throttleWindow';
  
  // Property: jQuery.resize.delay
  // 
  // The numeric interval (in milliseconds) at which the resize event polling
  // loop executes. Defaults to 250.
  
  jq_resize[ str_delay ] = 250;
  
  // Property: jQuery.resize.throttleWindow
  // 
  // Throttle the native window object resize event to fire no more than once
  // every <jQuery.resize.delay> milliseconds. Defaults to true.
  // 
  // Because the window object has its own resize event, it doesn't need to be
  // provided by this plugin, and its execution can be left entirely up to the
  // browser. However, since certain browsers fire the resize event continuously
  // while others do not, enabling this will throttle the window resize event,
  // making event behavior consistent across all elements in all browsers.
  // 
  // While setting this property to false will disable window object resize
  // event throttling, please note that this property must be changed before any
  // window object resize event callbacks are bound.
  
  jq_resize[ str_throttle ] = true;
  
  // Event: resize event
  // 
  // Fired when an element's width or height changes. Because browsers only
  // provide this event for the window element, for other elements a polling
  // loop is initialized, running every <jQuery.resize.delay> milliseconds
  // to see if elements' dimensions have changed. You may bind with either
  // .resize( fn ) or .bind( "resize", fn ), and unbind with .unbind( "resize" ).
  // 
  // Usage:
  // 
  // > jQuery('selector').bind( 'resize', function(e) {
  // >   // element's width or height has changed!
  // >   ...
  // > });
  // 
  // Additional Notes:
  // 
  // * The polling loop is not created until at least one callback is actually
  //   bound to the 'resize' event, and this single polling loop is shared
  //   across all elements.
  // 
  // Double firing issue in jQuery 1.3.2:
  // 
  // While this plugin works in jQuery 1.3.2, if an element's event callbacks
  // are manually triggered via .trigger( 'resize' ) or .resize() those
  // callbacks may double-fire, due to limitations in the jQuery 1.3.2 special
  // events system. This is not an issue when using jQuery 1.4+.
  // 
  // > // While this works in jQuery 1.4+
  // > $(elem).css({ width: new_w, height: new_h }).resize();
  // > 
  // > // In jQuery 1.3.2, you need to do this:
  // > var elem = $(elem);
  // > elem.css({ width: new_w, height: new_h });
  // > elem.data( 'resize-special-event', { width: elem.width(), height: elem.height() } );
  // > elem.resize();
      
  $.event.special[ str_resize ] = {
    
    // Called only when the first 'resize' event callback is bound per element.
    setup: function() {
      // Since window has its own native 'resize' event, return false so that
      // jQuery will bind the event using DOM methods. Since only 'window'
      // objects have a .setTimeout method, this should be a sufficient test.
      // Unless, of course, we're throttling the 'resize' event for window.
      if ( !jq_resize[ str_throttle ] && this[ str_setTimeout ] ) { return false; }
      
      var elem = $(this);
      
      // Add this element to the list of internal elements to monitor.
      elems = elems.add( elem );
      
      // Initialize data store on the element.
      $.data( this, str_data, { w: elem.width(), h: elem.height() } );
      
      // If this is the first element added, start the polling loop.
      if ( elems.length === 1 ) {
        loopy();
      }
    },
    
    // Called only when the last 'resize' event callback is unbound per element.
    teardown: function() {
      // Since window has its own native 'resize' event, return false so that
      // jQuery will unbind the event using DOM methods. Since only 'window'
      // objects have a .setTimeout method, this should be a sufficient test.
      // Unless, of course, we're throttling the 'resize' event for window.
      if ( !jq_resize[ str_throttle ] && this[ str_setTimeout ] ) { return false; }
      
      var elem = $(this);
      
      // Remove this element from the list of internal elements to monitor.
      elems = elems.not( elem );
      
      // Remove any data stored on the element.
      elem.removeData( str_data );
      
      // If this is the last element removed, stop the polling loop.
      if ( !elems.length ) {
        clearTimeout( timeout_id );
      }
    },
    
    // Called every time a 'resize' event callback is bound per element (new in
    // jQuery 1.4).
    add: function( handleObj ) {
      // Since window has its own native 'resize' event, return false so that
      // jQuery doesn't modify the event object. Unless, of course, we're
      // throttling the 'resize' event for window.
      if ( !jq_resize[ str_throttle ] && this[ str_setTimeout ] ) { return false; }
      
      var old_handler;
      
      // The new_handler function is executed every time the event is triggered.
      // This is used to update the internal element data store with the width
      // and height when the event is triggered manually, to avoid double-firing
      // of the event callback. See the "Double firing issue in jQuery 1.3.2"
      // comments above for more information.
      
      function new_handler( e, w, h ) {
        var elem = $(this),
          data = $.data( this, str_data );
        
        // If called from the polling loop, w and h will be passed in as
        // arguments. If called manually, via .trigger( 'resize' ) or .resize(),
        // those values will need to be computed.
        data.w = w !== undefined ? w : elem.width();
        data.h = h !== undefined ? h : elem.height();
        
        old_handler.apply( this, arguments );
      };
      
      // This may seem a little complicated, but it normalizes the special event
      // .add method between jQuery 1.4/1.4.1 and 1.4.2+
      if ( $.isFunction( handleObj ) ) {
        // 1.4, 1.4.1
        old_handler = handleObj;
        return new_handler;
      } else {
        // 1.4.2+
        old_handler = handleObj.handler;
        handleObj.handler = new_handler;
      }
    }
    
  };
  
  function loopy() {
    
    // Start the polling loop, asynchronously.
    timeout_id = window[ str_setTimeout ](function(){
      
      // Iterate over all elements to which the 'resize' event is bound.
      elems.each(function(){
        var elem = $(this),
          width = elem.width(),
          height = elem.height(),
          data = $.data( this, str_data );
        
        // If element size has changed since the last time, update the element
        // data store and trigger the 'resize' event.
        if ( width !== data.w || height !== data.h ) {
          elem.trigger( str_resize, [ data.w = width, data.h = height ] );
        }
        
      });
      
      // Loop.
      loopy();
      
    }, jq_resize[ str_delay ] );
    
  };
  
})(jQuery,this);
/*!
	Colorbox v1.4.28 - 2013-09-04
	jQuery lightbox and modal window plugin
	(c) 2013 Jack Moore - http://www.jacklmoore.com/colorbox
	license: http://www.opensource.org/licenses/mit-license.php
*/
(function ($, document, window) {
	var
	// Default settings object.
	// See http://jacklmoore.com/colorbox for details.
	defaults = {
		transition: "elastic",
		speed: 300,
		fadeOut: 300,
		width: false,
		initialWidth: "600",
		innerWidth: false,
		maxWidth: false,
		height: false,
		initialHeight: "450",
		innerHeight: false,
		maxHeight: false,
		scalePhotos: true,
		scrolling: true,
		inline: false,
		html: false,
		iframe: false,
		fastIframe: true,
		photo: false,
		href: false,
		title: false,
		rel: false,
		opacity: 0.9,
		preloading: true,
		className: false,

		// alternate image paths for high-res displays
		retinaImage: false,
		retinaUrl: false,
		retinaSuffix: '@2x.$1',

		// internationalization
		current: "image {current} of {total}",
		previous: "previous",
		next: "next",
		close: "close",
		xhrError: "This content failed to load.",
		imgError: "This image failed to load.",

		open: false,
		returnFocus: true,
		trapFocus: true,
		reposition: true,
		loop: true,
		slideshow: false,
		slideshowAuto: true,
		slideshowSpeed: 2500,
		slideshowStart: "start slideshow",
		slideshowStop: "stop slideshow",
		photoRegex: /\.(gif|png|jp(e|g|eg)|bmp|ico|webp)((#|\?).*)?$/i,

		onOpen: false,
		onLoad: false,
		onComplete: false,
		onCleanup: false,
		onClosed: false,

		overlayClose: true,
		escKey: true,
		arrowKey: true,
		top: false,
		bottom: false,
		left: false,
		right: false,
		fixed: false,
		data: undefined,
		closeButton: true
	},
	
	// Abstracting the HTML and event identifiers for easy rebranding
	colorbox = 'colorbox',
	prefix = 'cbox',
	boxElement = prefix + 'Element',
	
	// Events
	event_open = prefix + '_open',
	event_load = prefix + '_load',
	event_complete = prefix + '_complete',
	event_cleanup = prefix + '_cleanup',
	event_closed = prefix + '_closed',
	event_purge = prefix + '_purge',

	// Cached jQuery Object Variables
	$overlay,
	$box,
	$wrap,
	$content,
	$topBorder,
	$leftBorder,
	$rightBorder,
	$bottomBorder,
	$related,
	$window,
	$loaded,
	$loadingBay,
	$loadingOverlay,
	$title,
	$current,
	$slideshow,
	$next,
	$prev,
	$close,
	$groupControls,
	$events = $('<a/>'),
	
	// Variables for cached values or use across multiple functions
	settings,
	interfaceHeight,
	interfaceWidth,
	loadedHeight,
	loadedWidth,
	element,
	index,
	photo,
	open,
	active,
	closing,
	loadingTimer,
	publicMethod,
	div = "div",
	className,
	requests = 0,
	previousCSS = {},
	init;

	// ****************
	// HELPER FUNCTIONS
	// ****************
	
	// Convenience function for creating new jQuery objects
	function $tag(tag, id, css) {
		var element = document.createElement(tag);

		if (id) {
			element.id = prefix + id;
		}

		if (css) {
			element.style.cssText = css;
		}

		return $(element);
	}
	
	// Get the window height using innerHeight when available to avoid an issue with iOS
	// http://bugs.jquery.com/ticket/6724
	function winheight() {
		return window.innerHeight ? window.innerHeight : $(window).height();
	}

	// Determine the next and previous members in a group.
	function getIndex(increment) {
		var
		max = $related.length,
		newIndex = (index + increment) % max;
		
		return (newIndex < 0) ? max + newIndex : newIndex;
	}

	// Convert '%' and 'px' values to integers
	function setSize(size, dimension) {
		return Math.round((/%/.test(size) ? ((dimension === 'x' ? $window.width() : winheight()) / 100) : 1) * parseInt(size, 10));
	}
	
	// Checks an href to see if it is a photo.
	// There is a force photo option (photo: true) for hrefs that cannot be matched by the regex.
	function isImage(settings, url) {
		return settings.photo || settings.photoRegex.test(url);
	}

	function retinaUrl(settings, url) {
		return settings.retinaUrl && window.devicePixelRatio > 1 ? url.replace(settings.photoRegex, settings.retinaSuffix) : url;
	}

	function trapFocus(e) {
		if ('contains' in $box[0] && !$box[0].contains(e.target)) {
			e.stopPropagation();
			$box.focus();
		}
	}

	// Assigns function results to their respective properties
	function makeSettings() {
		var i,
			data = $.data(element, colorbox);
		
		if (data == null) {
			settings = $.extend({}, defaults);
			if (console && console.log) {
				console.log('Error: cboxElement missing settings object');
			}
		} else {
			settings = $.extend({}, data);
		}
		
		for (i in settings) {
			if ($.isFunction(settings[i]) && i.slice(0, 2) !== 'on') { // checks to make sure the function isn't one of the callbacks, they will be handled at the appropriate time.
				settings[i] = settings[i].call(element);
			}
		}
		
		settings.rel = settings.rel || element.rel || $(element).data('rel') || 'nofollow';
		settings.href = settings.href || $(element).attr('href');
		settings.title = settings.title || element.title;
		
		if (typeof settings.href === "string") {
			settings.href = $.trim(settings.href);
		}
	}

	function trigger(event, callback) {
		// for external use
		$(document).trigger(event);

		// for internal use
		$events.trigger(event);

		if ($.isFunction(callback)) {
			callback.call(element);
		}
	}

	// Slideshow functionality
	var slideshow = (function(){
		var
		className = prefix + "Slideshow_",
		click = "click." + prefix,
		ssActive = false,
		timeOut;

		function clear () {
			clearTimeout(timeOut);
		}

		function set() {
			if (settings.loop || $related[index + 1]) {
				clear();
				timeOut = setTimeout(publicMethod.next, settings.slideshowSpeed);
			}
		}

		function start() {
			$slideshow
				.html(settings.slideshowStop)
				.unbind(click)
				.one(click, stop);

			$events
				.bind(event_complete, set)
				.bind(event_load, clear)
				.bind(event_cleanup, stop);

			$box.removeClass(className + "off").addClass(className + "on");
		}
		
		function stop() {
			clear();
			
			$events
				.unbind(event_complete, set)
				.unbind(event_load, clear)
				.unbind(event_cleanup, stop);
			
			$slideshow
				.html(settings.slideshowStart)
				.unbind(click)
				.one(click, function () {
					publicMethod.next();
					start();
				});

			$box.removeClass(className + "on").addClass(className + "off");
		}

		return function() {
			if (ssActive) {
				if (settings.slideshow) {
					return;
				} else {
					ssActive = false;
					$slideshow.hide();
					clear();
					$events
						.unbind(event_complete, set)
						.unbind(event_load, clear)
						.unbind(event_cleanup, stop);
					$box.removeClass(className + "off " + className + "on");
				}
			} else if (settings.slideshow && $related[1]) {
				ssActive = true;

				if (settings.slideshowAuto) {
					start();
				} else {
					stop();
				}

				$slideshow.show();
			}
		};
	}());


	function launch(target) {
		if (!closing) {
			
			element = target;
			
			makeSettings();
			
			$related = $(element);
			
			index = 0;
			
			if (settings.rel !== 'nofollow') {
				$related = $('.' + boxElement).filter(function () {
					var data = $.data(this, colorbox),
						relRelated;

					if (data) {
						relRelated =  $(this).data('rel') || data.rel || this.rel;
					}
					
					return (relRelated === settings.rel);
				});
				index = $related.index(element);
				
				// Check direct calls to Colorbox.
				if (index === -1) {
					$related = $related.add(element);
					index = $related.length - 1;
				}
			}
			
			$overlay.css({
				opacity: parseFloat(settings.opacity),
				cursor: settings.overlayClose ? "pointer" : "auto",
				visibility: 'visible'
			}).show();
			

			if (className) {
				$box.add($overlay).removeClass(className);
			}
			if (settings.className) {
				$box.add($overlay).addClass(settings.className);
			}
			className = settings.className;

			if (settings.closeButton) {
				$close.html(settings.close).appendTo($content);
			} else {
				$close.appendTo('<div/>');
			}

			if (!open) {
				open = active = true; // Prevents the page-change action from queuing up if the visitor holds down the left or right keys.
				
				// Show colorbox so the sizes can be calculated in older versions of jQuery
				$box.css({visibility:'hidden', display:'block'});
				
				$loaded = $tag(div, 'LoadedContent', 'width:0; height:0; overflow:hidden');
				$content.css({width:'', height:''}).append($loaded);

				// Cache values needed for size calculations
				interfaceHeight = $topBorder.height() + $bottomBorder.height() + $content.outerHeight(true) - $content.height();
				interfaceWidth = $leftBorder.width() + $rightBorder.width() + $content.outerWidth(true) - $content.width();
				loadedHeight = $loaded.outerHeight(true);
				loadedWidth = $loaded.outerWidth(true);
				
				// Opens inital empty Colorbox prior to content being loaded.
				settings.w = setSize(settings.initialWidth, 'x');
				settings.h = setSize(settings.initialHeight, 'y');
				publicMethod.position();

				trigger(event_open, settings.onOpen);
				
				$groupControls.add($title).hide();

				$box.focus();
				
				if (settings.trapFocus) {
					// Confine focus to the modal
					// Uses event capturing that is not supported in IE8-
					if (document.addEventListener) {

						document.addEventListener('focus', trapFocus, true);
						
						$events.one(event_closed, function () {
							document.removeEventListener('focus', trapFocus, true);
						});
					}
				}

				// Return focus on closing
				if (settings.returnFocus) {
					$events.one(event_closed, function () {
						$(element).focus();
					});
				}
			}
			
			load();
		}
	}

	// Colorbox's markup needs to be added to the DOM prior to being called
	// so that the browser will go ahead and load the CSS background images.
	function appendHTML() {
		if (!$box && document.body) {
			init = false;
			$window = $(window);
			$box = $tag(div).attr({
				id: colorbox,
				'class': $.support.opacity === false ? prefix + 'IE' : '', // class for optional IE8 & lower targeted CSS.
				role: 'dialog',
				tabindex: '-1'
			}).hide();
			$overlay = $tag(div, "Overlay").hide();
			$loadingOverlay = $([$tag(div, "LoadingOverlay")[0],$tag(div, "LoadingGraphic")[0]]);
			$wrap = $tag(div, "Wrapper");
			$content = $tag(div, "Content").append(
				$title = $tag(div, "Title"),
				$current = $tag(div, "Current"),
				$prev = $('<button type="button"/>').attr({id:prefix+'Previous'}),
				$next = $('<button type="button"/>').attr({id:prefix+'Next'}),
				$slideshow = $tag('button', "Slideshow"),
				$loadingOverlay
			);

			$close = $('<button type="button"/>').attr({id:prefix+'Close'});
			
			$wrap.append( // The 3x3 Grid that makes up Colorbox
				$tag(div).append(
					$tag(div, "TopLeft"),
					$topBorder = $tag(div, "TopCenter"),
					$tag(div, "TopRight")
				),
				$tag(div, false, 'clear:left').append(
					$leftBorder = $tag(div, "MiddleLeft"),
					$content,
					$rightBorder = $tag(div, "MiddleRight")
				),
				$tag(div, false, 'clear:left').append(
					$tag(div, "BottomLeft"),
					$bottomBorder = $tag(div, "BottomCenter"),
					$tag(div, "BottomRight")
				)
			).find('div div').css({'float': 'left'});
			
			$loadingBay = $tag(div, false, 'position:absolute; width:9999px; visibility:hidden; display:none');
			
			$groupControls = $next.add($prev).add($current).add($slideshow);

			$(document.body).append($overlay, $box.append($wrap, $loadingBay));
		}
	}

	// Add Colorbox's event bindings
	function addBindings() {
		function clickHandler(e) {
			// ignore non-left-mouse-clicks and clicks modified with ctrl / command, shift, or alt.
			// See: http://jacklmoore.com/notes/click-events/
			if (!(e.which > 1 || e.shiftKey || e.altKey || e.metaKey || e.ctrlKey)) {
				e.preventDefault();
				launch(this);
			}
		}

		if ($box) {
			if (!init) {
				init = true;

				// Anonymous functions here keep the public method from being cached, thereby allowing them to be redefined on the fly.
				$next.click(function () {
					publicMethod.next();
				});
				$prev.click(function () {
					publicMethod.prev();
				});
				$close.click(function () {
					publicMethod.close();
				});
				$overlay.click(function () {
					if (settings.overlayClose) {
						publicMethod.close();
					}
				});
				
				// Key Bindings
				$(document).bind('keydown.' + prefix, function (e) {
					var key = e.keyCode;
					if (open && settings.escKey && key === 27) {
						e.preventDefault();
						publicMethod.close();
					}
					if (open && settings.arrowKey && $related[1] && !e.altKey) {
						if (key === 37) {
							e.preventDefault();
							$prev.click();
						} else if (key === 39) {
							e.preventDefault();
							$next.click();
						}
					}
				});

				if ($.isFunction($.fn.on)) {
					// For jQuery 1.7+
					$(document).on('click.'+prefix, '.'+boxElement, clickHandler);
				} else {
					// For jQuery 1.3.x -> 1.6.x
					// This code is never reached in jQuery 1.9, so do not contact me about 'live' being removed.
					// This is not here for jQuery 1.9, it's here for legacy users.
					$('.'+boxElement).live('click.'+prefix, clickHandler);
				}
			}
			return true;
		}
		return false;
	}

	// Don't do anything if Colorbox already exists.
	if ($.colorbox) {
		return;
	}

	// Append the HTML when the DOM loads
	$(appendHTML);


	// ****************
	// PUBLIC FUNCTIONS
	// Usage format: $.colorbox.close();
	// Usage from within an iframe: parent.jQuery.colorbox.close();
	// ****************
	
	publicMethod = $.fn[colorbox] = $[colorbox] = function (options, callback) {
		var $this = this;
		
		options = options || {};
		
		appendHTML();

		if (addBindings()) {
			if ($.isFunction($this)) { // assume a call to $.colorbox
				$this = $('<a/>');
				options.open = true;
			} else if (!$this[0]) { // colorbox being applied to empty collection
				return $this;
			}
			
			if (callback) {
				options.onComplete = callback;
			}
			
			$this.each(function () {
				$.data(this, colorbox, $.extend({}, $.data(this, colorbox) || defaults, options));
			}).addClass(boxElement);
			
			if (($.isFunction(options.open) && options.open.call($this)) || options.open) {
				launch($this[0]);
			}
		}
		
		return $this;
	};

	publicMethod.position = function (speed, loadedCallback) {
		var
		css,
		top = 0,
		left = 0,
		offset = $box.offset(),
		scrollTop,
		scrollLeft;
		
		$window.unbind('resize.' + prefix);

		// remove the modal so that it doesn't influence the document width/height
		$box.css({top: -9e4, left: -9e4});

		scrollTop = $window.scrollTop();
		scrollLeft = $window.scrollLeft();

		if (settings.fixed) {
			offset.top -= scrollTop;
			offset.left -= scrollLeft;
			$box.css({position: 'fixed'});
		} else {
			top = scrollTop;
			left = scrollLeft;
			$box.css({position: 'absolute'});
		}

		// keeps the top and left positions within the browser's viewport.
		if (settings.right !== false) {
			left += Math.max($window.width() - settings.w - loadedWidth - interfaceWidth - setSize(settings.right, 'x'), 0);
		} else if (settings.left !== false) {
			left += setSize(settings.left, 'x');
		} else {
			left += Math.round(Math.max($window.width() - settings.w - loadedWidth - interfaceWidth, 0) / 2);
		}
		
		if (settings.bottom !== false) {
			top += Math.max(winheight() - settings.h - loadedHeight - interfaceHeight - setSize(settings.bottom, 'y'), 0);
		} else if (settings.top !== false) {
			top += setSize(settings.top, 'y');
		} else {
			top += Math.round(Math.max(winheight() - settings.h - loadedHeight - interfaceHeight, 0) / 2);
		}

		$box.css({top: offset.top, left: offset.left, visibility:'visible'});
		
		// this gives the wrapper plenty of breathing room so it's floated contents can move around smoothly,
		// but it has to be shrank down around the size of div#colorbox when it's done.  If not,
		// it can invoke an obscure IE bug when using iframes.
		$wrap[0].style.width = $wrap[0].style.height = "9999px";
		
		function modalDimensions() {
			$topBorder[0].style.width = $bottomBorder[0].style.width = $content[0].style.width = (parseInt($box[0].style.width,10) - interfaceWidth)+'px';
			$content[0].style.height = $leftBorder[0].style.height = $rightBorder[0].style.height = (parseInt($box[0].style.height,10) - interfaceHeight)+'px';
		}

		css = {width: settings.w + loadedWidth + interfaceWidth, height: settings.h + loadedHeight + interfaceHeight, top: top, left: left};

		// setting the speed to 0 if the content hasn't changed size or position
		if (speed) {
			var tempSpeed = 0;
			$.each(css, function(i){
				if (css[i] !== previousCSS[i]) {
					tempSpeed = speed;
					return;
				}
			});
			speed = tempSpeed;
		}

		previousCSS = css;

		if (!speed) {
			$box.css(css);
		}

		$box.dequeue().animate(css, {
			duration: speed || 0,
			complete: function () {
				modalDimensions();
				
				active = false;
				
				// shrink the wrapper down to exactly the size of colorbox to avoid a bug in IE's iframe implementation.
				$wrap[0].style.width = (settings.w + loadedWidth + interfaceWidth) + "px";
				$wrap[0].style.height = (settings.h + loadedHeight + interfaceHeight) + "px";
				
				if (settings.reposition) {
					setTimeout(function () {  // small delay before binding onresize due to an IE8 bug.
						$window.bind('resize.' + prefix, publicMethod.position);
					}, 1);
				}

				if (loadedCallback) {
					loadedCallback();
				}
			},
			step: modalDimensions
		});
	};

	publicMethod.resize = function (options) {
		var scrolltop;
		
		if (open) {
			options = options || {};
			
			if (options.width) {
				settings.w = setSize(options.width, 'x') - loadedWidth - interfaceWidth;
			}

			if (options.innerWidth) {
				settings.w = setSize(options.innerWidth, 'x');
			}

			$loaded.css({width: settings.w});
			
			if (options.height) {
				settings.h = setSize(options.height, 'y') - loadedHeight - interfaceHeight;
			}

			if (options.innerHeight) {
				settings.h = setSize(options.innerHeight, 'y');
			}

			if (!options.innerHeight && !options.height) {
				scrolltop = $loaded.scrollTop();
				$loaded.css({height: "auto"});
				settings.h = $loaded.height();
			}

			$loaded.css({height: settings.h});

			if(scrolltop) {
				$loaded.scrollTop(scrolltop);
			}
			
			publicMethod.position(settings.transition === "none" ? 0 : settings.speed);
		}
	};

	publicMethod.prep = function (object) {
		if (!open) {
			return;
		}
		
		var callback, speed = settings.transition === "none" ? 0 : settings.speed;

		$loaded.empty().remove(); // Using empty first may prevent some IE7 issues.

		$loaded = $tag(div, 'LoadedContent').append(object);
		
		function getWidth() {
			settings.w = settings.w || $loaded.width();
			settings.w = settings.mw && settings.mw < settings.w ? settings.mw : settings.w;
			return settings.w;
		}
		function getHeight() {
			settings.h = settings.h || $loaded.height();
			settings.h = settings.mh && settings.mh < settings.h ? settings.mh : settings.h;
			return settings.h;
		}
		
		$loaded.hide()
		.appendTo($loadingBay.show())// content has to be appended to the DOM for accurate size calculations.
		.css({width: getWidth(), overflow: settings.scrolling ? 'auto' : 'hidden'})
		.css({height: getHeight()})// sets the height independently from the width in case the new width influences the value of height.
		.prependTo($content);
		
		$loadingBay.hide();
		
		// floating the IMG removes the bottom line-height and fixed a problem where IE miscalculates the width of the parent element as 100% of the document width.
		
		$(photo).css({'float': 'none'});

		callback = function () {
			var total = $related.length,
				iframe,
				frameBorder = 'frameBorder',
				allowTransparency = 'allowTransparency',
				complete;
			
			if (!open) {
				return;
			}
			
			function removeFilter() { // Needed for IE7 & IE8 in versions of jQuery prior to 1.7.2
				if ($.support.opacity === false) {
					$box[0].style.removeAttribute('filter');
				}
			}
			
			complete = function () {
				clearTimeout(loadingTimer);
				$loadingOverlay.hide();
				trigger(event_complete, settings.onComplete);
			};

			
			$title.html(settings.title).add($loaded).show();
			
			if (total > 1) { // handle grouping
				if (typeof settings.current === "string") {
					$current.html(settings.current.replace('{current}', index + 1).replace('{total}', total)).show();
				}
				
				$next[(settings.loop || index < total - 1) ? "show" : "hide"]().html(settings.next);
				$prev[(settings.loop || index) ? "show" : "hide"]().html(settings.previous);
				
				slideshow();
				
				// Preloads images within a rel group
				if (settings.preloading) {
					$.each([getIndex(-1), getIndex(1)], function(){
						var src,
							img,
							i = $related[this],
							data = $.data(i, colorbox);

						if (data && data.href) {
							src = data.href;
							if ($.isFunction(src)) {
								src = src.call(i);
							}
						} else {
							src = $(i).attr('href');
						}

						if (src && isImage(data, src)) {
							src = retinaUrl(data, src);
							img = document.createElement('img');
							img.src = src;
						}
					});
				}
			} else {
				$groupControls.hide();
			}
			
			if (settings.iframe) {
				iframe = $tag('iframe')[0];
				
				if (frameBorder in iframe) {
					iframe[frameBorder] = 0;
				}
				
				if (allowTransparency in iframe) {
					iframe[allowTransparency] = "true";
				}

				if (!settings.scrolling) {
					iframe.scrolling = "no";
				}
				
				$(iframe)
					.attr({
						src: settings.href,
						name: (new Date()).getTime(), // give the iframe a unique name to prevent caching
						'class': prefix + 'Iframe',
						allowFullScreen : true, // allow HTML5 video to go fullscreen
						webkitAllowFullScreen : true,
						mozallowfullscreen : true
					})
					.one('load', complete)
					.appendTo($loaded);
				
				$events.one(event_purge, function () {
					iframe.src = "//about:blank";
				});

				if (settings.fastIframe) {
					$(iframe).trigger('load');
				}
			} else {
				complete();
			}
			
			if (settings.transition === 'fade') {
				$box.fadeTo(speed, 1, removeFilter);
			} else {
				removeFilter();
			}
		};
		
		if (settings.transition === 'fade') {
			$box.fadeTo(speed, 0, function () {
				publicMethod.position(0, callback);
			});
		} else {
			publicMethod.position(speed, callback);
		}
	};

	function load () {
		var href, setResize, prep = publicMethod.prep, $inline, request = ++requests;
		
		active = true;
		
		photo = false;
		
		element = $related[index];
		
		makeSettings();
		
		trigger(event_purge);
		
		trigger(event_load, settings.onLoad);
		
		settings.h = settings.height ?
				setSize(settings.height, 'y') - loadedHeight - interfaceHeight :
				settings.innerHeight && setSize(settings.innerHeight, 'y');
		
		settings.w = settings.width ?
				setSize(settings.width, 'x') - loadedWidth - interfaceWidth :
				settings.innerWidth && setSize(settings.innerWidth, 'x');
		
		// Sets the minimum dimensions for use in image scaling
		settings.mw = settings.w;
		settings.mh = settings.h;
		
		// Re-evaluate the minimum width and height based on maxWidth and maxHeight values.
		// If the width or height exceed the maxWidth or maxHeight, use the maximum values instead.
		if (settings.maxWidth) {
			settings.mw = setSize(settings.maxWidth, 'x') - loadedWidth - interfaceWidth;
			settings.mw = settings.w && settings.w < settings.mw ? settings.w : settings.mw;
		}
		if (settings.maxHeight) {
			settings.mh = setSize(settings.maxHeight, 'y') - loadedHeight - interfaceHeight;
			settings.mh = settings.h && settings.h < settings.mh ? settings.h : settings.mh;
		}
		
		href = settings.href;
		
		loadingTimer = setTimeout(function () {
			$loadingOverlay.show();
		}, 100);
		
		if (settings.inline) {
			// Inserts an empty placeholder where inline content is being pulled from.
			// An event is bound to put inline content back when Colorbox closes or loads new content.
			$inline = $tag(div).hide().insertBefore($(href)[0]);

			$events.one(event_purge, function () {
				$inline.replaceWith($loaded.children());
			});

			prep($(href));
		} else if (settings.iframe) {
			// IFrame element won't be added to the DOM until it is ready to be displayed,
			// to avoid problems with DOM-ready JS that might be trying to run in that iframe.
			prep(" ");
		} else if (settings.html) {
			prep(settings.html);
		} else if (isImage(settings, href)) {

			href = retinaUrl(settings, href);

			photo = document.createElement('img');

			$(photo)
			.addClass(prefix + 'Photo')
			.bind('error',function () {
				settings.title = false;
				prep($tag(div, 'Error').html(settings.imgError));
			})
			.one('load', function () {
				var percent;

				if (request !== requests) {
					return;
				}

				photo.alt = $(element).attr('alt') || $(element).attr('data-alt') || '';

				if (settings.retinaImage && window.devicePixelRatio > 1) {
					photo.height = photo.height / window.devicePixelRatio;
					photo.width = photo.width / window.devicePixelRatio;
				}

				if (settings.scalePhotos) {
					setResize = function () {
						photo.height -= photo.height * percent;
						photo.width -= photo.width * percent;
					};
					if (settings.mw && photo.width > settings.mw) {
						percent = (photo.width - settings.mw) / photo.width;
						setResize();
					}
					if (settings.mh && photo.height > settings.mh) {
						percent = (photo.height - settings.mh) / photo.height;
						setResize();
					}
				}
				
				if (settings.h) {
					photo.style.marginTop = Math.max(settings.mh - photo.height, 0) / 2 + 'px';
				}
				
				if ($related[1] && (settings.loop || $related[index + 1])) {
					photo.style.cursor = 'pointer';
					photo.onclick = function () {
						publicMethod.next();
					};
				}

				photo.style.width = photo.width + 'px';
				photo.style.height = photo.height + 'px';

				setTimeout(function () { // A pause because Chrome will sometimes report a 0 by 0 size otherwise.
					prep(photo);
				}, 1);
			});
			
			setTimeout(function () { // A pause because Opera 10.6+ will sometimes not run the onload function otherwise.
				photo.src = href;
			}, 1);
		} else if (href) {
			$loadingBay.load(href, settings.data, function (data, status) {
				if (request === requests) {
					prep(status === 'error' ? $tag(div, 'Error').html(settings.xhrError) : $(this).contents());
				}
			});
		}
	}
		
	// Navigates to the next page/image in a set.
	publicMethod.next = function () {
		if (!active && $related[1] && (settings.loop || $related[index + 1])) {
			index = getIndex(1);
			launch($related[index]);
		}
	};
	
	publicMethod.prev = function () {
		if (!active && $related[1] && (settings.loop || index)) {
			index = getIndex(-1);
			launch($related[index]);
		}
	};

	// Note: to use this within an iframe use the following format: parent.jQuery.colorbox.close();
	publicMethod.close = function () {
		if (open && !closing) {
			
			closing = true;
			
			open = false;
			
			trigger(event_cleanup, settings.onCleanup);
			
			$window.unbind('.' + prefix);
			
			$overlay.fadeTo(settings.fadeOut || 0, 0);
			
			$box.stop().fadeTo(settings.fadeOut || 0, 0, function () {
			
				$box.add($overlay).css({'opacity': 1, cursor: 'auto'}).hide();
				
				trigger(event_purge);
				
				$loaded.empty().remove(); // Using empty first may prevent some IE7 issues.
				
				setTimeout(function () {
					closing = false;
					trigger(event_closed, settings.onClosed);
				}, 1);
			});
		}
	};

	// Removes changes Colorbox made to the document, but does not remove the plugin.
	publicMethod.remove = function () {
		if (!$box) { return; }

		$box.stop();
		$.colorbox.close();
		$box.stop().remove();
		$overlay.remove();
		closing = false;
		$box = null;
		$('.' + boxElement)
			.removeData(colorbox)
			.removeClass(boxElement);

		$(document).unbind('click.'+prefix);
	};

	// A method for fetching the current element Colorbox is referencing.
	// returns a jQuery object.
	publicMethod.element = function () {
		return $(element);
	};

	publicMethod.settings = defaults;

}(jQuery, document, window));
/*! http://mths.be/placeholder v2.0.7 by @mathias */
;(function(window, document, $) {

	var isInputSupported = 'placeholder' in document.createElement('input');
	var isTextareaSupported = 'placeholder' in document.createElement('textarea');
	var prototype = $.fn;
	var valHooks = $.valHooks;
	var propHooks = $.propHooks;
	var hooks;
	var placeholder;

	if (isInputSupported && isTextareaSupported) {

		placeholder = prototype.placeholder = function() {
			return this;
		};

		placeholder.input = placeholder.textarea = true;

	} else {

		placeholder = prototype.placeholder = function() {
			var $this = this;
			$this
				.filter((isInputSupported ? 'textarea' : ':input') + '[placeholder]')
				.not('.placeholder')
				.bind({
					'focus.placeholder': clearPlaceholder,
					'blur.placeholder': setPlaceholder
				})
				.data('placeholder-enabled', true)
				.trigger('blur.placeholder');
			return $this;
		};

		placeholder.input = isInputSupported;
		placeholder.textarea = isTextareaSupported;

		hooks = {
			'get': function(element) {
				var $element = $(element);

				var $passwordInput = $element.data('placeholder-password');
				if ($passwordInput) {
					return $passwordInput[0].value;
				}

				return $element.data('placeholder-enabled') && $element.hasClass('placeholder') ? '' : element.value;
			},
			'set': function(element, value) {
				var $element = $(element);

				var $passwordInput = $element.data('placeholder-password');
				if ($passwordInput) {
					return $passwordInput[0].value = value;
				}

				if (!$element.data('placeholder-enabled')) {
					return element.value = value;
				}
				if (value == '') {
					element.value = value;
					// Issue #56: Setting the placeholder causes problems if the element continues to have focus.
					if (element != document.activeElement) {
						// We can't use `triggerHandler` here because of dummy text/password inputs :(
						setPlaceholder.call(element);
					}
				} else if ($element.hasClass('placeholder')) {
					clearPlaceholder.call(element, true, value) || (element.value = value);
				} else {
					element.value = value;
				}
				// `set` can not return `undefined`; see http://jsapi.info/jquery/1.7.1/val#L2363
				return $element;
			}
		};

		if (!isInputSupported) {
			valHooks.input = hooks;
			propHooks.value = hooks;
		}
		if (!isTextareaSupported) {
			valHooks.textarea = hooks;
			propHooks.value = hooks;
		}

		$(function() {
			// Look for forms
			$(document).delegate('form', 'submit.placeholder', function() {
				// Clear the placeholder values so they don't get submitted
				var $inputs = $('.placeholder', this).each(clearPlaceholder);
				setTimeout(function() {
					$inputs.each(setPlaceholder);
				}, 10);
			});
		});

		// Clear placeholder values upon page reload
		$(window).bind('beforeunload.placeholder', function() {
			$('.placeholder').each(function() {
				this.value = '';
			});
		});

	}

	function args(elem) {
		// Return an object of element attributes
		var newAttrs = {};
		var rinlinejQuery = /^jQuery\d+$/;
		$.each(elem.attributes, function(i, attr) {
			if (attr.specified && !rinlinejQuery.test(attr.name)) {
				newAttrs[attr.name] = attr.value;
			}
		});
		return newAttrs;
	}

	function clearPlaceholder(event, value) {
		var input = this;
		var $input = $(input);
		if (input.value == $input.attr('placeholder') && $input.hasClass('placeholder')) {
			if ($input.data('placeholder-password')) {
				$input = $input.hide().next().show().attr('id', $input.removeAttr('id').data('placeholder-id'));
				// If `clearPlaceholder` was called from `$.valHooks.input.set`
				if (event === true) {
					return $input[0].value = value;
				}
				$input.focus();
			} else {
				input.value = '';
				$input.removeClass('placeholder');
				input == document.activeElement && input.select();
			}
		}
	}

	function setPlaceholder() {
		var $replacement;
		var input = this;
		var $input = $(input);
		var id = this.id;
		if (input.value == '') {
			if (input.type == 'password') {
				if (!$input.data('placeholder-textinput')) {
					try {
						$replacement = $input.clone().attr({ 'type': 'text' });
					} catch(e) {
						$replacement = $('<input>').attr($.extend(args(this), { 'type': 'text' }));
					}
					$replacement
						.removeAttr('name')
						.data({
							'placeholder-password': $input,
							'placeholder-id': id
						})
						.bind('focus.placeholder', clearPlaceholder);
					$input
						.data({
							'placeholder-textinput': $replacement,
							'placeholder-id': id
						})
						.before($replacement);
				}
				$input = $input.removeAttr('id').hide().prev().attr('id', id).show();
				// Note: `$input[0] != input` now!
			}
			$input.addClass('placeholder');
			$input[0].value = $input.attr('placeholder');
		} else {
			$input.removeClass('placeholder');
		}
	}

}(this, document, jQuery));