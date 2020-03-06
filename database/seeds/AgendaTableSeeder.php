<?php

use App\Agenda;
use Illuminate\Database\Seeder;

class AgendaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $agenda = new Agenda();
        $agenda->segunda = true;
        $agenda->terca = true;
        $agenda->quarta = true;
        $agenda->quinta = true;
        $agenda->sexta = true;
        $agenda->sabado = false;
        $agenda->domingo = false;
        $agenda->inicio_periodo = '2020-01-01';
        $agenda->fim_periodo = '2020-12-31';
        $agenda->tempo_consulta = '00:30';
        $agenda->inicio_horario_1 = '08:00';
        $agenda->fim_horario_1 = '12:00';
        $agenda->inicio_horario_2 = '18:00';
        $agenda->fim_horario_2 = '23:30';
        $agenda->profissional_id = 3;
        $agenda->ativo = false;
        $agenda->save();
    }
}
