<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserTableSeeder::class);
        $pacientes = factory(App\Paciente::class, 20)->create();
        $profissionais = factory(App\Profissional::class, 3)->create();
        $this->call(AreaAtuacaoTableSeeder::class);
        $this->call(EspecialidadeTableSeeder::class);
        $this->call(ExameGrupoTableSeeder::class);
        $this->call(ExameMaterialTableSeeder::class);
        $this->call(ExameMetodoTableSeeder::class);
    }
}
