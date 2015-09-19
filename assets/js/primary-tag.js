/*! Primary Tag - v0.1.0
 * https://github.com/needbee/primary-tag
 * Copyright (c) 2015; * Licensed GPLv2+ */
( function( window, undefined ) {
	'use strict';

  function updatePrimaryTagDropdownOnDelay() {
    setTimeout( function() {
      var $select = jQuery('#primary-tag select');
      var currentTag = $select.val();
      $select.empty();
      var tags = getTags();
      for( var i in tags ) {
        jQuery("<option />").attr("value", tags[i]).text(tags[i]).appendTo($select);
      }
      $select.val(currentTag);
    }, 100 );
  }

  function getTags() {
    var tags = jQuery('div.tagchecklist span').map(function(i, elm){return jQuery(elm).text().substring(2);}).get();
    return tags;
  }

  jQuery(function() {
    jQuery('input.tagadd').click(updatePrimaryTagDropdownOnDelay);

    jQuery('#new-tag-post_tag').keyup(function(evt) {
      if( evt.keyCode == 13 ) {
        updatePrimaryTagDropdownOnDelay();
      }
    });
    /* not working yet
    jQuery('#tagsdiv-post_tag').on('click','.ntdelbutton', function(evt) {
      console.log('clicked delete');
      // setTimeout( function() {
      //   console.log( getTags() );
      // }, 100 );
    });
    */
  });

} )( this );
