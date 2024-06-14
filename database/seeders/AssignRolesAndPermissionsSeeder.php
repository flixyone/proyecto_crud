<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AssignRolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Crear roles
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'cliente']);

        // Crear permisos
        Permission::create(['name' => 'crear categorias']);
        Permission::create(['name' => 'editar categorias']);
        // Otros permisos...

        // Asignar roles a usuarios
        $adminRole = Role::findByName('admin');
        $clienteRole = Role::findByName('cliente');

        $adminUser = User::find(1); // Asignar al usuario con ID 1 como administrador
        $adminUser->assignRole($adminRole);

        // Asignar permisos a roles
        $adminRole->givePermissionTo('crear categorias');
        $adminRole->givePermissionTo('editar categorias');
        // Otros permisos...
    }
}
