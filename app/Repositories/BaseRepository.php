<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class BaseRepository implements RepositoryInterface
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all($columns = ['*'])
    {
        return $this->model
            ->newQuery()
            ->select($columns)
            ->get();
    }

    public function show(int $id)
    {
        return $this->model->newQuery()->findOrFail($id);
    }
}