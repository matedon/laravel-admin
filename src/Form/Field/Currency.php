<?php

namespace MAteDon\Admin\Form\Field;

class Currency extends Text
{
    protected $icon = 'fa-dollar';

    protected static $js = [
        '/packages/admin/AdminLTE/plugins/input-mask/jquery.inputmask.bundle.min.js',
    ];

    /**
     * @see https://github.com/RobinHerbots/Inputmask#options
     *
     * @var array
     */
    protected $options = [
        'alias'              => 'currency',
        'radixPoint'         => '.',
        'prefix'             => '',
        'removeMaskOnSubmit' => true,
    ];

    public function prepare($value)
    {
        return (float)$value;
    }

    public function render()
    {
        $options = json_encode($this->options);

        $this->script = "$('{$this->getElementClassSelector()}').inputmask($options);";

        return parent::render();
    }
}
