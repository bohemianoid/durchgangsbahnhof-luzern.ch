// local scroll
// --------------------------------------------------------------

$( document ).ready( function() {
	// axis
	$.localScroll.defaults.axis = 'y';

	// scroll hash
	$.localScroll.hash( {
		duration: 500
	} );

	// scroll
	$.localScroll( {
		duration: 500,
		hash: false
	} );
} );


// back to top link
// --------------------------------------------------------------

$( document ).ready( function() {
	// first hide
	$( '#back-to-top' ).hide();

	// fade in-out
	$( function () {
		$( window ).scroll( function () {
			if ( $(this).scrollTop() > 100 ) {
				$( '#back-to-top' ).fadeIn();
			} else {
				$( '#back-to-top' ).fadeOut();
			}
		} );
	} );
} );


// fancybox
// --------------------------------------------------------------

$( document ).ready( function() {
	$( '.fancybox' ).fancybox();
} );


// masonry
// --------------------------------------------------------------

$( document ).ready( function() {
	$( '.masonry' ).masonry( {
		itemSelector: 'article'
	} );
} );


// third party
// --------------------------------------------------------------

$( document ).ready( function() {
	// first hide
	$('#slide-toggle').css( 'height', $( '#slide-toggle' ).height() + 'px' );
	$( '#slide-toggle' ).hide();

	// slide toggle
	$( '#toggle' ).click( function() {
		$( '#slide-toggle' ).slideToggle( 'fast' );
	} )
} )
