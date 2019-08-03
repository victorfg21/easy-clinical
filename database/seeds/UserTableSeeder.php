<?php

use Illuminate\Database\Seeder;
use App\User;
//use App\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$role_employee = Role::where('name', 'user')->first();
        //$role_manager  = Role::where('name', 'superadministrator')->first();

        $manager = new User();
        $manager->name = 'Administrador';
        $manager->email = 'admin@mail.com';
        $manager->password = bcrypt('123@Mudar');
        $manager->save();
        //$manager->roles()->attach($role_manager);
    }
}
