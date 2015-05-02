/*
 * Handles timeline infinite scrolling
 */

/* global jQuery:false */

(function ($) {

  var paginationDiv   = $('ul.pagination'),
      loadingImageDiv = $('.loading-image'),
      timelineDiv     = $('#timeline'),
      currentPage     = 1;

  // On load more button click
  $(document).on('click', 'ul.pagination li a.active', function (e) {
    currentPage = currentPage + 1;
    getStatuses(currentPage);
    e.preventDefault();
  });

  // Get new statuses
  function getStatuses(page) {
    $.ajax({
      url      : '?page=' + page,
      type     : 'GET',
      dataType : 'JSON',
      beforeSend : function () {
        // Hide load more button
        paginationDiv.hide();

        // Show loading image
        loadingImageDiv.show();

        // Fix timeline bottom border styles
        autoScrollTimelineWrapperFix();
      },
      success : function (response) {
        // Append new content
        timelineDiv.append(response.view);

        if (response.countStatuses >= 25) {
          // Show load more button
          paginationDiv.show();
        }

        // Hide loading image
        loadingImageDiv.hide();
      },
      complete : function () {
        $('.comments').each(function () {
          var thisObj = $(this);
          var thisId = '#' + thisObj.attr('id');
          $(thisId).animate({
            scrollTop : $(thisId)[0].scrollHeight
          }, "fast");
        });
      },
      error : function (response) {
        console.log(response);
      }
    });
  }

  // Fixes timeline's bottom border
  function autoScrollTimelineWrapperFix () {
    $('.timeline-wrapper-last-child').css({
      'border-bottom-color' : '#E0E1E2'
    });
  }
}(jQuery));