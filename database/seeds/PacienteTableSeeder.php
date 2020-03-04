<?php

use Illuminate\Database\Seeder;
use App\Paciente;

class PacienteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pacientes = factory(App\Paciente::class, 20)->create();

        $profissional = Paciente::find(1);
        $profissional->user_id = 2;
        $profissional->update();
    }
}
