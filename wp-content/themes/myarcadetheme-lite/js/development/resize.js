var myarcadetheme = myarcadetheme || {};

myarcadetheme.intrinsicRatioGames = {

  init: function() {
    this.makeFit();

    window.addEventListener( 'resize', function() {
			this.makeFit();
		}.bind( this ) );
	},

  makeFit: function() {
    element_list = document.querySelectorAll( '#playframe' );

    if ( ! element_list.length ) {
      element_list = document.querySelectorAll( '#myarcade_game iframe, #myarcade_game ruffle-player' );
    }

    element_list.forEach( function( game ) {
			var ratio, height, width,
        container = game.parentNode;
      var maxHeight = window.innerHeight - 50;
      var maxWidth  = container.offsetWidth;

      var width, height;

      // Get game dismensions
      if ( typeof game.width === 'undefined' ) {
        width  = game.style.width.replace('px', '');
        height = game.style.height.replace('px', '');
      }
      else {
        width = game.width;
        height = game.height;
      }

      // Check the game width
      if ( width.search("%") >= 0 ) {
        // we have % widht. Try to set the game dimmensions to 16:9
        width  = maxWidth;
        height = maxWidth * 9 / 16;
      }

			if ( ! game.dataset.origwidth ) {
				// Get the game element proportions.
				game.setAttribute( 'data-origwidth', width );
				game.setAttribute( 'data-origheight', height );
      }

      ratio = game.dataset.origwidth / game.dataset.origheight;

      // Handle game orientation
      if ( parseInt( game.dataset.origheight ) > parseInt( game.dataset.origwidth ) ) {
        // Portrait
        height = maxHeight;
        width  = maxHeight * ratio;

        if ( width > maxWidth ) {
          height = maxWidth / ratio;
          width = maxWidth;
        }
      }
      else {
        // Landscape
        width  = maxWidth;
        height = width / ratio;

        if ( height > maxHeight ) {
          height = maxHeight;
          width  = height * ratio ;
        }
      }

      // Scale based on ratio, thus retaining proportions.
      game.style.width = width + 'px';
      game.style.height = height + 'px';
		} );
	}
}

/**
 * Is the DOM ready?
 *
 * This implementation is coming from https://gomakethings.com/a-native-javascript-equivalent-of-jquerys-ready-method/
 *
 * @param {Function} fn Callback function to run.
 */
function myarcadethemeDomReady( fn ) {
	if ( typeof fn !== 'function' ) {
		return;
	}

	if ( document.readyState === 'interactive' || document.readyState === 'complete' ) {
		return fn();
	}

	document.addEventListener( 'DOMContentLoaded', fn, false );
}

myarcadethemeDomReady( function() {
	myarcadetheme.intrinsicRatioGames.init(); // Retain aspect ratio of games on window resize.
} );