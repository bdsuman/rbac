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

        $permission = new Permission();
        $permission->name = 'create-user';
        $permission->save();

        $role = new Role();
        $role->name = 'admin';
        $role->save();
        $role->permissions()->attach($permission);
        $permission->roles()->attach($role);

        $role = new Role();
        $role->name = 'manager';
        $role->save();
        $role->permissions()->attach($permission);
        $permission->roles()->attach($role);

        $role = new Role();
        $role->name = 'employee';
        $role->save();
        $role->permissions()->attach($permission);
        $permission->roles()->attach($role);





        $adminRole = Role::where('name', 'admin')->first();
        $managerRole = Role::where('name', 'manager')->first();
        $employeeRole = Role::where('name', 'employee')->first();
        $create_post = Permission::where('name', 'create-post')->first()->id;
        $create_user = Permission::where('name', 'create-user')->first()->id;
        $update_post = Permission::where('name', 'update-post')->first()->id;

        $admin = new User();
        $admin->name = 'Admin';
        $admin->email = 'admin@gmail.com';
        $admin->password = bcrypt('123456');
        $admin->save();
        $admin->roles()->attach($adminRole);
        $admin->permissions()->attach([$create_post,$create_user]);

        $user = new User();
        $user->name = 'Manager';
        $user->email = 'manager@gmail.com';
        $user->password = bcrypt('123456');
        $user->save();
        $user->roles()->attach($managerRole);
        $user->permissions()->attach($update_post);

        $user = new User();
        $user->name = 'Employee';
        $user->email = 'employee@gmail.com';
        $user->password = bcrypt('123456');
        $user->save();
        $user->roles()->attach($employeeRole);
        $user->permissions()->attach($create_post);
    }
}
