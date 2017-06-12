<?php

namespace MAteDon\Admin\Grid\Displayers;

class Boolean extends AbstractDisplayer
{
    public function display()
    {
        return view('admin::display.boolean', ['value' => $this->value])->render();
    }
}
