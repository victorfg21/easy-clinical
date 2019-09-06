<?php

namespace App\Http\Controllers\Admin;

use App\Exame;
use App\ExameMaterial;
use App\ExameMetodo;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExameRequest;
use App\ValorReferencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExameController extends Controller
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
        $exames = Exame::orderBy('nome')->get();

        return view('admin.exames.index', compact('exames'));
    }

    //Método que lista todos os usuarios no DataTable da Tela
    public function listarexames(Request $request)
    {
        //if (Auth::user()->authorizeRoles() == false)
        //    abort(403, 'Você não possui autorização para realizar essa ação.');
        $exames = new Exame();

        return $exames->ListarExames($request);
    }

    public function create()
    {
        //if (Auth::user()->authorizeRoles() == false)
        //    abort(403, 'Você não possui autorização para realizar essa ação.');
        $exame_material_list = ExameMaterial::orderBy('nome')->get();
        $exame_metodo_list = ExameMetodo::orderBy('nome')->get();
        $valor_referencia_list = ValorReferencia::orderBy('nome')->get();

        return view('admin.exames.create', [
            'exame_material_list' => $exame_material_list,
            'exame_metodo_list' => $exame_metodo_list,
            'valor_referencia_list' => $valor_referencia_list,
        ]);
    }

    public function store(ExameRequest $req)
    {
        $dados = new Exame();
        $dados->nome = $req->input('nome');
        $dados->save();

        return 'Cadastrado com sucesso!';
    }

    public function show($id)
    {
        //if (Auth::user()->authorizeRoles() == false)
        //    abort(403, 'Você não possui autorização para realizar essa ação.');
        $registro = Exame::find($id);

        return view('admin.exames.show', compact('registro'));
    }

    public function edit($id)
    {
        //if (Auth::user()->authorizeRoles() == false)
        //    abort(403, 'Você não possui autorização para realizar essa ação.');
        $registro = Exame::find($id);
        $exame_material_list = ExameMaterial::orderBy('nome')->get();
        $exame_metodo_list = ExameMetodo::orderBy('nome')->get();
        $valor_referencia_list = ValorReferencia::orderBy('nome')->get();
        $valores_referencia_exame = DB::table('valor_referencia_exame')->where('exame_id', $id)
            ->join('valores_referencia', 'valor_referencia_exame.valor_referencia_id', '=', 'valores_referencia.id')
            ->select('valores_referencia.id', 'valores_referencia.descricao')
            ->get()
        ;

        return view('admin.exames.edit', [
            'registro' => $registro,
            'exame_material_list' => $exame_material_list,
            'exame_metodo_list' => $exame_metodo_list,
            'valor_referencia_list' => $valor_referencia_list,
            'valores_referencia_exame' => $valores_referencia_exame,
        ]);
    }

    public function update(ExameRequest $req, $id)
    {
        try {
            //if (Auth::user()->authorizeRoles() == false)
            //    abort(403, 'Você não possui autorização para realizar essa ação.');

            $dados = Exame::find($id);
            $dados->nome = $req->input('nome');

            $dados->update();

            return 'Alterado com sucesso!';
        } catch (Exception $e) {
            return 'Ocorreu um erro ao alterar!';
        }
    }

    public function delete(Request $request, $id)
    {
        //if (Auth::user()->authorizeRoles() == false)
        //    abort(403, 'Você não possui autorização para realizar essa ação.');
        $exameMetodo = Exame::find($id);

        return view('admin.exames.delete', compact('exameMetodo'));
    }

    public function confirmardelete($id)
    {
        try {
            DB::beginTransaction();
            $exameMetodo = Exame::where('id', '=', $id)->delete();
            DB::commit();

            return 'Removido com sucesso!';
        } catch (Exception $e) {
            DB::rollback();

            return 'Ocorreu um erro ao remover.';
        }
    }
}
