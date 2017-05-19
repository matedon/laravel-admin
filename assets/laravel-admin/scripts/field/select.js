'use strict'
;
(function ($) {
  window.attach('[data-block="field-select"]', function () {
    var $block = $(this)
    var dataSet = $block.data('optionsFieldSelect')
    var $input = $block.find('[data-element="field-select-input"]')
    var $keeper = $block.find('[data-element="field-select-keeper"]')
    var options = $.extend(true, {}, dataSet)
    const clearInput = function () {
      $input.val('').change()
    }
    $input.select2(options);
    $input.on('change.select2', function () {
      var inputVal = $input.val()
      if (!(inputVal && inputVal.length)) {
        $keeper.val('null')
      } else {
        $keeper.val(inputVal)
      }
    })
    if ($keeper.val() === 'null') {
      clearInput()
    }
    var select2 = $input.data('select2');

    select2.$selection.off('mousedown', '.select2-selection__clear')
    select2.$selection.on('mousedown', '.select2-selection__clear', function (evt) {
      evt.stopPropagation()
      clearInput()
    })
    attach(select2.$selection, '.select2-selection__clear', function () {
      var clearTemplate = '<span class="btn btn-xs btn-default" style="margin-top: -3px">' +
        '<span class="glyphicon glyphicon-remove text-muted" style="margin-top: 2px"></span>' +
        '</span>'
      $(this).html(clearTemplate)
    })
  })
})(jQuery)