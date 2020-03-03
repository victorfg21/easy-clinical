<?php

namespace App\Http\Controllers\Medico;

use App\Consulta;
use App\Http\Controllers\Controller;
use App\Http\Requests\ConsultaRequest;
use App\Paciente;
use App\Profissional;
use App\User;
use Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AcompanhamentoController extends Controller
{
    //construtor
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //if (Auth::user()->authorizeRoles() == false)
        //    abort(403, 'Você não possui autorização para realizar essa ação.');

        $user = Auth::id();
        $data = date('Y-m-d');
        $profissional_list = Profissional::where('user_id', '=', $user)->orderBy('nome')->get();
        $consulta_list = DB::table('consultas')
                        ->join('pacientes', 'consultas.paciente_id', 'pacientes.id')
                        ->join('profissionais', 'consultas.profissional_id', 'profissionais.id')
                        ->select('consultas.*', 'pacientes.nome')
                        ->where(function ($query) {
                            $query->orWhere('realizado', '=', null)
                                  ->orWhere('realizado', '=', false);
                        })
                        ->where(function ($query) {
                            $query->orWhere('cancelado', '=', null)
                                  ->orWhere('cancelado', '=', false);
                        })
                        ->where(function ($query) {
                            $query->orWhere('bloqueado', '=', null)
                                  ->orWhere('bloqueado', '=', false);
                        })
                        ->where('profissionais.user_id', '=', $user)
                        ->where('data_consulta', '=', $data)
                        ->orderBy('horario_consulta')
                        ->get();

        return view('medico.acompanhamento.index', [
            'profissional_list' => $profissional_list,
            'consulta_list' => $consulta_list,
            'user' => $user,
        ]);
    }

    public function realizar($id)
    {
        //if (Auth::user()->authorizeRoles() == false)
        //    abort(403, 'Você não possui autorização para realizar essa ação.');

        $user = Auth::id();
        $consulta = DB::table('consultas')
                        ->join('pacientes', 'consultas.paciente_id', 'pacientes.id')
                        ->join('profissionais', 'consultas.profissional_id', 'profissionais.id')
                        ->select('consultas.*', 'pacientes.nome AS paciente', 'profissionais.nome AS profissional')
                        ->where('consultas.id', '=', $id)
                        ->first();
        //dd($consulta);

        return view('medico.acompanhamento.realizar', [
            'consulta' => $consulta,
        ]);
    }
}
