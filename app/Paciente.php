<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    protected $table = 'pacientes';

    protected $fillable = [
        'nome', 'rg', 'cpf', 'ih', 'dt_nasc', 'sexo', 
        'celular', 'numero', 'endereco', 'complemento', 
        'bairro', 'cidade', 'estado', 'cep'
    ];

    public function User(){
        return $this->hasOne(\App\User::class, 'id', 'user_id');
    }

    public function Foto(){
        return $this->hasOne(\App\Foto::class, 'id', 'foto_id');
    }
}
