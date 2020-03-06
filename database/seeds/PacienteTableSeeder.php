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

        $paciente = Paciente::find(1);
        $paciente->user_id = 2;
        $paciente->update();
    }
}
