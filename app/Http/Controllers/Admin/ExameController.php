<?php

namespace App\Http\Controllers\Admin;

use App\Exame;
use App\ExameGrupo;
use App\ExameLinha;
use App\ExameMaterial;
use App\ExameMetodo;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExameRequest;
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

    //Método que lista todos os usuarios no DataTable da Tela
    public function listarexamegrupos(Request $request)
    {
        //if (Auth::user()->authorizeRoles() == false)
        //    abort(403, 'Você não possui autorização para realizar essa ação.');
        $exameGrupos = ExameGrupo::orderBy('nome')->get()->toJson();
        return $exameGrupos;
    }

    public function create()
    {
        //if (Auth::user()->authorizeRoles() == false)
        //    abort(403, 'Você não possui autorização para realizar essa ação.');
        $exame_material_list = ExameMaterial::orderBy('nome')->get();
        $exame_metodo_list = ExameMetodo::orderBy('nome')->get();
        $exame_grupo_list = ExameGrupo::orderBy('nome')->get();

        return view('admin.exames.create', [
            'exame_material_list' => $exame_material_list,
            'exame_metodo_list' => $exame_metodo_list,
            'exame_grupo_list' => $exame_grupo_list,
        ]);
    }

    public function store(ExameRequest $req)
    {
        try {
            DB::beginTransaction();
            $dados = new Exame();
            $dados->nome = $req->input('nome');
            $dados->exame_metodo_id = $req->input('exame_metodo_id');
            $dados->exame_material_id = $req->input('exame_material_id');
            $dados->observacao = $req->input('observacao');
            //dd($dados);
            $dados->save();

            $linhasExame = json_decode($req->input('exameLinha'));
            foreach ($linhasExame as $linha) {
                $dadosLinha = new ExameLinha();
                $dadosLinha->descricao = $req->input('descricao');
                $dadosLinha->exame_grupo_id = '1'; //$req->input('exame_grupo_id');
                $dadosLinha->valor_min = $req->input('minimo');
                $dadosLinha->valor_max = $req->input('maximo');
                $dadosLinha->unidade = $req->input('unidade');

                $dadosLinha->exame_id = $dados->id;
                $dadosLinha->save();
            }

            DB::commit();

            return 'Cadastrado com sucesso!';
        } catch (Exception $e) {
            DB::rollback();

            return 'Ocorreu um erro ao cadastrar.';
        }
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
        $exame_grupo_list = ExameGrupo::orderBy('nome')->get();
        $exames_linha = DB::table('exames_linha')->where('exame_id', $id)
            ->select(
                'exames_linha.id',
                'exames_linha.exame_grupo_id',
                'exames_linha.descricao',
                'exames_linha.valor_min',
                'exames_linha.valor_max',
                'exames_linha.unidade'
            )
            ->get()
        ;

        return view('admin.exames.edit', [
            'registro' => $registro,
            'exame_material_list' => $exame_material_list,
            'exame_metodo_list' => $exame_metodo_list,
            'exames_linha' => $exames_linha,
            'exame_grupo_list' => $exame_grupo_list,
        ]);
    }

    public function update(ExameRequest $req, $id)
    {
        try {
            //if (Auth::user()->authorizeRoles() == false)
            //    abort(403, 'Você não possui autorização para realizar essa ação.');

            DB::beginTransaction();
            $dados = Exame::find($id);
            $dados->nome = $req->input('nome');
            $dados->exame_metodo_id = $req->input('exame_metodo_id');
            $dados->exame_material_id = $req->input('exame_material_id');
            $dados->observacao = $req->input('observacao');

            $dados->update();

            ExameLinha::where('exame_id', '=', $id)->delete();
            $linhasExame = json_decode($req->input('linhasExame'));
            foreach ($linhasExame as $linha) {
                dd($linha);
                $dadosLinha = new ExameLinha();
                $dadosLinha->descricao = $linha->descricao;
                $dadosLinha->exame_grupo_id = $linha->exame_grupo_id;
                $dadosLinha->valor_min = $linha->minimo;
                $dadosLinha->valor_max = $linha->maximo;
                $dadosLinha->unidade = $linha->unidade;

                $dadosLinha->exame_id = $dados->id;
                $dadosLinha->save();
            }

            DB::commit();

            return 'Alterado com sucesso!';
        } catch (Exception $e) {
            DB::rollback();

            return 'Ocorreu um erro ao alterar!';
        }
    }

    public function delete(Request $request, $id)
    {
        //if (Auth::user()->authorizeRoles() == false)
        //    abort(403, 'Você não possui autorização para realizar essa ação.');
        $exame = Exame::find($id);

        return view('admin.exames.delete', compact('exameMetodo'));
    }

    public function confirmardelete($id)
    {
        try {
            DB::beginTransaction();
            $exame = Exame::where('id', '=', $id)->delete();
            $exames_linha = ExameLinha::where('exame_id', '=', $id)->delete();
            DB::commit();

            return 'Removido com sucesso!';
        } catch (Exception $e) {
            DB::rollback();

            return 'Ocorreu um erro ao remover.';
        }
    }
}
