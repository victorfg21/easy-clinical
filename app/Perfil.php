<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    protected $table = 'perfis';

    protected $fillable = [
        'descricao'
    ];

    public function Paginas(){
        return $this->belongsToMany(Pagina::class);
    }

    public function Users(){
        return $this->belongsToMany(User::class);
    }
}
