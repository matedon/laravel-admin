<?php

namespace MAteDon\Admin\Form\Field;

use MAteDon\Admin\Form\Field;

class CKEditor extends Field
{
  public static $js = [
    '/packages/admin/ckeditor/ckeditor.js',
    '/packages/admin/ckeditor/adapters/jquery.js',
  ];

  public function render()
  {
    $editor_id = $this->id;

    $this->script = <<<EOT
      $('textarea#{$editor_id}').ckeditor({
        language: 'hu',
        toolbar: [
          [ 'Undo', 'Redo' ],
          [ 'Styles', 'Bold', 'Italic', 'Underline', 'SpellChecker', 'Scayt', '-', 'NumberedList', 'BulletedList', 'SpecialChar' ],
          [ 'Link', 'Unlink' ],
          [ 'SelectAll', 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord' ],
          [ 'Preview', 'Maximize' ],
          [ 'Source' ]
        ]
      });
EOT;
    return parent::render();
  }
}
