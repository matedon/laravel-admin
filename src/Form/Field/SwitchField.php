<?php

namespace MAteDon\Admin\Form\Field;

use MAteDon\Admin\Form\Field;

class SwitchField extends Field
{
    protected static $css = [
        '/vendor/laravel-admin/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css',
    ];

    protected static $js = [
        '/vendor/laravel-admin/bootstrap-switch/dist/js/bootstrap-switch.min.js',
    ];

    protected $states = [
        'null' => ['value' => null, 'text' => 'UNSET', 'color' => 'warning'],
        'on'  => ['value' => 1, 'text' => 'ON', 'color' => 'primary'],
        'off' => ['value' => 0, 'text' => 'OFF', 'color' => 'default'],
    ];

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
                'onSwitchChange' => "function(event, state) {
                    $(event.target).closest('.bootstrap-switch').next().val(state ? 'on' : 'off').change();
                }",
            ],
        ], $this->options));

        return parent::render();
    }
}
