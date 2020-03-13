<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\EspecialidadeRequest;
use App\Http\Controllers\Controller;
use App\Especialidade;
use Illuminate\Support\Facades\DB;

class EspecialidadeController extends Controller
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

        $especialidades = Especialidade::orderBy('nome')->get();
        return view('admin.especialidades.index', compact('especialidades'));
    }
    //Método que lista todos os usuarios no DataTable da Tela
    public function listarespecialidades(Request $req)
    {
        if (!$req->user()->authorizeRoles('superadministrator'))
            abort(403, 'Você não possui autorização para realizar essa ação.');

        $especialidades = new Especialidade;
        return $especialidades->ListarEspecialidades($req);
    }

    public function create(Request $req)
    {
        if (!$req->user()->authorizeRoles('superadministrator'))
            abort(403, 'Você não possui autorização para realizar essa ação.');

        return view('admin.especialidades.create');
    }

    public function store(EspecialidadeRequest $req)
    {
        if (!$req->user()->authorizeRoles('superadministrator'))
            abort(403, 'Você não possui autorização para realizar essa ação.');

        $dados = new Especialidade;
        $dados->nome = $req->input('nome');
        $dados->save();
        return "Cadastrado com sucesso!";
    }

    public function show(Request $req, $id)
    {
        if (!$req->user()->authorizeRoles('superadministrator'))
            abort(403, 'Você não possui autorização para realizar essa ação.');

        $registro = Especialidade::find($id);
        return view('admin.especialidades.show', compact('registro'));
    }

    public function edit(Request $req, $id)
    {
        if (!$req->user()->authorizeRoles('superadministrator'))
            abort(403, 'Você não possui autorização para realizar essa ação.');

        $registro = Especialidade::find($id);
        return view('admin.especialidades.edit', compact('registro'));
    }

    public function update(EspecialidadeRequest $req, $id)
    {
        try
        {
            if (!$req->user()->authorizeRoles('superadministrator'))
                abort(403, 'Você não possui autorização para realizar essa ação.');

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

    public function delete(Request $req, $id)
    {
        if (!$req->user()->authorizeRoles('superadministrator'))
            abort(403, 'Você não possui autorização para realizar essa ação.');

        $especialidade = Especialidade::find($id);
        return view ('admin.especialidades.delete', compact('especialidade'));
    }

    public function confirmardelete(Request $req, $id)
    {
        try
        {
            if (!$req->user()->authorizeRoles('superadministrator'))
                abort(403, 'Você não possui autorização para realizar essa ação.');

            DB::beginTransaction();
            $especialidade = Especialidade::where('id', '=', $id)->delete();
            DB::commit();
            return "Removido com sucesso!";
        }
        catch(Exception $e)
        {
            DB::rollback();
            return "Ocorreu um erro ao remover.";
        }
    }
}
