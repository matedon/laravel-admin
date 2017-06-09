<?php

namespace MAteDon\Admin\Grid\Displayers;

class DateFormat extends AbstractDisplayer
{
    public function display($format = 'y-m-d<\b\r>H:i:s')
    {
        return date($format, strtotime($this->value));
    }
}
