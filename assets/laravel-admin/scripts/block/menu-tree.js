'use strict'
;
(function ($) {
  window.attach('[data-block="menu-tree"]', function () {
    var $block = $(this)
    var dataSet = $block.data('optionsMenuTree')
    var $nestable = $block.find('[data-element="menu-tree__nestable"]')
    var $save = $block.find('[data-element="menu-tree__save"]')
    var $refresh = $block.find('[data-element="menu-tree__refresh"]')
    var expandSelector = '[data-element="menu-tree__expand"]'
    var collapseSelector = '[data-element="menu-tree__collapse"]'
    var deleteSelector = '[data-element="menu-tree__delete"]'
    var options = $.extend(true, {
      path: '/',
      messages: {
        'confirm': 'Are you sure?',
        'save': 'Save OK',
        'refresh': 'Refresh OK',
        'delete': 'Delete OK'
      },
      nestable: {
        expandBtnHTML: '<button data-action="expand"><i class="fa fa-lg fa-chevron-down"></i></button>',
        collapseBtnHTML: '<button data-action="collapse"><i class="fa fa-lg fa-chevron-right"></i></button>'
      }
    }, dataSet)

    $nestable.nestable(options.nestable)
    var nestable = $nestable.data('nestable')

    $block.on('click', deleteSelector, function () {
      var id = $(this).data('id')
      if (confirm(options.messages.confirm)) {
        $.post(options.path + '/' + id, {
          _method: 'delete',
          _token: window.LA.token
        }, function (data) {
          $.pjax.reload('#pjax-container')
          toastr.success(options.messages.delete)
        })
      }
    })

    $save.on('click', function () {
      var serialize = $nestable.nestable('serialize')

      $.post(options.path, {
          _token: window.LA.token,
          _order: JSON.stringify(serialize)
        },
        function (data) {
          $.pjax.reload('#pjax-container')
          toastr.success(options.messages.save)
        })
    })

    $refresh.click(function () {
      $.pjax.reload('#pjax-container')
      toastr.success(options.messages.refresh)
    })

    $block.on('click', expandSelector, function () {
      nestable.expandAll()
    })

    $block.on('click', collapseSelector, function () {
      nestable.collapseAll()
    })
  })
})(jQuery)