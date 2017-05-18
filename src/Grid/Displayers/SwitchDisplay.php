<?php

namespace MAteDon\Admin\Grid\Displayers;

use MAteDon\Admin\Admin;
use MAteDon\Admin\Grid;
use MAteDon\Admin\Grid\Column;

class SwitchDisplay extends AbstractDisplayer
{
    protected $states = [
        'on'  => ['value' => 1, 'text' => 'ON', 'color' => 'primary'],
        'off' => ['value' => 0, 'text' => 'OFF', 'color' => 'default'],
    ];

    public function __construct($value, Grid $grid, Column $column, $row)
    {
        $modelName = $grid->getModelName();
        $this->states['on']['text'] = admin_translate($modelName, $this->states['on']['text']);
        $this->states['off']['text'] = admin_translate($modelName, $this->states['off']['text']);
        parent::__construct($value, $grid, $column, $row);
    }

    protected function updateStates($states)
    {
        foreach (array_dot($states) as $key => $state) {
            array_set($this->states, $key, $state);
        }
    }

    public function display($states = [])
    {
        $this->updateStates($states);

        $this->setDataSet([
            'url'             => $this->grid->resource() . '/' . $this->row->{$this->grid->getKeyName()},
            'bootstrapSwitch' => [
                'size'     => 'small',
                'onText'   => $this->states['on']['text'],
                'offText'  => $this->states['off']['text'],
                'onColor'  => $this->states['on']['color'],
                'offColor' => $this->states['off']['color']
            ],
        ]);

        return view('admin::display.switch', [
            'checked' => $this->states['on']['value'] == $this->value,
            'name'    => $this->column->getName(),
            'dataSet' => $this->getDataSetJson(),
        ])->render();
    }
}
