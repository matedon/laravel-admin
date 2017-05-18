'use strict'
;
(function ($) {
  window.attach('[data-block="display-switch"]', function () {
    var $block = $(this)
    var dataSet = $block.data('optionsDisplaySwitch')
    var $input = $block.find('[data-element="display-switch-input"]')
    var options = $.extend(true, {
      url: '/',
      bootstrapSwitch: {
        onSwitchChange: function (event, state) {
          $input.val(state ? 'on' : 'off');
          var ajaxSetup = {
            url: options.url,
            type: 'POST',
            data: {
              _token: window.LA.token,
              _method: 'PUT'
            },
            success: function (data) {
              toastr.success(data.message);
            }
          }
          ajaxSetup.data[$input.attr('name')] = $input.val()
          $.ajax(ajaxSetup);
        }
      }
    }, dataSet)
    $input.bootstrapSwitch(options.bootstrapSwitch)
  })
})(jQuery)