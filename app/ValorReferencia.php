<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ValorReferencia extends Model
{
    protected $table = 'valores_referencia';

    protected $fillable = [
        'descricao', 'val_desejavel', 'val_limitrofe_min',
        'val_limitrofe_max', 'val_alto'
    ];

    public function Exames(){
        return $this->belongsToMany(Exame::class);
    }
}
