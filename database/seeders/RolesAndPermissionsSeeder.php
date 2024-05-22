<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
  public function run()
  {
    // Reset cached roles and permissions
    app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

    // Create permissions
    Permission::create(['name' => 'create users']);
    Permission::create(['name' => 'edit users']);
    Permission::create(['name' => 'delete users']);

    // Create roles and assign existing permissions
    $roleSuperAdmin = Role::create(['name' => 'Super Admin']);
    $roleAdmin = Role::create(['name' => 'Admin']);
    $roleUser = Role::create(['name' => 'User']);

    $roleSuperAdmin->givePermissionTo(Permission::all());
    $roleAdmin->givePermissionTo(['create users', 'edit users', 'delete users']);
  }
}
