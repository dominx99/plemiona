<?php

namespace App\Twig;

use App\Config;

class ConfigExtension extends \Twig_Extension
{
    protected $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('config', [$this, 'config']),
        ];
    }

    public function config($route)
    {
        return $this->config->get($route);
    }
}
