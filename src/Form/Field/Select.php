<?php

namespace MAteDon\Admin\Form\Field;

use MAteDon\Admin\Facades\Admin;
use MAteDon\Admin\Form\Field;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;

class Select extends Field
{
    protected static $css = [
        '/packages/admin/AdminLTE/plugins/select2/select2.min.css',
    ];

    protected static $js = [
        '/packages/admin/AdminLTE/plugins/select2/select2.full.min.js',
    ];

    public function prepare($value)
    {
        if ($value === 'null') {
            return null;
        }
        return $value;
    }

    public function render()
    {
        $this->extendDataSet([
            'select2' => [
                'allowClear'  => true,
                'placeholder' => $this->label,
            ],
        ]);

        if ($this->options instanceof \Closure) {
            if ($this->form) {
                $this->options = $this->options->bindTo($this->form->model());
            }

            $this->options(call_user_func($this->options, $this->value));
        }

        $this->options = array_filter($this->options);

        $this->value = is_null($this->value) ? 'null' : $this->value;
        $this->value = $this->value ? $this->value : key($this->options);
        $this->value = old($this->column, $this->value);

        return parent::render()->with(['options' => $this->options]);
    }

    /**
     * Set options.
     *
     * @param array|callable|string $options
     *
     * @return $this|mixed
     */
    public function options($options = [])
    {
        // remote options
        if (is_string($options)) {
            return call_user_func_array([$this, 'loadOptionsFromRemote'], func_get_args());
        }

        if ($options instanceof Arrayable) {
            $options = $options->toArray();
        }

        if (is_callable($options)) {
            $this->options = $options;
        } else {
            $this->options = (array)$options;
        }

        return $this;
    }

    /**
     * Load options for other select on change.
     *
     * @param string $field
     * @param string $sourceUrl
     * @param string $idField
     * @param string $textField
     *
     * @return $this
     */
    public function load($field, $sourceUrl, $idField = 'id', $textField = 'text')
    {
        if (Str::contains($field, '.')) {
            $field = $this->formatName($field);
            $class = str_replace(['[', ']'], '_', $field);
        } else {
            $class = $field;
        }

        // TODO: move all js code to scripts/fields/select.js

        $script = <<<EOT

$(document).on('change', "{$this->getElementClassSelector()}", function () {
    var target = $(this).closest('.fields-group').find(".$class");
    $.get("$sourceUrl?q="+this.value, function (data) {
        target.find("option").remove();
        $(target).select2({
            data: $.map(data, function (d) {
                d.id = d.$idField;
                d.text = d.$textField;
                return d;
            })
        }).trigger('change');
    });
});
EOT;

        Admin::script($script);

        return $this;
    }

    /**
     * Load options from remote.
     *
     * @param string $url
     * @param array $parameters
     * @param array $options
     *
     * @return $this
     */
    protected function loadOptionsFromRemote($url, $parameters = [], $options = [])
    {
        $ajaxOptions = [
            'url' => $url . '?' . http_build_query($parameters),
        ];

        $ajaxOptions = json_encode(array_merge($ajaxOptions, $options));

        // TODO: move all js code to scripts/fields/select.js

        $this->script = <<<EOT

$.ajax($ajaxOptions).done(function(data) {
  $("{$this->getElementClassSelector()}").select2({data: data});
});

EOT;

        return $this;
    }

    /**
     * Load options from ajax results.
     *
     * @param string $url
     * @param $idField
     * @param $textField
     *
     * @return $this
     */
    public function ajax($url, $idField = 'id', $textField = 'text')
    {
        $this->extendDataSet([
            'ajax'    => true,
            'url'     => $url,
            'fields'  => [
                'id'   => $idField,
                'text' => $textField
            ],
            'select2' => [],
        ]);

        return $this;
    }
}
