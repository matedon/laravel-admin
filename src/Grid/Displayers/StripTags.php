<?php

namespace MAteDon\Admin\Grid\Displayers;

class StripTags extends AbstractDisplayer
{
    public function display($limit = null, $dots = '...')
    {
        return strip_tags_plus($this->value, $limit, $dots);
    }
}
