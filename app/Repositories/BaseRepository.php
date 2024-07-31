<?php

namespace App\Repositories;

abstract class BaseRepository implements RepositoryInterface
{
    protected $model;

    public function __construct()
    {
        $this->setModel();
    }

    abstract function getModel();

    public function setModel()
    {
        $this->model = app()->make(
            $this->getModel()
        );
    }

    public function getAll($limit = 10)
    {
        return $this->model::latest('id')->paginate($limit);
    }

    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    public function create($attributes = [])
    {
        return $this->model->create($attributes);
    }

    public function update($attributes = [], $id)
    {
        $result = $this->find($id);
        if($result) {
            $result->update($attributes);
            return $result;
        }
        return false;
    }

    public function delete($id)
    {
        $result = $this->find($id);
        if($result) {
            return $result->delete();
        }
        return false;
    }

}