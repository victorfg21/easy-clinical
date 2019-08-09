<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\AreaAtuacaoRequest;
use App\Http\Controllers\Controller;
use App\AreaAtuacao;

class AreaAtuacaoController extends Controller
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
        $areasAtuacao = AreaAtuacao::orderBy('nome')->get();
        return view('admin.areas-atuacao.index', compact('areasAtuacao'));
    }
    //Método que lista todos os usuarios no DataTable da Tela
    public function listarareasatuacao(Request $request)
    {
        //if (Auth::user()->authorizeRoles() == false)
        //    abort(403, 'Você não possui autorização para realizar essa ação.');
        $areasAtuacao = new AreaAtuacao;
        return $areasAtuacao->ListarAreasAtuacao($request);
    }

    public function create()
    {
        //if (Auth::user()->authorizeRoles() == false)
        //    abort(403, 'Você não possui autorização para realizar essa ação.');
        return view('admin.areas-atuacao.create');
    }

    public function store(AreaAtuacaoRequest $req)
    {
        $dados = new AreaAtuacao;
        $dados->nome = $req->input('nome');
        $dados->save();
        return "Cadastrado com sucesso!";
    }

    public function show($id)
    {
        //if (Auth::user()->authorizeRoles() == false)
        //    abort(403, 'Você não possui autorização para realizar essa ação.');
        $registro = AreaAtuacao::find($id);
        return view('admin.areas-atuacao.show', compact('registro'));
    }
    public function edit($id)
    {
        //if (Auth::user()->authorizeRoles() == false)
        //    abort(403, 'Você não possui autorização para realizar essa ação.');
        $registro = AreaAtuacao::find($id);
        return view('admin.areas-atuacao.edit', compact('registro'));
    }
    public function update(AreaAtuacaoRequest $req, $id)
    {
        try
        {
            //if (Auth::user()->authorizeRoles() == false)
            //    abort(403, 'Você não possui autorização para realizar essa ação.');

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
}
