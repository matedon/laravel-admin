'use strict'
;
(function ($) {
  window.attach('[data-block="field-icon"]', function () {
    var $block = $(this)
    var dataSet = $block.data('optionsFieldIcon')
    var $input = $block.find('[data-element="field-icon-input"]')
    var options = $.extend(true, {
      iconpicker: {
        placement: 'bottomLeft',
        fullClassFormatter: function (val) {
          return 'fa fa-lg fa-fw ' + val;
        }
      }
    }, dataSet)
    $input.iconpicker(options.iconpicker)
  })
})(jQuery)