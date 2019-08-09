<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\EspecialidadeRequest;
use App\Http\Controllers\Controller;
use App\Especialidade;

class EspecialidadeController extends Controller
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
        $especialidades = Especialidade::orderBy('nome')->get();
        return view('admin.especialidades.index', compact('especialidades'));
    }
    //Método que lista todos os usuarios no DataTable da Tela
    public function listarespecialidades(Request $request)
    {
        //if (Auth::user()->authorizeRoles() == false)
        //    abort(403, 'Você não possui autorização para realizar essa ação.');
        $especialidades = new Especialidade;
        return $especialidades->ListarEspecialidades($request);
    }

    public function create()
    {
        //if (Auth::user()->authorizeRoles() == false)
        //    abort(403, 'Você não possui autorização para realizar essa ação.');
        return view('admin.especialidades.create');
    }

    public function store(EspecialidadeRequest $req)
    {
        $dados = new Especialidade;
        $dados->nome = $req->input('nome');
        $dados->save();
        return "Cadastrado com sucesso!";
    }

    public function show($id)
    {
        //if (Auth::user()->authorizeRoles() == false)
        //    abort(403, 'Você não possui autorização para realizar essa ação.');
        $registro = Especialidade::find($id);
        return view('admin.especialidades.show', compact('registro'));
    }
    public function edit($id)
    {
        //if (Auth::user()->authorizeRoles() == false)
        //    abort(403, 'Você não possui autorização para realizar essa ação.');
        $registro = Especialidade::find($id);
        return view('admin.especialidades.edit', compact('registro'));
    }
    public function update(EspecialidadeRequest $req, $id)
    {
        try
        {
            //if (Auth::user()->authorizeRoles() == false)
            //    abort(403, 'Você não possui autorização para realizar essa ação.');

            $dados = Especialidade::find($id);
            $dados->nome = $req->input('nome');

            $dados->update();
            return "Alterado com sucesso!";
        }
        catch(Exception $e)
        {
            return "Ocorreu um erro ao alterar!";
        }
    }
}
