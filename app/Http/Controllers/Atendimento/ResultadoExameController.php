<?php

namespace App\Http\Controllers\Atendimento;

use App\ExameRealizado;
use App\Http\Controllers\Controller;
use App\SolicitacaoExame;
use App\Profissional;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResultadoExameController extends Controller
{
    //construtor
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if (!$request->user()->authorizeRoles('superadministrator') && !$request->user()->authorizeRoles('atendente'))
            abort(403, 'Você não possui autorização para realizar essa ação.');

        $solicitacao_list = SolicitacaoExame::orWhere('realizado', '=', '0')
                                            ->orWhereNull('realizado')
                                            ->orderBy('created_at')
                                            ->get();
        $profissional_list = Profissional::orderBy('nome')->get();

        return view('atendimento.resultado-exame.index', [
            'solicitacao_list' => $solicitacao_list,
            'profissional_list' => $profissional_list,
        ]);
    }

    //Método que lista todos os usuarios no DataTable da Tela
    public function listarsolicitacoes(Request $request)
    {
        if (!$request->user()->authorizeRoles('superadministrator') && !$request->user()->authorizeRoles('atendente'))
            abort(403, 'Você não possui autorização para realizar essa ação.');

        $exames = new SolicitacaoExame();
        return $exames->ListarSolicitacoes($request);
    }

    public function create(Request $request, $id)
    {
        if (!$request->user()->authorizeRoles('superadministrator') && !$request->user()->authorizeRoles('atendente'))
            abort(403, 'Você não possui autorização para realizar essa ação.');

        $registro = DB::table('solicitacoes_exames_linha')
                        ->join('solicitacoes_exames', 'solicitacoes_exames_linha.solicitacao_exame_id', 'solicitacoes_exames.id')
                        ->join('consultas', 'solicitacoes_exames.consulta_id', 'consultas.id')
                        ->join('pacientes', 'consultas.paciente_id', 'pacientes.id')
                        ->join('exames', 'solicitacoes_exames_linha.exame_id', 'exames.id')
                        ->where('solicitacoes_exames.id', '=', $id)
                        ->select('solicitacoes_exames_linha.*', 'pacientes.nome AS paciente_nome', 'exames.nome AS exame_nome')
                        ->get();

        $paciente = $registro->first()->paciente_nome;
        $profissional_list = Profissional::orderBy('nome')->get();
        return view('atendimento.resultado-exame.create', [
            'registro' => $registro,
            'paciente' => $paciente,
            'solicitacao_exame_id' => $id,
            'profissional_list' => $profissional_list,
        ]);
    }

    public function store(Request $request)
    {
        try {
            if (!$request->user()->authorizeRoles('superadministrator') && !$request->user()->authorizeRoles('atendente'))
                abort(403, 'Você não possui autorização para realizar essa ação.');

            $id_solicitacao = $request->input('solicitacao_exame_id');
            $resultadoLinha = json_decode($request->input('resultadoLinha'));
            foreach ($resultadoLinha as $linha) {
                DB::beginTransaction();
                $dados = new ExameRealizado();
                $dados->solicitacao_exame_id = $id_solicitacao;
                $dados->profissional_id = $request->input('profissional_id');
                $dados->solicitacao_exame_linha_id = $linha->id;
                $dados->val_resultado = $linha->val_resultado;
                $dados->save();

                $dados = SolicitacaoExame::find($id_solicitacao);
                $dados->realizado = 1;
                $dados->update();
                DB::commit();
            }

            return 'Resultado lançado com sucesso!';
        } catch (Exception $e) {
            DB::rollback();

            return 'Ocorreu um erro ao lançar o resultado!';
        }
    }
}
