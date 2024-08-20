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

    public function createRole($request)
    {
        $data = $request->all();
        $data['guard_name'] = 'web';

        if($request->has('permission_ids')) {
            $role = $this->roleRepository->create($data);
            $role->permissions()->attach($data['permission_ids']);
        } else {
            $role = $this->roleRepository->create($data);
        }
    }

    public function update($id, $request)
    {
        $role = $this->roleRepository->findRoleById($id);
        $dataUpdate = $request->all();
        $role->update($dataUpdate);
        $role->permissions()->sync($dataUpdate['permission_ids'] ?? []);
    }

    public function destroy($id)
    {
        return $this->roleRepository->findRoleById($id)->delete();
    }
}