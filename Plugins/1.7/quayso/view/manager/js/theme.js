/*
Name: 			Theme Base
Written by: 	Okler Themes - (http://www.okler.net)
Theme Version: 	1.3.0
*/


// khóa nút back trình duyệt
history.pushState(null, document.title, location.href);
window.addEventListener('popstate', function (event)
{
	history.pushState(null, document.title, location.href);
});




// show modal và focus vào button đóng
$("#showM").on('show.bs.modal', function(){
	$(this).find('.modal-footer button').focus();
});
$('.modal-footer button').attr({
	autofocus: ''
});
$(window).on('load',function(){
	$('#showM').modal('show');
});
$('.modal-dialog').draggable({
	handle: ".modal-header"
});

// select có tìm kiếm
$('input[data-list]').each(function () {
	var availableTags = $('#' + $(this).attr("data-list")).find('option').map(function () {
		return this.value;
	}).get();

	$(this).autocomplete({
		source: availableTags
	}).on('focus', function () {
		$(this).autocomplete('search', ' ');
	}).on('search', function () {
		if ($(this).val() === '') {
			$(this).autocomplete('search', ' ');
		}
	});
});


// trim khoảng trắng đầu cuối
$('input, textarea').blur(function(){
	$(this).val($.trim($(this).val()));
});

// $(window).on('load',function(){
// 	$('#showM12').modal('show');
// });

// check input rỗng ManagerAddTypeRoom
$( "form.tab_input_null" ).on( "submit", function() { 
	var has_empty = false;
	$(this).find( ':required' ).each(function () {
		if ( ! $(this).val() ) { has_empty = true; return false; }
	});
	if ( has_empty ) { return false; alert("a");}
});

// lăn chuột lên trên ở ManagerAddTypeRoom
$(".mt_20 button[type='button']").click(function(){
	$("html, body").animate({ scrollTop: 0 }, "0");
});

// $(window).load(function() {
// 	$('form').focus_first();
// 	$("input[type='submit']").click(function(){
// 		$(".datepicker").blur();
// 	});
// });
// Focus first element
$.fn.focus_first = function() {
	var textarea = $('textarea:visible', this).get(0);
	if (textarea && elem) {
		if (textarea.offsetTop < elem.offsetTop) {
			elem = textarea;
		}
	}
	var select = $('select:visible', this).get(0);
	if (select && elem) {
		if (select.offsetTop < elem.offsetTop) {
			elem = select;
		}
	}
	var elem = $('input:visible', this).get(0);

	if (elem) {
		//elem.focus();
	}
	return this;
}


//$( 'input[type="text"]' ).attr("maxlength", '255');
//$( ".input_money" ).attr("maxlength", '21');
// $( ".input_sdt" ).attr("maxlength", '13');
// $( ".input_sdt" ).attr("title", 'Vui lòng điền đúng theo định dạng đầu số điện thoại hiện hành?');
// $( ".input_sdt" ).attr("pattern", '^(01[2689]|02[0-9]|09|08|84[0-9])[0-9]{8}');

// $( ".input_num" ).attr("pattern", '[0-9]{8,13}');
// $( ".input_n" ).attr("pattern", '[0-9]{0,13}');
// $( ".input_n" ).attr("title", 'Chỉ nhập số dương, không quá 13 ký tự');
$( "input, select" ).attr("autocomplete", 'off');



// lăn chuột đến input rỗng
//$("input[value='']:not(:checkbox,:button):visible:first").focus();
$("input[type='submit']").click(function(){
	$(".datepicker").blur();
});



// hiện thông báo khi chưa điền hết dữ liệu ở các tab
// $('#showM12').css("display", "none");
// $('.tab_input_null :button').click(function(e) {

// 	var isValid = true;
// 	$(':required').each(function() {
// 		if ($.trim($(this).val()) == '') {
// 			isValid = false;

// 		}
// 	});
// 	if (isValid == false){
// 		$('#showM12').modal('show');
// 		$("input[value='']:not(:checkbox,:button):visible:first").focus();
// 	}


// });

$(".datepicker").datepicker({
	autoclose: true,
    todayHighlight: true,
});
$(".datepicker1").datepicker({
	minDate: 0,
	maxDate: "",
});
$(".input_ngaysinh ").datepicker({
	maxDate: "now"
});
$("#date_start").datepicker({
	minDate: 0,
	maxDate: "",
	numberOfMonths: 1,
	onSelect: function(selected) {
		$("#date_end").datepicker("option","minDate", selected)
	}
});
$("#date_end").datepicker({ 
	minDate: 0,
	maxDate:"",
	numberOfMonths: 1,
	onSelect: function(selected) {
		$("#date_start").datepicker("option","maxDate", selected)
	}
});  
jQuery(function($){
	$.datepicker.regional['vi'] = {
		closeText: 'Đóng',
		prevText: '<Trước',
		nextText: 'Tiếp>',
		currentText: 'Hôm nay',
		monthNames: ['Tháng Một', 'Tháng Hai', 'Tháng Ba', 'Tháng Tư', 'Tháng Năm', 'Tháng Sáu',
		'Tháng Bảy', 'Tháng Tám', 'Tháng Chín', 'Tháng Mười', 'Tháng Mười Một', 'Tháng Mười Hai'],
		monthNamesShort: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6',
		'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
		dayNames: ['Chủ Nhật', 'Thứ Hai', 'Thứ Ba', 'Thứ Tư', 'Thứ Năm', 'Thứ Sáu', 'Thứ Bảy'],
		dayNamesShort: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
		dayNamesMin: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
		weekHeader: 'Tu',
		dateFormat: 'dd/mm/yy',
		firstDay: 0,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''};
		$.datepicker.setDefaults($.datepicker.regional['vi']);
	});

// ngày/tháng/năm
// (function($){
// 	$.fn.datepicker.dates['vi'] = {
// 		days: ["Chủ nhật", "Thứ hai", "Thứ ba", "Thứ tư", "Thứ năm", "Thứ sáu", "Thứ bảy"],
// 		daysShort: ["CN", "Thứ 2", "Thứ 3", "Thứ 4", "Thứ 5", "Thứ 6", "Thứ 7"],
// 		daysMin: ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
// 		months: ["Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6", "Tháng 7", "Tháng 8", "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12"],
// 		monthsShort: ["Th1", "Th2", "Th3", "Th4", "Th5", "Th6", "Th7", "Th8", "Th9", "Th10", "Th11", "Th12"],
// 		today: "Hôm nay",
// 		clear: "Xóa",
// 		format: "dd/mm/yyyy"
// 	};
// }(jQuery));
// $ ( '.datepicker' ). datepicker ({ language : 'vi',

// });
// $(".datepicker1").datepicker({
// 	language : 'vi',
// 	startDate: "dateToday"
// });
// $ ( '.input_ngaysinh' ). datepicker ({ language : 'vi',
// 	endDate: '+0d',
// 	autoclose: true
// });

var checkForm= true;
// check ít nhất 1 checkbox
$('.summary-form1').submit(function (e) {
	if (!$('.staffcheck').is(':checked')) {
		checkForm= false;
		alert('Không được bỏ trống các trường bắt buộc có dấu *');
		e.preventDefault();
	}
});




(function(e){function t(e){return e!==void 0}function n(t,n,l){var r=function(){};r.prototype=n.prototype,t.prototype=new r,t.prototype.constructor=t,n.prototype.constructor=n,t._super=n.prototype,l&&e.extend(t.prototype,l)}function l(e,n){var l;"string"==typeof e&&(n=e,e=document);for(var i=0;r.length>i;++i){n=n.replace(r[i][0],r[i][1]);for(var o=0;s.length>o;++o)if(l=s[o],l+=0===o?n:n.charAt(0).toUpperCase()+n.substr(1),t(e[l]))return e[l]}return void 0}var r=[["",""],["exit","cancel"],["screen","Screen"]],s=["","o","ms","moz","webkit","webkitCurrent"],i=navigator.userAgent,o=l("fullscreenEnabled"),u=-1!==i.indexOf("Android")&&-1!==i.indexOf("Chrome"),c=!u&&t(l("fullscreenElement"))&&(!t(o)||o===!0),_=e.fn.jquery.split("."),h=2>parseInt(_[0])&&7>parseInt(_[1]),f=function(){this.__options=null,this._fullScreenElement=null,this.__savedStyles={}};f.prototype={_DEFAULT_OPTIONS:{styles:{boxSizing:"border-box",MozBoxSizing:"border-box",WebkitBoxSizing:"border-box"},toggleClass:null},__documentOverflow:"",__htmlOverflow:"",_preventDocumentScroll:function(){this.__documentOverflow=e("body")[0].style.overflow,this.__htmlOverflow=e("html")[0].style.overflow,e("body, html").css("overflow","hidden")},_allowDocumentScroll:function(){e("body")[0].style.overflow=this.__documentOverflow,e("html")[0].style.overflow=this.__htmlOverflow},_fullScreenChange:function(){this.isFullScreen()?(this._preventDocumentScroll(),this._triggerEvents()):(this._allowDocumentScroll(),this._revertStyles(),this._triggerEvents(),this._fullScreenElement=null)},_fullScreenError:function(t){this._revertStyles(),this._fullScreenElement=null,t&&e(document).trigger("fscreenerror",[t])},_triggerEvents:function(){e(this._fullScreenElement).trigger(this.isFullScreen()?"fscreenopen":"fscreenclose"),e(document).trigger("fscreenchange",[this.isFullScreen(),this._fullScreenElement])},_saveAndApplyStyles:function(){var t=e(this._fullScreenElement);this.__savedStyles={};for(var n in this.__options.styles)this.__savedStyles[n]=this._fullScreenElement.style[n],this._fullScreenElement.style[n]=this.__options.styles[n];this.__options.toggleClass&&t.addClass(this.__options.toggleClass)},_revertStyles:function(){var t=e(this._fullScreenElement);for(var n in this.__options.styles)this._fullScreenElement.style[n]=this.__savedStyles[n];this.__options.toggleClass&&t.removeClass(this.__options.toggleClass)},open:function(t,n){t!==this._fullScreenElement&&(this.isFullScreen()&&this.exit(),this._fullScreenElement=t,this.__options=e.extend(!0,{},this._DEFAULT_OPTIONS,n),this._saveAndApplyStyles())},exit:null,isFullScreen:null,isNativelySupported:function(){return c}};var p=function(){p._super.constructor.apply(this,arguments),this.exit=e.proxy(l("exitFullscreen"),document),this._DEFAULT_OPTIONS=e.extend(!0,{},this._DEFAULT_OPTIONS,{styles:{width:"100%",height:"100%"}}),e(document).bind(this._prefixedString("fullscreenchange")+" MSFullscreenChange",e.proxy(this._fullScreenChange,this)).bind(this._prefixedString("fullscreenerror")+" MSFullscreenError",e.proxy(this._fullScreenError,this))};n(p,f,{VENDOR_PREFIXES:["","o","moz","webkit"],_prefixedString:function(t){return e.map(this.VENDOR_PREFIXES,function(e){return e+t}).join(" ")},open:function(e){p._super.open.apply(this,arguments);var t=l(e,"requestFullscreen");t.call(e)},exit:e.noop,isFullScreen:function(){return null!==l("fullscreenElement")},element:function(){return l("fullscreenElement")}});var a=function(){a._super.constructor.apply(this,arguments),this._DEFAULT_OPTIONS=e.extend({},this._DEFAULT_OPTIONS,{styles:{position:"fixed",zIndex:"2147483647",left:0,top:0,bottom:0,right:0}}),this.__delegateKeydownHandler()};n(a,f,{__isFullScreen:!1,__delegateKeydownHandler:function(){var t=e(document);t.delegate("*","keydown.fullscreen",e.proxy(this.__keydownHandler,this));var n=h?t.data("events"):e._data(document).events,l=n.keydown;h?n.live.unshift(n.live.pop()):l.splice(0,0,l.splice(l.delegateCount-1,1)[0])},__keydownHandler:function(e){return this.isFullScreen()&&27===e.which?(this.exit(),!1):!0},_revertStyles:function(){a._super._revertStyles.apply(this,arguments),this._fullScreenElement.offsetHeight},open:function(){a._super.open.apply(this,arguments),this.__isFullScreen=!0,this._fullScreenChange()},exit:function(){this.__isFullScreen=!1,this._fullScreenChange()},isFullScreen:function(){return this.__isFullScreen},element:function(){return this.__isFullScreen?this._fullScreenElement:null}}),e.fullscreen=c?new p:new a,e.fn.fullscreen=function(t){var n=this[0];return t=e.extend({toggleClass:null,overflow:"scroll"},t),t.styles={overflow:t.overflow},delete t.overflow,n&&e.fullscreen.open(n,t),this}})(jQuery);
$(function() {
	$('#support').text($.fullscreen.isNativelySupported() ? 'supports' : 'doesn\'t support');

	$('#fullscreen .requestfullscreen').click(function() {
		$('#fullscreen').fullscreen();
		return false;
		
	});

	$('#fullscreen .exitfullscreen').click(function() {
		$.fullscreen.exit();
		return false;
		
	});

	$(document).bind('fscreenchange', function(e, state, elem) {
		if ($.fullscreen.isFullScreen()) {
			$('#fullscreen .requestfullscreen').hide();
			$('#fullscreen .exitfullscreen').show();
			console.log('full');


		} else {
			$('#fullscreen .requestfullscreen').show();
			$('#fullscreen .exitfullscreen').hide();
			console.log('NOTfull');

			$('html.fixed .page-header').css('display','block');
			$('html.fixed .content-body').removeClass('mL0');
		}

		$('#state').text($.fullscreen.isFullScreen() ? '' : 'not');
	});

	$('.requestfullscreen').click(function(){
		$('html.fixed .page-header').css('display','none');
		$('html.fixed .content-body').addClass('mL0');
	});

	$('.exitfullscreen ').click(function(){
		$('html.fixed .page-header').css('display','block');
		var w = $(window).innerWidth();

		$('html.fixed .content-body').removeClass('mL0');
	});

	

	// $(document).keyup(function(e) {

	// 	$('html.fixed .page-header').css('display','block');
	// 	$('html.fixed .content-body').removeClass('mL0');

	// 	$('html.fixed .page-header').css('display','block');
	// 	$('html.fixed .content-body').removeClass('mL0');
	// 	if (e.keyCode == 27) { 
	// 		$('html.fixed .page-header').css('display','block');
	// 		$('html.fixed .content-body').removeClass('mL0');

	// 	}

	// });

});

