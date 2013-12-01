var TS;

function ThumbScripts( options ) {
		
	this.options	= Array();
	this.images		= null;
	this.start		= false; 

	this.getDefaultOptions = function() {
		return {
			width		: 512,
			height		: 384,
			maxWidth	: false,
			fadeSpeed	: 700
		}
	}
	
	this.init = function( opt ) {
		this.options = this.getDefaultOptions();
		if(opt) {
			for( prop in opt ) {
				this.options[prop] = opt[prop];
			}
		}
	}
	
	this.enableSelection = function( checked ) {
		if (typeof checked === 'undefined') { checked = false; }
		
		var def_class = checked ? 'Image-Selected' : 'Image-Deselected';
		$('.Image-Select-Layer')
			.addClass('Image-Select-Layer-Enabled').addClass(def_class)
		.children(":checkbox")
			.toggleClass('Image-Checkbox-Hide')
			.prop("checked", checked);
	}

	this.disableSelection = function() {
		$('.Image-Select-Layer-Enabled').removeClass('Image-Select-Layer-Enabled');
		$('.Image-Deselected').removeClass('Image-Deselected');
		$('.Image-Selected').removeClass('Image-Selected');
		$(":checkbox").toggleClass('Image-Checkbox-Hide')
	}
	
	this.resizeThumbnails = function( prefSize , maxSize  ) {
		if (typeof prefSize === 'undefined') { prefSize = false; }
		if (typeof maxSize === 'undefined') { maxSize = false; }
	
		if( !prefSize ) {
			prefSize = this.options['width'];
		}
		if( !maxSize ) {
			if( this.options['maxWidth'] ) {
				maxSize = this.options['maxWidth'];
			} else {
				maxSize = prefSize * 1.414;
			}
		}

		$('.Image-List-Container').width($(window).width() - $('.Image-Album-List-Container').outerWidth());

		maxSize = Math.round(maxSize);
		var ratio = $('.Image-Thumbnail-MainContainer').height() / $('.Image-Thumbnail-MainContainer').width();
		var new_width = Math.floor($('.Image-List-Container').width() / Math.floor( $('.Image-List-Container').width()/prefSize) );
		if( new_width > maxSize ) {
			new_width = maxSize;
		}
		$('.Image-Thumbnail-MainContainer').css('width', new_width).css('height', Math.round(new_width*ratio));
	}
	
	this.setDefaultThumbnailSize = function( width , height ) {
		if (typeof width === 'undefined') { width = false; }
		if (typeof height === 'undefined') { height = false; }

		if( !width ) width = this.options['width'];
		if( !height ) height = this.options['height'];
		$('.Image-Thumbnail-MainContainer').css('width', width).css('height', height);
	}
	
	this.registerEvents = function() {
		// Register effects ----------------------------------------------------
		var fs = this.options['fadeSpeed'];
		$('.Image-Thumbnail-MainContainer').mouseenter(function() {
			var t = $(this);
			t.children('.Image-Hover-Layer').stop(true).show(0).removeClass('LastImage');
			t.children('.Image-Hover-Leaving').stop(true).hide(0);
		});
		
		$('.Image-Thumbnail-MainContainer').mouseleave(function() {
			var t = $(this);
			var layer	= t.children('.Image-Hover-Layer');
			var leaving	= t.children('.Image-Hover-Leaving');
			layer.hide(0);
			leaving.fadeIn(fs, 'linear',function() {
				leaving.hide(0);
				layer.show(0);
			});
		});
		
		// Register selection --------------------------------------------------
		
		$('.Image-Thumbnail-MainContainer').click(function() {
			var cb = $(this).children('.Image-Select-Layer-Enabled')
				.toggleClass('Image-Selected Image-Deselected')
				.children();
			if( cb ) {
				$(cb).prop("checked") ? $(cb).prop("checked", false) : $(cb).prop("checked", true);
			}
		});
		
		// Register startViewer ------------------------------------------------
		
		//$('.Image-Thumbnail-MainContainer').click(startViewer(this));
		
	}
	
	this.registerImages = function() {
		if( this.images == null ) {
			var img = $('.Image-SourcePath');
			this.images = Array();
			for (var i=0; i<img.size(); i++) {
				this.images[i] = img.eq(i).html();
				img.eq(i).parent().parent().attr('onclick','startViewer('+i+')');
			}
		}

		return this.images;
	}
	
	this.slidesForViewer= function() {
		var images = Array();
		var collected = this.images;
		for (var i=0; i<collected.length; i++) {
			images[i] = {image: collected[i], url: collected[i]};
		}
		return images;
	}
	
	this.afterLoad = function() {
		this.setDefaultThumbnailSize();
		this.registerEvents();
		this.registerImages();
	}
	
	this.init(options);
}

