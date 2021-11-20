<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;

class BaseService implements ServiceInterface
{
    protected Model $model;

    /**
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function store(array $data)
    {
        return $this->model->newQuery()->forceCreate($data);
    }

    public function update(array $data, $id)
    {
        $object = $this->model->newQuery()->findOrFail($id);
        $object->fill($data);
        if ($object->isDirty()) {
            $object->save();
        }

        return $object;
    }

    public function destroy($id): void
    {
        $this->model->newQuery()->destroy($id);
    }
}