window.theme = {};

// Navigation
(function( $ ) {

	'use strict';

	var $items = $( '.nav-main li.nav-parent' );

	function expand( li ) {
		li.children( 'ul.nav-children' ).slideDown( 'fast', function() {
			li.addClass( 'nav-expanded' );
			$(this).css( 'display', '' );
			ensureVisible( li );
		});
	}

	function collapse( li ) {
		li.children('ul.nav-children' ).slideUp( 'fast', function() {
			$(this).css( 'display', '' );
			li.removeClass( 'nav-expanded' );
		});
	}

	function ensureVisible( li ) {
		var scroller = li.offsetParent();
		if ( !scroller.get(0) ) {
			return false;
		}

		var top = li.position().top;
		if ( top < 0 ) {
			scroller.animate({
				scrollTop: scroller.scrollTop() + top
			}, 'fast');
		}
	}

	$items.find('> a').on('click', function() {
		var prev = $( this ).closest('ul.nav').find('> li.nav-expanded' ),
		next = $( this ).closest('li');

		if ( prev.get( 0 ) !== next.get( 0 ) ) {
			collapse( prev );
			expand( next );
		} else {
			collapse( prev );
		}
	});

}).apply( this, [ jQuery ]);

// Skeleton
(function(theme, $) {

	'use strict';

	theme = theme || {};

	var $body		= $( 'body' ),
	$html		= $( 'html' ),
	$window		= $( window ),
	isAndroid	= navigator.userAgent.toLowerCase().indexOf('android') > -1;

	// mobile devices with fixed has a lot of issues when focus inputs and others...
	if ( typeof $.browser !== 'undefined' && $.browser.mobile && $html.hasClass('fixed') ) {
		$html.removeClass( 'fixed' ).addClass( 'scroll' );
	}

	var Skeleton = {

		options: {
			sidebars: {
				menu: '#content-menu',
				left: '#sidebar-left',
				right: '#sidebar-right'
			}
		},

		customScroll: ( !Modernizr.overflowscrolling && !isAndroid && $.fn.nanoScroller !== 'undefined'),

		initialize: function() {
			this
			.setVars()
			.build()
			.events();
		},

		setVars: function() {
			this.sidebars = {};

			this.sidebars.left = {
				$el: $( this.options.sidebars.left )
			};

			this.sidebars.right = {
				$el: $( this.options.sidebars.right ),
				isOpened: $html.hasClass( 'sidebar-right-opened' )
			};

			this.sidebars.menu = {
				$el: $( this.options.sidebars.menu ),
				isOpened: $html.hasClass( 'inner-menu-opened' )
			};

			return this;
		},

		build: function() {

			if ( typeof $.browser !== 'undefined' && $.browser.mobile ) {
				$html.addClass( 'mobile-device' );
			} else {
				$html.addClass( 'no-mobile-device' );
			}

			$html.addClass( 'custom-scroll' );
			if ( this.customScroll ) {
				this.buildSidebarLeft();
				this.buildContentMenu();
			}

			this.buildSidebarRight();

			return this;
		},

		events: function() {
			if ( this.customScroll ) {
				this.eventsSidebarLeft();
			}

			this.eventsSidebarRight();
			this.eventsContentMenu();

			if ( typeof $.browser !== 'undefined' && !this.customScroll && isAndroid ) {
				this.fixScroll();
			}

			return this;
		},

		fixScroll: function() {
			var _self = this;

			$window
			.on( 'sidebar-left-opened sidebar-right-toggle', function( e, data ) {
				_self.preventBodyScrollToggle( data.added );
			});
		},

		buildSidebarLeft: function() {
			this.sidebars.left.$nano = this.sidebars.left.$el.find( '.nano' );

			this.sidebars.left.$nano.nanoScroller({
				alwaysVisible: true,
				preventPageScrolling: true
			});

			return this;
		},

		eventsSidebarLeft: function() {

			var $nano = this.sidebars.left.$nano;

			var updateNanoScroll = function() {
				if ( $.support.transition ) {
					$nano.nanoScroller();
					$nano
					.one('bsTransitionEnd', updateNanoScroll)
					.emulateTransitionEnd(150)
				} else {
					updateNanoScroll();
				}
			};

			this.sidebars.left.$el
			.on( 'click', function() {
				updateNanoScroll();
			});

			$nano
			.on( 'mouseenter', function() {
				if ( $html.hasClass( 'sidebar-left-collapsed' ) ) {
					$nano.nanoScroller();
				}
			})
			.on( 'mouseleave', function() {
				if ( $html.hasClass( 'sidebar-left-collapsed' ) ) {
					$nano.nanoScroller();
				}
			});

			return this;
		},

		buildSidebarRight: function() {
			this.sidebars.right.isOpened = $html.hasClass( 'sidebar-right-opened' );

			if ( this.customScroll ) {
				this.sidebars.right.$nano = this.sidebars.right.$el.find( '.nano' );

				this.sidebars.right.$nano.nanoScroller({
					alwaysVisible: true,
					preventPageScrolling: true
				});
			}

			return this;
		},

		eventsSidebarRight: function() {
			var _self = this;

			var open = function() {
				if ( _self.sidebars.right.isOpened ) {
					return close();
				}

				_self.sidebars.right.isOpened = true;

				$html.addClass( 'sidebar-right-opened' );

				$window.trigger( 'sidebar-right-toggle', {
					added: true,
					removed: false
				});

				$html.on( 'click.close-right-sidebar', function(e) {
					e.stopPropagation();
					close(e);
				});
			};

			var close = function(e) {
				if ( !!e && !!e.target && ($(e.target).closest( '.sidebar-right' ).get(0) || !$(e.target).closest( 'html' ).get(0)) ) {
					e.preventDefault();
					return false;
				}

				$html.removeClass( 'sidebar-right-opened' );
				$html.off( 'click.close-right-sidebar' );

				$window.trigger( 'sidebar-right-toggle', {
					added: false,
					removed: true
				});

				_self.sidebars.right.isOpened = false;
			};

			var bind = function() {
				$('[data-open="sidebar-right"]').on('click', function(e) {
					var $el = $(this);
					e.stopPropagation();

					if ( $el.is('a') )
						e.preventDefault();

					open();
				});
			};

			this.sidebars.right.$el.find( '.mobile-close' )
			.on( 'click', function( e ) {
				e.preventDefault();
				$html.trigger( 'click.close-right-sidebar' );
			});

			bind();

			return this;
		},

		buildContentMenu: function() {
			if ( !$html.hasClass( 'fixed' ) ) {
				return false;
			}

			this.sidebars.menu.$nano = this.sidebars.menu.$el.find( '.nano' );

			this.sidebars.menu.$nano.nanoScroller({
				alwaysVisible: true,
				preventPageScrolling: true
			});

			return this;
		},

		eventsContentMenu: function() {
			var _self = this;

			var open = function() {
				if ( _self.sidebars.menu.isOpened ) {
					return close();
				}

				_self.sidebars.menu.isOpened = true;

				$html.addClass( 'inner-menu-opened' );

				$window.trigger( 'inner-menu-toggle', {
					added: true,
					removed: false
				});

				$html.on( 'click.close-inner-menu', function(e) {

					close(e);
				});

			};

			var close = function(e) {
				if ( !!e && !!e.target && !$(e.target).closest( '.inner-menu-collapse' ).get(0) && ($(e.target).closest( '.inner-menu' ).get(0) || !$(e.target).closest( 'html' ).get(0)) ) {
					return false;
				}

				e.stopPropagation();

				$html.removeClass( 'inner-menu-opened' );
				$html.off( 'click.close-inner-menu' );

				$window.trigger( 'inner-menu-toggle', {
					added: false,
					removed: true
				});

				_self.sidebars.menu.isOpened = false;
			};

			var bind = function() {
				$('[data-open="inner-menu"]').on('click', function(e) {
					var $el = $(this);
					e.stopPropagation();

					if ( $el.is('a') )
						e.preventDefault();

					open();
				});
			};

			bind();

			/* Nano Scroll */
			if ( $html.hasClass( 'fixed' ) ) {
				var $nano = this.sidebars.menu.$nano;

				var updateNanoScroll = function() {
					if ( $.support.transition ) {
						$nano.nanoScroller();
						$nano
						.one('bsTransitionEnd', updateNanoScroll)
						.emulateTransitionEnd(150)
					} else {
						updateNanoScroll();
					}
				};

				this.sidebars.menu.$el
				.on( 'click', function() {
					updateNanoScroll();
				});
			}

			return this;
		},

		preventBodyScrollToggle: function( shouldPrevent, $el ) {
			setTimeout(function() {
				if ( shouldPrevent ) {
					$body
					.data( 'scrollTop', $body.get(0).scrollTop )
					.css({
						position: 'fixed',
						top: $body.get(0).scrollTop * -1
					})
				} else {
					$body
					.css({
						position: '',
						top: ''
					})
					.scrollTop( $body.data( 'scrollTop' ) );
				}
			}, 150);
		}

	};

	// expose to scope
	$.extend(theme, {
		Skeleton: Skeleton
	});

}).apply(this, [ window.theme, jQuery ]);

// Base
(function(theme, $) {

	'use strict';

	theme = theme || {};

	theme.Skeleton.initialize();

}).apply(this, [ window.theme, jQuery ]);

/*
Name: 			Theme Admin Extension
Written by: 	Okler Themes - (http://www.okler.net)
Theme Version: 	1.3.0
*/

window.theme = {};

