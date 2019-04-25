<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Role comes before User seeder here.
        // $this->call(RoleTableSeeder::class);
        // User seeder will use the roles above created.
        // $this->call(UserTableSeeder::class);
        
        $role_admin = new Role();
        $role_admin->name = 'admin';
        $role_admin->description = 'An administrator';
        $role_admin->save();

        $role_user = new Role();
        $role_user->name = 'user';
        $role_user->description = 'A user';
        $role_user->save();
        
        //$role_user = Role::where('name', 'user')->first();
        //$role_admin  = Role::where('name', 'admin')->first();

        $user = new User();
        $user->name = 'Joe Bloggs';
        $user->email = 'joe@bloggs.com';
        $user->password = bcrypt('secret');
        $user->save();
        $user->roles()->attach($role_user);

        $admin = new User();
        $admin->name = 'Mary Bloggs';
        $admin->email = 'mary@bloggs.com';
        $admin->password = bcrypt('secret');
        $admin->save();
        $admin->roles()->attach($role_admin);
    }
}
