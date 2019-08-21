<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\AgendaRequest;
use App\Http\Controllers\Controller;
use App\Agenda;
use App\Profissional;
use Illuminate\Support\Facades\DB;

class AgendaController extends Controller
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
        $agendas = Agenda::all();
        return view('admin.agendas.index', compact('agendas'));
    }
    //Método que lista todos os usuarios no DataTable da Tela
    public function listaragendas(Request $request)
    {
        //if (Auth::user()->authorizeRoles() == false)
        //    abort(403, 'Você não possui autorização para realizar essa ação.');
        $agendas = new Agenda;
        return $agendas->ListarAgendas($request);
    }

    public function create()
    {
        //if (Auth::user()->authorizeRoles() == false)
        //    abort(403, 'Você não possui autorização para realizar essa ação.');

        $profissional_list = Profissional::orderBy('nome')->get();
        return view('admin.agendas.create', [
            'profissional_list' => $profissional_list
        ]);
    }

    public function store(AgendaRequest $req)
    {
        try {
            DB::beginTransaction();

            dd($req);
            $dados = new Agenda;

            $profissional = Profissional::find($req->input('profissional_id'));
            $dados->Profissional()->save($profissional);

            $dados->inicio_periodo = $req->input('inicio_periodo');
            $dados->fim_periodo = $req->input('fim_periodo');
            $dados->tempo_consulta = $req->input('tempo_consulta');
            $dados->inicio_horario_1 = $req->input('inicio_horario_1');
            $dados->fim_horario_1 = $req->input('fim_horario_1');
            $dados->inicio_horario_2 = $req->input('inicio_horario_2');
            $dados->fim_horario_2 = $req->input('fim_horario_2');
            $dados->bairro = $req->input('bairro');
            $dados->cidade = $req->input('cidade');
            $dados->estado = $req->input('estado');
            $dados->cep = $req->input('cep');

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
        $registro = Agenda::find($id);
        return view('admin.agendas.show', compact('registro'));
    }

    public function edit($id)
    {
        //if (Auth::user()->authorizeRoles() == false)
        //    abort(403, 'Você não possui autorização para realizar essa ação.');
        $registro = Agenda::find($id);
        $user = User::find($registro->user_id);

        return view('admin.agendas.edit', [
            'registro' => $registro,
            'user' => $user,
        ]);
    }

    public function update(AgendaRequest $req, $id)
    {
        try {
            //if (Auth::user()->authorizeRoles() == false)
            //    abort(403, 'Você não possui autorização para realizar essa ação.');

            /*$dados = Agenda::find($id);
            $dados->nome = $req->input('nome');
            $dados->rg = $req->input('rg');
            $dados->cpf = $req->input('cpf');
            $dados->ih = $req->input('ih');
            $dados->dt_nasc = $req->input('dt_nasc');
            $dados->sexo = $req->input('sexo');
            $dados->celular = $req->input('celular');
            $dados->numero = $req->input('numero');
            $dados->endereco = $req->input('endereco');
            $dados->complemento = $req->input('complemento');
            $dados->bairro = $req->input('bairro');
            $dados->cidade = $req->input('cidade');
            $dados->estado = $req->input('estado');
            $dados->cep = $req->input('cep');

            $dados->cep = str_replace(".", "", str_replace("-", "", $dados->cep));
            $dados->cpf = str_replace(".", "", str_replace("-", "", $dados->cpf));
            $dados->celular = str_replace(" ", "", str_replace("-", "", str_replace(")", "", str_replace("(", "", $dados->celular))));

            $dados->update();*/
            return "Alterado com sucesso!";
        } catch (Exception $e) {
            return "Ocorreu um erro ao alterar!";
        }
    }
}
