<?php

namespace MAteDon\Admin\Grid\Filter\Presenter;

use MAteDon\Admin\Facades\Admin;
use Illuminate\Contracts\Support\Arrayable;

class Select extends Presenter
{
    /**
     * Options of select.
     *
     * @var array
     */
    protected $options = [];

    /**
     * @var string
     */
    protected $script = '';

    /**
     * Select constructor.
     *
     * @param mixed $options
     */
    public function __construct($options)
    {
        $this->options = $options;
    }

    /**
     * Build options.
     *
     * @return array
     */
    protected function buildOptions() : array
    {
        if (is_string($this->options)) {
            $this->loadRemoteOptions($this->options);
        }

        if ($this->options instanceof \Closure) {
            $this->options = $this->options->call($this->filter, $this->filter->getValue());
        }

        if ($this->options instanceof Arrayable) {
            $this->options = $this->options->toArray();
        }

        if (empty($this->script)) {
            $placeholder = trans('admin::lang.choose');

            $this->script = <<<SCRIPT
$(".{$this->getElementClass()}").select2({
  placeholder: "$placeholder"
});

SCRIPT;
        }

        Admin::script($this->script);

        return is_array($this->options) ? $this->options : [];
    }

    /**
     * Load options from remote.
     *
     * @param string $url
     * @param array  $parameters
     * @param array  $options
     *
     * @return $this
     */
    protected function loadRemoteOptions($url, $parameters = [], $options = [])
    {
        $ajaxOptions = [
            'url' => $url.'?'.http_build_query($parameters),
        ];

        $ajaxOptions = json_encode(array_merge($ajaxOptions, $options));

        $this->script = <<<EOT

$.ajax($ajaxOptions).done(function(data) {
  $(".{$this->getElementClass()}").select2({data: data});
});

EOT;
    }

    /**
     * Load options from ajax.
     *
     * @param string $resourceUrl
     */
    public function ajax($resourceUrl)
    {
        $placeholder = trans('admin.choose');

        $this->script = <<<EOT

$(".{$this->getElementClass()}").select2({
  placeholder: "$placeholder",
  ajax: {
    url: "$resourceUrl",
    dataType: 'json',
    delay: 250,
    data: function (params) {
      return {
        q: params.term,
        page: params.page
      };
    },
    processResults: function (data, params) {
      params.page = params.page || 1;

      return {
        results: data.data,
        pagination: {
          more: data.next_page_url
        }
      };
    },
    cache: true
  },
  minimumInputLength: 1,
  escapeMarkup: function (markup) {
      return markup;
  }
});

EOT;
    }

    /**
     * @return array
     */
    public function variables() : array
    {
        return [
            'options' => $this->buildOptions(),
            'class'   => $this->getElementClass(),
        ];
    }

    /**
     * @return string
     */
    protected function getElementClass() : string
    {
        return str_replace('.', '_', $this->filter->getColumn());
    }

    /**
     * Load options for other select when change.
     *
     * @param string $target
     * @param string $resourceUrl
     * @param string $idField
     * @param string $textField
     *
     * @return $this
     */
    public function load($target, $resourceUrl, $idField = 'id', $textField = 'text') : self
    {
        $column = $this->filter->getColumn();

        $script = <<<EOT

$(document).on('change', ".{$this->getClass($column)}", function () {
    var target = $(this).closest('form').find(".{$this->getClass($target)}");
    $.get("$resourceUrl?q="+this.value, function (data) {
        target.find("option").remove();
        $.each(data, function (i, item) {
            $(target).append($('<option>', {
                value: item.$idField,
                text : item.$textField
            }));
        });
        
        $(target).trigger('change');
    });
});
EOT;

        Admin::script($script);

        return $this;
    }

    /**
     * Get form element class.
     *
     * @param string $target
     *
     * @return mixed
     */
    protected function getClass($target) : string
    {
        return str_replace('.', '_', $target);
    }
}
