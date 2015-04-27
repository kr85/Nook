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
        console.log(thisBodyText);
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
        var thisForm = $(this),
            thisUrl  = thisForm.attr('action'),
            thisFromData, imageWidth;
        if (systemObject.supportFormData()) {
          thisFromData = new FormData(this);
          $.ajax({
            url         : thisUrl,
            type        : 'POST',
            data        : thisFromData,
            processData : false,
            contentType : false,
            success : function (response) {
              if (response.success) {
                thisForm[0].reset();
                if (response.message && response.timeline) {
                  $('#timeline').prepend(response.timeline);
                  imageWidth = $('.status-image-box').width();
                  $('.status-image').css({ width : imageWidth });
                  $('#post-status').prop('disabled', true);
                  systemObject.showAlertMessage(response.message);
                }
              } else {
                if (response.message) {
                  systemObject.showErrorMessage(response.message);
                }
              }
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
                if (response.message && response.timeline) {
                  $('#timeline').prepend(response.timeline);
                  imageWidth = $('.status-image-box').width();
                  $('.status-image').css({ width : imageWidth });
                  systemObject.showAlertMessage(response.message);
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
              $('#timeline-status-' + thisId).remove();
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
              $('#timeline-status-' + thisId).remove();
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
                textElement.text(thisValue).show();
                return false;
              }
            },
            success : function (response) {
              if (response.success && response.message) {
                thisObj.hide();
                textElement.text(thisValue).show();
                $('#timeline-status-text-' + thisId).addClass('status-media');
                systemObject.showAlertMessage(response.message);
              }
            },
            error : function () {
              //window.location.reload();
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
                  textElement.text(thisValue).show();
                  return false;
                }
              },
              success: function (response) {
                if (response.success && response.message) {
                  thisObj.hide();
                  textElement.text(thisValue).show();
                  $('#timeline-status-text-' + thisId).addClass('status-media');
                  systemObject.showAlertMessage(response.message);
                }
              },
              error: function () {
                //window.location.reload();
              }
            });
          } else {
            systemObject.showErrorMessage('This field cannot be empty.');
          }
          return false;
        }
      });
    },
    statusFormLike : function (thisIdentity) {
      $(document).on('submit', thisIdentity, function (e) {
        e.preventDefault();
        var thisObj      = $(this),
            thisForm     = $('#' + thisObj.attr('id')),
            thisUrl      = thisObj.attr('action'),
            thisFormData = thisForm.serialize(),
            thisId       = thisObj.data('id'),
            thisLikeIcon = '#status-like-button-' + thisId;
        $.ajax({
          url      : thisUrl,
          type     : 'POST',
          dataType : 'JSON',
          data     : thisFormData,
          success : function (response) {
            if (response.success) {
              $(thisLikeIcon).toggleClass('status-liked');
              systemObject.showAlertMessage(response.message);
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
              statusId     = thisForm.data('id');
          if (!systemObject.isEmpty(thisText)) {
            $.ajax({
              url      : thisUrl,
              type     : 'POST',
              dataType : 'JSON',
              data     : thisFormData,
              success : function (response) {
                if (response.success) {
                  thisForm[0].reset();
                  if (response.message && response.timeline) {
                    $('#status-' + statusId + '-comments').append(response.timeline);
                    systemObject.showAlertMessage(response.message);
                  }
                }
              },
              error : function () {
                //window.location.reload();
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
            thisId       = thisObj.data('id');
        $.ajax({
          url      : thisUrl,
          type     : 'POST',
          dataType : 'JSON',
          data     : thisFormData,
          success : function (response) {
            if (response.success) {
              $('#comment-' + thisId).remove();
              if (response.message) {
                systemObject.showAlertMessage(response.message);
              }
            }
          },
          error : function () {
            //window.location.reload();
          }
        });
        return false;
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
              if (response.success && response.message) {
                thisObj.hide();
                textElement.text(thisValue).show();
                systemObject.showAlertMessage(response.message);
              }
            },
            error : function () {
              //window.location.reload();
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
                if (response.success && response.message) {
                  thisObj.hide();
                  textElement.text(thisValue).show();
                  systemObject.showAlertMessage(response.message);
                }
              },
              error: function () {
                //window.location.reload();
              }
            });
          } else {
            systemObject.showErrorMessage('This field cannot be empty.');
          }
          return false;
        }
      });
    },
    statusImageResize : function (thisIdentity) {
      var width = $(thisIdentity).width();
      $('.status-image').css({ width : width });
      $(window).resize(function () {
        width = $(thisIdentity).width();
        $('.status-image').css({ width : width });
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
    statusObject.statusImageResize('.status-image-box');
    statusObject.commentFormSubmit('.comments_create-form');
    statusObject.commentFormDelete('.delete-comment-form');
    statusObject.commentEditShowInputField('.edit-comment');
    statusObject.commentFormEditSubmitFocusOut('.comment-blur-update-hide-show');
    statusObject.commentFormEditSubmitKeyDown('.comment-blur-update-hide-show');

    systemObject.addPressedToHomeIcon('.navbar-home-icon-box');
    systemObject.alertShowHide('body');
    systemObject.forceTopOfPageOnRefresh();

    $('#flash-overlay-modal').modal();
  });
}(jQuery));