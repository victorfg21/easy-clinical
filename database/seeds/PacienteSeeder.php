<?php

use Illuminate\Database\Seeder;
use App\Cliente;

class PacienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dados = [
            [
                'nome' => "Iago Caio da Costa",
                'rg' => "10.763.371-1",
                'cpf' => "41632375699",
                'ih' => "0000001",
                'sexo' => "M",
                'nascimento' => "19960426",
                'email' => "admiagocaiodacosta_@ipk.org.br",
                'celular' => "31981829172",
                'numero' => "762",
                'endereco' => "Saião",
                'bairro' => "Chácaras Madalena",
                'cidade' => "Ipatinga",
                'estado' => "MG",
                'cep' => "35162872",
                'user_id' => "1",
            ]
        ];
        
        DB::table('pacientes')->insert($dados);
    }
}
