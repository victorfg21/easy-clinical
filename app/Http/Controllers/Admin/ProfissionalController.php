<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\ProfissionalRequest;
use App\Http\Controllers\Controller;
use App\Profissional;
use App\User;
use App\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Especialidade;
use App\AreaAtuacao;
use Config;

class ProfissionalController extends Controller
{
    //construtor
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $req)
    {
        if (!$req->user()->authorizeRoles('superadministrator'))
            abort(403, 'Você não possui autorização para realizar essa ação.');

        $profissionais = Profissional::orderBy('nome')->get();
        return view('admin.profissionais.index', compact('profissionais'));
    }

    //Método que lista todos os usuarios no DataTable da Tela
    public function listarprofissionais(Request $req)
    {
        if (!$req->user()->authorizeRoles('superadministrator'))
            abort(403, 'Você não possui autorização para realizar essa ação.');

        $profissionais = new Profissional;
        return $profissionais->ListarProfissionais($req);
    }

    public function create(Request $req)
    {
        if (!$req->user()->authorizeRoles('superadministrator'))
            abort(403, 'Você não possui autorização para realizar essa ação.');

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
            if (!$req->user()->authorizeRoles('superadministrator'))
                abort(403, 'Você não possui autorização para realizar essa ação.');

            $dados = new Profissional;
            $dados->nome = $req->input('nome');
            $dados->rg = $req->input('rg');
            $dados->cpf = $req->input('cpf');
            $dados->conselho = $req->input('conselho');
            $dados->numero_registro = $req->input('numero_registro');
            $dados->dt_nasc = date('Y-m-d', strtotime($req->input('dt_nasc')));
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
            $dados->save();

            $especialidades = json_decode($req->input('especialidades'));
            $areasAtuacao = json_decode($req->input('areasAtuacao'));

            foreach ($especialidades as $especialidade) {
                $exists = $dados->Especialidades->contains($especialidade->id);

                if (!$exists) {
                    $dados->Especialidades()->attach($especialidade->id);
                }
            }

            foreach ($areasAtuacao as $areaAtuacao) {
                $exists = $dados->AreasAtuacao->contains($areaAtuacao->id);

                if (!$exists) {
                    $dados->AreasAtuacao()->attach($areaAtuacao->id);
                }
            }

            $usuario = new User;
            $usuario->name = $req->input('nome');
            $usuario->email = $req->input('email');
            $usuario->password = Hash::make($dados->cpf);
            $usuario->save();

            $role_profissional = Role::where('name', 'profissional')->first();
            $usuario->roles()->attach($role_profissional);

            $dados->user_id = $usuario->id;
            $dados->update();
            return "Cadastrado com sucesso!";
        } catch (Exception $e) {
            return "Ocorreu um erro ao remover.";
        }
    }

    public function show(Request $req, $id)
    {
        if (!$req->user()->authorizeRoles('superadministrator'))
            abort(403, 'Você não possui autorização para realizar essa ação.');

        $registro = Profissional::find($id);
        return view('admin.profissionais.show', compact('registro'));
    }

    public function edit(Request $req, $id)
    {
        if (!$req->user()->authorizeRoles('superadministrator'))
            abort(403, 'Você não possui autorização para realizar essa ação.');

        $registro = Profissional::find($id);
        $user = User::find($registro->user_id);

        $especialidades_profissional = DB::table('especialidade_profissional')->where('profissional_id', $id)
                                            ->join('especialidades', 'especialidade_profissional.especialidade_id', '=', 'especialidades.id')
                                            ->select('especialidades.id', 'especialidades.nome')
                                            ->get();
        $areas_atuacao_profissional = DB::table('area_atuacao_profissional')->where('profissional_id', $id)
                                            ->join('areas_atuacao', 'area_atuacao_profissional.area_atuacao_id', '=', 'areas_atuacao.id')
                                            ->select('areas_atuacao.id', 'areas_atuacao.nome')
                                            ->get();

        $especialidade_list = Especialidade::orderBy('nome')->get();
        $areaAtuacao_list = AreaAtuacao::orderBy('nome')->get();

        return view('admin.profissionais.edit', [
            'registro' => $registro,
            'user' => $user,
            'especialidades_profissional' => $especialidades_profissional,
            'areas_atuacao_profissional' => $areas_atuacao_profissional,
            'especialidade_list' => $especialidade_list,
            'areaAtuacao_list' => $areaAtuacao_list,
        ]);
    }

    public function update(ProfissionalRequest $req, $id)
    {
        try {
            if (!$req->user()->authorizeRoles('superadministrator'))
                abort(403, 'Você não possui autorização para realizar essa ação.');

            $dados = Profissional::find($id);
            $dados->nome = $req->input('nome');
            $dados->rg = $req->input('rg');
            $dados->cpf = $req->input('cpf');
            $dados->conselho = $req->input('conselho');
            $dados->numero_registro = $req->input('numero_registro');
            $dados->dt_nasc = date('Y-m-d', strtotime($req->input('dt_nasc')));
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

            $especialidades = json_decode($req->input('especialidades'));
            $areasAtuacao = json_decode($req->input('areasAtuacao'));
            foreach ($especialidades as $especialidade) {
                $exists = $dados->Especialidades->contains($especialidade->id);

                if (!$exists)
                    $dados->Especialidades()->attach($especialidade->id);
            }

            foreach ($areasAtuacao as $areaAtuacao) {
                $exists = $dados->AreasAtuacao->contains($areaAtuacao->id);

                if (!$exists)
                    $dados->AreasAtuacao()->attach($areaAtuacao->id);
            }

            $dados->update();
            return "Alterado com sucesso!";
        } catch (Exception $e) {
            return "Ocorreu um erro ao alterar!";
        }
    }
}
