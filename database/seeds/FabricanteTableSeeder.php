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
        $fabricante = new Fabricante();
        $fabricante->nome = 'Takeda Pharma Ltda.';
        $fabricante->save();

        $fabricante = new Fabricante();
        $fabricante->nome = 'Zydus Nikkho';
        $fabricante->save();

        $fabricante = new Fabricante();
        $fabricante->nome = 'Sanofi';
        $fabricante->save();

        $fabricante = new Fabricante();
        $fabricante->nome = 'Teuto';
        $fabricante->save();

        $fabricante = new Fabricante();
        $fabricante->nome = 'HL I.C.D.I.E.E. LTDA EPP';
        $fabricante->save();

        $fabricante = new Fabricante();
        $fabricante->nome = 'Nova Química';
        $fabricante->save();
    }
}
