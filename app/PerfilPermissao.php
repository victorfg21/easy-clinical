<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PerfilPermissao extends Model
{
    protected $fillable = [
        'perfil_id', 'visualizar', 'criar', 'editar', 'deletar'
    ];

    public function Perfil(){
        return $this->hasOne(\App\Perfil::class, 'id', 'perfil_id');
    }
}
