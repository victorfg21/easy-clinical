<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profissional extends Model
{
    protected $table = 'profissionais';

    protected $fillable = [
        'nome', 'rg', 'cpf', 'conselho', 'numero_registro', 
        'dt_nasc', 'sexo', 'celular', 'telefone', 'numero', 
        'endereco', 'complemento', 'bairro', 'cidade', 'estado', 
        'cep'
    ];

    public function User(){
        return $this->hasOne(\App\User::class, 'id', 'user_id');
    }

    public function Foto(){
        return $this->hasOne(\App\Foto::class, 'id', 'foto_id');
    }

    public function AreasAtuacao(){
        return $this->hasMany(AreaAtuacao::class);
    }

    public function Especialidades(){
        return $this->hasMany(\App\Especialidade::class);
    }
}
