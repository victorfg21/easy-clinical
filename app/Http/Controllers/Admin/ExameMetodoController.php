<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\ExameMetodoRequest;
use App\Http\Controllers\Controller;
use App\ExameMetodo;
use Illuminate\Support\Facades\DB;

class ExameMetodoController extends Controller
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
        $exameMetodos = ExameMetodo::orderBy('nome')->get();
        return view('admin.exame-metodos.index', compact('exameMetodos'));
    }
    //Método que lista todos os usuarios no DataTable da Tela
    public function listarexamemetodos(Request $request)
    {
        //if (Auth::user()->authorizeRoles() == false)
        //    abort(403, 'Você não possui autorização para realizar essa ação.');
        $exameMetodos = new ExameMetodo;
        return $exameMetodos->ListarExameMetodos($request);
    }

    public function create()
    {
        //if (Auth::user()->authorizeRoles() == false)
        //    abort(403, 'Você não possui autorização para realizar essa ação.');
        return view('admin.exame-metodos.create');
    }

    public function store(ExameMetodoRequest $req)
    {
        $dados = new ExameMetodo;
        $dados->nome = $req->input('nome');
        $dados->save();
        return "Cadastrado com sucesso!";
    }

    public function show($id)
    {
        //if (Auth::user()->authorizeRoles() == false)
        //    abort(403, 'Você não possui autorização para realizar essa ação.');
        $registro = ExameMetodo::find($id);
        return view('admin.exame-metodos.show', compact('registro'));
    }

    public function edit($id)
    {
        //if (Auth::user()->authorizeRoles() == false)
        //    abort(403, 'Você não possui autorização para realizar essa ação.');
        $registro = ExameMetodo::find($id);
        return view('admin.exame-metodos.edit', compact('registro'));
    }

    public function update(ExameMetodoRequest $req, $id)
    {
        try
        {
            //if (Auth::user()->authorizeRoles() == false)
            //    abort(403, 'Você não possui autorização para realizar essa ação.');

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

    public function delete(Request $request, $id)
    {
        //if (Auth::user()->authorizeRoles() == false)
        //    abort(403, 'Você não possui autorização para realizar essa ação.');
        $exameMetodo = ExameMetodo::find($id);
        return view ('admin.exame-metodos.delete', compact('exameMetodo'));
    }

    public function confirmardelete($id)
    {
        try
        {
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
