<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\fabricanteRequest;
use App\Http\Controllers\Controller;
use App\Fabricante;
use Illuminate\Support\Facades\DB;

class FabricanteController extends Controller
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

        $fabricantes = Fabricante::orderBy('nome')->get();
        return view('admin.fabricantes.index', compact('fabricantes'));
    }
    //Método que lista todos os usuarios no DataTable da Tela
    public function listarfabricantes(Request $req)
    {
        if (!$req->user()->authorizeRoles('superadministrator'))
            abort(403, 'Você não possui autorização para realizar essa ação.');

        $fabricantes = new Fabricante;
        return $fabricantes->ListarFabricantes($req);
    }

    public function create(Request $req)
    {
        if (!$req->user()->authorizeRoles('superadministrator'))
            abort(403, 'Você não possui autorização para realizar essa ação.');

        return view('admin.fabricantes.create');
    }

    public function store(fabricanteRequest $req)
    {
        if (!$req->user()->authorizeRoles('superadministrator'))
            abort(403, 'Você não possui autorização para realizar essa ação.');

        $dados = new Fabricante;
        $dados->nome = $req->input('nome');
        $dados->save();
        return "Cadastrado com sucesso!";
    }

    public function show(Request $req, $id)
    {
        if (!$req->user()->authorizeRoles('superadministrator'))
            abort(403, 'Você não possui autorização para realizar essa ação.');

        $registro = Fabricante::find($id);
        return view('admin.fabricantes.show', compact('registro'));
    }

    public function edit(Request $req, $id)
    {
        if (!$req->user()->authorizeRoles('superadministrator'))
            abort(403, 'Você não possui autorização para realizar essa ação.');

        $registro = Fabricante::find($id);
        return view('admin.fabricantes.edit', compact('registro'));
    }

    public function update(fabricanteRequest $req, $id)
    {
        try
        {
            if (!$req->user()->authorizeRoles('superadministrator'))
                abort(403, 'Você não possui autorização para realizar essa ação.');

            $dados = Fabricante::find($id);
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

        $fabricante = Fabricante::find($id);
        return view ('admin.fabricantes.delete', compact('fabricante'));
    }

    public function confirmardelete(Request $req, $id)
    {
        try
        {
            if (!$req->user()->authorizeRoles('superadministrator'))
                abort(403, 'Você não possui autorização para realizar essa ação.');

            DB::beginTransaction();
            $fabricante = Fabricante::where('id', '=', $id)->delete();
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
