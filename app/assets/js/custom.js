/* global jQuery:false */

(function ($) {
  "use strict";

  var statusObject = {
    ajaxSetup : function () {
      $.ajaxSetup({
        headers: {
          'X-CSRF-Token' : $('input[name="_token"]').val()
        }
      });
    },
    statusFormChange : function (thisIdentity) {
      var thisForm           = $(thisIdentity),
          thisTextarea       = thisForm.find('#post-status-textarea'),
          thisImageName      = thisForm.find('input[name="image"]').val(),
          thisBodyText       = $(thisTextarea).val(),
          submitStatusButton = $('#post-status');
      // Initial state of the button
      if (!systemObject.isEmpty(thisBodyText) || !systemObject.isEmpty(thisImageName)) {
        submitStatusButton.prop('disabled', false);
      } else {
        submitStatusButton.prop('disabled', true);
      }
      // Change input listener on status text area
      $(thisTextarea).on('input', function () {
        thisBodyText  = $(this).val();
        if (!systemObject.isEmpty(thisBodyText) || !systemObject.isEmpty(thisImageName)) {
          submitStatusButton.prop('disabled', false);
        } else {
          submitStatusButton.prop('disabled', true);
        }
      });
      // Change input listener on status image
      $(thisIdentity).change(function () {
        thisImageName = thisForm.find('input[name="image"]').val();
        if (!systemObject.isEmpty(thisBodyText) || !systemObject.isEmpty(thisImageName)) {
          submitStatusButton.prop('disabled', false);
        } else {
          submitStatusButton.prop('disabled', true);
        }
      });
    },
    statusFormSubmit : function (thisIdentity) {
      $(document).on('submit', thisIdentity, function (e) {
        e.preventDefault();
        var thisForm     = $(this),
            thisUrl      = thisForm.attr('action'),
            $thisTimeline = $('#timeline'),
            imageWidth    = $('.status-image-box').width(),
            thisFromData, $newStatus;
        if (systemObject.supportFormData()) {
          thisFromData = new FormData(this);
          thisFromData.append('imageWidth', imageWidth);
          $.ajax({
            url         : thisUrl,
            type        : 'POST',
            data        : thisFromData,
            processData : false,
            contentType : false,
            beforeSend : function () {
              $('.status-post-loading-box').show();
            },
            success : function (response) {
              if (response.success) {
                thisForm[0].reset();
                if (response.view) {
                  if ($thisTimeline.find('.no-status-fix').length > 0) {
                    $thisTimeline.find('.no-status-fix p').html("");
                  }
                  // Prepend the new status to the timeline
                  $thisTimeline.prepend(response.view);
                  // Get the id of the new status
                  $newStatus = $('#timeline-status-' + response.statusId);
                  // Hide the new status
                  $newStatus.hide();
                  // Add a slide down animation to the new status
                  $newStatus.slideDown(400);
                  // Resize the image of the new status
                  imageWidth = $('.status-image-box').width();
                  $('.status-image').css({ width : imageWidth, height : 'auto' });
                  // Disable the status post button
                  $('#post-status').prop('disabled', true);
                  // Display message if available
                  if (response.message) {
                    systemObject.showAlertMessage(response.message);
                  }
                }
              } else {
                if (response.message) {
                  systemObject.showErrorMessage(response.message);
                }
              }
            },
            complete : function () {
              $('.status-post-loading-box').hide();
            },
            error : function () {
              window.location.reload();
            }
          });
        } else {
          thisFromData = thisForm.serialize();
          $.ajax({
            url         : thisUrl,
            type        : 'POST',
            dataType    : 'JSON',
            data        : thisFromData,
            success : function (response) {
              if (response.success) {
                thisForm[0].reset();
                if (response.view) {
                  if ($thisTimeline.find('.no-status-fix').length > 0) {
                    $thisTimeline.find('.no-status-fix p').html("");
                  }
                  // Prepend the new status to the timeline
                  $thisTimeline.prepend(response.view);
                  // Get the id of the new status
                  $newStatus = $('#timeline-status-' + response.statusId);
                  // Hide the new status
                  $newStatus.hide();
                  // Add a slide down animation to the new status
                  $newStatus.slideDown(400);
                  // Resize the image of the new status
                  imageWidth = $('.status-image-box').width();
                  $('.status-image').css({ width : imageWidth, height : 'auto' });
                  // Disable the status post button
                  $('#post-status').prop('disabled', true);
                  // Display message if available
                  if (response.message) {
                    systemObject.showAlertMessage(response.message);
                  }
                }
              }
            },
            error : function () {
              window.location.reload();
            }
          });
        }
        return false;
      });
    },
    statusEditShowInputField : function (thisIdentity) {
      $(document).on('click', thisIdentity, function (e) {
        e.preventDefault();
        var statusId      = $(this).attr('id'),
            dataShowClass = '.click-hide-show-' + statusId,
            thisTarget    = $(dataShowClass).data('show'),
            thisArticle   = '#timeline-status-text-' + statusId;
        $(thisArticle).removeClass('status-media-mobile');
        $(dataShowClass).hide();
        $(thisTarget).show().focus();
      });
    },
    statusFormEditSubmitFocusOut : function (thisIdentity) {
      $(document).on('focusout', thisIdentity, function (e) {
        e.preventDefault();
        var thisObj         = $(this),
            thisId          = thisObj.data('id'),
            thisShow        = thisObj.attr('id'),
            thisForm        = '#edit-status-form-' + thisId,
            thisUrl         = $(thisForm).attr('action'),
            thisValue       = $.trim(thisObj.val()),
            textElement     = $('[data-show="#' + thisShow + '"]'),
            thisFormData    = $(thisForm).serialize();
        if (!systemObject.isEmpty(thisValue)) {
          $.ajax({
            url      : thisUrl,
            type     : 'POST',
            dataType : 'JSON',
            data     : thisFormData,
            beforeSend : function () {
              var currentValue = $.trim(textElement.text());
              if (currentValue == thisValue) {
                thisObj.hide();
                textElement.show();
                return false;
              }
            },
            success : function (response) {
              if (response.success) {
                thisObj.hide();
                $('#status-' + thisId + '-body').html(response.view);
                $('#timeline-status-text-' + thisId).addClass('status-media');
                if (response.message) {
                  systemObject.showAlertMessage(response.message);
                }
              }
            },
            error : function () {
              window.location.reload();
            }
          });
        } else {
          systemObject.showErrorMessage('This field cannot be empty.');
        }
        return false;
      });
    },
    statusFormEditSubmitKeyDown : function (thisIdentity) {
      $(document).on('keydown', thisIdentity, function (e) {
        var code = e.keyCode ? e.keyCode : e.which;
        if (code == 13) {
          e.preventDefault();
          var thisObj         = $(this),
              thisId          = thisObj.data('id'),
              thisShow        = thisObj.attr('id'),
              thisForm        = '#edit-status-form-' + thisId,
              thisUrl         = $(thisForm).attr('action'),
              thisValue       = thisObj.val(),
              textElement     = $('[data-show="#' + thisShow + '"]'),
              thisFormData    = $(thisForm).serialize();
          if (!systemObject.isEmpty(thisValue)) {
            $.ajax({
              url      : thisUrl,
              type     : 'POST',
              dataType : 'JSON',
              data     : thisFormData,
              beforeSend : function () {
                var currentValue = $.trim(textElement.text());
                if (currentValue == thisValue) {
                  thisObj.hide();
                  textElement.show();
                  return false;
                }
              },
              success: function (response) {
                if (response.success && response.message) {
                  thisObj.hide();
                  $('#status-' + thisId + '-body').html(response.view);
                  $('#timeline-status-text-' + thisId).addClass('status-media');
                  systemObject.showAlertMessage(response.message);
                }
              },
              error: function () {
                window.location.reload();
              }
            });
          } else {
            systemObject.showErrorMessage('This field cannot be empty.');
          }
          return false;
        }
      });
    },
    statusFormDelete : function (thisIdentity) {
      $(document).on('submit', thisIdentity, function (e) {
        e.preventDefault();
        var thisForm     = '#' + $(this).attr('id'),
          thisId       = $(thisForm).data('id'),
          thisUrl      = $(thisForm).attr('action'),
          thisFormData = $(thisForm).serialize();
        $.ajax({
          url      : thisUrl,
          type     : 'POST',
          dataType : 'JSON',
          data     : thisFormData,
          success : function (response) {
            if (response.success) {
              $('#timeline-status-' + thisId).slideUp(400);
              if (response.message) {
                systemObject.showAlertMessage(response.message);
              }
            }
          },
          error : function () {
            window.location.reload();
          }
        });
        return false;
      });
    },
    statusFormHide : function (thisIdentity) {
      $(document).on('submit', thisIdentity, function (e) {
        e.preventDefault();
        var thisForm     = '#' + $(this).attr('id'),
          thisId       = $(thisForm).data('id'),
          thisUrl      = $(thisForm).attr('action'),
          thisFormData = $(thisForm).serialize();
        $.ajax({
          url      : thisUrl,
          type     : 'POST',
          dataType : 'JSON',
          data     : thisFormData,
          success : function (response) {
            if (response.success) {
              $('#timeline-status-' + thisId).slideUp(400);
              if (response.message) {
                systemObject.showAlertMessage(response.message);
              }
            }
          },
          error : function () {
            window.location.reload();
          }
        });
        return false;
      });
    },
    statusFormLike : function (thisIdentity) {
      $(document).on('submit', thisIdentity, function (e) {
        e.preventDefault();
        var thisObj      = $(this),
            thisForm     = $('#' + thisObj.attr('id')),
            thisUrl      = thisObj.attr('action'),
            thisFormData = thisForm.serialize(),
            thisId       = thisObj.data('id');
        $.ajax({
          url      : thisUrl,
          type     : 'POST',
          dataType : 'JSON',
          data     : thisFormData,
          success : function (response) {
            if (response.success) {
              if (response.view) {
                $('#status-options-' + thisId).html(response.view);
              }
              if (response.message) {
                systemObject.showAlertMessage(response.message);
              }
            }
          },
          error : function () {
            window.location.reload();
          }
        });
        return false;
      });
    },
    commentFormSubmit : function (thisIdentity) {
      $(document).on('keydown', thisIdentity, function (e) {
        var code = e.keyCode ? e.keyCode : e.which;
        if (code == 13) {
          e.preventDefault();
          var formId       = $(this).attr('id'),
              thisForm     = $('#' + formId),
              thisFormData = thisForm.serialize(),
              thisUrl      = thisForm.attr('action'),
              thisText     = thisForm.find('.comment-textarea').val(),
              statusId     = thisForm.data('id'),
              $newComment, commentsDiv;
          if (!systemObject.isEmpty(thisText)) {
            $.ajax({
              url      : thisUrl,
              type     : 'POST',
              dataType : 'JSON',
              data     : thisFormData,
              success : function (response) {
                if (response.success) {
                  // Reset the form
                  thisForm[0].reset();
                  if (response.view) {
                    // Find status comments div
                    commentsDiv = $('#status-' + statusId + '-comments');
                    // Append the new comment
                    commentsDiv.append(response.view);
                    // Find the new comment
                    $newComment = $('#comment-' + response.commentId);
                    // Hide the new comment
                    $newComment.hide();
                    // Add slide down animation to the new comment
                    $newComment.slideDown(300);
                    // Add scroll down animation to the comments div
                    commentsDiv.animate({
                      scrollTop : commentsDiv[0].scrollHeight
                    }, "slow");
                    // Remove a styling class
                    thisForm.find('.comment-textarea').removeClass('remove-border-top');
                  }
                  // Display message if available
                  if (response.message) {
                    systemObject.showAlertMessage(response.message);
                  }
                }
              },
              error : function () {
                window.location.reload();
              }
            });
          } else {
            systemObject.showErrorMessage('This field cannot be empty.');
          }
          return false;
        }
      });
    },
    commentEditShowInputField : function (thisIdentity) {
      $(document).on('click', thisIdentity, function (e) {
        e.preventDefault();
        var statusId      = $(this).attr('id'),
            dataShowClass = '.comment-click-hide-show-' + statusId,
            thisTarget    = $(dataShowClass).data('show');
        $(dataShowClass).hide();
        $(thisTarget).show().focus();
      });
    },
    commentFormEditSubmitFocusOut : function (thisIdentity) {
      $(document).on('focusout', thisIdentity, function (e) {
        e.preventDefault();
        var thisObj         = $(this),
            thisId          = thisObj.data('id'),
            thisShow        = thisObj.attr('id'),
            thisForm        = '#edit-comment-form-' + thisId,
            thisUrl         = $(thisForm).attr('action'),
            thisValue       = $.trim(thisObj.val()),
            textElement     = $('[data-show="#' + thisShow + '"]'),
            thisFormData    = $(thisForm).serialize();
        if (!systemObject.isEmpty(thisValue)) {
          $.ajax({
            url      : thisUrl,
            type     : 'POST',
            dataType : 'JSON',
            data     : thisFormData,
            beforeSend : function () {
              var currentValue = $.trim(textElement.text());
              if (currentValue == thisValue) {
                thisObj.hide();
                textElement.text(thisValue).show();
                return false;
              }
            },
            success : function (response) {
              if (response.success) {
                thisObj.hide();
                $('#comment-' + thisId).replaceWith(response.view);
                if (response.message) {
                  systemObject.showAlertMessage(response.message);
                }
              }
            },
            error : function () {
              window.location.reload();
            }
          });
        } else {
          systemObject.showErrorMessage('This field cannot be empty.');
        }
        return false;
      });
    },
    commentFormEditSubmitKeyDown : function (thisIdentity) {
      $(document).on('keydown', thisIdentity, function (e) {
        var code = e.keyCode ? e.keyCode : e.which;
        if (code == 13) {
          e.preventDefault();
          var thisObj         = $(this),
              thisId          = thisObj.data('id'),
              thisShow        = thisObj.attr('id'),
              thisForm        = '#edit-comment-form-' + thisId,
              thisUrl         = $(thisForm).attr('action'),
              thisValue       = thisObj.val(),
              textElement     = $('[data-show="#' + thisShow + '"]'),
              thisFormData    = $(thisForm).serialize();
          if (!systemObject.isEmpty(thisValue)) {
            $.ajax({
              url      : thisUrl,
              type     : 'POST',
              dataType : 'JSON',
              data     : thisFormData,
              beforeSend : function () {
                var currentValue = $.trim(textElement.text());
                if (currentValue == thisValue) {
                  thisObj.hide();
                  textElement.text(thisValue).show();
                  return false;
                }
              },
              success: function (response) {
                if (response.success) {
                  thisObj.hide();
                  $('#comment-' + thisId).replaceWith(response.view);
                  if (response.message) {
                    systemObject.showAlertMessage(response.message);
                  }
                }
              },
              error: function () {
                window.location.reload();
              }
            });
          } else {
            systemObject.showErrorMessage('This field cannot be empty.');
          }
          return false;
        }
      });
    },
    commentFormDelete : function (thisIdentity) {
      $(document).on('submit', thisIdentity, function (e) {
        e.preventDefault();
        var thisObj      = $(this),
          thisForm     = $('#' + thisObj.attr('id')),
          thisFormData = thisForm.serialize(),
          thisUrl      = thisObj.attr('action'),
          thisId       = thisObj.data('id'),
          $thisComment;
        $.ajax({
          url      : thisUrl,
          type     : 'POST',
          dataType : 'JSON',
          data     : thisFormData,
          success : function (response) {
            if (response.success) {
              $thisComment = $('#comment-' + thisId);
              $thisComment.slideUp(300, function () {
                $(this).remove();
              });
              if (response.message) {
                systemObject.showAlertMessage(response.message);
              }
            }
          },
          error : function () {
            window.location.reload();
          }
        });
        return false;
      });
    }
  };

  var systemObject = {
    addPressedToHomeIcon : function (thisIdentity) {
      if (window.location.pathname === '/statuses') {
        $(thisIdentity).addClass('navbar-home-icon-pressed');
      }
    },
    alertShowHide : function (thisIdentity) {
      var element = $(thisIdentity).find('.alert-info-wrapper');
      $(element).animate({ top : '51px' }, function () {
        setTimeout(function () {
          $(element).animate({ top : '0px' }, function () {
            $(this).hide();
          });
        }, 1500);
      });
    },
    showAlertMessage : function (thisMessage) {
      if (thisMessage !== '' && typeof thisMessage !== 'undefined') {
        var messageElement = '.alert-info-wrapper';
        if ($(messageElement).length > 0) {
          $(messageElement).remove();
        }
        $('#alert-container').prepend($(systemObject.alertMessageTemplate(thisMessage)));
        $(messageElement).animate({ top : '51px' });
        setTimeout(function () {
          $(messageElement).animate({ top : '0px' }, function () {
            $(this).hide();
          });
        }, 1500);
      }
    },
    showErrorMessage : function (thisMessage) {
      if (thisMessage !== '' && typeof thisMessage !== 'undefined') {
        var messageElement = '.alert-info-wrapper';
        if ($(messageElement).length > 0) {
          $(messageElement).remove();
        }
        $('#alert-container').prepend($(systemObject.errorMessageTemplate(thisMessage)));
        $(messageElement).animate({ top : '51px' });
      }
    },
    alertMessageTemplate : function (thisMessage) {
      var template     = '<div class="container">';
          template    += '<div class="alert-info-wrapper">';
          template    += '<div class="alert alert-info">';
          template    += thisMessage;
          template    += '</div>';
          template    += '</div>';
          template    += '</div>';
      return template;
    },
    errorMessageTemplate : function (thisMessage) {
      var template     = '<div class="container">';
          template    += '<div class="alert-info-wrapper">';
          template    += '<div class="alert alert-danger-flash">';
          template    += thisMessage;
          template    += '</div>';
          template    += '</div>';
          template    += '</div>';
      return template;
    },
    isEmpty : function (thisValue) {
      return (!(thisValue !== '' && typeof  thisValue !== 'undefined'));
    },
    forceTopOfPageOnRefresh : function () {
      $(document).scrollTop(0);
    },
    supportFormData : function () {
      return !! window.FormData;
    },
    statusImageResize : function (thisIdentity) {
      var width = $(thisIdentity).width();
      $('.status-image').css({ width : width });
      $(window).resize(function () {
        width = $(thisIdentity).width();
        $('.status-image').css({ width : width, height : 'auto' });
      });
    },
    facebookOAuthRedirectUrlFix : function () {
      $(document).ready(function (e) {
        if (window.location.hash == '#_=_') {
          window.location.hash = '';
          history.pushState('', document.title, window.location.pathname);
          e.preventDefault();
        }
      });
    },
    scrollToBottomCommentsDivs : function (thisIdentity) {
      $(document).ready(function () {
        $(thisIdentity).each(function () {
          var thisObj = $(this);
          var thisId = '#' + thisObj.attr('id');
          $(thisId).animate({
           scrollTop : $(thisId)[0].scrollHeight
           }, "fast");
        });
      });
    },
    changeCursorToProgressOnAjaxRequest : function () {
      $(document).ajaxStart(function () {
        $('body').css({ 'cursor' : 'progress' });
      }).ajaxStop(function () {
        $('body').css({ 'cursor' : 'auto' });
      });
    },
    showLoadingImageOnStatusImageLoad : function () {
      // Show the loading image
      $('.status-image-loading').show();
      // Hide the loading image after image is loaded
      $('.status-image').on('load', function () {
        $('.status-image-loading').hide();
      }).error(function () {
        window.location.reload();
      });
    }
  };

  $(function () {
    statusObject.ajaxSetup();
    statusObject.statusFormChange('#post-status-form');
    statusObject.statusFormSubmit('#post-status-form');
    statusObject.statusEditShowInputField('.edit-status');
    statusObject.statusFormEditSubmitFocusOut('.blur-update-hide-show');
    statusObject.statusFormEditSubmitKeyDown('.blur-update-hide-show');
    statusObject.statusFormDelete('.delete-status');
    statusObject.statusFormHide('.hide-status');
    statusObject.statusFormLike('.like-status-form');
    statusObject.commentFormSubmit('.comments_create-form');
    statusObject.commentEditShowInputField('.edit-comment');
    statusObject.commentFormEditSubmitFocusOut('.comment-blur-update-hide-show');
    statusObject.commentFormEditSubmitKeyDown('.comment-blur-update-hide-show');
    statusObject.commentFormDelete('.delete-comment-form');

    systemObject.addPressedToHomeIcon('.navbar-home-icon-box');
    systemObject.alertShowHide('body');
    systemObject.forceTopOfPageOnRefresh();
    systemObject.statusImageResize('.status-image-box');
    systemObject.facebookOAuthRedirectUrlFix();
    systemObject.scrollToBottomCommentsDivs('.comments');
    systemObject.changeCursorToProgressOnAjaxRequest();
    systemObject.showLoadingImageOnStatusImageLoad();

    $('#flash-overlay-modal').modal();
  });
}(jQuery));