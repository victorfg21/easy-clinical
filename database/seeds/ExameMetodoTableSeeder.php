<?php

use Illuminate\Database\Seeder;
use App\ExameMetodo;

class ExameMetodoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $metodo = new ExameMetodo();
        $metodo->nome = 'Glicerol fosfato oxidase';
        $metodo->save();

        $metodo = new ExameMetodo();
        $metodo->nome = 'Quimioluminescência';
        $metodo->save();

        $metodo = new ExameMetodo();
        $metodo->nome = 'NADH (sem P-5\'-P)';
        $metodo->save();

        $metodo = new ExameMetodo();
        $metodo->nome = 'Eletrodo-Seletivo';
        $metodo->save();
    }
}
