<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\ProfissionalRequest;
use App\Http\Controllers\Controller;
use App\Profissional;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Especialidade;
use App\AreaAtuacao;

class ProfissionalController extends Controller
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
        $profissionais = Profissional::orderBy('nome')->get();
        return view('admin.profissionais.index', compact('profissionais'));
    }
    //Método que lista todos os usuarios no DataTable da Tela
    public function listarprofissionais(Request $request)
    {
        //if (Auth::user()->authorizeRoles() == false)
        //    abort(403, 'Você não possui autorização para realizar essa ação.');
        $profissionais = new Profissional;
        return $profissionais->ListarProfissionais($request);
    }

    public function create()
    {
        //if (Auth::user()->authorizeRoles() == false)
        //    abort(403, 'Você não possui autorização para realizar essa ação.');
        $especialidade_list = Especialidade::orderBy('nome')->get();
        $areaAtuacao_list = AreaAtuacao::orderBy('nome')->get();

        return view('admin.profissionais.create', [
            'especialidade_list' => $especialidade_list,
            'areaAtuacao_list' => $areaAtuacao_list,
        ]);
    }

    public function store(ProfissionalRequest $req)
    {
        try {
            DB::beginTransaction();
            $dados = new Profissional;
            $dados->nome = $req->input('nome');
            $dados->rg = $req->input('rg');
            $dados->cpf = $req->input('cpf');
            $dados->conselho = $req->input('conselho');
            $dados->numero_registro = $req->input('numero_registro');
            $dados->dt_nasc = date("Ymd", strtotime($req->input('dt_nasc')));
            $dados->sexo = $req->input('sexo');
            $dados->celular = $req->input('celular');
            $dados->telefone = $req->input('telefone');
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
            $dados->telefone = str_replace(" ", "", str_replace("-", "", str_replace(")", "", str_replace("(", "", $dados->telefone))));

            $usuario = new User;
            $usuario->name = $req->input('nome');
            $usuario->email = $req->input('email');
            //Profissional = 1
            $usuario->tipo_cadastro = '1';
            $usuario->password = Hash::make($dados->ih);
            $usuario->save();

            $dados->user_id = DB::table('users')->max('id');
            $dados->save();
            DB::commit();
            return "Cadastrado com sucesso!";
        } catch (Exception $e) {
            DB::rollback();
            return "Ocorreu um erro ao remover.";
        }
    }

    public function show($id)
    {
        //if (Auth::user()->authorizeRoles() == false)
        //    abort(403, 'Você não possui autorização para realizar essa ação.');
        $registro = Profissional::find($id);
        return view('admin.profissionais.show', compact('registro'));
    }
    public function edit($id)
    {
        //if (Auth::user()->authorizeRoles() == false)
        //    abort(403, 'Você não possui autorização para realizar essa ação.');
        $registro = Profissional::find($id);
        $user = User::find($registro->user_id);

        return view('admin.profissionais.edit', [
            'registro' => $registro,
            'user' => $user,
        ]);
    }
    public function update(ProfissionalRequest $req, $id)
    {
        try {
            //if (Auth::user()->authorizeRoles() == false)
            //    abort(403, 'Você não possui autorização para realizar essa ação.');
            DB::beginTransaction();
            $dados = Profissional::find($id);
            $dados->nome = $req->input('nome');
            $dados->rg = $req->input('rg');
            $dados->cpf = $req->input('cpf');
            $dados->conselho = $req->input('conselho');
            $dados->numero_registro = $req->input('numero_registro');
            $dados->dt_nasc = date("Ymd", strtotime($req->input('dt_nasc')));
            $dados->sexo = $req->input('sexo');
            $dados->celular = $req->input('celular');
            $dados->telefone = $req->input('telefone');
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
            $dados->telefone = str_replace(" ", "", str_replace("-", "", str_replace(")", "", str_replace("(", "", $dados->telefone))));

            $dados->update();
            DB::commit();
            return "Alterado com sucesso!";
        } catch (Exception $e) {
            DB::rollback();
            return "Ocorreu um erro ao alterar!";
        }
    }
}
