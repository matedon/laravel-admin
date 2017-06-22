<?php

namespace MAteDon\Admin\Form\Field;

class Mobile extends Text
{
    protected $type = 'phone';

    protected $icon = 'fa-phone';

    protected static $js = [
        '/packages/admin/AdminLTE/plugins/input-mask/jquery.inputmask.bundle.min.js',
        '/packages/admin/AdminLTE/plugins/input-mask/inputmask/phone-codes/phone.min.js',
    ];

    /**
     * @see https://github.com/RobinHerbots/Inputmask#options
     *
     * @var array
     */
    protected $options = [
        'mask' => '+99999999999',
    ];

    public function render()
    {
        if (!empty($this->options)) {
            $options = json_encode($this->options);
        } else {
            $options = '"phone"';
        }

        $this->script = "$('{$this->getElementClassSelector()}').inputmask($options);";

        return parent::render();
    }
}
