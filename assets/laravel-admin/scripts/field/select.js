'use strict'
;
(function ($) {
  window.attach('[data-block="field-select"]', function () {
    var $block = $(this)
    var dataSet = $block.data('optionsFieldSelect')
    var $input = $block.find('[data-element="field-select-input"]')
    var $keeper = $block.find('[data-element="field-select-keeper"]')
    var options = $.extend(true, {
      ajax: false,
      url: '/',
      fields: {
        id: 'id',
        text: 'text'
      },
      select2: {}
    }, dataSet)
    if (options.ajax) {
      options.select2.ajax = {
        url: options.url,
        dataType: 'json',
        delay: 250,
        data: function (params) {
          return {
            q: params.term,
            page: params.page
          }
        },
        processResults: function (data, params) {
          params.page = params.page || 1

          return {
            results: $.map(data.data, function (d) {
              d.id = d[options.fields.id]
              d.text = d[options.fields.text]
              return d
            }),
            pagination: {
              more: data.next_page_url
            }
          }
        },
        cache: true
      }
      options.select2.minimumInputLength = 1
      options.select2.escapeMarkup = function (markup) {
        return markup
      }
    }
    console.log(options)
    $input.select2(options.select2)
    const clearInput = function () {
      $input.val('').change()
    }
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
    var select2 = $input.data('select2')
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