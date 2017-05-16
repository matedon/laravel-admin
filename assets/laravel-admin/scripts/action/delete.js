'use strict'
;
(function ($) {
  window.attach('[data-block="action-delete"]', function () {
    var $block = $(this)
    var dataSet = $block.data('optionsActionDelete')
    var options = $.extend({
      event: 'click',
      confirm: 'Are you sure?'
    }, dataSet)
    console.log(options)
    var deleteHandler = function (ev) {
      ev.preventDefault()
      if (confirm(options.confirm)) {
        $.ajax({
          method: 'post',
          url: $block.attr('href'),
          data: {
            _method: 'delete',
            _token: LA.token
          },
          success: function (data) {
            $.pjax.reload('#pjax-container')

            if (typeof data === 'object') {
              if (data.status) {
                toastr.success(data.message)
              } else {
                toastr.error(data.message)
              }
            }
          }
        })
      }
    }
    $block.on(options.event, deleteHandler)
  })
})(jQuery)