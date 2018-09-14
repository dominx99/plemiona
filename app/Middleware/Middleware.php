<?php

namespace App\Middleware;

use Slim\Container;

class Middleware
{
    /**
     * @var \Slim\Container
     */
    protected $container;

    /**
     * @param \Slim\Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }
}
