<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExameMetodo extends Model
{
    protected $table = 'exame_metodos';

    protected $fillable = [
        'nomes'
    ];
}