// Mailbox
(function(theme, $) {

	theme = theme || {};

	var instanceName = '__mailbox';

	var capitalizeString = function( str ) {
		return str.charAt( 0 ).toUpperCase() + str.slice( 1 );
	}

	var Mailbox = function($wrapper) {
		return this.initialize($wrapper);
	};

	Mailbox.prototype = {
		initialize: function($wrapper) {
			if ( $wrapper.data( instanceName ) ) {
				return this;
			}

			this.$wrapper = $wrapper;

			this
			.setVars()
			.setData()
			.build()
			.events();

			return this;
		},

		setVars: function() {
			this.view = capitalizeString( this.$wrapper.data( 'mailbox-view' ) || "" );

			return this;
		},

		setData: function() {
			this.$wrapper.data(instanceName, this);

			return this;
		},

		build: function() {

			if ( typeof this[ 'build' + this.view ] === 'function' ) {
				this[ 'build' + this.view ].call( this );
			}


			return this;
		},

		events: function() {
			if ( typeof this[ 'events' + this.view ] === 'function' ) {
				this[ 'events' + this.view ].call( this );
			}

			return this;
		},

		buildFolder: function() {
			this.$wrapper.find('.mailbox-email-list .nano').nanoScroller({
				alwaysVisible: true,
				preventPageScrolling: true
			});
		},

		buildEmail: function() {
			this.buildComposer();
		},

		buildCompose: function() {
			this.buildComposer();
		},

		buildComposer: function() {
			this.$wrapper.find( '#compose-field' ).summernote({
				height: 250,
				toolbar: [
				['style', ['style']],
				['font', ['bold', 'italic', 'underline', 'clear']],
				['fontname', ['fontname']],
				['color', ['color']],
				['para', ['ul', 'ol', 'paragraph']],
				['height', ['height']],
				['table', ['table']],
				['insert', ['link', 'picture', 'video']],
				['view', ['fullscreen']],
				['help', ['help']]
				]
			});
		},

		eventsCompose: function() {
			var $composer,
			$contentBody,
			$html,
			$innerBody;

			$composer		= $( '.note-editable' );
			$contentBody	= $( '.content-body' );
			$html			= $( 'html' );
			$innerBody		= $( '.inner-body' );

			var adjustComposeSize = function() {
				var composerHeight,
				composerTop,
				contentBodyPaddingBottom,
				innerBodyHeight,
				viewportHeight,
				viewportWidth;


				contentBodyPaddingBottom	= parseInt( $contentBody.css('paddingBottom'), 10 ) || 0;
				viewportHeight				= Math.max( document.documentElement.clientHeight, window.innerHeight || 0 );
				viewportWidth				= Math.max( document.documentElement.clientWidth, window.innerWidth || 0 );

				$composer.css( 'height', '' );

				if ( viewportWidth < 767 || $html.hasClass('mobile-device') ) {
					composerTop	   = $composer.offset().top;
					composerHeight = viewportHeight - composerTop;
				} else {
					if ( $html.hasClass( 'fixed' ) ) {
						composerTop	= $composer.offset().top;
					} else {
						composerTop	= $composer.position().top;
					}
					composerHeight = $innerBody.outerHeight() - composerTop;
				}

				composerHeight -= contentBodyPaddingBottom;

				$composer.css({
					height: composerHeight
				});
			};

			var timer;
			$(window)
			.on( 'resize orientationchange sidebar-left-toggle mailbox-recalc', function() {
				clearTimeout( timer );
				timer = setTimeout(function() {
					adjustComposeSize();
				}, 100);
			});

			adjustComposeSize();
		}
	};

	// expose to scope
	$.extend(theme, {
		Mailbox: Mailbox
	});

	// jquery plugin
	$.fn.themeMailbox = function(opts) {
		return this.each(function() {
			var $this = $(this);

			if ($this.data(instanceName)) {
				return $this.data(instanceName);
			} else {
				return new Mailbox($this);
			}

		});
	}

}).apply(this, [ window.theme, jQuery ]);

// Lock Screen
(function( $ ) {

	'use strict';

	var LockScreen = {

		initialize: function() {
			this.$body = $( 'body' );

			this
			.build()
			.events();
		},

		build: function() {
			var lockHTML,
			userinfo;

			userinfo = this.getUserInfo();
			this.lockHTML = this.buildTemplate( userinfo );

			this.$lock        = this.$body.children( '#LockScreenInline' );
			this.$userPicture = this.$lock.find( '#LockUserPicture' );
			this.$userName    = this.$lock.find( '#LockUserName' );
			this.$userEmail   = this.$lock.find( '#LockUserEmail' );

			return this;
		},

		events: function() {
			var _self = this;

			this.$body.find( '[data-lock-screen="true"]' ).on( 'click', function( e ) {
				e.preventDefault();

				_self.show();
			});

			return this;
		},

		formEvents: function( $form ) {
			var _self = this;

			$form.on( 'submit', function( e ) {
				e.preventDefault();

				_self.hide();
			});
		},

		show: function() {
			var _self = this,
			userinfo = this.getUserInfo();

			this.$userPicture.attr( 'src', userinfo.picture );
			this.$userName.text( userinfo.username );
			this.$userEmail.text( userinfo.email );

			this.$body.addClass( 'show-lock-screen' );

			$.magnificPopup.open({
				items: {
					src: this.lockHTML,
					type: 'inline'
				},
				modal: true,
				mainClass: 'mfp-lock-screen',
				callbacks: {
					change: function() {
						_self.formEvents( this.content.find( 'form' ) );
					}
				}
			});
		},

		hide: function() {
			$.magnificPopup.close();
		},

		getUserInfo: function() {
			var $info,
			picture,
			name,
			email;

			// always search in case something is changed through ajax
			$info    = $( '#userbox' );
			picture  = $info.find( '.profile-picture img' ).attr( 'data-lock-picture' );
			name     = $info.find( '.profile-info' ).attr( 'data-lock-name' );
			email    = $info.find( '.profile-info' ).attr( 'data-lock-email' );

			return {
				picture: picture,
				username: name,
				email: email
			};
		},

		buildTemplate: function( userinfo ) {
			return [
			'<section id="LockScreenInline" class="body-sign body-locked body-locked-inline">',
			'<div class="center-sign">',
			'<div class="panel panel-sign">',
			'<div class="panel-body">',
			'<form>',
			'<div class="current-user text-center">',
			// '<img id="LockUserPicture" src="{{picture}}" alt="John Doe" class="img-circle user-image" />',
			'<h2 id="LockUserName" class="user-name text-dark m-none">{{username}}</h2>',
			'<p  id="LockUserEmail" class="user-email m-none">{{email}}</p>',
			'</div>',
			'<div class="form-group mb-lg">',
			'<div class="input-group input-group-icon">',
			'<input id="pwd" name="pwd" type="password" class="form-control input-lg" placeholder="Password" />',
			'<span class="input-group-addon">',
			'<span class="icon icon-lg">',
			'<i class="fa fa-lock"></i>',
			'</span>',
			'</span>',
			'</div>',
			'</div>',

			'<div class="row">',
			'<div class="col-xs-6">',
			'<p class="mt-xs mb-none">',
			'<a href="#"></a>',
			'</p>',
			'</div>',
			'<div class="col-xs-6 text-right">',
			'<button type="submit" class="btn btn-primary">Mở khóa</button>',
			'</div>',
			'</div>',
			'</form>',
			'</div>',
			'</div>',
			'</div>',
			'</section>'
			]
			.join( '' )
			.replace( /\{\{picture\}\}/, userinfo.picture )
			.replace( /\{\{username\}\}/, userinfo.username )
			.replace( /\{\{email\}\}/, userinfo.email );
		}

	};

	this.LockScreen = LockScreen;

	$(function() {
		LockScreen.initialize();
	});

}).apply(this, [ jQuery ]);

// Panels
(function( $ ) {

	$(function() {
		$('.panel')
		.on( 'click', '.panel-actions a.fa-caret-up', function( e ) {
			e.preventDefault();

			var $this,
			$panel;

			$this = $( this );
			$panel = $this.closest( '.panel' );

			$this
			.removeClass( 'fa-caret-up' )
			.addClass( 'fa-caret-down' );

			$panel.find('.panel-body, .panel-footer').slideDown( 200 );
		})
		.on( 'click', '.panel-actions a.fa-caret-down', function( e ) {
			e.preventDefault();

			var $this,
			$panel;

			$this = $( this );
			$panel = $this.closest( '.panel' );

			$this
			.removeClass( 'fa-caret-down' )
			.addClass( 'fa-caret-up' );

			$panel.find('.panel-body, .panel-footer').slideUp( 200 );
		})
		.on( 'click', '.panel-actions a.fa-times', function( e ) {
			e.preventDefault();

			var $panel,
			$row;

			$panel = $(this).closest('.panel');

			if ( !!( $panel.parent('div').attr('class') || '' ).match( /col-(xs|sm|md|lg)/g ) && $panel.siblings().length === 0 ) {
				$row = $panel.closest('.row');
				$panel.parent('div').remove();
				if ( $row.children().length === 0 ) {
					$row.remove();
				}
			} else {
				$panel.remove();
			}
		});
	});

})( jQuery );

// Bootstrap Toggle
(function( $ ) {

	'use strict';

	var $window = $( window );

	var toggleClass = function( $el ) {
		if ( !!$el.data('toggleClassBinded') ) {
			return false;
		}

		var $target,
		className,
		eventName;

		$target = $( $el.attr('data-target') );
		className = $el.attr('data-toggle-class');
		eventName = $el.attr('data-fire-event');


		$el.on('click.toggleClass', function(e) {
			e.preventDefault();
			$target.toggleClass( className );

			var hasClass = $target.hasClass( className );

			if ( !!eventName ) {
				$window.trigger( eventName, {
					added: hasClass,
					removed: !hasClass
				});
			}
		});

		$el.data('toggleClassBinded', true);

		return true;
	};

	$(function() {
		$('[data-toggle-class][data-target]').each(function() {
			toggleClass( $(this) );
		});
	});

}).apply( this, [ jQuery ]);

// Form to Object
(function( $ ) {

	'use strict';

	$.fn.formToObject = function() {
		var arrayData,
		objectData;

		arrayData	= this.serializeArray();
		objectData	= {};

		$.each( arrayData, function() {
			var value;

			if (this.value != null) {
				value = this.value;
			} else {
				value = '';
			}

			if (objectData[this.name] != null) {
				if (!objectData[this.name].push) {
					objectData[this.name] = [objectData[this.name]];
				}

				objectData[this.name].push(value);
			} else {
				objectData[this.name] = value;
			}
		});

		return objectData;
	};

})( jQuery );

// Codemirror
(function(theme, $) {

	theme = theme || {};

	var instanceName = '__codemirror';

	var PluginCodeMirror = function($el, opts) {
		return this.initialize($el, opts);
	};

	PluginCodeMirror.defaults = {
		lineNumbers: true,
		styleActiveLine: true,
		matchBrackets: true,
		theme: 'monokai'
	};

	PluginCodeMirror.prototype = {
		initialize: function($el, opts) {
			if ( $el.data( instanceName ) ) {
				return this;
			}

			this.$el = $el;

			this
			.setData()
			.setOptions(opts)
			.build();

			return this;
		},

		setData: function() {
			this.$el.data(instanceName, this);

			return this;
		},

		setOptions: function(opts) {
			this.options = $.extend( true, {}, PluginCodeMirror.defaults, opts );

			return this;
		},

		build: function() {
			CodeMirror.fromTextArea( this.$el.get(0), this.options );

			return this;
		}
	};

	// expose to scope
	$.extend(theme, {
		PluginCodeMirror: PluginCodeMirror
	});

	// jquery plugin
	$.fn.themePluginCodeMirror = function(opts) {
		return this.each(function() {
			var $this = $(this);

			if ($this.data(instanceName)) {
				return $this.data(instanceName);
			} else {
				return new PluginCodeMirror($this, opts);
			}

		});
	}

}).apply(this, [ window.theme, jQuery ]);

// Colorpicker
(function(theme, $) {

	theme = theme || {};

	var instanceName = '__colorpicker';

	var PluginColorPicker = function($el, opts) {
		return this.initialize($el, opts);
	};

	PluginColorPicker.defaults = {
	};

	PluginColorPicker.prototype = {
		initialize: function($el, opts) {
			if ( $el.data( instanceName ) ) {
				return this;
			}

			this.$el = $el;

			this
			.setData()
			.setOptions(opts)
			.build();

			return this;
		},

		setData: function() {
			this.$el.data(instanceName, this);

			return this;
		},

		setOptions: function(opts) {
			this.options = $.extend( true, {}, PluginColorPicker.defaults, opts );

			return this;
		},

		build: function() {
			this.$el.colorpicker( this.options );

			return this;
		}
	};

	// expose to scope
	$.extend(theme, {
		PluginColorPicker: PluginColorPicker
	});

	// jquery plugin
	$.fn.themePluginColorPicker = function(opts) {
		return this.each(function() {
			var $this = $(this);

			if ($this.data(instanceName)) {
				return $this.data(instanceName);
			} else {
				return new PluginColorPicker($this, opts);
			}

		});
	}

}).apply(this, [ window.theme, jQuery ]);

// Datepicker
(function(theme, $) {

	theme = theme || {};

	var instanceName = '__datepicker';

	var PluginDatePicker = function($el, opts) {
		return this.initialize($el, opts);
	};

	PluginDatePicker.defaults = {
	};

	PluginDatePicker.prototype = {
		initialize: function($el, opts) {
			if ( $el.data( instanceName ) ) {
				return this;
			}

			this.$el = $el;

			this
			.setVars()
			.setData()
			.setOptions(opts)
			.build();

			return this;
		},

		setVars: function() {
			this.skin = this.$el.data( 'plugin-skin' );

			return this;
		},

		setData: function() {
			this.$el.data(instanceName, this);

			return this;
		},

		setOptions: function(opts) {
			this.options = $.extend( true, {}, PluginDatePicker.defaults, opts );

			return this;
		},

		build: function() {
			this.$el.datepicker( this.options );

			if ( !!this.skin ) {
				this.$el.data('datepicker').picker.addClass( 'datepicker-' + this.skin );
			}

			return this;
		}
	};

	// expose to scope
	$.extend(theme, {
		PluginDatePicker: PluginDatePicker
	});

	// jquery plugin
	$.fn.themePluginDatePicker = function(opts) {
		return this.each(function() {
			var $this = $(this);

			if ($this.data(instanceName)) {
				return $this.data(instanceName);
			} else {
				return new PluginDatePicker($this, opts);
			}

		});
	}

}).apply(this, [ window.theme, jQuery ]);

