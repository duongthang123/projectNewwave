<?php

namespace App\Repositories;

interface RepositoryInterface
{
    public function getAll();

    public function find($id);

    public function create($attributes = []);

    public function update($attributes = [], $id);
    
    public function delete($id);
}