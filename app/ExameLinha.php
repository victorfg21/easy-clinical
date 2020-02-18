<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ExameLinha extends Model
{
    protected $table = 'exames_linha';

    protected $fillable = [
        'descricao', 'tipo_valor', 'valor_simples', 'valor_min', 'valor_max', 'unidade'
    ];

    public function ExameGrupo(){
        return $this->hasOne(ExameGrupo::class, 'id', 'exame_grupo_id');
    }

    public function Exame(){
        return $this->hasMany(Exame::class, 'id', 'exame_id');
    }
}