// iosSwitcher
(function(theme, $) {

	theme = theme || {};

	var instanceName = '__IOS7Switch';

	var PluginIOS7Switch = function($el) {
		return this.initialize($el);
	};

	PluginIOS7Switch.prototype = {
		initialize: function($el) {
			if ( $el.data( instanceName ) ) {
				return this;
			}

			this.$el = $el;

			this
			.setData()
			.build();

			return this;
		},

		setData: function() {
			this.$el.data(instanceName, this);

			return this;
		},

		build: function() {
			var switcher = new Switch( this.$el.get(0) );

			$( switcher.el ).on( 'click', function( e ) {
				e.preventDefault();
				switcher.toggle();
			});

			return this;
		}
	};

	// expose to scope
	$.extend(theme, {
		PluginIOS7Switch: PluginIOS7Switch
	});

	// jquery plugin
	$.fn.themePluginIOS7Switch = function(opts) {
		return this.each(function() {
			var $this = $(this);

			if ($this.data(instanceName)) {
				return $this.data(instanceName);
			} else {
				return new PluginIOS7Switch($this);
			}

		});
	}

}).apply(this, [ window.theme, jQuery ]);

// Markdown
(function(theme, $) {

	theme = theme || {};

	var instanceName = '__markdownEditor';

	var PluginMarkdownEditor = function($el, opts) {
		return this.initialize($el, opts);
	};

	PluginMarkdownEditor.defaults = {
		iconlibrary: 'fa'
	};

	PluginMarkdownEditor.prototype = {
		initialize: function($el, opts) {
			if ( $el.data( instanceName ) ) {
				return this;
			}

			this.$el = $el;

			this
			.setData()
			.setOptions(opts)
			.build();

			return this;
		},

		setData: function() {
			this.$el.data(instanceName, this);

			return this;
		},

		setOptions: function(opts) {
			this.options = $.extend( true, {}, PluginMarkdownEditor.defaults, opts );

			return this;
		},

		build: function() {
			this.$el.markdown( this.options );

			return this;
		}
	};

	// expose to scope
	$.extend(theme, {
		PluginMarkdownEditor: PluginMarkdownEditor
	});

	// jquery plugin
	$.fn.themePluginMarkdownEditor = function(opts) {
		return this.each(function() {
			var $this = $(this);

			if ($this.data(instanceName)) {
				return $this.data(instanceName);
			} else {
				return new PluginMarkdownEditor($this, opts);
			}

		});
	}

}).apply(this, [ window.theme, jQuery ]);

// Masked Input
(function(theme, $) {

	theme = theme || {};

	var instanceName = '__maskedInput';

	var PluginMaskedInput = function($el, opts) {
		return this.initialize($el, opts);
	};

	PluginMaskedInput.defaults = {
	};

	PluginMaskedInput.prototype = {
		initialize: function($el, opts) {
			if ( $el.data( instanceName ) ) {
				return this;
			}

			this.$el = $el;

			this
			.setData()
			.setOptions(opts)
			.build();

			return this;
		},

		setData: function() {
			this.$el.data(instanceName, this);

			return this;
		},

		setOptions: function(opts) {
			this.options = $.extend( true, {}, PluginMaskedInput.defaults, opts );

			return this;
		},

		build: function() {
			this.$el.mask( this.$el.data('input-mask'), this.options );

			return this;
		}
	};

	// expose to scope
	$.extend(theme, {
		PluginMaskedInput: PluginMaskedInput
	});

	// jquery plugin
	$.fn.themePluginMaskedInput = function(opts) {
		return this.each(function() {
			var $this = $(this);

			if ($this.data(instanceName)) {
				return $this.data(instanceName);
			} else {
				return new PluginMaskedInput($this, opts);
			}

		});
	}

}).apply(this, [ window.theme, jQuery ]);

// MaxLength
(function(theme, $) {

	theme = theme || {};

	var instanceName = '__maxlength';

	var PluginMaxLength = function($el, opts) {
		return this.initialize($el, opts);
	};

	PluginMaxLength.defaults = {
		alwaysShow: true,
		placement: 'bottom-left',
		warningClass: 'label label-success bottom-left',
		limitReachedClass: 'label label-danger bottom-left'
	};

	PluginMaxLength.prototype = {
		initialize: function($el, opts) {
			if ( $el.data( instanceName ) ) {
				return this;
			}

			this.$el = $el;

			this
			.setData()
			.setOptions(opts)
			.build();

			return this;
		},

		setData: function() {
			this.$el.data(instanceName, this);

			return this;
		},

		setOptions: function(opts) {
			this.options = $.extend( true, {}, PluginMaxLength.defaults, opts );

			return this;
		},

		build: function() {
			this.$el.maxlength( this.options );

			return this;
		}
	};

	// expose to scope
	$.extend(theme, {
		PluginMaxLength: PluginMaxLength
	});

	// jquery plugin
	$.fn.themePluginMaxLength = function(opts) {
		return this.each(function() {
			var $this = $(this);

			if ($this.data(instanceName)) {
				return $this.data(instanceName);
			} else {
				return new PluginMaxLength($this, opts);
			}

		});
	}

}).apply(this, [ window.theme, jQuery ]);

// MultiSelect
(function(theme, $) {

	theme = theme || {};

	var instanceName = '__multiselect';

	var PluginMultiSelect = function($el, opts) {
		return this.initialize($el, opts);
	};

	PluginMultiSelect.defaults = {
		templates: {
			filter: '<div class="input-group"><span class="input-group-addon"><i class="fa fa-search"></i></span><input class="form-control multiselect-search" type="text"></div>'
		}
	};

	PluginMultiSelect.prototype = {
		initialize: function($el, opts) {
			if ( $el.data( instanceName ) ) {
				return this;
			}

			this.$el = $el;

			this
			.setData()
			.setOptions(opts)
			.build();

			return this;
		},

		setData: function() {
			this.$el.data(instanceName, this);

			return this;
		},

		setOptions: function(opts) {
			this.options = $.extend( true, {}, PluginMultiSelect.defaults, opts );

			return this;
		},

		build: function() {
			this.$el.multiselect( this.options );

			return this;
		}
	};

	// expose to scope
	$.extend(theme, {
		PluginMultiSelect: PluginMultiSelect
	});

	// jquery plugin
	$.fn.themePluginMultiSelect = function(opts) {
		return this.each(function() {
			var $this = $(this);

			if ($this.data(instanceName)) {
				return $this.data(instanceName);
			} else {
				return new PluginMultiSelect($this, opts);
			}

		});
	}

}).apply(this, [ window.theme, jQuery ]);

// Select2
(function(theme, $) {

	theme = theme || {};

	var instanceName = '__select2';

	var PluginSelect2 = function($el, opts) {
		return this.initialize($el, opts);
	};

	PluginSelect2.defaults = {
	};

	PluginSelect2.prototype = {
		initialize: function($el, opts) {
			if ( $el.data( instanceName ) ) {
				return this;
			}

			this.$el = $el;

			this
			.setData()
			.setOptions(opts)
			.build();

			return this;
		},

		setData: function() {
			this.$el.data(instanceName, this);

			return this;
		},

		setOptions: function(opts) {
			this.options = $.extend( true, {}, PluginSelect2.defaults, opts );

			return this;
		},

		build: function() {
			this.$el.select2( this.options );

			return this;
		}
	};

	// expose to scope
	$.extend(theme, {
		PluginSelect2: PluginSelect2
	});

	// jquery plugin
	$.fn.themePluginSelect2 = function(opts) {
		return this.each(function() {
			var $this = $(this);

			if ($this.data(instanceName)) {
				return $this.data(instanceName);
			} else {
				return new PluginSelect2($this, opts);
			}

		});
	}

}).apply(this, [ window.theme, jQuery ]);

// Spinner
(function(theme, $) {

	theme = theme || {};

	var instanceName = '__spinner';

	var PluginSpinner = function($el, opts) {
		return this.initialize($el, opts);
	};

	PluginSpinner.defaults = {
	};

	PluginSpinner.prototype = {
		initialize: function($el, opts) {
			if ( $el.data( instanceName ) ) {
				return this;
			}

			this.$el = $el;

			this
			.setData()
			.setOptions(opts)
			.build();

			return this;
		},

		setData: function() {
			this.$el.data(instanceName, this);

			return this;
		},

		setOptions: function(opts) {
			this.options = $.extend( true, {}, PluginSpinner.defaults, opts );

			return this;
		},

		build: function() {
			this.$el.spinner( this.options );

			return this;
		}
	};

	// expose to scope
	$.extend(theme, {
		PluginSpinner: PluginSpinner
	});

	// jquery plugin
	$.fn.themePluginSpinner = function(opts) {
		return this.each(function() {
			var $this = $(this);

			if ($this.data(instanceName)) {
				return $this.data(instanceName);
			} else {
				return new PluginSpinner($this, opts);
			}

		});
	}

}).apply(this, [ window.theme, jQuery ]);

// SummerNote
(function(theme, $) {

	theme = theme || {};

	var instanceName = '__summernote';

	var PluginSummerNote = function($el, opts) {
		return this.initialize($el, opts);
	};

	PluginSummerNote.defaults = {
		onfocus: function() {
			$( this ).closest( '.note-editor' ).addClass( 'active' );
		},
		onblur: function() {
			$( this ).closest( '.note-editor' ).removeClass( 'active' );
		}
	};

	PluginSummerNote.prototype = {
		initialize: function($el, opts) {
			if ( $el.data( instanceName ) ) {
				return this;
			}

			this.$el = $el;

			this
			.setData()
			.setOptions(opts)
			.build();

			return this;
		},

		setData: function() {
			this.$el.data(instanceName, this);

			return this;
		},

		setOptions: function(opts) {
			this.options = $.extend( true, {}, PluginSummerNote.defaults, opts );

			return this;
		},

		build: function() {
			this.$el.summernote( this.options );

			return this;
		}
	};

	// expose to scope
	$.extend(theme, {
		PluginSummerNote: PluginSummerNote
	});

	// jquery plugin
	$.fn.themePluginSummerNote = function(opts) {
		return this.each(function() {
			var $this = $(this);

			if ($this.data(instanceName)) {
				return $this.data(instanceName);
			} else {
				return new PluginSummerNote($this, opts);
			}

		});
	}

}).apply(this, [ window.theme, jQuery ]);

// TextArea AutoSize
(function(theme, $) {

	theme = theme || {};

	var initialized = false;
	var instanceName = '__textareaAutosize';

	var PluginTextAreaAutoSize = function($el, opts) {
		return this.initialize($el, opts);
	};

	PluginTextAreaAutoSize.defaults = {
	};

	PluginTextAreaAutoSize.prototype = {
		initialize: function($el, opts) {
			if (initialized) {
				return this;
			}

			this.$el = $el;

			this
			.setData()
			.setOptions(opts)
			.build();

			return this;
		},

		setData: function() {
			this.$el.data(instanceName, this);

			return this;
		},

		setOptions: function(opts) {
			this.options = $.extend( true, {}, PluginTextAreaAutoSize.defaults, opts );

			return this;
		},

		build: function() {
			this.$el.autosize( this.options );

			return this;
		}
	};

	// expose to scope
	$.extend(theme, {
		PluginTextAreaAutoSize: PluginTextAreaAutoSize
	});

	// jquery plugin
	$.fn.themePluginTextAreaAutoSize = function(opts) {
		return this.each(function() {
			var $this = $(this);

			if ($this.data(instanceName)) {
				return $this.data(instanceName);
			} else {
				return new PluginTextAreaAutoSize($this, opts);
			}

		});
	}

}).apply(this, [ window.theme, jQuery ]);


