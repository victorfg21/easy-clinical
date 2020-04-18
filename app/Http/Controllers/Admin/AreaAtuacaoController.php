<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\AreaAtuacaoRequest;
use App\Http\Controllers\Controller;
use App\AreaAtuacao;
use Illuminate\Support\Facades\DB;
use Exception;

class AreaAtuacaoController extends Controller
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

        $areasAtuacao = AreaAtuacao::orderBy('nome')->get();
        return view('admin.areas-atuacao.index', compact('areasAtuacao'));
    }
    //Método que lista todos os usuarios no DataTable da Tela
    public function listarareasatuacao(Request $req)
    {
        if (!$req->user()->authorizeRoles('superadministrator'))
            abort(403, 'Você não possui autorização para realizar essa ação.');

        $areasAtuacao = new AreaAtuacao;
        return $areasAtuacao->ListarAreasAtuacao($req);
    }

    public function create(Request $req)
    {
        if (!$req->user()->authorizeRoles('superadministrator'))
            abort(403, 'Você não possui autorização para realizar essa ação.');

        return view('admin.areas-atuacao.create');
    }

    public function store(AreaAtuacaoRequest $req)
    {
        $dados = new AreaAtuacao;
        $dados->nome = $req->input('nome');
        $dados->save();
        return "Cadastrado com sucesso!";
    }

    public function show(Request $req, $id)
    {
        if (!$req->user()->authorizeRoles('superadministrator'))
            abort(403, 'Você não possui autorização para realizar essa ação.');

        $registro = AreaAtuacao::find($id);
        return view('admin.areas-atuacao.show', compact('registro'));
    }

    public function edit(Request $req, $id)
    {
        if (!$req->user()->authorizeRoles('superadministrator'))
            abort(403, 'Você não possui autorização para realizar essa ação.');

        $registro = AreaAtuacao::find($id);
        return view('admin.areas-atuacao.edit', compact('registro'));
    }

    public function update(AreaAtuacaoRequest $req, $id)
    {
        try
        {
            if (!$req->user()->authorizeRoles('superadministrator'))
                abort(403, 'Você não possui autorização para realizar essa ação.');

            $dados = AreaAtuacao::find($id);
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

        $areaAtuacao = AreaAtuacao::find($id);
        return view ('admin.areas-atuacao.delete', compact('areaAtuacao'));
    }

    public function confirmardelete(Request $req, $id)
    {
        try
        {
            if (!$req->user()->authorizeRoles('superadministrator'))
                abort(403, 'Você não possui autorização para realizar essa ação.');

            DB::beginTransaction();
            $areaAtuacao = AreaAtuacao::where('id', '=', $id)->delete();
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
