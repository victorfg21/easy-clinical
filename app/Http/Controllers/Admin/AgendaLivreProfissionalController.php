<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\AgendaLivreProfissionalRequest;
use App\Http\Controllers\Controller;
use App\AgendaLivreProfissional;
use App\Profissional;
use Illuminate\Support\Facades\DB;

class AgendaLivreProfissionalController extends Controller
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
        $agendas = AgendaLivreProfissional::all();
        return view('admin.agenda-livre-profissionais.index', compact('agendas'));
    }
    //Método que lista todos os usuarios no DataTable da Tela
    public function listaragendalivreprofissionais(Request $request)
    {
        //if (Auth::user()->authorizeRoles() == false)
        //    abort(403, 'Você não possui autorização para realizar essa ação.');
        $agendas = new AgendaLivreProfissional;
        return $agendas->ListarAgendaLivreProfissionais($request);
    }

    public function create()
    {
        //if (Auth::user()->authorizeRoles() == false)
        //    abort(403, 'Você não possui autorização para realizar essa ação.');

        $profissional_list = Profissional::orderBy('nome')->get();
        return view('admin.agenda-livre-profissionais.create', [
            'profissional_list' => $profissional_list
        ]);
    }

    public function store(AgendaLivreProfissionalRequest $req)
    {
        try {
            DB::beginTransaction();

            $dados = new AgendaLivreProfissional;
            $dados->profissional_id = $req->input('profissional_id');
            $dados->data_livre = date('Y-m-d H:i:s', strtotime($req->input('data_livre')));
            $dados->inicio_periodo = $req->input('inicio_periodo');
            $dados->fim_periodo = $req->input('fim_periodo');
            $dados->motivo = $req->input('motivo');

            $dados->save();
            DB::commit();
            return "Cadastrado com sucesso!";
        } catch (Exception $e) {
            DB::rollback();
            return "Ocorreu um erro ao cadastrar.";
        }
    }

    public function show($id)
    {
        //if (Auth::user()->authorizeRoles() == false)
        //    abort(403, 'Você não possui autorização para realizar essa ação.');
        $registro = AgendaLivreProfissional::find($id);
        return view('admin.agenda-livre-profissionais.show', compact('registro'));
    }

    public function edit($id)
    {
        //if (Auth::user()->authorizeRoles() == false)
        //    abort(403, 'Você não possui autorização para realizar essa ação.');
        $registro = AgendaLivreProfissional::find($id);
        $profissional_list = Profissional::orderBy('nome')->get();
        return view('admin.agenda-livre-profissionais.edit', [
            'registro' => $registro,
            'profissional_list' => $profissional_list
        ]);
    }

    public function update(AgendaLivreProfissionalRequest $req, $id)
    {
        try {
            DB::beginTransaction();

            $dados = AgendaLivreProfissional::find($id);
            $dados->profissional_id = $req->input('profissional_id');
            $dados->data_livre = date('Y-m-d H:i:s', strtotime($req->input('data_livre')));
            $dados->inicio_periodo = $req->input('inicio_periodo');
            $dados->fim_periodo = $req->input('fim_periodo');
            $dados->motivo = $req->input('motivo');

            $dados->update();
            DB::commit();
            return "Alterado com sucesso!";
        } catch (Exception $e) {
            DB::rollback();
            return "Ocorreu um erro ao alterar.";
        }
    }
}