// Map Builder
(function( theme, $ ) {

	'use strict';

	// prevent undefined var
	theme = theme || {};

	// internal var to check if reached limit
	var timeouts = 0;

	// instance
	var instanceName = '__gmapbuilder';

	// private
	var roundNumber = function( number, precision ) {
		if( precision < 0 ) {
			precision = 0;
		} else if( precision > 10 ) {
			precision = 10;
		}
		var a = [ 1, 10, 100, 1000, 10000, 100000, 1000000, 10000000, 100000000, 1000000000, 10000000000 ];

		return Math.round( number * a[ precision ] ) / a[ precision ];
	};

	// definition
	var GMapBuilder = function( $wrapper, opts ) {
		return this.initialize( $wrapper, opts );
	};

	GMapBuilder.defaults = {
		mapSelector: '#gmap',

		markers: {
			modal: '#MarkerModal',
			list: '#MarkersList',
			removeAll: '#MarkerRemoveAll'
		},

		previewModal: '#ModalPreview',
		getCodeModal: '#ModalGetCode',

		mapOptions: {
			center: {
				lat: -38.908133,
				lng: -13.692628
			},
			panControl: true,
			zoom: 3
		}
	};

	GMapBuilder.prototype = {

		markers: [],

		initialize: function( $wrapper, opts ) {
			this.$wrapper = $wrapper;

			this
			.setData()
			.setOptions( opts )
			.setVars()
			.build()
			.events();

			return this;
		},

		setData: function() {
			this.$wrapper.data( instanceName, this );

			return this;
		},

		setOptions: function( opts ) {
			this.options = $.extend( true, {}, GMapBuilder.defaults, opts );

			return this;
		},

		setVars: function() {
			this.$mapContainer		= this.$wrapper.find( this.options.mapSelector );

			this.$previewModal		= $( this.options.previewModal );
			this.$getCodeModal		= $( this.options.getCodeModal );

			this.marker				= {};
			this.marker.$modal  	= $( this.options.markers.modal );
			this.marker.$form		= this.marker.$modal.find( 'form' );
			this.marker.$list		= $( this.options.markers.list );
			this.marker.$removeAll	= $( this.options.markers.removeAll );

			return this;
		},

		build: function() {
			var _self = this;

			if ( !!window.SnazzyThemes ) {
				var themeOpts = [];

				$.each( window.SnazzyThemes, function( i, theme ) {
					themeOpts.push( $('<option value="' + theme.id + '">' + theme.name + '</option>').data( 'json', theme.json ) );
				});

				this.$wrapper.find( '[data-builder-field="maptheme"]' ).append( themeOpts );
			}

			this.geocoder = new google.maps.Geocoder();

			google.maps.event.addDomListener( window, 'load', function() {
				_self.options.mapOptions.center = new google.maps.LatLng( _self.options.mapOptions.center.lat, _self.options.mapOptions.center.lng );

				_self.map = new google.maps.Map( _self.$mapContainer.get(0), _self.options.mapOptions );

				_self
				.updateControl( 'latlng' )
				.updateControl( 'zoomlevel' );

				_self.mapEvents();
			});

			return this;
		},

		events: function() {
			var _self = this;

			this.$wrapper.find( '[data-builder-field]' ).each(function() {
				var $this = $( this ),
				field,
				value;

				field = $this.data( 'builder-field' );

				$this.on( 'change', function() {

					if ( $this.is( 'select' ) ) {
						value = $this.children( 'option:selected' ).val().toLowerCase();
					} else {
						value = $this.val().toLowerCase();
					}

					_self.updateMap( field, value );
				});

			});

			this.marker.$form.on( 'submit', function( e ) {
				e.preventDefault();

				_self.saveMarker( _self.marker.$form.formToObject() );
			});

			this.marker.$removeAll.on( 'click', function( e ) {
				e.preventDefault();
				_self.removeAllMarkers();
			});

			// preview events
			this.$previewModal.on( 'shown.bs.modal', function() {
				_self.preview();
			});

			this.$previewModal.on( 'hidden.bs.modal', function() {
				_self.$previewModal.find( 'iframe' ).get(0).contentWindow.document.body.innerHTML = '';
			});

			// get code events
			this.$getCodeModal.on( 'shown.bs.modal', function() {
				_self.getCode();
			});

			return this;
		},

		// MAP FUNCTIONS
		// -----------------------------------------------------------------------------
		mapEvents: function() {
			var _self = this;

			google.maps.event.addDomListener( _self.map, 'resize', function() {
				google.maps.event.trigger( _self.map, 'resize' );
			});

			google.maps.event.addListener( this.map, 'center_changed', function() {
				var coords = _self.map.getCenter();
				_self.updateControl( 'latlng', {
					lat: roundNumber( coords.lat(), 6 ),
					lng: roundNumber( coords.lng(), 6 )
				});
			});

			google.maps.event.addListener( this.map, 'zoom_changed', function() {
				_self.updateControl( 'zoomlevel', _self.map.getZoom() );
			});

			google.maps.event.addListener( this.map, 'maptypeid_changed', function() {
				_self.updateControl( 'maptype', _self.map.getMapTypeId() );
			});

			return this;
		},

		updateMap: function( prop, value ) {
			var updateFn;

			updateFn = this.updateMapProperty[ prop ];

			if ( $.isFunction( updateFn ) ) {
				updateFn.apply( this, [ value ] );
			} else {
				console.info( 'missing update function for', prop );
			}

			return this;
		},

		updateMapProperty: {

			latlng: function() {
				var lat,
				lng;

				lat = this.$wrapper.find('[data-builder-field][name="latitude"]').val();
				lng = this.$wrapper.find('[data-builder-field][name="longitude"]').val();

				if ( lat.length > 0 && lng.length > 0 ) {
					this.map.setCenter( new google.maps.LatLng( lat, lng ) );
				}

				return this;
			},

			zoomlevel: function( value ) {
				var value = arguments[ 0 ];

				this.map.setZoom( parseInt( value, 10 ) );

				return this;
			},

			maptypecontrol: function( value ) {
				var options;

				options	= {};

				if ( value === 'false' ){
					options.mapTypeControl = false;
				} else {
					options = {
						mapTypeControl: true,
						mapTypeControlOptions: {
							style: google.maps.MapTypeControlStyle[ value.toUpperCase() ]
						}
					};
				}

				this.map.setOptions( options );

				return this;
			},

			zoomcontrol: function( value ) {
				var options;

				options	= {};

				if ( value === 'false' ){
					options.zoomControl = false;
				} else {
					options = {
						zoomControl: true,
						zoomControlOptions: {
							style: google.maps.ZoomControlStyle[ value.toUpperCase() ]
						}
					};
				}

				this.map.setOptions( options );

				return this;
			},

			scalecontrol: function( value ) {
				var options;

				options	= {};

				options.scaleControl = value !== 'false';

				this.map.setOptions( options );

				return this;
			},

			streetviewcontrol: function( value ) {
				var options;

				options	= {};

				options.streetViewControl = value !== 'false';

				this.map.setOptions( options );

				return this;
			},

			pancontrol: function( value ) {
				var options;

				options	= {};

				options.panControl = value !== 'false';

				this.map.setOptions( options );

				return this;
			},

			overviewcontrol: function( value ) {
				var options;

				options	= {};

				if ( value === 'false' ){
					options.overviewMapControl = false;
				} else {
					options = {
						overviewMapControl: true,
						overviewMapControlOptions: {
							opened: value === 'opened'
						}
					};
				}

				this.map.setOptions( options );

				return this;
			},

			draggablecontrol: function( value ) {
				var options;

				options	= {};

				options.draggable = value !== 'false';

				this.map.setOptions( options );

				return this;
			},

			clicktozoomcontrol: function( value ) {
				var options;

				options	= {};

				options.disableDoubleClickZoom = value === 'false';

				this.map.setOptions( options );

				return this;
			},

			scrollwheelcontrol: function( value ) {
				var options;

				options	= {};

				options.scrollwheel = value !== 'false';

				this.map.setOptions( options );

				return this;
			},

			maptype: function( value ) {
				var options,
				mapStyles,
				mapType;

				mapStyles = this.$wrapper.find( '[data-builder-field="maptheme"]' ).children( 'option' ).filter( ':selected' ).data( 'json' );
				mapType =  google.maps.MapTypeId[ value.toUpperCase() ];

				options	= {
					mapTypeId: mapType
				};

				if ( $.inArray( google.maps.MapTypeId[ value.toUpperCase() ], [ 'terrain', 'roadmap' ]) > -1 && !!mapStyles ) {
					options.styles = eval( mapStyles );
				} else {
					options.styles = false;
					this.updateControl( 'maptheme' );
				}

				this.map.setOptions( options );
			},

			maptheme: function( value ) {
				var json,
				mapType,
				options;

				mapType = google.maps.MapTypeId[ this.map.getMapTypeId() === 'terrain' ? 'TERRAIN' : 'ROADMAP' ];
				options = {};
				json = this.$wrapper.find( '[data-builder-field="maptheme"]' ).children( 'option' ).filter( ':selected' ).data( 'json' );

				if ( !json ) {
					options = {
						mapTypeId: mapType,
						styles: false
					};
				} else {
					options = {
						mapTypeId: mapType,
						styles: eval( json )
					};
				}

				this.map.setOptions( options );
			}

		},

		// CONTROLS FUNCTIONS
		// -----------------------------------------------------------------------------
		updateControl: function( prop ) {
			var updateFn;

			updateFn = this.updateControlValue[ prop ];

			if ( $.isFunction( updateFn ) ) {
				updateFn.apply( this );
			} else {
				console.info( 'missing update function for', prop );
			}

			return this;
		},

		updateControlValue: {

			latlng: function() {
				var center = this.map.getCenter();

				this.$wrapper.find('[data-builder-field][name="latitude"]').val( roundNumber( center.lat() , 6 ) );
				this.$wrapper.find('[data-builder-field][name="longitude"]').val( roundNumber( center.lng() , 6 ) );
			},

			zoomlevel: function() {
				var $control,
				level;

				level = this.map.getZoom();

				$control = this.$wrapper.find('[data-builder-field="zoomlevel"]');

				$control
				.children( 'option[value="' + level + '"]' )
				.prop( 'selected', true );

				if ( $control.hasClass( 'select2-offscreen' ) ) {
					$control.select2( 'val', level );
				}
			},

			maptype: function() {
				var $control,
				mapType;

				mapType = this.map.getMapTypeId();
				$control = this.$wrapper.find('[data-builder-field="maptype"]');

				$control
				.children( 'option[value="' + mapType + '"]' )
				.prop( 'selected', true );

				if ( $control.hasClass( 'select2-offscreen' ) ) {
					$control.select2( 'val', mapType );
				}
			},

			maptheme: function() {
				var $control;

				$control = this.$wrapper.find('[data-builder-field="maptheme"]');

				$control
				.children( 'option[value="false"]' )
				.prop( 'selected', true );

				if ( $control.hasClass( 'select2-offscreen' ) ) {
					$control.select2( 'val', 'false' );
				}
			}

		},

		// MARKERS FUNCTIONS
		// -----------------------------------------------------------------------------
		editMarker: function( marker ) {
			this.currentMarker = marker;

			this.marker.$form
			.find( '#MarkerLocation' ).val( marker.location );

			this.marker.$form
			.find( '#MarkerTitle' ).val( marker.title );

			this.marker.$form
			.find( '#MarkerDescription' ).val( marker.description );

			this.marker.$modal.modal( 'show' );
		},

		removeMarker: function( marker ) {
			var i;

			marker._instance.setMap( null );
			marker._$html.remove();

			for( i = 0; i < this.markers.length; i++ ) {
				if ( marker === this.markers[ i ] ) {
					this.markers.splice( i, 1 );
					break;
				}
			}

			if ( this.markers.length === 0 ) {
				this.marker.$list.addClass( 'hidden' );
			}
		},

		saveMarker: function( marker ) {
			this._geocode( marker );
		},

		removeAllMarkers: function() {
			var i = 0,
			l,
			marker;

			l = this.markers.length;

			for( ; i < l; i++ ) {
				marker = this.markers[ i ];

				marker._instance.setMap( null );
				marker._$html.remove();
			}

			this.markers = [];
			this.marker.$list.addClass( 'hidden' );
		},

		_geocode: function( marker ) {
			var _self = this,
			status;

			this.geocoder.geocode({ address: marker.location }, function( response, status ) {
				_self._onGeocodeResult( marker, response, status );
			});
		},

		_onGeocodeResult: function( marker, response, status ) {
			var result;

			if ( !response || status !== google.maps.GeocoderStatus.OK ) {
				if ( status == google.maps.GeocoderStatus.ZERO_RESULTS ) {
					// show notification
				} else {
					timeouts++;
					if ( timeouts > 3 ) {
						// show notification reached limit of requests
					}
				}
			} else {
				timeouts = 0;

				if ( this.currentMarker ) {
					this.removeMarker( this.currentMarker );
					this.currentMarker = null;
				}

				// grab first result of the list
				result = response[ 0 ];

				// get lat & lng and set to marker
				marker.lat = Math.round( result.geometry.location.lat() * 1000000 ) / 1000000;
				marker.lng = Math.round( result.geometry.location.lng() * 1000000 ) / 1000000;

				var opts = {
					position: new google.maps.LatLng( marker.lat, marker.lng ),
					map: this.map
				};

				if ( marker.title.length > 0 ) {
					opts.title = marker.title;
				}

				if ( marker.description.length > 0 ) {
					opts.desc = marker.description;
				}

				marker.position = opts.position;
				marker._instance = new google.maps.Marker( opts );

				if ( !!marker.title || !!marker.description  ) {
					this._bindMarkerClick( marker );
				}

				this.markers.push( marker );

				// append to markers list
				this._appendMarkerToList( marker );

				// hide modal and reset form
				this.marker.$form.get(0).reset();
				this.marker.$modal.modal( 'hide' );
			}
		},

		_appendMarkerToList: function( marker ) {
			var _self = this,
			html;

			html = [
			'<li>',
			'<p>{location}</p>',
			'<a href="#" class="location-action location-center"><i class="fa fa-map-marker"></i></a>',
			'<a href="#" class="location-action location-edit"><i class="fa fa-edit"></i></a>',
			'<a href="#" class="location-action location-remove text-danger"><i class="fa fa-times"></i></a>',
			'</li>'
			].join('');

			html = html.replace( /\{location\}/, !!marker.title ? marker.title : marker.location );

			marker._$html = $( html );

			// events
			marker._$html.find( '.location-center' )
			.on( 'click', function( e ) {
				_self.map.setCenter( marker.position );
			});

			marker._$html.find( '.location-remove' )
			.on( 'click', function( e ) {
				e.preventDefault();
				_self.removeMarker( marker );
			});

			marker._$html.find( '.location-edit' )
			.on( 'click', function( e ) {
				e.preventDefault();
				_self.editMarker( marker );
			});

			this.marker.$list
			.append( marker._$html )
			.removeClass( 'hidden' );
		},

		_bindMarkerClick: function( marker ) {
			var _self = this,
			html;

			html = [
			'<div style="background-color: #FFF; color: #000; padding: 5px; width: 150px;">',
			'{title}',
			'{description}',
			'</div>'
			].join('');

			html = html.replace(/\{title\}/, !!marker.title ?  ("<h4>" + marker.title + "</h4>") : "" );
			html = html.replace(/\{description\}/, !!marker.description ?  ("<p>" + marker.description + "</p>") : "" );

			marker._infoWindow = new google.maps.InfoWindow({ content: html });

			google.maps.event.addListener( marker._instance, 'click', function() {

				if ( marker._infoWindow.isOpened ) {
					marker._infoWindow.close();
					marker._infoWindow.isOpened = false;
				} else {
					marker._infoWindow.open( _self.map, this );
					marker._infoWindow.isOpened = true;
				}

			});
		},

		preview: function() {
			var customScript,
			googleScript,
			iframe,
			previewHtml;

			previewHtml = [
			'<style>',
			'html, body { margin: 0; padding: 0; }',
			'</style>',
			'<div id="' + this.$wrapper.find('[data-builder-field="mapid"]').val() + '" style="width: 100%; height: 100%;"></div>'
			];

			iframe = this.$previewModal.find( 'iframe' ).get(0).contentWindow.document;

			iframe.body.innerHTML = previewHtml.join('');

			customScript = iframe.createElement( 'script' );
			customScript.type = 'text/javascript';
			customScript.text = "window.initialize = function() { " + this.generate() + " init(); }; ";
			iframe.body.appendChild( customScript );

			googleScript = iframe.createElement( 'script' );
			googleScript.type = 'text/javascript';
			googleScript.text = 'function loadScript() { var script = document.createElement("script"); script.type = "text/javascript"; script.src = "http://maps.googleapis.com/maps/api/js?key=&sensor=&callback=initialize"; document.body.appendChild(script); } loadScript()';
			iframe.body.appendChild( googleScript );
		},

		getCode: function() {
			this.$getCodeModal.find('.modal-body pre').html( this.generate().replace( /</g, '&lt;' ).replace( />/g, '&gt;' ) );
		},

		// GENERATE CODE
		// -----------------------------------------------------------------------------
		generate: function() {
			var i,
			work;

			var output = [
			'    google.maps.event.addDomListener(window, "load", init);',
			'    var map;',
			'    function init() {',
			'        var mapOptions = {',
			'            center: new google.maps.LatLng({lat}, {lng}),',
			'            zoom: {zoom},',
			'            zoomControl: {zoomControl},',
			'            {zoomControlOptions}',
			'            disableDoubleClickZoom: {disableDoubleClickZoom},',
			'            mapTypeControl: {mapTypeControl},',
			'            {mapTypeControlOptions}',
			'            scaleControl: {scaleControl},',
			'            scrollwheel: {scrollwheel},',
			'            panControl: {panControl},',
			'            streetViewControl: {streetViewControl},',
			'            draggable : {draggable},',
			'            overviewMapControl: {overviewMapControl},',
			'            {overviewMapControlOptions}',
			'            mapTypeId: google.maps.MapTypeId.{mapTypeId}{styles}',
			'        };',
			'',
			'        var mapElement = document.getElementById("{mapid}");',
			'        var map = new google.maps.Map(mapElement, mapOptions);',
			'        {locations}',
			'    }'
			];

			output = output.join("\r\n");

			var zoomControl			= this.$wrapper.find('[data-builder-field="zoomcontrol"] option:selected').val() !== 'false';
			var mapTypeControl		= this.$wrapper.find('[data-builder-field="maptypecontrol"] option:selected').val() !== 'false';
			var overviewMapControl	= this.$wrapper.find('[data-builder-field="overviewcontrol"] option:selected').val().toLowerCase();
			var $themeControl		= this.$wrapper.find('[data-builder-field="maptheme"] option:selected').filter( ':selected' );

			output = output
			.replace( /\{mapid\}/, this.$wrapper.find('[data-builder-field="mapid"]').val() )
			.replace( /\{lat\}/, this.$wrapper.find('[data-builder-field][name="latitude"]').val() )
			.replace( /\{lng\}/, this.$wrapper.find('[data-builder-field][name="longitude"]').val() )
			.replace( /\{zoom\}/, this.$wrapper.find('[data-builder-field="zoomlevel"] option:selected').val() )
			.replace( /\{zoomControl\}/, zoomControl )
			.replace( /\{disableDoubleClickZoom\}/, this.$wrapper.find('[data-builder-field="clicktozoomcontrol"] option:selected').val() === 'false' )
			.replace( /\{mapTypeControl\}/, mapTypeControl )
			.replace( /\{scaleControl\}/, this.$wrapper.find('[data-builder-field="scalecontrol"] option:selected').val() !== 'false' )
			.replace( /\{scrollwheel\}/, this.$wrapper.find('[data-builder-field="scrollwheelcontrol"] option:selected').val() !== 'false' )
			.replace( /\{panControl\}/, this.$wrapper.find('[data-builder-field="pancontrol"] option:selected').val() !== 'false' )
			.replace( /\{streetViewControl\}/, this.$wrapper.find('[data-builder-field="streetviewcontrol"] option:selected').val() !== 'false' )
			.replace( /\{draggable\}/, this.$wrapper.find('[data-builder-field="draggablecontrol"] option:selected').val() !== 'false' )
			.replace( /\{overviewMapControl\}/, overviewMapControl !== 'false' )
			.replace( /\{mapTypeId\}/, this.$wrapper.find('[data-builder-field="maptype"] option:selected').val().toUpperCase() );

			if ( zoomControl ) {
				work = {
					zoomControlOptions: {
						style: this.$wrapper.find('[data-builder-field="maptypecontrol"] option:selected').val().toUpperCase()
					}
				};
				output = output.replace( /\{zoomControlOptions\}/, "zoomControlOptions: {\r\n                style: google.maps.ZoomControlStyle." + this.$wrapper.find('[data-builder-field="zoomcontrol"] option:selected').val().toUpperCase() + "\r\n\            },");
			} else {
				output = output.replace( /\{zoomControlOptions\}/, '' );
			}

			if ( mapTypeControl ) {
				work = {
					zoomControlOptions: {
						style: this.$wrapper.find('[data-builder-field="maptypecontrol"] option:selected').val().toUpperCase()
					}
				};
				output = output.replace( /\{mapTypeControlOptions\}/, "mapTypeControlOptions: {\r\n                style: google.maps.MapTypeControlStyle." + this.$wrapper.find('[data-builder-field="maptypecontrol"] option:selected').val().toUpperCase() + "\r\n\            },");
			} else {
				output = output.replace( /\{mapTypeControlOptions\}/, '' );
			}

			if ( overviewMapControl !== 'false' ) {
				output = output.replace( /\{overviewMapControlOptions\}/, "overviewMapControlOptions: {\r\n                opened: " + (overviewMapControl === 'opened') + "\r\n\            },");
			} else {
				output = output.replace( /\{overviewMapControlOptions\}/, '' );
			}

			if ( $themeControl.val() !== 'false' ) {
				output = output.replace( /\{styles\}/, ',\r\n            styles: ' + $themeControl.data( 'json' ).replace(/\r\n/g, '') );
			} else {
				output = output.replace( /\{styles\}/, '' );
			}

			if ( this.markers.length > 0 ) {
				var work = [ 'var locations = [' ];
				var m,
				object;

				for( i = 0; i < this.markers.length; i++ ) {
					m = this.markers[ i ];
					object = '';

					object += '            { lat: ' + m.lat + ', lng: ' + m.lng;

					if ( !!m.title ) {
						object += ', title: "' + m.title + '"';
					}

					if ( !!m.description ) {
						object += ', description: "' + m.description + '"';
					}

					object += ' }';

					if ( i + 1 < this.markers.length ) {
						object += ',';
					}

					work.push( object );
				}

				work.push( '        ];\r\n' )

				work.push( '        var opts = {};' )
				work.push( '        for (var i = 0; i < locations.length; i++) {' );
				work.push( '            opts.position = new google.maps.LatLng( locations[ i ].lat, locations[ i ].lng );' );
				work.push( '            opts.map = map;' );
				work.push( '            if ( !!locations[ i ] .title ) { opts.title = locations[ i ].title; }');
				work.push( '            if ( !!locations[ i ] .description ) { opts.description = locations[ i ].description; }');
				work.push( '            marker = new google.maps.Marker( opts );' );
				work.push( '' );
				work.push( '            (function() {' );
				work.push( '                var html = [' );
				work.push( '                	\'<div style="background-color: #FFF; color: #000; padding: 5px; width: 150px;">\',' );
				work.push( '                		\'{title}\',' );
				work.push( '                		\'{description}\',' );
				work.push( '                	\'</div>\'' );
				work.push( '                ].join(\'\');' );

				work.push( '' );
				work.push( '                html = html.replace(/\{title\}/, !!opts.title ?  ("<h4>" + opts.title + "</h4>") : "" );' );
				work.push( '                html = html.replace(/\{description\}/, !!opts.description ?  ("<p>" + opts.description + "</p>") : "" );' );

				work.push( '                var infoWindow = new google.maps.InfoWindow({ content: html });' );

				work.push( '                google.maps.event.addListener( marker, \'click\', function() {' );
				work.push( '                	if ( infoWindow.isOpened ) {' );
				work.push( '                		infoWindow.close();' );
				work.push( '                		infoWindow.isOpened = false;' );
				work.push( '                	} else {' );
				work.push( '                		infoWindow.open( map, this );' );
				work.push( '                		infoWindow.isOpened = true;' );
				work.push( '                	}' );
				work.push( '                });' );
				work.push( '            })();' )
				work.push( '        }');

				output = output.replace( /\{locations\}/, work.join('\r\n') );
			} else {
				output = output.replace( /\{locations\}/, '' );
			}

			console.log( output );

			return output;
		}
	};

	// expose
	$.extend( true, theme, {
		Maps: {
			GMapBuilder: GMapBuilder
		}
	});

	// jQuery plugin
	$.fn.themeGMapBuilder = function( opts ) {
		return this.map(function() {
			var $this = $( this ),
			instance;

			instance = $this.data( instanceName );

			if ( instance ) {
				return instance;
			} else {
				return (new GMapBuilder( $this, opts ));
			}
		});
	};

	// auto initialize
	$(function() {
		$('[data-theme-gmap-builder]').each(function() {
			var $this = $( this );

			window.builder = $this.themeGMapBuilder();
		});
	});

}).apply(this, [ window.theme, jQuery ]);

