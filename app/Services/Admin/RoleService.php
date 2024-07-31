<?php
namespace App\Services\Admin;

use App\Repositories\Admin\RoleRepository;

class RoleService 
{
    protected $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function getAll()
    {
        return $this->roleRepository->getAll();
    }

    public function findRoleById($id)
    {
        return $this->roleRepository->findRoleById($id);
    }

    /**
     * 
     */
    public function createRole($request)
    {
        $data = $request->all();
        $data['gouard_name'] = 'web';

        if($request->has('permissions_id')) {
            $role = $this->roleRepository->create($data);
            $role->permissions()->attach($data['permissions_id']);
        } else {
            $role = $this->roleRepository->create($data);
        }
    }

    public function update($id, $request)
    {
        $role = $this->roleRepository->findRoleById($id);
        $dataUpdate = $request->all();
        $role->update($dataUpdate);
        $role->permissions()->sync($dataUpdate['permissions_id'] ?? []);
    }

    public function destroy($id)
    {
        $role = $this->roleRepository->findRoleById($id);
        if($role)
        {
            return $this->roleRepository->delete($role);
        }
        return false;
    }
}