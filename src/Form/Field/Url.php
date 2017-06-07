<?php

namespace MAteDon\Admin\Form\Field;

class Url extends Text
{
    protected $rules = 'url|nullable';

    protected $type = 'url';

    protected $icon = 'fa-globe';
}
