<?php

namespace MAteDon\Admin\Facades;

use Illuminate\Support\Facades\Facade;

class Admin extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \MAteDon\Admin\Admin::class;
    }
}