function initTS(options) {
	TS = new ThumbScripts(options);
	TS.afterLoad();
	$(window).resize(TS.resizeThumbnails());
	jQuery("img.lazy").lazy({ enableThrottle: true, throttle: 250, visibleOnly : false });
}

function startViewer(start) {
	if (typeof prefSize === 'undefined') {
		//start = $(start).attr('id').substr(10);
	}
	
	TS.start = start;

	var images = TS.slidesForViewer();
	$('body').css('overflow', 'hidden');
	jQuery(function($){
		$.supersized({
		
			// Functionality
			start_slide			:	start+1,
			autoplay			:	0,			// Slideshow starts playing automatically
			transition			:   6, 			// 0-None, 1-Fade, 2-Slide Top, 3-Slide Right, 4-Slide Bottom, 5-Slide Left, 6-Carousel Right, 7-Carousel Left
			transition_speed	:	700,		// Speed of transition
			performance			:	0,			// quality
			fit_landscape		:	1,
													   
			// Components							
			slide_links			:	'blank',	// Individual links for each slide (Options: false, 'num', 'name', 'blank')
			slides				:  	images
			
		});
		
	});
	
	$('#supersized').fadeIn(700);
	if( $('#supersized-loader') )
		 $('#supersized-loader').remove();
	
	$('.Image-Gallery-Container').fadeOut(700);
	$('.Image-DividerStrip').hide();
	$('.MainNavigation-Container').fadeOut(700, function() {
		$('.Image-Viewer-Container').fadeIn(700);
	});
	
	$(document.documentElement).keyup(function (event) {
		if( event.keyCode == 27 ) {			// ESC
			stopViewer();
		}
	});
}

function stopViewer() {
	if( TS.start === false ) return;
	
	// highlight last
	var as = $('.activeslide');
	var last = as.removeClass('activeslide').attr('class').substr(6);
	as.addClass('activeslide');
	last = '#img-thumb-'+last;
	$(last).children('.Image-Hover-Layer').addClass('LastImage');
	
	$('#supersized').before('<div id="supersized-loader"></div>');
	$('.MainNavigation-Container').fadeIn(700);
	$('.Image-Gallery-Container').fadeIn(700);
	$('.Image-Gallery-Background').fadeIn(700);
	
	scrollToElement(last, 0, -60);
	
	$('.Image-Viewer-Container').fadeOut(700, function() {
		$('#supersized').hide().children().removeAttr( 'style' );
		$('body').css('overflow', 'auto');
		$('.Image-Gallery-Background').hide();
		$('.Image-DividerStrip').fadeIn(200);
	});
	
	TS.start = false;
}

function scrollToElement(selector, time, verticalOffset) {
	if (typeof time === 'undefined') { time = 1000; }
	if (typeof verticalOffset === 'undefined') { verticalOffset = 0;}
    element = $(selector);
    offset = element.offset();
    offsetTop = offset.top + verticalOffset;
    $('html, body').animate({
        scrollTop: offsetTop
    }, time);
}