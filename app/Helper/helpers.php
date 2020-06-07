<?php

if (! function_exists('const_exists')) {
    /**
     * @param string|object $class
     * @param string $const
     * @return bool
     */
    function const_exists($class, string $const)
    {
        if (is_object($class)) {
            $class = get_class($class);
        }

        if (!class_exists($class)) {
            return false;
        }

        try {
            $state = !empty($class::$const);
        } catch (Exception $e) {
            $state = false;
        }

        return $state;
    }
}

if (! function_exists('const_value')) {
    /**
     * @param string|object $class
     * @param string $const
     * @return mixed|null
     */
    function const_value($class, string $const)
    {
        return const_exists($class, $const) ? $class::$const : null;
    }
}

if (! function_exists('views_path')) {
    function views_path($path = null)
    {
        return resource_path('views/'. $path);
    }
}
