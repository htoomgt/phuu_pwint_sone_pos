<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();



        // create permissions
        Permission::create(['name' => 'make sale']);
        Permission::create(['name' => 'manage product']);
        Permission::create(['name' => 'manage user']);
        Permission::create(['name' => 'see super-admin']);
        Permission::create(['name' => 'check login-log']);
        Permission::create(['name' => 'see reports']);
        Permission::create(['name' => 'see dashboard']);
        Permission::create(['name' => 'setup system-setting']);
        Permission::create(['name' => 'edit system-setting']);


        $role = Role::create(['name' => 'super-admin']);
        $role->givePermissionTo(Permission::all());

        $role = Role::create(['name' => 'owner']);
        $role->givePermissionTo([
            'make sale',
            'manage product',
            'manage user',
            'see reports',
            'see dashboard',
            'setup system-setting',
            'edit system-setting'
        ]);



        $role = Role::create(['name' => 'sale-person'])
            ->givePermissionTo('make sale');





    }
}
