<?php

namespace MAteDon\Admin\Form\Field;

class Ip extends Text
{
    protected $icon = 'fa-laptop';

    protected $rules = 'ip';

    protected static $js = [
        '/packages/admin/AdminLTE/plugins/input-mask/jquery.inputmask.bundle.min.js',
    ];

    /**
     * @see https://github.com/RobinHerbots/Inputmask#options
     *
     * @var array
     */
    protected $options = [
        'alias' => 'ip',
    ];

    public function render()
    {
        $options = json_encode($this->options);

        $this->script = <<<EOT
$('{$this->getElementClassSelector()}').inputmask($options);
EOT;

        return parent::render();
    }
}
