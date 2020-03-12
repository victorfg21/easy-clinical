<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        /*if (Auth::user()->authorizeRoles('superadministrator') == false)
            abort(403, 'Você não possui autorização para realizar essa ação.');*/

        $dados_consultas = DB::table('consultas')
                        ->leftJoin('profissionais', 'consultas.profissional_id', '=', 'profissionais.id')
                        ->groupby('profissionais.nome')
                        ->orderby('profissionais.nome')
                        ->select(DB::raw('profissionais.nome, COUNT(consultas.id) AS qtd'))
                        ->get();

        $dados_exames = DB::table('solicitacoes_exames_linha')
                        ->leftJoin('exames', 'solicitacoes_exames_linha.exame_id', '=', 'exames.id')
                        ->groupby('exames.nome')
                        ->orderby('exames.nome')
                        ->select(DB::raw('exames.nome, COUNT(solicitacoes_exames_linha.id) AS qtd'))
                        ->get();

        return view('home', [
            'dados_consultas' => $dados_consultas,
            'dados_exames' => $dados_exames,
        ]);
    }
}
