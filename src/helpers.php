<?php

if (!function_exists('admin_path')) {

    /**
     * Get admin path.
     *
     * @param string $path
     *
     * @return string
     */
    function admin_path($path = '')
    {
        return ucfirst(config('admin.directory')).($path ? DIRECTORY_SEPARATOR.$path : $path);
    }
}

if (!function_exists('admin_url')) {
    /**
     * Get admin url.
     *
     * @param string $path
     * @param mixed  $parameters
     * @param bool   $secure
     *
     * @return string
     */
    function admin_url($path = '', $parameters = [], $secure = null)
    {
        if (\Illuminate\Support\Facades\URL::isValidUrl($path)) {
            return $path;
        }

        $secure = $secure ?: config('admin.secure');

        return url(admin_base_path($path), $parameters, $secure);
    }
}

if (!function_exists('admin_base_path')) {
    /**
     * Get admin url.
     *
     * @param string $path
     *
     * @return string
     */
    function admin_base_path($path = '')
    {
        $prefix = '/'.trim(config('admin.route.prefix'), '/');

        $prefix = ($prefix == '/') ? '' : $prefix;

        return $prefix.'/'.trim($path, '/');
    }
}

if (!function_exists('admin_toastr')) {

    /**
     * Flash a toastr message bag to session.
     *
     * @param string $message
     * @param string $type
     * @param array  $options
     *
     * @return string
     */
    function admin_toastr($message = '', $type = 'success', $options = [])
    {
        $toastr = new \Illuminate\Support\MessageBag(get_defined_vars());

        \Illuminate\Support\Facades\Session::flash('toastr', $toastr);
    }
}

if (!function_exists('admin_asset')) {

    /**
     * @param $path
     *
     * @return string
     */
    function admin_asset($path)
    {
        return asset($path, config('admin.secure'));
    }
}

if (!function_exists('array_delete')) {

    /**
     * Delete from array by value.
     *
     * @param array $array
     * @param mixed $value
     */
    function array_delete(&$array, $value)
    {
        foreach ($array as $index => $item) {
            if ($value == $item) {
                unset($array[$index]);
            }
        }
    }
}

if (!function_exists('admin_translate')) {

    /**
     * Now you can add your own translate files for your project.
     * The "laravel-admin" will search for the translations in these sequence:
     * A.) admin.modelName.columnName
     * B.) admin.columnName
     * C.) Column name with spaces (dots and underscore replaced with spaces)
     * D.) Fallback
     * If you have translation A, that will be used, if not then B.
     * If there is no translation at all:
     * if exists the fallback D else the C will be the output.
     *
     * @param $modelPath
     * @param $column
     * @param null $fallback
     * @return string
     */
    function admin_translate($modelPath, $column, $fallback = null)
    {
        $nameList = explode('\\', $modelPath);
        /*
         * CamelCase model name converted to underscore name version.
         * ExampleString => example_strinig
         */
        $modelName = ltrim(strtolower(preg_replace('/[A-Z]([A-Z](?![a-z]))*/', '_$0', end($nameList))), '_');
        /*
         * ExampleString with banana => example_string_with_banana
         */
        $columnLower = ltrim(strtolower(preg_replace('/[A-Z ]([A-Z](?![a-z]))*/', '_$0', $column)), '_');
        /*
         * example_  string _with_banana => example_string_with_banana
         */
        $columnLower = preg_replace('!\s+!', '', $columnLower);
        /*
         * example__sring_____with_banana => example_string_with_banana
         */
        $columnLower = preg_replace('!_+!', '_', $columnLower);
        /*
         * The possible translate keys in priority order.
         */
        $transLateKeys = [
            'admin.' . $modelName . '.' . $columnLower,
            'admin.' . $columnLower,
            'validation.attributes.' . $columnLower,
        ];
        $label = null;
        foreach ($transLateKeys as $key) {
            if (Lang::has($key)) {
                $label = trans($key);
                break;
            }
        }
        if (!$label) {
            $label = str_replace(['.', '_'], ' ', $fallback ? $fallback : ucfirst($column));
        }
        return (string)$label;
    }
}

if (!function_exists('composer_json')) {
    /**
     * Read variables from the vendor project's composer.json file.
     *
     * @param $key
     * @return mixed
     */
    function composer_json($key = null)
    {
        $path = realpath(dirname(__FILE__)) . '/../composer.json';
        if (file_exists($path)) {
            $composer = json_decode(file_get_contents($path), true);
            if (is_null($key)) {
                return $composer;
            }
            if (isset($composer[$key])) {
                return $composer[$key];
            }
        }
    }
}

if (!function_exists('array_extend')) {
    /*
     * Extend arrays as in jQuery
     * It's like array_merge_recursive but common depth values are overwritten.
     */
    function array_extend()
    {
        $arrays = func_get_args();
        $base = array_shift($arrays);
        foreach ($arrays as $array) {
            reset($base);
            while (list($key, $value) = @each($array)) {
                if (is_array($value) && @is_array($base[$key])) {
                    $base[$key] = array_extend($base[$key], $value);
                } else {
                    $base[$key] = $value;
                }
            }
        }
        return $base;
    }
}

if (!function_exists('strip_tags_plus')) {
    /*
     * Extend arrays as in jQuery
     * It's like array_merge_recursive but common depth values are overwritten.
     */
    function strip_tags_plus($value, $limit = null, $dots = '...')
    {

        $out = strip_tags($value);
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