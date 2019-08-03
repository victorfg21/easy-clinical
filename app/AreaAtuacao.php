<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AreaAtuacao extends Model
{
    protected $table = 'areas_atuacao';

    protected $fillable = [
        'nome'
    ];

    public function Profissionais(){
        return $this->belongsToMany(Profissional::class);
    }
}
