<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Paciente;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class PacienteController extends Controller
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
        $pacientes = Paciente::orderBy('nome')->get();
        return view('admin.pacientes.index', compact('pacientes'));
    }
    //Método que lista todos os usuarios no DataTable da Tela
    public function listarpacientes(Request $request)
    {
        //if (Auth::user()->authorizeRoles() == false)
        //    abort(403, 'Você não possui autorização para realizar essa ação.');
        $pacientes = new Paciente;
        return $pacientes->ListarPacientes($request);
    }

    public function create()
    {
        //if (Auth::user()->authorizeRoles() == false)
        //    abort(403, 'Você não possui autorização para realizar essa ação.');
        return view('admin.pacientes.create');
    }

    public function store(Request $req)
    {
        $req->validate([
            'nome' => 'required|max:150',
            'rg' => 'required|max:20|unique:pacientes',
            'cpf' => 'required|unique:pacientes',
            'dt_nasc' => 'required',
            'sexo' => 'required',
            'email' => 'email|max:200',
            'celular' => 'required',
            'cep' => 'required',
            'endereco' => 'required|max:150',
            'numero' => 'required',
            'bairro' => 'required|max:150',
            'cidade' => 'required|max:150',
            'estado' => 'required|max:2',
        ], $mensagensErro = [
            'required' => strtoupper(':attribute') . ' Campo obrigatório',
            'max' => 'Quantidade caracteres excedido',
            'unique' => 'O ' . strtoupper(':attribute') . ' já está cadastrado! Não é permitido registro duplicado',
        ]);

        $dados = new Paciente;
        $dados->nome = $req->input('nome');
        $dados->rg = $req->input('rg');
        $dados->cpf = $req->input('cpf');
        $dados->ih = str_pad(DB::table('pacientes')->max('ih') + 1, 7, "0", STR_PAD_LEFT);
        $dados->dt_nasc = date("Ymd", strtotime($req->input('dt_nasc')));
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
        $dados->cpf = str_replace(".", "",str_replace("-", "", $dados->cpf));
        $dados->celular = str_replace(" ", "", str_replace("-", "", str_replace(")", "", str_replace("(", "", $dados->celular))));
        
        $usuario = new User;
        $usuario->name = $req->input('nome');
        $usuario->email = $req->input('email');
        $usuario->tipo_cadastro = 'P';
        $usuario->password = Hash::make($dados->ih);
        $usuario->save();
                
        $dados->user_id = DB::table('users')->max('id');        
        $dados->save();
        return "Cadastrado com sucesso!";
    }

    public function show($id)
    {
        //if (Auth::user()->authorizeRoles() == false)
        //    abort(403, 'Você não possui autorização para realizar essa ação.');
        $registro = Paciente::find($id);
        return view('admin.pacientes.show', compact('registro'));
    }
    public function edit($id)
    {
        //if (Auth::user()->authorizeRoles() == false)
        //    abort(403, 'Você não possui autorização para realizar essa ação.');
        $registro = Paciente::find($id);
        return view('admin.pacientes.edit', compact('registro'));
    }
    public function update(Request $req, $id)
    {
        try
        {
            //if (Auth::user()->authorizeRoles() == false)
            //    abort(403, 'Você não possui autorização para realizar essa ação.');
            $req->validate([
                'nome' => 'required|max:150',
                'rg' => 'required|max:20|unique:pacientes',
                'cpf' => 'required|unique:pacientes',
                'dt_nasc' => 'required',
                'sexo' => 'required',
                'celular' => 'required',
                'cep' => 'required',
                'endereco' => 'required|max:150',
                'numero' => 'required',
                'bairro' => 'required|max:150',
                'cidade' => 'required|max:150',
                'estado' => 'required|max:2',
            ], $mensagensErro = [
                'required' => strtoupper(':attribute') . ' Campo obrigatório',
                'max' => 'Quantidade caracteres excedido',
                'unique' => 'O ' . strtoupper(':attribute') . ' já está cadastrado! Não é permitido registro duplicado',
            ]); 

            $dados = new Paciente;
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
            $dados->cpf = str_replace(".", "",str_replace("-", "", $dados->cpf));
            $dados->celular = str_replace(" ", "", str_replace("-", "", str_replace(")", "", str_replace("(", "", $dados->celular))));

            $dados->update();
            return "Alterado com sucesso!";
        }
        catch(Exception $e)
        {
            return "Ocorreu um erro ao alterar!";
        }
    }

    /*public function index()
    {
        $registros = Paciente::orderBy('nome')->get();
        return view('admin.pacientes.index', compact('registros'));
    }

    public function novo()
    {
        return view('admin.pacientes.novo');
    }

    public function salvar(Request $req)
    {
        $req->validate([
            'nome' => 'required|max:150',
            'rg' => 'required|max:20|unique:pacientes',
            'cpf' => 'required|unique:pacientes',
            'ih' => 'required|unique:pacientes',
            'dt_nasc' => 'required',
            'sexo' => 'required',
            'email' => 'email|max:200',
            'celular' => 'required',
            'cep' => 'required',
            'endereco' => 'required|max:150',
            'numero' => 'required',
            'bairro' => 'required|max:150',
            'cidade' => 'required|max:150',
            'estado' => 'required|max:2',
        ], $mensagensErro = [
            'required' => 'Campo obrigatório',
            'max' => 'Quantidade caracteres excedido',
            'unique' => 'O :attribute já está cadastrado!\nNão é permitido registro duplicado',
        ]); 

        $dados = $req->all();
        $dados['cep'] = str_replace(".", "", str_replace("-", "", $dados['cep']));
        $dados['cpf'] = str_replace(".", "",str_replace("-", "", $dados['cpf']));
        $dados['telefone'] = str_replace(" ", "", str_replace("-", "", str_replace(")", "", str_replace("(", "", $dados['telefone']))));
        $dados['celular'] = str_replace(" ", "", str_replace("-", "", str_replace(")", "", str_replace("(", "", $dados['celular']))));

        Paciente::create($dados);

        return redirect()->route('admin.pacientes');
    }

    public function editar($id)
    {
        $registro = Paciente::find($id);
        return view('admin.pacientes.editar', compact('registro'));
    }

    public function atualizar(Request $req, $id)
    {
        $req->validate([
            'nome' => 'required|max:150',
            'rg' => 'required|max:20',
            'cpf' => 'required',
            'ih' => 'required',
            'dt_nasc' => 'required',
            'sexo' => 'required',
            'email' => 'required|string|email|max:255',
            'celular' => 'required',
            'cep' => 'required',
            'endereco' => 'required|max:150',
            'numero' => 'required',
            'bairro' => 'required|max:150',
            'cidade' => 'required|max:150',
            'estado' => 'required|max:2',
        ], $mensagensErro = [
            'required' => 'Campo obrigatório',
            'max' => 'Quantidade caracteres excedido',
            'unique' => 'O :attribute já está cadastrado!\nNão é permitido registro duplicado',
            'email' => 'O email não é valido',
        ]);         

        $dados = $req->all();
        $dados['cep'] = str_replace(".", "", str_replace("-", "", $dados['cep']));
        $dados['cpf'] = str_replace(".", "",str_replace("-", "", $dados['cpf']));
        $dados['telefone'] = str_replace(" ", "", str_replace("-", "", str_replace(")", "", str_replace("(", "", $dados['telefone']))));
        $dados['celular'] = str_replace(" ", "", str_replace("-", "", str_replace(")", "", str_replace("(", "", $dados['celular']))));

        Paciente::find($id)->update($dados);

        return redirect()->route('admin.pacientes');
    }

    public function deletar(Request $request, $id)
    {
        $request->user()->authorizeRoles('superadministrator');
        Paciente::find($id)->delete();

        return redirect()->route('admin.pacientes');
    }*/
}
