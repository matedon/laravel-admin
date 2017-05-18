<?php

namespace MAteDon\Admin\Form\Field;

class Email extends Text
{
    protected $rules = 'email';

    protected $type = 'email';

    protected $icon = 'fa-envelope-o';
}
