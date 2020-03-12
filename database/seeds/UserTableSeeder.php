<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_profissional = Role::where('name', 'profissional')->first();
        $role_administrativo  = Role::where('name', 'superadministrator')->first();
        $role_paciente = Role::where('name', 'paciente')->first();
        $role_atendente  = Role::where('name', 'atendente')->first();

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('users')->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $manager = new User();
        $manager->name = 'Administrador';
        $manager->email = 'admin@mail.com';
        $manager->password = bcrypt('123@Mudar');
        $manager->save();
        $manager->roles()->attach($role_administrativo);

        $manager = new User();
        $manager->name = 'Usuario';
        $manager->email = 'usuario@mail.com';
        $manager->password = bcrypt('123@Mudar');
        $manager->save();
        $manager->roles()->attach($role_paciente);

        $manager = new User();
        $manager->name = 'Profissional';
        $manager->email = 'profissional@mail.com';
        $manager->password = bcrypt('123@Mudar');
        $manager->save();
        $manager->roles()->attach($role_profissional);

        $manager = new User();
        $manager->name = 'Atendente';
        $manager->email = 'atendente@mail.com';
        $manager->password = bcrypt('123@Mudar');
        $manager->save();
        $manager->roles()->attach($role_atendente);
    }
}
