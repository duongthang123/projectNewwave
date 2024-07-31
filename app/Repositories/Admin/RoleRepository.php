<?php

namespace App\Repositories\Admin;

use App\Models\Role;

class RoleRepository
{
    protected $role;

    public function __construct(Role $role)
    {
        $this->role = $role;
    }

    public function getAll($limit = 10)
    {
        return $this->role::latest('id')->paginate($limit);
    }

    public function findRoleById($id)
    {
        return $this->role::with('permissions')->findOrFail($id);
    }

    public function create($data)
    {
        return $this->role::create($data);
    }

    public function delete($role)
    {
        return $role->delete();
    }
}