<?php

namespace MAteDon\Admin\Form\Field;

use MAteDon\Admin\Form\Field;

class SwitchField extends Field
{
    protected static $css = [
        '/packages/admin/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css',
    ];

    protected static $js = [
        '/packages/admin/bootstrap-switch/dist/js/bootstrap-switch.min.js',
    ];

    protected $states = [
        'null' => ['value' => null, 'text' => 'UNSET', 'color' => 'warning'],
        'off'  => ['value' => 0, 'text' => 'OFF', 'color' => 'default'],
        'on'   => ['value' => 1, 'text' => 'ON', 'color' => 'primary'],
    ];

    public function __construct($column, $arguments = [], $modelName = '')
    {
        $this->states['off']['text'] = admin_translate($modelName, $this->states['off']['text']);
        $this->states['on']['text'] = admin_translate($modelName, $this->states['on']['text']);
        parent::__construct($column, $arguments, $modelName);
    }

    public function states($states = [])
    {
        foreach (array_dot($states) as $key => $state) {
            array_set($this->states, $key, $state);
        }

        return $this;
    }

    public function prepare($value)
    {
        if (isset($this->states[$value])) {
            return $this->states[$value]['value'];
        }

        return $value;
    }

    public function render()
    {
        $fieldValue = $this->value();
        foreach ($this->states as $state => $option) {
            if ($fieldValue === $option['value']) {
                $this->value = $state;
                break;
            }
        }
        $this->setDataSet(array_extend([
            'bootstrapSwitch' => [
                'size'          => 'small',
                'offText'       => $this->states['off']['text'],
                'onText'        => $this->states['on']['text'],
                'offColor'      => $this->states['off']['color'],
                'onColor'       => $this->states['on']['color'],
                'indeterminate' => ($fieldValue === false ? true : false),
            ],
        ], $this->options));

        return parent::render();
    }
}
