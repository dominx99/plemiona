<?php

namespace App;

class Config
{
    protected static $path = __DIR__ . '/config//';

    /**
     * @param string $file
     * @return string|array|integer
     */
    public function get(string $route)
    {
        $pieces = explode('.', $route);

        $file = $pieces[0];
        unset($pieces[0]);

        $fullName = static::$path . $file . '.php';

        $result = require $fullName;

        if (!$pieces) {
            return $result;
        }

        foreach ($pieces as $piece) {
            if (!isset($result[$piece])) {
                return false;
            }

            $result = $result[$piece];
        }

        return $result;
    }
}
