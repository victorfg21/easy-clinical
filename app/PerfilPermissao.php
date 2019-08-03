<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PerfilPermissao extends Model
{
    protected $table = 'perfil_permissoes';

    protected $fillable = [
        'visualizar', 'criar', 'editar', 'deletar'
    ];

    public function Perfil(){
        return $this->hasOne(\App\Perfil::class, 'id', 'perfil_id');
    }
}
