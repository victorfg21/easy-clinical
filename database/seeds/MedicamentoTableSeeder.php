<?php

use Illuminate\Database\Seeder;
use App\Medicamento;

class MedicamentoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $medicamento = new Medicamento();
        $medicamento->nome_generico = 'Sulfato de Neomicina';
        $medicamento->nome_fabrica = 'Nebacetin';
        $medicamento->fabricante_id = 1;
        $medicamento->save();

        $medicamento = new Medicamento();
        $medicamento->nome_generico = 'Aspartato de Arginina';
        $medicamento->nome_fabrica = 'Reforgan';
        $medicamento->fabricante_id = 2;
        $medicamento->save();

        $medicamento = new Medicamento();
        $medicamento->nome_generico = 'Levotiroxina Sódica';
        $medicamento->nome_fabrica = 'Puran T4';
        $medicamento->fabricante_id = 3;
        $medicamento->save();

        $medicamento = new Medicamento();
        $medicamento->nome_generico = 'Nitrofurantoína';
        $medicamento->nome_fabrica = 'Macrodantina';
        $medicamento->fabricante_id = 4;
        $medicamento->save();

        $medicamento = new Medicamento();
        $medicamento->nome_generico = 'Cafeína Capsula';
        $medicamento->nome_fabrica = 'Borg Cafeína';
        $medicamento->fabricante_id = 5;
        $medicamento->save();

        $medicamento = new Medicamento();
        $medicamento->nome_generico = 'Pomada Cetoconazol';
        $medicamento->nome_fabrica = 'Pomada Cetoconazol';
        $medicamento->fabricante_id = 6;
        $medicamento->save();
    }
}