// Animate
(function(theme, $) {

	theme = theme || {};

	var instanceName = '__animate';

	var PluginAnimate = function($el, opts) {
		return this.initialize($el, opts);
	};

	PluginAnimate.defaults = {
		accX: 0,
		accY: -150,
		delay: 1
	};

	PluginAnimate.prototype = {
		initialize: function($el, opts) {
			if ( $el.data( instanceName ) ) {
				return this;
			}

			this.$el = $el;

			this
			.setData()
			.setOptions(opts)
			.build();

			return this;
		},

		setData: function() {
			this.$el.data(instanceName, this);

			return this;
		},

		setOptions: function(opts) {
			this.options = $.extend(true, {}, PluginAnimate.defaults, opts, {
				wrapper: this.$el
			});

			return this;
		},

		build: function() {
			var self = this,
			$el = this.options.wrapper,
			delay = 0;

			$el.addClass('appear-animation');

			if(!$('html').hasClass('no-csstransitions') && $(window).width() > 767) {

				$el.appear(function() {

					delay = ($el.attr('data-appear-animation-delay') ? $el.attr('data-appear-animation-delay') : self.options.delay);

					if(delay > 1) {
						$el.css('animation-delay', delay + 'ms');
					}

					$el.addClass($el.attr('data-appear-animation'));

					setTimeout(function() {
						$el.addClass('appear-animation-visible');
					}, delay);

				}, {accX: self.options.accX, accY: self.options.accY});

			} else {

				$el.addClass('appear-animation-visible');

			}

			return this;
		}
	};

	// expose to scope
	$.extend(theme, {
		PluginAnimate: PluginAnimate
	});

	// jquery plugin
	$.fn.themePluginAnimate = function(opts) {
		return this.map(function() {
			var $this = $(this);

			if ($this.data(instanceName)) {
				return $this.data(instanceName);
			} else {
				return new PluginAnimate($this, opts);
			}

		});
	};

}).apply(this, [ window.theme, jQuery ]);

