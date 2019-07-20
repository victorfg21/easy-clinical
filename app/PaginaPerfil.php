<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaginaPerfil extends Model
{
    protected $fillable = [
        'pagina_id', 'perfil_id'
    ];

    public function Pagina(){
        return $this->hasOne(\App\Pagina::class, 'id', 'pagina_id');
    }

    public function Perfil(){
        return $this->hasOne(\App\Perfil::class, 'id', 'perfil_id');
    }
}
