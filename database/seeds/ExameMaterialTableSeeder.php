<?php

use Illuminate\Database\Seeder;
use App\ExameMaterial;

class ExameMaterialTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $material = new ExameMaterial();
        $material->nome = 'Soro';
        $material->save();
    }
}
