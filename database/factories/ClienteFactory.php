<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Cliente;
use Faker\Generator as Faker;

$factory->define(Cliente::class, function (Faker $faker) {

    return [
        'nome' => $faker->name('male'),
        'rg' => $faker->regexify('/[0-9]{8}/'),
        'cpf' => $faker->regexify('[0-9]{3}[0-9]{3}[0-9]{3}[0-9]{2}'),
        'dt_nasc' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'sexo' => 'M',
        'email' => $faker->unique()->freeEmail,
        'celular' => $faker->regexify('/[0-9]{11}/'),
        'numero' => $faker->buildingNumber,
        'endereco' => $faker->streetName,
        'bairro' => $faker->streetSuffix,
        'cidade' => $faker->city,
        'estado' => $faker->stateAbbr,
        'cep' => str_replace('-', '', $faker->postcode),
        'url' => $faker->url,
        'facebook' => $faker->url,
        'instagram' => $faker->url,
    ];
});
