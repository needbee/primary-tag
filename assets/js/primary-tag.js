/*! Primary Tag - v0.1.0
 * https://github.com/needbee/primary-tag
 * Copyright (c) 2015; * Licensed GPLv2+ */
( function( window, undefined ) {
	'use strict';

	/**
	 * Updates the primary tag dropdown to match all current tags for the post.
	 *
	 * This is fired on a 100 ms delay to allow time for WordPress's JS to
	 * update the list of tags shown. A better future implementation would
	 * actually hook into WordPress's JS or operate in response to DOM changes.
	 *
	 * @global {Object} jQuery the jQuery object.
	 */
	function updatePrimaryTagDropdownOnDelay() {
		setTimeout( function() {
			var $select = jQuery( '#primary-tag' );
			var currentTag = $select.val();

			// remove all tag options
			$select.find( 'option:not(:first)' ).remove();

			// in case the primary tag was removed, select '(none)' by default
			$select.val( '' );

			// add all current tags back in as options
			var tags = getTags();
			var option;
			for( var i in tags ) {
				option = jQuery( '<option />' )
					.attr( 'value', tags[ i ] )
					.text( tags[ i ] );
				if( currentTag === tags[ i ] ) {
					option.attr( 'selected', true );
				}
				option.appendTo( $select );
			}
		}, 100 );
	}

	/**
	 * Gets the tags currently on the post.
	 *
	 * Currently implemented by looking in the DOM. A better future
	 * implementation would hook into WordPress's JS to get the list, if
	 * possible.
	 *
	 * @global {Object} jQuery the jQuery object.
	 * @return {string[]} the current tags
	 */
	function getTags() {
		var tags = jQuery( 'div.tagchecklist span' )
			.map( function( i, elm ) {
				return jQuery( elm ).text().substring( 2 );
			} )
			.get();
		return tags;
	}

	jQuery(function() {
		// update the primary tag dropdown any time the tags change, either by:

		// clicking the Add button
		jQuery( 'input.tagadd' ).click( updatePrimaryTagDropdownOnDelay );

		// hitting return while in the add tag box
		jQuery( '#new-tag-post_tag' ).keyup( function( evt ) {
			// return key
			if ( 13 === evt.keyCode ) {
				updatePrimaryTagDropdownOnDelay();
			}
		});

		/*
		 * Clicking X to remove a tag.
		 *
		 * For some reason, detecting clicks on '.ntdelbutton' children isn't
		 * working (and not because they're dynamically added later). But since all
		 * this does is refresh the tag list, it's not a big problem to do it for
		 * _any_ click in the checklist area.
		 */
		jQuery( '.tagchecklist' ).on( 'click', updatePrimaryTagDropdownOnDelay );
	});

} )( this );
