<?php

use Illuminate\Database\Seeder;
use App\Profissional;

class ProfissionalTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $profissionais = factory(App\Profissional::class, 3)->create();

        $profissional = Profissional::find(3);
        $profissional->user_id = 3;
        $profissional->update();
    }
}
