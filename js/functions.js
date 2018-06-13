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


// form validation
// --------------------------------------------------------------

$( document ).ready( function() {
	$( '#comment-form' ).validate( {
		messages: {
			author: 'Bitte geben Sie Ihren Namen an.',
			email: 'Bitte geben Sie eine gültige E-Mail-Adresse an.',
			comment: 'Bitte schreiben Sie Ihre Meinung in das obrige Textfeld.'
		}
	} );
	
	$( '#recommend-form' ).validate( {
		messages: {
			toname: 'Bitte geben Sie den Namen des Empfängers ein.',
			toemail: 'Bitte geben Sie eine gültige E-Mail-Adresse an.',
			fromname: 'Bitte geben Sie Ihren Namen an.',
			fromemail: 'Bitte geben Sie eine gültige E-Mail-Adresse an.'
		}
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
