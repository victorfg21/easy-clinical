<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\PacienteRequest;
use App\Http\Controllers\Controller;
use App\Paciente;
use App\User;
use App\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class PacienteController extends Controller
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

        $pacientes = Paciente::orderBy('nome')->get();
        return view('admin.pacientes.index', compact('pacientes'));
    }
    //Método que lista todos os usuarios no DataTable da Tela
    public function listarpacientes(Request $req)
    {
        if (!$req->user()->authorizeRoles('superadministrator'))
            abort(403, 'Você não possui autorização para realizar essa ação.');

        $pacientes = new Paciente;
        return $pacientes->ListarPacientes($req);
    }

    public function create(Request $req)
    {
        if (!$req->user()->authorizeRoles('superadministrator'))
            abort(403, 'Você não possui autorização para realizar essa ação.');

        return view('admin.pacientes.create');
    }

    public function store(PacienteRequest $req)
    {
        try {
            if (!$req->user()->authorizeRoles('superadministrator'))
                abort(403, 'Você não possui autorização para realizar essa ação.');

            $dados = new Paciente;
            $dados->nome = $req->input('nome');
            $dados->rg = $req->input('rg');
            $dados->cpf = $req->input('cpf');
            $dados->ih = str_pad(DB::table('pacientes')->max('ih') + 1, 7, "0", STR_PAD_LEFT);
            $dados->dt_nasc = date('Y-m-d', strtotime($req->input('dt_nasc')));
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

            $usuario = new User;
            $usuario->name = $req->input('nome');
            $usuario->email = $req->input('email');
            $usuario->password = Hash::make($dados->ih);
            $usuario->save();

            $role_paciente = Role::where('name', 'paciente')->first();
            $usuario->roles()->attach($role_paciente);

            $dados->user_id = $usuario->id;
            $dados->save();
            return "Cadastrado com sucesso!";
        } catch (Exception $e) {
            return "Ocorreu um erro ao cadastrar.";
        }
    }

    public function show(Request $req, $id)
    {
        if (!$req->user()->authorizeRoles('superadministrator'))
            abort(403, 'Você não possui autorização para realizar essa ação.');

        $registro = Paciente::find($id);
        return view('admin.pacientes.show', compact('registro'));
    }

    public function edit(Request $req, $id)
    {
        if (!$req->user()->authorizeRoles('superadministrator'))
            abort(403, 'Você não possui autorização para realizar essa ação.');

        $registro = Paciente::find($id);
        $user = User::find($registro->user_id);

        return view('admin.pacientes.edit', [
            'registro' => $registro,
            'user' => $user,
        ]);
    }

    public function update(PacienteRequest $req, $id)
    {
        try {
            if (!$req->user()->authorizeRoles('superadministrator'))
                abort(403, 'Você não possui autorização para realizar essa ação.');

            $dados = Paciente::find($id);
            $dados->nome = $req->input('nome');
            $dados->rg = $req->input('rg');
            $dados->cpf = $req->input('cpf');
            $dados->ih = $req->input('ih');
            $dados->dt_nasc = date('Y-m-d', strtotime($req->input('dt_nasc')));
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

            $dados->update();
            return "Alterado com sucesso!";
        } catch (Exception $e) {
            return "Ocorreu um erro ao alterar!";
        }
    }
}
