<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Slim\Container;

abstract class AbstractRepository
{
    protected $modelNamespace = '\\App\\Models';

    /**
     * @var \Slim\Container $container
     */
    protected $container;

    /**
     * @param \Slim\Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param integer $id
     * @param string|array|null $with
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function find(int $id, $with = null)
    {
        $model = $this->model();

        if ($with) {
            return $model = $model::with($with)->find($id);
        }

        return $model::find($id);
    }

    /**
     * @return string
     */
    public function model(): string
    {
        $model = get_called_class();
        $model = str_replace('\\', '/', $model);
        $model = basename($model);
        $model = str_replace('Repository', null, $model);
        $model = Str::singular($model);

        return $this->modelNamespace . '\\' . $model;
    }
}
