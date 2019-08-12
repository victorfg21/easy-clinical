<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\ExameMaterialRequest;
use App\Http\Controllers\Controller;
use App\ExameMaterial;
use Illuminate\Support\Facades\DB;

class ExameMaterialController extends Controller
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
        $exameMateriais = ExameMaterial::orderBy('nome')->get();
        return view('admin.exame-materiais.index', compact('exameMateriais'));
    }
    //Método que lista todos os usuarios no DataTable da Tela
    public function listarexamemateriais(Request $request)
    {
        //if (Auth::user()->authorizeRoles() == false)
        //    abort(403, 'Você não possui autorização para realizar essa ação.');
        $exameMateriais = new ExameMaterial;
        return $exameMateriais->ListarExameMateriais($request);
    }

    public function create()
    {
        //if (Auth::user()->authorizeRoles() == false)
        //    abort(403, 'Você não possui autorização para realizar essa ação.');
        return view('admin.exame-materiais.create');
    }

    public function store(ExameMaterialRequest $req)
    {
        $dados = new ExameMaterial;
        $dados->nome = $req->input('nome');
        $dados->save();
        return "Cadastrado com sucesso!";
    }

    public function show($id)
    {
        //if (Auth::user()->authorizeRoles() == false)
        //    abort(403, 'Você não possui autorização para realizar essa ação.');
        $registro = ExameMaterial::find($id);
        return view('admin.exame-materiais.show', compact('registro'));
    }

    public function edit($id)
    {
        //if (Auth::user()->authorizeRoles() == false)
        //    abort(403, 'Você não possui autorização para realizar essa ação.');
        $registro = ExameMaterial::find($id);
        return view('admin.exame-materiais.edit', compact('registro'));
    }

    public function update(ExameMaterialRequest $req, $id)
    {
        try
        {
            //if (Auth::user()->authorizeRoles() == false)
            //    abort(403, 'Você não possui autorização para realizar essa ação.');

            $dados = ExameMaterial::find($id);
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
        $exameMaterial = ExameMaterial::find($id);
        return view ('admin.exame-materiais.delete', compact('exameMaterial'));
    }

    public function confirmardelete($id)
    {
        try
        {
            DB::beginTransaction();
            $exameMaterial = ExameMaterial::where('id', '=', $id)->delete();
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
