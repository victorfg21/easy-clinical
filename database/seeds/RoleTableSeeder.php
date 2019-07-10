<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_employee = new Role();
        $role_employee->name = 'user';
        $role_employee->description = 'Usuário';
        $role_employee->save();

        $role_manager = new Role();
        $role_manager->name = 'superadministrator';
        $role_manager->description = 'Administrador';
        $role_manager->save();
    }
}
