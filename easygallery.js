/*
 * EasyGallery
 * http://github.com/romaricdrigon/
 */

// when Galleria is ready
Galleria.ready(function () {
	// bind function to keyboard using Galleria API
	this.attachKeyboard({
	    left: this.prev, // applies the native prev() function
	    right: this.next,
	    13: function() {
	        this.play(3000); // start playing when return (keyCode 13) is pressed:
	    },
	    27: this.pause // stop with esc
	});
});