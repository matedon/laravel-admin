<?php

namespace MAteDon\Admin\Grid\Displayers;

class StripTags extends AbstractDisplayer
{
    public function display($limit = null, $dots = '...')
    {
        $out = strip_tags($this->value);
        $out = html_entity_decode($out);
        $out = preg_replace('/\s+/', ' ', $out);
        $out = preg_replace('/\r|\n/', '', $out);
        if (!is_null($limit) and is_numeric($limit) and $limit < mb_strlen($out)) {
            $out = mb_substr($out, 0, $limit);
            if ($dots) {
                $out .= $dots;
            }
        }
        return $out;
    }
}
