<?php

namespace MAteDon\Admin\Form\Field;

class Icon extends Text
{
    protected $default = 'fa-fort-awesome';

    protected $icon = 'fa-fort-awesome';

    protected $view = 'admin::form.icon';

    protected static $css = [
        '/vendor/laravel-admin/fontawesome-iconpicker/dist/css/fontawesome-iconpicker.min.css',
    ];

    protected static $js = [
        '/vendor/laravel-admin/fontawesome-iconpicker/dist/js/fontawesome-iconpicker.min.js',
    ];
}
