<?php


namespace Acfabro\Assignment2\Helpers;


class Env
{
    /**
     * Environment Variable helper
     * @param string $name Environment variable name
     * @param string $default Default value if env variable is missing
     * @return string|null
     */
    public static function get($name, $default = null)
    {
        return isset($_ENV[$name]) ? $_ENV[$name] : $default;
    }
}