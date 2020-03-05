<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receita extends Model
{
    protected $table = 'receitas';

    protected $fillable = [
        'observacao'
    ];

    public function ReceitaLinha(){
        return $this->belongsToMany(ReceitaLinha::class);
    }

    public function Consulta(){
        return $this->hasOne(Consulta::class, 'id', 'consulta_id');
    }
}
