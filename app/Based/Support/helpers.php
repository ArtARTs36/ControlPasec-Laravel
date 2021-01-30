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

        return defined("{$class}::{$const}");
    }
}

if (! function_exists('views_path')) {
    function views_path(?string $path = null): string
    {
        return resource_path('views/'. $path);
    }
}
