<?php

use Illuminate\Database\Seeder;
use App\Exame;
use App\ExameLinha;

class ExameTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $exame = new Exame();
        $exame->nome = 'VDRL';
        $exame->observacao = 'Nota: O resultado laboratorial indica o estado sorológico do indivíduo e deve ser associado ao seu histórico clínico e/ou epidemiológico.';
        $exame->exame_material_id = 2;
        $exame->exame_metodo_id = 5;
        $exame->save();

        $exameLinha = new ExameLinha();
        $exameLinha->exame_id = 1;
        $exameLinha->exame_grupo_id = 1;
        $exameLinha->descricao = '';
        $exameLinha->valor_min = 'NÃO REATOR';
        $exameLinha->valor_max = '';
        $exameLinha->unidade = '';
        $exameLinha->save();


        $exame = new Exame();
        $exame->nome = 'TSH';
        $exame->observacao = '';
        $exame->exame_material_id = 1;
        $exame->exame_metodo_id = 2;
        $exame->save();

        $exameLinha = new ExameLinha();
        $exameLinha->exame_id = 2;
        $exameLinha->exame_grupo_id = 1;
        $exameLinha->descricao = '';
        $exameLinha->valor_min = '0,35';
        $exameLinha->valor_max = '4,94';
        $exameLinha->unidade = 'mUI/ml';
        $exameLinha->save();


        $exame = new Exame();
        $exame->nome = 'T4 Livre';
        $exame->observacao = '';
        $exame->exame_material_id = 1;
        $exame->exame_metodo_id = 2;
        $exame->save();

        $exameLinha = new ExameLinha();
        $exameLinha->exame_id = 3;
        $exameLinha->exame_grupo_id = 1;
        $exameLinha->descricao = '';
        $exameLinha->valor_min = '0,70';
        $exameLinha->valor_max = '1,48';
        $exameLinha->unidade = 'ng/dl';
        $exameLinha->save();


        $exame = new Exame();
        $exame->nome = 'T3';
        $exame->observacao = '';
        $exame->exame_material_id = 1;
        $exame->exame_metodo_id = 6;
        $exame->save();

        $exameLinha = new ExameLinha();
        $exameLinha->exame_id = 4;
        $exameLinha->exame_grupo_id = 1;
        $exameLinha->descricao = '';
        $exameLinha->valor_min = '0,80';
        $exameLinha->valor_max = '2,00';
        $exameLinha->unidade = 'ng/ml';
        $exameLinha->save();


        $exame = new Exame();
        $exame->nome = 'Vitamina B12';
        $exame->observacao = '';
        $exame->exame_material_id = 1;
        $exame->exame_metodo_id = 2;
        $exame->save();

        $exameLinha = new ExameLinha();
        $exameLinha->exame_id = 5;
        $exameLinha->exame_grupo_id = 1;
        $exameLinha->descricao = '';
        $exameLinha->valor_min = '187,00';
        $exameLinha->valor_max = '883,00';
        $exameLinha->unidade = 'pg/ml';
        $exameLinha->save();


        $exame = new Exame();
        $exame->nome = 'Transaminase Oxalacética B12';
        $exame->observacao = '';
        $exame->exame_material_id = 1;
        $exame->exame_metodo_id = 7;
        $exame->save();

        $exameLinha = new ExameLinha();
        $exameLinha->exame_id = 6;
        $exameLinha->exame_grupo_id = 1;
        $exameLinha->descricao = '';
        $exameLinha->valor_min = '0';
        $exameLinha->valor_max = '40';
        $exameLinha->unidade = 'u/l';
        $exameLinha->save();


        $exame = new Exame();
        $exame->nome = 'Transaminase Pirúvica';
        $exame->observacao = '';
        $exame->exame_material_id = 1;
        $exame->exame_metodo_id = 7;
        $exame->save();

        $exameLinha = new ExameLinha();
        $exameLinha->exame_id = 7;
        $exameLinha->exame_grupo_id = 1;
        $exameLinha->descricao = '';
        $exameLinha->valor_min = '0';
        $exameLinha->valor_max = '41';
        $exameLinha->unidade = 'u/l';
        $exameLinha->save();


        $exame = new Exame();
        $exame->nome = 'Glicemia';
        $exame->observacao = '';
        $exame->exame_material_id = 3;
        $exame->exame_metodo_id = 8;
        $exame->save();

        $exameLinha = new ExameLinha();
        $exameLinha->exame_id = 8;
        $exameLinha->exame_grupo_id = 1;
        $exameLinha->descricao = '';
        $exameLinha->valor_min = '70';
        $exameLinha->valor_max = '100';
        $exameLinha->unidade = 'mg/dl';
        $exameLinha->save();


        $exame = new Exame();
        $exame->nome = 'Colesterol Total';
        $exame->observacao = '';
        $exame->exame_material_id = 1;
        $exame->exame_metodo_id = 9;
        $exame->save();

        $exameLinha = new ExameLinha();
        $exameLinha->exame_id = 9;
        $exameLinha->exame_grupo_id = 1;
        $exameLinha->descricao = 'Desejável -';
        $exameLinha->valor_min = '200';
        $exameLinha->valor_max = '';
        $exameLinha->unidade = 'mg/dl';
        $exameLinha->save();

        $exameLinha = new ExameLinha();
        $exameLinha->exame_id = 9;
        $exameLinha->exame_grupo_id = 1;
        $exameLinha->descricao = 'Limítrofe -';
        $exameLinha->valor_min = '200';
        $exameLinha->valor_max = '239';
        $exameLinha->unidade = 'mg/dl';
        $exameLinha->save();

        $exameLinha = new ExameLinha();
        $exameLinha->exame_id = 9;
        $exameLinha->exame_grupo_id = 1;
        $exameLinha->descricao = 'Elevado - Acima de';
        $exameLinha->valor_min = '240';
        $exameLinha->valor_max = '';
        $exameLinha->unidade = 'mg/dl';
        $exameLinha->save();

    }
}
