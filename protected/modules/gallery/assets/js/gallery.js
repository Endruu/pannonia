$(document).ready( function() {
	
	$('.Image-Album-MainContainer').mouseenter(function() {
		$(this).stop(true,false).animate({ left: '20px'	}, 200, 'linear');
	});
	
	$('.Image-Album-MainContainer').mouseleave(function() {
		$(this).stop(true,false).animate({ left: '0' }, 200, 'linear');
	});
	
});