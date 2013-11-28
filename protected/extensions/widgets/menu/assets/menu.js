var Menu = null;

function activateMenu(options) {

	var defaultOptions = {
		duration		: 300,
		effect			: 'slide',
		effect_options	: { direction: 'up' },
		below			: 90,
		above			: 65,
		delay			: 200,
		fixed			: false
	}

	this.registerEvents = function() {
		
		$('.MainNavigation-Logo-Fix').mouseenter(function() {
			$('.MainNavigation-Container:hidden').show(Menu.effect, Menu.effect_options, Menu.duration);
			$('.MainNavigation-Logo-Fix').fadeOut(Menu.duration);
		});

		$('.MainNavigation-Container').mouseleave(function(){
			if( $(window).scrollTop() > Menu.below ) {
				$('.MainNavigation-Container').hide(Menu.effect, Menu.effect_options, Menu.duration);
				$('.MainNavigation-Logo-Fix').show(Menu.effect, Menu.effect_options, Menu.duration);
			}
		});

		$(window).scroll(function(){					// scroll event 

			var windowTop = $(window).scrollTop();		// returns number

			if ( Menu.above > windowTop ) {
				$('.MainNavigation-Logo-Fix:visible').fadeOut(Menu.duration);
				$('.MainNavigation-Container').show().css({position: 'static'});
				$('.MainNavigation-Container-Placeholder').hide();
			}
			
			if ( Menu.below < windowTop ) {
				$('.MainNavigation-Logo-Fix:hidden').finish().delay(Menu.delay).show(Menu.effect, Menu.effect_options, Menu.duration);
				$('.MainNavigation-Container').hide().css({position: 'fixed'});
				$('.MainNavigation-Container-Placeholder').show();
			}
			
		});
	
	}
	
	this.fixMenu = function() {
		$('.MainNavigation-Container').css({position: 'fixed'});
		$('.MainNavigation-Container-Placeholder').show();
	}
	
	this.initOptions = function(options) {
		var M = defaultOptions;
		for( o in options ) {
			M[o] = options[o];
		}
		return M;
	}
	
	
	if( Menu === null ) {
		Menu = this.initOptions(options);
		if( Menu['fixed'] ) {
			this.fixMenu();
		} else {
			this.registerEvents();
		}
	}
	
}
