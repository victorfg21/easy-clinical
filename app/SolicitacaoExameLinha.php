<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SolicitacaoExameLinha extends Model
{
protected $table = 'exames_linha';

    protected $fillable = [
        'realizado'
    ];

    public function Exame(){
        return $this->hasOne(Exame::class, 'id', 'exame_id');
    }

    public function SolicitacaoExame(){
        return $this->hasMany(SolicitacaoExame::class, 'id', 'solicitacao_exame_id');
    }
}
