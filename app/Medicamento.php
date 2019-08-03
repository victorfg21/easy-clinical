<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Medicamento extends Model
{
    protected $table = 'medicamentos';

    protected $fillable = [
        'nome_generico', 'nome_fabrica'
    ];

    public function Fabricante(){
        return $this->hasOne(\App\Fabricante::class, 'id', 'fabricante_id');
    }
}
