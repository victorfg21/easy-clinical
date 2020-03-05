<?php

namespace App\Http\Controllers\Medico;

use App\Consulta;
use App\Http\Controllers\Controller;
use App\Http\Requests\ConsultaRequest;
use App\Paciente;
use App\Profissional;
use App\Exame;
use App\SolicitacaoExame;
use App\SolicitacaoExameLinha;
use App\Receita;
use App\ReceitaLinha;
use App\Medicamento;
use App\User;
use Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AcompanhamentoController extends Controller
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

        $user = Auth::id();
        $data = date('Y-m-d');
        $profissional_list = Profissional::where('user_id', '=', $user)->orderBy('nome')->get();
        $consulta_list = DB::table('consultas')
                        ->join('pacientes', 'consultas.paciente_id', 'pacientes.id')
                        ->join('profissionais', 'consultas.profissional_id', 'profissionais.id')
                        ->select('consultas.*', 'pacientes.nome')
                        ->where(function ($query) {
                            $query->orWhere('realizado', '=', null)
                                  ->orWhere('realizado', '=', false);
                        })
                        ->where(function ($query) {
                            $query->orWhere('cancelado', '=', null)
                                  ->orWhere('cancelado', '=', false);
                        })
                        ->where(function ($query) {
                            $query->orWhere('bloqueado', '=', null)
                                  ->orWhere('bloqueado', '=', false);
                        })
                        ->where('profissionais.user_id', '=', $user)
                        ->where('data_consulta', '=', $data)
                        ->orderBy('horario_consulta')
                        ->get();

        return view('medico.acompanhamento.index', [
            'profissional_list' => $profissional_list,
            'consulta_list' => $consulta_list,
            'user' => $user,
        ]);
    }

    public function realizar($id)
    {
        //if (Auth::user()->authorizeRoles() == false)
        //    abort(403, 'Você não possui autorização para realizar essa ação.');

        $user = Auth::id();
        $consulta = DB::table('consultas')
                        ->join('pacientes', 'consultas.paciente_id', 'pacientes.id')
                        ->join('profissionais', 'consultas.profissional_id', 'profissionais.id')
                        ->select('consultas.*', 'pacientes.nome AS paciente', 'profissionais.nome AS profissional')
                        ->where('consultas.id', '=', $id)
                        ->first();
        //dd($consulta);

        return view('medico.acompanhamento.realizar', [
            'consulta' => $consulta,
        ]);
    }

    public function listarexames(Request $request)
    {
        //if (Auth::user()->authorizeRoles() == false)
        //    abort(403, 'Você não possui autorização para realizar essa ação.');
        $exames = Exame::orderBy('nome')->get()->toJson();
        return $exames;
    }

    public function listarmedicamentos(Request $request)
    {
        //if (Auth::user()->authorizeRoles() == false)
        //    abort(403, 'Você não possui autorização para realizar essa ação.');
        $medicamentos = Medicamento::orderBy('nome_fabrica')->get()->toJson();
        return $medicamentos;
    }

    public function store(Request $req)
    {
        try {
            DB::beginTransaction();
            dd($req);
            $registro = Consulta::find($req->input('id'));
            $registro->anotacao = $req->input('observacao');
            $registro->realizado = true;
            $registro->update();

            $solicitacaoExame = new SolicitacaoExame();
            $solicitacaoExame->observacao = $req->input('observacaoSolic');
            $solicitacaoExame->consulta_id = $req->input('id');
            $idSolicitacao = $solicitacaoExame->save();

            $linhasSolicitacao = json_decode($req->input('exameLinha'));
            foreach ($linhasSolicitacao as $linha) {
                $dadosLinha = new SolicitacaoExameLinha();
                $dadosLinha->exame_id = $linha->input('exame_id');
                $dadosLinha->solicitacao_exame_id = $idSolicitacao;
                $dadosLinha->save();
            }

            $receita = new Receita();
            $receita->observacao = $req->input('observacaoReceita');
            $receita->consulta_id = $req->input('id');
            $idReceita = $receita->save();

            $linhasReceita = json_decode($req->input('receitaLinha'));
            foreach ($linhasReceita as $linha) {
                $dadosLinha = new ReceitaLinha();
                $dadosLinha->medicamento_id = $linha->input('medicamento_id');
                $dadosLinha->dosagem = $linha->input('dosagem');
                $dadosLinha->receita_id = $idReceita;
                $dadosLinha->save();
            }

            DB::commit();

            $this->index();
        } catch (Exception $e) {
            DB::rollback();

            return 'Ocorreu um erro ao cadastrar.';
        }
    }
}
