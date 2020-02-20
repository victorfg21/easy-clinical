<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\ExameGrupoRequest;
use App\Http\Controllers\Controller;
use App\ExameGrupo;
use Illuminate\Support\Facades\DB;

class ExameGrupoController extends Controller
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
        $exameGrupos = ExameGrupo::orderBy('nome')->get();
        return view('admin.exame-grupos.index', compact('exameGrupos'));
    }
    
    //Método que lista todos os usuarios no DataTable da Tela
    public function listarexamegrupos(Request $request)
    {
        //if (Auth::user()->authorizeRoles() == false)
        //    abort(403, 'Você não possui autorização para realizar essa ação.');
        $exameGrupos = new ExameGrupo;
        return $exameGrupos->ListarExameGrupos($request);
    }

    public function create()
    {
        //if (Auth::user()->authorizeRoles() == false)
        //    abort(403, 'Você não possui autorização para realizar essa ação.');
        return view('admin.exame-grupos.create');
    }

    public function store(ExameGrupoRequest $req)
    {
        $dados = new ExameGrupo;
        $dados->nome = $req->input('nome');
        $dados->save();
        return "Cadastrado com sucesso!";
    }

    public function show($id)
    {
        //if (Auth::user()->authorizeRoles() == false)
        //    abort(403, 'Você não possui autorização para realizar essa ação.');
        $registro = ExameGrupo::find($id);
        return view('admin.exame-grupos.show', compact('registro'));
    }

    public function edit($id)
    {
        //if (Auth::user()->authorizeRoles() == false)
        //    abort(403, 'Você não possui autorização para realizar essa ação.');
        $registro = ExameGrupo::find($id);
        return view('admin.exame-grupos.edit', compact('registro'));
    }

    public function update(ExameGrupoRequest $req, $id)
    {
        try
        {
            //if (Auth::user()->authorizeRoles() == false)
            //    abort(403, 'Você não possui autorização para realizar essa ação.');

            $dados = ExameGrupo::find($id);
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
        $exameMetodo = ExameGrupo::find($id);
        return view ('admin.exame-grupos.delete', compact('exameMetodo'));
    }

    public function confirmardelete($id)
    {
        try
        {
            DB::beginTransaction();
            $exameMetodo = ExameGrupo::where('id', '=', $id)->delete();
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
