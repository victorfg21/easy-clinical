<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Profissional;
use Faker\Generator as Faker;

$factory->define(Profissional::class, function (Faker $faker){
    return [
        'nome' => $faker->name('male'),
        'rg' => $faker->regexify('/[0-9]{8}/'),
        'cpf' => $faker->regexify('[0-9]{3}[0-9]{3}[0-9]{3}[0-9]{2}'),
        'dt_nasc' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'conselho' => 'CRM',
        'conselho_uf' => $faker->stateAbbr,
        'numero_registro' => $faker->unique()->randomNumber($nbDigits = 8),
        'sexo' => 'M',
        'user_id' => '1',
        'celular' => $faker->regexify('/[0-9]{11}/'),
        'telefone' => $faker->regexify('/[0-9]{10}/'),
        'numero' => $faker->buildingNumber,
        'endereco' => $faker->streetName,
        'bairro' => $faker->streetSuffix,
        'cidade' => $faker->city,
        'estado' => $faker->stateAbbr,
        'cep' => str_replace('.', '', str_replace('-', '', substr($faker->postcode , 0, 8)))
    ];
});
