<?php

namespace MAteDon\Admin\Form\Field;

class Date extends Text
{
    protected static $css = [
        '/packages/admin/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
    ];

    protected static $js = [
        '/packages/admin/moment/min/moment-with-locales.min.js',
        '/packages/admin/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
    ];

    protected $format = 'YYYY-MM-DD';

    protected $icon = 'fa-calendar';

    public function format($format)
    {
        $this->format = $format;

        return $this;
    }

    public function prepare($value)
    {
        if ($value === '') {
            $value = null;
        }

        return $value;
    }

    public function render()
    {
        $this->options['format'] = $this->format;
        $this->options['locale'] = config('app.locale');

        $this->script = "$('{$this->getElementClassSelector()}').datetimepicker(".json_encode($this->options).');';

        return parent::render();
    }
}
