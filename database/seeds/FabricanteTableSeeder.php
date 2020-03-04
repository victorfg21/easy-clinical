<?php

use Illuminate\Database\Seeder;
use App\Fabricante;

class FabricanteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $especialidade = new Fabricante();
        $especialidade->nome = 'Takeda Pharma Ltda.';
        $especialidade->save();

        $especialidade = new Fabricante();
        $especialidade->nome = 'Zydus Nikkho';
        $especialidade->save();

        $especialidade = new Fabricante();
        $especialidade->nome = 'Sanofi';
        $especialidade->save();

        $especialidade = new Fabricante();
        $especialidade->nome = 'Teuto';
        $especialidade->save();

        $especialidade = new Fabricante();
        $especialidade->nome = 'HL I.C.D.I.E.E. LTDA EPP';
        $especialidade->save();

        $especialidade = new Fabricante();
        $especialidade->nome = 'Nova Química';
        $especialidade->save();
    }
}
