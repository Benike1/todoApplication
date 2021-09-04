<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'TestUser',
            'email' => 'user@user.com',
            'password' => bcrypt('user')
        ]);

        $role = Role::create(['name' => 'User']);

        $permissions = Permission::whereIn('name', ['todo-list','todo-create', 'todo-edit'])->get();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);
    }
}
