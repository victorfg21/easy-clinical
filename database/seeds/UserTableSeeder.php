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
        $manager = new User();
        $manager->name = 'Administrador';
        $manager->email = 'admin@mail.com';
        $manager->password = bcrypt('123@Mudar');
        $manager->tipo_cadastro = Config::get('constants.options.administrativo');
        $manager->save();

        $manager = new User();
        $manager->name = 'Usuario';
        $manager->email = 'usuario@mail.com';
        $manager->password = bcrypt('123@Mudar');
        $manager->tipo_cadastro = Config::get('constants.options.paciente');
        $manager->save();
        //$manager->roles()->attach($role_manager);
    }
}
