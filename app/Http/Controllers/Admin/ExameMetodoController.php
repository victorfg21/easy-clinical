<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\ExameMetodoRequest;
use App\Http\Controllers\Controller;
use App\ExameMetodo;
use Illuminate\Support\Facades\DB;
use Exception;

class ExameMetodoController extends Controller
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

        $exameMetodos = ExameMetodo::orderBy('nome')->get();
        return view('admin.exame-metodos.index', compact('exameMetodos'));
    }
    //Método que lista todos os usuarios no DataTable da Tela
    public function listarexamemetodos(Request $req)
    {
        if (!$req->user()->authorizeRoles('superadministrator'))
            abort(403, 'Você não possui autorização para realizar essa ação.');

        $exameMetodos = new ExameMetodo;
        return $exameMetodos->ListarExameMetodos($req);
    }

    public function create(Request $req)
    {
        if (!$req->user()->authorizeRoles('superadministrator'))
            abort(403, 'Você não possui autorização para realizar essa ação.');

        return view('admin.exame-metodos.create');
    }

    public function store(ExameMetodoRequest $req)
    {
        if (!$req->user()->authorizeRoles('superadministrator'))
            abort(403, 'Você não possui autorização para realizar essa ação.');

        $dados = new ExameMetodo;
        $dados->nome = $req->input('nome');
        $dados->save();
        return "Cadastrado com sucesso!";
    }

    public function show(Request $req, $id)
    {
        if (!$req->user()->authorizeRoles('superadministrator'))
            abort(403, 'Você não possui autorização para realizar essa ação.');

        $registro = ExameMetodo::find($id);
        return view('admin.exame-metodos.show', compact('registro'));
    }

    public function edit(Request $req, $id)
    {
        if (!$req->user()->authorizeRoles('superadministrator'))
            abort(403, 'Você não possui autorização para realizar essa ação.');

        $registro = ExameMetodo::find($id);
        return view('admin.exame-metodos.edit', compact('registro'));
    }

    public function update(ExameMetodoRequest $req, $id)
    {
        try
        {
            if (!$req->user()->authorizeRoles('superadministrator'))
                abort(403, 'Você não possui autorização para realizar essa ação.');

            $dados = ExameMetodo::find($id);
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

        $exameMetodo = ExameMetodo::find($id);
        return view ('admin.exame-metodos.delete', compact('exameMetodo'));
    }

    public function confirmardelete(Request $req, $id)
    {
        try
        {
            if (!$req->user()->authorizeRoles('superadministrator'))
                abort(403, 'Você não possui autorização para realizar essa ação.');

            DB::beginTransaction();
            $exameMetodo = ExameMetodo::where('id', '=', $id)->delete();
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
