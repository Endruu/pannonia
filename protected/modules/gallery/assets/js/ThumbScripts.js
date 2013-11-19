function ThumbScripts( options = false ) {
		
	this.options	= Array();

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
	
	this.enableSelection = function( checked = false ) {
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
	
	this.resizeThumbnails = function( prefSize = false, maxSize = false ) {
		if( !prefSize ) {
			prefSize = this.options.width;
		}
		if( !maxSize ) {
			if( this.options.maxWidth ) {
				maxSize = this.options.maxWidth;
			} else {
				maxSize = prefSize * 1.414;
			}
		}
	
		maxSize = Math.round(maxSize);
		var ratio = $('.Image-Thumbnail-MainContainer').height() / $('.Image-Thumbnail-MainContainer').width();
		var new_width = Math.floor($('.Image-ListContainer').width() / Math.floor( $('.Image-ListContainer').width()/prefSize) );
		if( new_width > maxSize ) {
			new_width = maxSize;
		}
		$('.Image-Thumbnail-MainContainer').css('width', new_width).css('height', Math.round(new_width*ratio));
	}
	
	this.setDefaultThumbnailSize = function( width = false, height = false ) {
		if( !width ) width = this.options.width;
		if( !height ) height = this.options.height;
		$('.Image-Thumbnail-MainContainer').css('width', width).css('height', height);
	}
	
	this.registerEvents = function() {
		// Register effects ----------------------------------------------------
		var fs = this.options.fadeSpeed;
		$('.Image-Thumbnail-MainContainer').mouseenter(function() {
			$(this).children('.Image-Hover-Layer').stop(true).show(0);
			$(this).children('.Image-Hover-Leaving').stop(true).hide(0);
		});
		
		$('.Image-Thumbnail-MainContainer').mouseleave(function() {
			var layer	= $(this).children('.Image-Hover-Layer');
			var leaving	= $(this).children('.Image-Hover-Leaving');
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
	}
	
	this.afterLoad = function() {
		this.setDefaultThumbnailSize();
		this.registerEvents();
	}
	
	this.init(options);
}