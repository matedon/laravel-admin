<?php

namespace MAteDon\Admin\Form\Field;

class TimeStamp extends Text
{
    protected $icon = 'fa-calendar';

    public function __construct($column, array $arguments = [], $modelName = '')
    {
        $this->readOnly();
        if ($column === 'created_at') {
            $this->icon = 'fa-calendar-plus-o';
        } elseif ($column === 'updated_at') {
            $this->icon = 'fa-calendar-check-o';
        }
        parent::__construct($column, $arguments, $modelName);
    }

}
