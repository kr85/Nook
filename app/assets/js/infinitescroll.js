/*
 * Handles timeline infinite scrolling
 */

/* global jQuery:false */

(function ($) {

  // Timeline element
  var thisSelector = '#timeline';

  // Initialize infinite scroll plugin
  $(thisSelector).infinitescroll({
    extraScrollPx: 0
  }, function () {

    // Fix timeline bottom border
    autoScrollTimelineWrapperFix();

    // Show load more button
    $('ul.pagination').show();

    // Hide loading image
    $('.loading-image').hide();
  });

  // Fix timeline bottom border
  autoScrollTimelineWrapperFix();

  // Unbind infinite scroll plugin
  $(thisSelector).infinitescroll('unbind');

  // On load more click
  $('ul.pagination li a.active').on('click', function (e) {
    e.preventDefault();

    // Show loading image
    $('.loading-image').show();

    // Reinitialize infinite scroll plugin
    $(thisSelector).infinitescroll('retrieve');
  });

  // Fixes timeline's bottom border
  function autoScrollTimelineWrapperFix () {
    $('.timeline-wrapper-last-child').css({
      'border-color' : '#E0E1E2'
    });
  }
}(jQuery));