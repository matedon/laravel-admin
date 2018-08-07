<?php

namespace MAteDon\Admin\Middleware;

use MAteDon\Admin\Form;
use MAteDon\Admin\Grid;
use Illuminate\Http\Request;

class Bootstrap
{
    public function handle(Request $request, \Closure $next)
    {
        Form::registerBuiltinFields();

        if (file_exists($bootstrap = admin_path('bootstrap.php'))) {
            require $bootstrap;
        }

        Form::collectFieldAssets();

        Grid::registerColumnDisplayer();

        return $next($request);
    }
}
