<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReceitaLinha extends Model
{
protected $table = 'receitas_linha';

    protected $fillable = [
        'dosagem'
    ];

    public function Medicamento(){
        return $this->hasOne(Medicamento::class, 'id', 'medicamento_id');
    }

    public function Receita(){
        return $this->hasMany(Receita::class, 'id', 'receita_id');
    }
}
