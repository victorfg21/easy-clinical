<?php

use Illuminate\Database\Seeder;
use App\ExameGrupo;

class ExameGrupoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $grupo = new ExameGrupo();
        $grupo->nome = 'Adulto';
        $grupo->save();

        $grupo = new ExameGrupo();
        $grupo->nome = 'Criança';
        $grupo->save();

        $grupo = new ExameGrupo();
        $grupo->nome = 'Idoso';
        $grupo->save();

        $grupo = new ExameGrupo();
        $grupo->nome = 'Mulher';
        $grupo->save();

        $grupo = new ExameGrupo();
        $grupo->nome = 'Homem';
        $grupo->save();

        $grupo = new ExameGrupo();
        $grupo->nome = 'Risco';
        $grupo->save();
    }
}
