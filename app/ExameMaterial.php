<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExameMaterial extends Model
{
    protected $table = 'exame_materiais';

    protected $fillable = [
        'nome'
    ];
}
