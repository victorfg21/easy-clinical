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
        $role_employee->name = 'profissional';
        $role_employee->description = 'Profissional';
        $role_employee->save();

        $role_employee = new Role();
        $role_employee->name = 'paciente';
        $role_employee->description = 'Paciente';
        $role_employee->save();

        $role_manager = new Role();
        $role_manager->name = 'superadministrator';
        $role_manager->description = 'Administrativo';
        $role_manager->save();


        $role_employee = new Role();
        $role_employee->name = 'atendente';
        $role_employee->description = 'Atendente';
        $role_employee->save();
    }
}
