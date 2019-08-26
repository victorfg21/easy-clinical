<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Paciente;
use Faker\Generator as Faker;

$autoIncrement = autoIncrement();

$factory->define(Paciente::class, function (Faker $faker) use ($autoIncrement){
    $autoIncrement->next();
    return [
        'nome' => $faker->name('male'),
        'rg' => $faker->regexify('/[0-9]{8}/'),
        'cpf' => $faker->regexify('[0-9]{3}[0-9]{3}[0-9]{3}[0-9]{2}'),
        'ih' => str_pad($autoIncrement->current(), 7, "0", STR_PAD_LEFT),
        'dt_nasc' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'sexo' => 'M',
        'user_id' => '1',
        'celular' => $faker->regexify('/[0-9]{11}/'),
        'numero' => $faker->buildingNumber,
        'endereco' => $faker->streetName,
        'bairro' => $faker->streetSuffix,
        'cidade' => $faker->city,
        'estado' => $faker->stateAbbr,
        'cep' => str_replace('.', '', str_replace('-', '', substr($faker->postcode , 0, 8)))
    ];
});

function autoIncrement()
{
    for ($i = 0; $i < 1000; $i++) {
        yield $i;
    }
}
