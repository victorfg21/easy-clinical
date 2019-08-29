<?php

namespace App;

use Config;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ReservaMarcacaoConsulta extends Model
{
    use Notifiable;

    protected $table = 'reservas_marcacoes_consultas';

    protected $fillable = [
        'data_consulta', 'horario_consulta'
    ];

    public function Profissional()
    {
        return $this->hasOne(\App\Profissional::class, 'id', 'profissional_id');
    }

    public function Usuario()
    {
        return $this->hasOne(\App\User::class, 'id', 'user_id');
    }
}
