<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleManager extends Component
{
    public $roles;
    public $newRoleName = '';

    // Editing permissions fields
    public $editingRoleId = null;
    public $selectedPermissions = [];

    protected $rules = [
        'newRoleName' => 'required|string|min:3|unique:roles,name',
    ];

    public function mount()
    {
        $this->loadRoles();
    }

    public function loadRoles()
    {
        $this->roles = Role::with('permissions')->get();
    }

    public function createRole()
    {
        $this->validate();

        Role::create(['name' => $this->newRoleName]);

        $this->newRoleName = '';
        $this->loadRoles();
        session()->flash('role_message', 'Rol creado con éxito.');
    }

    public function deleteRole($id)
    {
        $role = Role::findOrFail($id);
        
        // Prevent deleting core roles
        if (in_array($role->name, ['admin', 'student'])) {
            session()->flash('role_error', 'No se pueden eliminar los roles principales "admin" o "student".');
            return;
        }

        $role->delete();
        $this->loadRoles();
        session()->flash('role_message', 'Rol eliminado con éxito.');
    }

    public function openEditPermissionsModal($id)
    {
        $role = Role::findOrFail($id);
        $this->editingRoleId = $id;
        $this->selectedPermissions = $role->permissions->pluck('name')->toArray();
    }

    public function savePermissions()
    {
        $role = Role::findOrFail($this->editingRoleId);
        $role->syncPermissions($this->selectedPermissions);

        $this->editingRoleId = null;
        $this->loadRoles();
        session()->flash('role_message', 'Permisos del rol actualizados con éxito.');
    }

    public function render()
    {
        // Define some standard permissions for course platform
        $allPermissions = [
            'access admin panel' => 'Acceder al panel de administración',
            'manage courses' => 'Administrar cursos, secciones y lecciones',
            'manage payments' => 'Aprobar transferencias y ver ventas',
            'manage settings' => 'Modificar pasarelas de pago y ajustes',
            'manage roles' => 'Administrar roles y permisos de usuarios',
            'manage design' => 'Modificar la página de inicio (Constructor Visual)',
        ];

        // Ensure permissions exist in database
        foreach ($allPermissions as $permName => $desc) {
            Permission::firstOrCreate(['name' => $permName]);
        }

        $permissions = Permission::all();

        return view('livewire.admin.role-manager', compact('permissions'))
            ->layout('layouts.admin');
    }
}