// Carousel
(function(theme, $) {

	theme = theme || {};

	var initialized = false;
	var instanceName = '__carousel';

	var PluginCarousel = function($el, opts) {
		return this.initialize($el, opts);
	};

	PluginCarousel.defaults = {
		itemsDesktop: false,
		itemsDesktopSmall: false,
		itemsTablet: false,
		itemsTabletSmall: false,
		itemsMobile: false
	};

	PluginCarousel.prototype = {
		initialize: function($el, opts) {
			if ( $el.data( instanceName ) ) {
				return this;
			}

			this.$el = $el;

			this
			.setData()
			.setOptions(opts)
			.build();

			return this;
		},

		setData: function() {
			this.$el.data(instanceName, this);

			return this;
		},

		setOptions: function(opts) {
			this.options = $.extend(true, {}, PluginCarousel.defaults, opts, {
				wrapper: this.$el
			});

			return this;
		},

		build: function() {
			this.options.wrapper.owlCarousel(this.options).addClass("owl-carousel-init");

			return this;
		}
	};

	// expose to scope
	$.extend(theme, {
		PluginCarousel: PluginCarousel
	});

	// jquery plugin
	$.fn.themePluginCarousel = function(opts) {
		return this.map(function() {
			var $this = $(this);

			if ($this.data(instanceName)) {
				return $this.data(instanceName);
			} else {
				return new PluginCarousel($this, opts);
			}

		});
	}

}).apply(this, [ window.theme, jQuery ]);

// Chart Circular
(function(theme, $) {

	theme = theme || {};

	var instanceName = '__chartCircular';

	var PluginChartCircular = function($el, opts) {
		return this.initialize($el, opts);
	};

	PluginChartCircular.defaults = {
		accX: 0,
		accY: -150,
		delay: 1,
		barColor: '#0088CC',
		trackColor: '#f2f2f2',
		scaleColor: false,
		scaleLength: 5,
		lineCap: 'round',
		lineWidth: 13,
		size: 175,
		rotate: 0,
		animate: ({
			duration: 2500,
			enabled: true
		})
	};

	PluginChartCircular.prototype = {
		initialize: function($el, opts) {
			if ( $el.data( instanceName ) ) {
				return this;
			}

			this.$el = $el;

			this
			.setData()
			.setOptions(opts)
			.build();

			return this;
		},

		setData: function() {
			this.$el.data(instanceName, this);

			return this;
		},

		setOptions: function(opts) {
			this.options = $.extend(true, {}, PluginChartCircular.defaults, opts, {
				wrapper: this.$el
			});

			return this;
		},

		build: function() {
			var self = this,
			$el = this.options.wrapper,
			value = ($el.attr('data-percent') ? $el.attr('data-percent') : 0),
			percentEl = $el.find('.percent'),
			shouldAnimate,
			data;

			shouldAnimate = $.isFunction($.fn[ 'appear' ]) && ( typeof $.browser !== 'undefined' && !$.browser.mobile );
			data = { accX: self.options.accX, accY: self.options.accY };

			$.extend(true, self.options, {
				onStep: function(from, to, currentValue) {
					percentEl.html(parseInt(currentValue));
				}
			});

			$el.attr('data-percent', (shouldAnimate ? 0 : value) );

			$el.easyPieChart( this.options );

			if ( shouldAnimate ) {
				$el.appear(function() {
					setTimeout(function() {
						$el.data('easyPieChart').update(value);
						$el.attr('data-percent', value);

					}, self.options.delay);
				}, data);
			} else {
				$el.data('easyPieChart').update(value);
				$el.attr('data-percent', value);
			}

			return this;
		}
	};

	// expose to scope
	$.extend(true, theme, {
		Chart: {
			PluginChartCircular: PluginChartCircular
		}
	});

	// jquery plugin
	$.fn.themePluginChartCircular = function(opts) {
		return this.map(function() {
			var $this = $(this);

			if ($this.data(instanceName)) {
				return $this.data(instanceName);
			} else {
				return new PluginChartCircular($this, opts);
			}

		});
	}

}).apply(this, [ window.theme, jQuery ]);

// Lightbox
(function(theme, $) {

	theme = theme || {};

	var instanceName = '__lightbox';

	var PluginLightbox = function($el, opts) {
		return this.initialize($el, opts);
	};

	PluginLightbox.defaults = {
		tClose: 'Close (Esc)', // Alt text on close button
		tLoading: 'Loading...', // Text that is displayed during loading. Can contain %curr% and %total% keys
		gallery: {
			tPrev: 'Previous (Left arrow key)', // Alt text on left arrow
			tNext: 'Next (Right arrow key)', // Alt text on right arrow
			tCounter: '%curr% of %total%' // Markup for "1 of 7" counter
		},
		image: {
			tError: '<a href="%url%">The image</a> could not be loaded.' // Error message when image could not be loaded
		},
		ajax: {
			tError: '<a href="%url%">The content</a> could not be loaded.' // Error message when ajax request failed
		}
	};

	PluginLightbox.prototype = {
		initialize: function($el, opts) {
			if ( $el.data( instanceName ) ) {
				return this;
			}

			this.$el = $el;

			this
			.setData()
			.setOptions(opts)
			.build();

			return this;
		},

		setData: function() {
			this.$el.data(instanceName, this);

			return this;
		},

		setOptions: function(opts) {
			this.options = $.extend(true, {}, PluginLightbox.defaults, opts, {
				wrapper: this.$el
			});

			return this;
		},

		build: function() {
			this.options.wrapper.magnificPopup(this.options);

			return this;
		}
	};

	// expose to scope
	$.extend(theme, {
		PluginLightbox: PluginLightbox
	});

	// jquery plugin
	$.fn.themePluginLightbox = function(opts) {
		return this.each(function() {
			var $this = $(this);

			if ($this.data(instanceName)) {
				return $this.data(instanceName);
			} else {
				return new PluginLightbox($this, opts);
			}

		});
	}

}).apply(this, [ window.theme, jQuery ]);

// Portlets
(function(theme, $) {

	theme = theme || {};

	var instanceName = '__portlet',
	storageOrderKey = '__portletOrder',
	storageStateKey = '__portletState';

	var PluginPortlet = function($el, opts) {
		return this.initialize($el, opts);
	};

	PluginPortlet.defaults = {
		connectWith: '[data-plugin-portlet]',
		items: '[data-portlet-item]',
		handle: '.portlet-handler',
		opacity: 0.7,
		placeholder: 'portlet-placeholder',
		cancel: 'portlet-cancel',
		forcePlaceholderSize: true,
		forceHelperSize: true,
		tolerance: 'pointer',
		helper: 'original',
		revert: 200
	};

	PluginPortlet.prototype = {
		initialize: function($el, opts) {
			if ( $el.data( instanceName ) ) {
				return this;
			}

			this.$el = $el;

			this
			.setData()
			.setOptions(opts)
			.build();

			return this;
		},

		setData: function() {
			this.$el.data(instanceName, this);

			return this;
		},

		setOptions: function(opts) {
			var _self = this;

			this.options = $.extend(true, {}, PluginPortlet.defaults, opts, {
				wrapper: this.$el,
				update: _self.onUpdate,
				create: _self.onLoad
			});

			return this;
		},

		onUpdate: function(event, ui) {
			var key = storageOrderKey,
			data = store.get(key),
			$this = $(this),
			porletId = $this.prop('id');

			if (!data) {
				data = {};
			}

			if (!!porletId) {
				data[porletId] = $this.sortable('toArray');
				store.set(key, data);
			}
		},

		onLoad: function(event, ui) {
			var key = storageOrderKey,
			data = store.get(key),
			$this = $(this),
			porletId = $this.prop('id'),
			portlet = $('#' + porletId);

			if (!!data) {
				var panels = data[porletId];

				if (!!panels) {
					$.each(panels, function(index, panelId) {
						$('#' + panelId).appendTo(portlet);
					});
				}
			}
		},

		saveState: function( panel ) {
			var key = storageStateKey,
			data = store.get(key),
			panelId = panel.prop('id');

			if (!data) {
				data = {};
			}

			if (!panelId) {
				return this;
			}

			var collapse = panel.find('.panel-actions').children('a.fa-caret-up, a.fa-caret-down'),
			isCollapsed = !!collapse.hasClass('fa-caret-up'),
			isRemoved = !panel.closest('body').get(0);

			if (isRemoved) {
				data[panelId] = 'removed';
			} else if (isCollapsed) {
				data[panelId] = 'collapsed';
			} else {
				delete data[panelId];
			}

			store.set(key, data);
			return this;
		},

		loadState: function() {
			var key = storageStateKey,
			data = store.get(key);

			if (!!data) {
				$.each(data, function(panelId, state) {
					var panel = $('#' + panelId);
					if (!panel.data('portlet-state-loaded')) {
						if (state == 'collapsed') {
							panel.find('.panel-actions a.fa-caret-down').trigger('click');
						} else if (state == 'removed') {
							panel.find('.panel-actions a.fa-times').trigger('click');
						}
						panel.data('portlet-state-loaded', true);
					}
				});
			}

			return this;
		},

		build: function() {
			var _self = this;

			if ( $.isFunction( $.fn.sortable ) ) {
				this.$el.sortable( this.options );
				this.$el.find('[data-portlet-item]').each(function() {
					_self.events( $(this) );
				});
			}

			var portlet = this.$el;
			portlet.css('min-height', 150);

			return this;
		},

		events: function($el) {
			var _self = this,
			portlet = $el.closest('[data-plugin-portlet]');

			this.loadState();

			$el.find('.panel-actions').on( 'click', 'a.fa-caret-up, a.fa-caret-down, a.fa-times', function( e ) {
				setTimeout(function() {
					_self.saveState( $el );
				}, 250);
			});

			return this;
		}
	};

	// expose to scope
	$.extend(theme, {
		PluginPortlet: PluginPortlet
	});

	// jquery plugin
	$.fn.themePluginPortlet = function(opts) {
		return this.map(function() {
			var $this = $(this);

			if ($this.data(instanceName)) {
				return $this.data(instanceName);
			} else {
				return new PluginPortlet($this, opts);
			}

		});
	}

}).apply(this, [ window.theme, jQuery ]);

// Slider
(function(theme, $) {

	theme = theme || {};

	var instanceName = '__slider';

	var PluginSlider = function($el, opts) {
		return this.initialize($el, opts);
	};

	PluginSlider.defaults = {

	};

	PluginSlider.prototype = {
		initialize: function($el, opts) {
			if ( $el.data( instanceName ) ) {
				return this;
			}

			this.$el = $el;

			this
			.setVars()
			.setData()
			.setOptions(opts)
			.build();

			return this;
		},

		setVars: function() {
			var $output = $( this.$el.data('plugin-slider-output') );
			this.$output = $output.get(0) ? $output : null;

			return this;
		},

		setData: function() {
			this.$el.data(instanceName, this);

			return this;
		},

		setOptions: function(opts) {
			var _self = this;
			this.options = $.extend( true, {}, PluginSlider.defaults, opts );

			if ( this.$output ) {
				$.extend( this.options, {
					slide: function( event, ui ) {
						_self.onSlide( event, ui );
					}
				});
			}

			return this;
		},

		build: function() {
			this.$el.slider( this.options );

			return this;
		},

		onSlide: function( event, ui ) {
			if ( !ui.values ) {
				this.$output.val( ui.value );
			} else {
				this.$output.val( ui.values[ 0 ] + '/' + ui.values[ 1 ] );
			}

			this.$output.trigger('change');
		}
	};

	// expose to scope
	$.extend(theme, {
		PluginSlider: PluginSlider
	});

	// jquery plugin
	$.fn.themePluginSlider = function(opts) {
		return this.each(function() {
			var $this = $(this);

			if ($this.data(instanceName)) {
				return $this.data(instanceName);
			} else {
				return new PluginSlider($this, opts);
			}

		});
	}

}).apply(this, [ window.theme, jQuery ]);

