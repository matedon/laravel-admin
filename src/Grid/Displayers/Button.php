<?php

namespace MAteDon\Admin\Grid\Displayers;

class Button extends AbstractDisplayer
{
    public function display($styleArray = [])
    {
        $style = collect((array)$styleArray)->map(function ($styleBit) {
            return 'btn-' . $styleBit;
        })->implode(' ');

        return "<span class='btn $style'>{$this->value}</span>";
    }
}
