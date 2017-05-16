<?php

namespace MAteDon\Admin\Form\Field;

use MAteDon\Admin\Form\Field;

class Id extends Text
{
    protected $icon = 'fa-key';

    public function __construct($column, array $arguments = [], $modelName = '')
    {
        $this->readOnly();
        parent::__construct($column, $arguments, $modelName);
    }
}