// Toggle
(function(theme, $) {

	theme = theme || {};

	var instanceName = '__toggle';

	var PluginToggle = function($el, opts) {
		return this.initialize($el, opts);
	};

	PluginToggle.defaults = {
		duration: 350,
		isAccordion: false,
		addIcons: true
	};

	PluginToggle.prototype = {
		initialize: function($el, opts) {
			if ( $el.data( instanceName ) ) {
				return this;
			}

			this.$el = $el;

			this
			.setData()
			.setOptions(opts)
			.build();

			return this;
		},

		setData: function() {
			this.$el.data(instanceName, this);

			return this;
		},

		setOptions: function(opts) {
			this.options = $.extend(true, {}, PluginToggle.defaults, opts, {
				wrapper: this.$el
			});

			return this;
		},

		build: function() {
			var self = this,
			$wrapper = this.options.wrapper,
			$items = $wrapper.find('.toggle'),
			$el = null;

			$items.each(function() {
				$el = $(this);

				if(self.options.addIcons) {
					$el.find('> label').prepend(
						$('<i />').addClass('fa fa-plus'),
						$('<i />').addClass('fa fa-minus')
						);
				}

				if($el.hasClass('active')) {
					$el.find('> p').addClass('preview-active');
					$el.find('> .toggle-content').slideDown(self.options.duration);
				}

				self.events($el);
			});

			if(self.options.isAccordion) {
				self.options.duration = self.options.duration/2;
			}

			return this;
		},

		events: function($el) {
			var self = this,
			previewParCurrentHeight = 0,
			previewParAnimateHeight = 0,
			toggleContent = null;

			$el.find('> label').click(function(e) {

				var $this = $(this),
				parentSection = $this.parent(),
				parentWrapper = $this.parents('.toggle'),
				previewPar = null,
				closeElement = null;

				if(self.options.isAccordion && typeof(e.originalEvent) != 'undefined') {
					closeElement = parentWrapper.find('.toggle.active > label');

					if(closeElement[0] == $this[0]) {
						return;
					}
				}

				parentSection.toggleClass('active');

				// Preview Paragraph
				if(parentSection.find('> p').get(0)) {

					previewPar = parentSection.find('> p');
					previewParCurrentHeight = previewPar.css('height');
					previewPar.css('height', 'auto');
					previewParAnimateHeight = previewPar.css('height');
					previewPar.css('height', previewParCurrentHeight);

				}

				// Content
				toggleContent = parentSection.find('> .toggle-content');

				if(parentSection.hasClass('active')) {

					$(previewPar).animate({
						height: previewParAnimateHeight
					}, self.options.duration, function() {
						$(this).addClass('preview-active');
					});

					toggleContent.slideDown(self.options.duration, function() {
						if(closeElement) {
							closeElement.trigger('click');
						}
					});

				} else {

					$(previewPar).animate({
						height: 0
					}, self.options.duration, function() {
						$(this).removeClass('preview-active');
					});

					toggleContent.slideUp(self.options.duration);

				}

			});
		}
	};

	// expose to scope
	$.extend(theme, {
		PluginToggle: PluginToggle
	});

	// jquery plugin
	$.fn.themePluginToggle = function(opts) {
		return this.map(function() {
			var $this = $(this);

			if ($this.data(instanceName)) {
				return $this.data(instanceName);
			} else {
				return new PluginToggle($this, opts);
			}

		});
	}

}).apply(this, [ window.theme, jQuery ]);

// Widget - Todo
(function(theme, $) {

	theme = theme || {};

	var instanceName = '__widgetTodoList';

	var WidgetTodoList = function($el, opts) {
		return this.initialize($el, opts);
	};

	WidgetTodoList.defaults = {
	};

	WidgetTodoList.prototype = {
		initialize: function($el, opts) {
			if ( $el.data( instanceName ) ) {
				return this;
			}

			this.$el = $el;

			this
			.setData()
			.setOptions(opts)
			.build()
			.events();

			return this;
		},

		setData: function() {
			this.$el.data(instanceName, this);

			return this;
		},

		setOptions: function(opts) {
			this.options = $.extend( true, {}, WidgetTodoList.defaults, opts );

			return this;
		},

		check: function( input, label ) {
			if ( input.is(':checked') ) {
				label.addClass('line-through');
			} else {
				label.removeClass('line-through');
			}
		},

		build: function() {
			var _self = this,
			$check = this.$el.find('.todo-check');

			$check.each(function () {
				var label = $(this).closest('li').find('.todo-label');
				_self.check( $(this), label );
			});

			return this;
		},

		events: function() {
			var _self = this,
			$remove = this.$el.find( '.todo-remove' ),
			$check = this.$el.find('.todo-check'),
			$window = $( window );

			$remove.on('click.widget-todo-list', function( ev ) {
				ev.preventDefault();
				$(this).closest("li").remove();
			});

			$check.on('change', function () {
				var label = $(this).closest('li').find('.todo-label');
				_self.check( $(this), label );
			});

			if ( $.isFunction( $.fn.sortable ) ) {
				this.$el.sortable({
					sort: function(event, ui) {
						var top = event.pageY - _self.$el.offset().top - (ui.helper.outerHeight(true) / 2);
						ui.helper.css({'top' : top + 'px'});
					}
				});
			}

			return this;
		}
	};

	// expose to scope
	$.extend(theme, {
		WidgetTodoList: WidgetTodoList
	});

	// jquery plugin
	$.fn.themePluginWidgetTodoList = function(opts) {
		return this.each(function() {
			var $this = $(this);

			if ($this.data(instanceName)) {
				return $this.data(instanceName);
			} else {
				return new WidgetTodoList($this, opts);
			}

		});
	}

}).apply(this, [ window.theme, jQuery ]);

// Widget - Toggle
(function(theme, $) {

	theme = theme || {};

	var instanceName = '__widgetToggleExpand';

	var WidgetToggleExpand = function($el, opts) {
		return this.initialize($el, opts);
	};

	WidgetToggleExpand.defaults = {
	};

	WidgetToggleExpand.prototype = {
		initialize: function($el, opts) {
			if ( $el.data( instanceName ) ) {
				return this;
			}

			this.$el = $el;

			this
			.setData()
			.setOptions(opts)
			.build()
			.events();

			return this;
		},

		setData: function() {
			this.$el.data(instanceName, this);

			return this;
		},

		setOptions: function(opts) {
			this.options = $.extend( true, {}, WidgetToggleExpand.defaults, opts );

			return this;
		},

		build: function() {
			return this;
		},

		events: function() {
			var _self = this,
			$toggler = this.$el.find( '.widget-toggle' );

			$toggler.on('click.widget-toggler', function() {
				_self.$el.hasClass('widget-collapsed') ? _self.expand( _self.$el ) : _self.collapse( _self.$el );
			});

			return this;
		},

		expand: function( content ) {
			content.children( '.widget-content-expanded' ).slideDown( 'fast', function() {
				$(this).css( 'display', '' );
				content.removeClass( 'widget-collapsed' );
			});
		},

		collapse: function( content ) {
			content.children('.widget-content-expanded' ).slideUp( 'fast', function() {
				content.addClass( 'widget-collapsed' );
				$(this).css( 'display', '' );
			});
		}
	};

	// expose to scope
	$.extend(theme, {
		WidgetToggleExpand: WidgetToggleExpand
	});

	// jquery plugin
	$.fn.themePluginWidgetToggleExpand = function(opts) {
		return this.each(function() {
			var $this = $(this);

			if ($this.data(instanceName)) {
				return $this.data(instanceName);
			} else {
				return new WidgetToggleExpand($this, opts);
			}

		});
	}

}).apply(this, [ window.theme, jQuery ]);

// Word Rotate
(function(theme, $) {

	theme = theme || {};

	var instanceName = '__wordRotate';

	var PluginWordRotate = function($el, opts) {
		return this.initialize($el, opts);
	};

	PluginWordRotate.defaults = {
		delay: 2000
	};

	PluginWordRotate.prototype = {
		initialize: function($el, opts) {
			if ( $el.data( instanceName ) ) {
				return this;
			}

			this.$el = $el;

			this
			.setData()
			.setOptions(opts)
			.build();

			return this;
		},

		setData: function() {
			this.$el.data(instanceName, this);

			return this;
		},

		setOptions: function(opts) {
			this.options = $.extend(true, {}, PluginWordRotate.defaults, opts, {
				wrapper: this.$el
			});

			return this;
		},

		build: function() {
			var $el = this.options.wrapper,
			itemsWrapper = $el.find(".word-rotate-items"),
			items = itemsWrapper.find("> span"),
			firstItem = items.eq(0),
			firstItemClone = firstItem.clone(),
			itemHeight = firstItem.height(),
			currentItem = 1,
			currentTop = 0;

			itemsWrapper.append(firstItemClone);

			$el
			.height(itemHeight)
			.addClass("active");

			setInterval(function() {

				currentTop = (currentItem * itemHeight);

				itemsWrapper.animate({
					top: -(currentTop) + "px"
				}, 300, function() {

					currentItem++;

					if(currentItem > items.length) {

						itemsWrapper.css("top", 0);
						currentItem = 1;

					}

				});

			}, this.options.delay);

			return this;
		}
	};

	// expose to scope
	$.extend(theme, {
		PluginWordRotate: PluginWordRotate
	});

	// jquery plugin
	$.fn.themePluginWordRotate = function(opts) {
		return this.each(function() {
			var $this = $(this);

			if ($this.data(instanceName)) {
				return $this.data(instanceName);
			} else {
				return new PluginWordRotate($this, opts);
			}

		});
	}

}).apply(this, [ window.theme, jQuery ]);

// Data Tables - Config
(function($) {

	'use strict';

	// we overwrite initialize of all datatables here
	// because we want to use select2, give search input a bootstrap look
	// keep in mind if you overwrite this fnInitComplete somewhere,
	// you should run the code inside this function to keep functionality.
	//
	// there's no better way to do this at this time :(
	if ( $.isFunction( $.fn[ 'dataTable' ] ) ) {

		$.extend(true, $.fn.dataTable.defaults, {
			sDom: "<'row datatables-header form-inline'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>r><'table-responsive't><'row datatables-footer'<'col-sm-12 col-md-6'i><'col-sm-12 col-md-6'p>>",
			oLanguage: {
				sLengthMenu: '_MENU_ records per page',
				sProcessing: '<i class="fa fa-spinner fa-spin"></i> Loading'
			},
			fnInitComplete: function( settings, json ) {
				// select 2
				if ( $.isFunction( $.fn[ 'select2' ] ) ) {
					$('.dataTables_length select', settings.nTableWrapper).select2({
						minimumResultsForSearch: -1
					});
				}

				var options = $( 'table', settings.nTableWrapper ).data( 'plugin-options' ) || {};

				// search
				var $search = $('.dataTables_filter input', settings.nTableWrapper);

				$search
				.attr({
					placeholder: typeof options.searchPlaceholder !== 'undefined' ? options.searchPlaceholder : 'Search'
				})
				.addClass('form-control');

				if ( $.isFunction( $.fn.placeholder ) ) {
					$search.placeholder();
				}
			}
		});

	}

}).apply( this, [ jQuery ]);

// Notifications - Config
(function($) {

	'use strict';

	// use font awesome icons if available
	if ( typeof PNotify != 'undefined' ) {
		PNotify.prototype.options.styling = "fontawesome";

		$.extend(true, PNotify.prototype.options, {
			shadow: false,
			stack: {
				spacing1: 15,
				spacing2: 15
			}
		});

		$.extend(PNotify.styling.fontawesome, {
			// classes
			container: "notification",
			notice: "notification-warning",
			info: "notification-info",
			success: "notification-success",
			error: "notification-danger",

			// icons
			notice_icon: "fa fa-exclamation",
			info_icon: "fa fa-info",
			success_icon: "fa fa-check",
			error_icon: "fa fa-times"
		});
	}

}).apply(this, [jQuery]);




$('form').submit(function(event) {
	if(checkForm){
	  	$(this).find("button[type='submit']").prop('disabled',true);
	  	$(this).find("input[type='submit']").prop('disabled',true);
	}
});


