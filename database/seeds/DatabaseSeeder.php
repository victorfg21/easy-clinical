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
        $this->call(ProfissionalTableSeeder::class);
        $this->call(PacienteTableSeeder::class);
        $this->call(AreaAtuacaoTableSeeder::class);
        $this->call(EspecialidadeTableSeeder::class);
        $this->call(ExameGrupoTableSeeder::class);
        $this->call(ExameMaterialTableSeeder::class);
        $this->call(ExameMetodoTableSeeder::class);
        $this->call(ExameTableSeeder::class);
        $this->call(FabricanteTableSeeder::class);
        $this->call(MedicamentoTableSeeder::class);
        $this->call(AgendaTableSeeder::class);
    }
}
