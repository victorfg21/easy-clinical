<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExameRealizado extends Model
{
    protected $table = 'exames_realizados';

    protected $fillable = [
        'val_resultado'
    ];

    public function Exame(){
        return $this->hasOne(Exame::class, 'id', 'exame_id');
    }

    public function SolicitacaoExame(){
        return $this->hasOne(SolicitacaoExame::class, 'id', 'solicitacao_exame_id');
    }

    public function SolicitacaoExameLinha(){
        return $this->hasOne(SolicitacaoExameLinha::class, 'id', 'solicitacao_exame_linha_id');
    }

    public function Profissional(){
        return $this->hasOne(Profissional::class, 'id', 'profissional_id');
    }
}
