<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SolicitacaoExame extends Model
{
    protected $table = 'solicitacoes_exames';

    protected $fillable = [
        'observacao'
    ];

    public function SolicitacaoExameLinha(){
        return $this->belongsToMany(SolicitacaoExameLinha::class);
    }
    
    public function Consulta(){
        return $this->hasOne(Consulta::class, 'id', 'consulta_id');
    }
}
