<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $permission = new Permission();
        $permission->name = 'create-post';
        $permission->save();

        $permission = new Permission();
        $permission->name = 'read-post';
        $permission->save();

        $permission = new Permission();
        $permission->name = 'update-post';
        $permission->save();

        $permission = new Permission();
        $permission->name = 'delete-post';
        $permission->save();

        $role = new Role();
        $role->name = 'Super Admin';
        $role->save();
        $role->permissions()->attach($permission);
        $permission->roles()->attach($role);

        $superAdminRole = Role::where('name', 'Super Admin')->first();

        $super = new User();
        $super->name = 'Admin';
        $super->role = 'Super Admin';
        $super->email = 'super@gmail.com';
        $super->password = bcrypt('123456');
        $super->save();
        $super->roles()->attach($superAdminRole);

    }
}
