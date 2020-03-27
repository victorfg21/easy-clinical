<?php

namespace App\Http\Controllers\Medico;

use App\Consulta;
use App\Exame;
use App\Http\Controllers\Controller;
use App\Medicamento;
use App\Profissional;
use App\Receita;
use App\ReceitaLinha;
use App\SolicitacaoExame;
use App\SolicitacaoExameLinha;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AcompanhamentoController extends Controller
{
    //Disponível em https://codepen.io/hairylemon/pen/MzXXeM - Artista Hairylemon
    const html_relatorio = '
    <html>
    <head>
    <style>
        body {
        font-family: sans-serif;
        font-size: 10pt;
        }

        p {
        margin: 0pt;
        }

        table {
        vertical-align: top;
        font-size: 9pt;
        border-collapse: collapse;
        font-family: sans-serif;
        }

        tr {
        padding: 1cm 0;
        }

        td {
        vertical-align: middle;
        }

        .header td {
        vertical-align: bottom;
        }

        table.items thead td {
        font-weight: bold;
        border-top: 0.1mm solid #AAA;
        border-bottom: 0.1mm solid #AAA;
        }

        table.items tr {
        border-bottom: 0.1mm solid #EEE;
        }
    </style>
    </head>

    <body>

        <htmlpagefooter name="myfooter">
        <div style="padding-bottom: 3mm; color: #25266C; text-align: center;">
        <div style="font-weight: bold; font-size: 16pt;">
        <!--It s the security of knowing we re there.-->
        </div>
        <div style="font-size: 8pt;">
        <!--Union Medical Benefits Society Ltd, 165 Gloucester Street, PO Box 1721, Christchurch 8140.-->
        </div>
        <div style="font-size: 8pt;">
        <!--Phone 64-3-365 4048, Fax 64-3-365 4066, Freephone 0800 600 666. <a href="www.unimed.co.nz">www.unimed.co.nz</a>-->
        </div>
        </div>
        <div style="border-top: 1px solid #000000; font-size: 9pt; text-align: center; padding-top: 3mm;">
        Página {PAGENO} de {nb}
        </div>
        </htmlpagefooter>
        <sethtmlpagefooter name="myfooter" value="on" />

    <table class="header" width="100%" cellpadding="10">
        <tr>
        <!--<td width="70%" style="font-weight: bold; font-size: 16pt;">CadMEI - Relatório</td>
        LOGO
        <td width="30%"><img src="https://www.unimed.co.nz/wp-content/uploads/2017/02/logo.png" /></td>
        -->
        </tr>
    </table>
    <table width="100%" cellpadding="5" style="margin: 1cm 0 0.3cm 0; background-color: #7698CC; color: #FFF;">
        <tr>
        <td style="font-size: 12pt">#####TITULO#####</td>
        </tr>
    </table>
    <table width="100%" cellpadding="5">
        #####CORPOTOPO#####
    </table>
    <table width="100%" cellpadding="5">
        #####CONTEUDO#####
    </table>
    <table width="100%" cellpadding="5">
        <tr>
        <td>
            <hr/>#####RODAPE#####</td>
        <td>
        </tr>
    </table>
    <br>
    <br>
    <table width="100%" cellpadding="5">
        <tr>
        <td><strong>Emissão: </strong> #####DATA#####</td>
        </tr>
    </table>
    </body>

    </html>';

    //construtor
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if (!$request->user()->authorizeRoles('superadministrator') && !$request->user()->authorizeRoles('profissional'))
                abort(403, 'Você não possui autorização para realizar essa ação.');

        $user = Auth::id();
        $data = date('Y-m-d');
        $profissional_list = Profissional::where('user_id', '=', $user)->orderBy('nome')->get();
        $consulta_list = DB::table('consultas')
            ->join('pacientes', 'consultas.paciente_id', 'pacientes.id')
            ->join('profissionais', 'consultas.profissional_id', 'profissionais.id')
            ->select('consultas.*', 'pacientes.nome')
            ->where(function ($query) {
                $query->orWhere('realizado', '=', null)
                    ->orWhere('realizado', '=', false)
                            ;
            })
            ->where(function ($query) {
                $query->orWhere('cancelado', '=', null)
                    ->orWhere('cancelado', '=', false)
                            ;
            })
            ->where(function ($query) {
                $query->orWhere('bloqueado', '=', null)
                    ->orWhere('bloqueado', '=', false)
                            ;
            })
            ->where('profissionais.user_id', '=', $user)
            ->where('data_consulta', '=', $data)
            ->orderBy('horario_consulta')
            ->get()
        ;

        return view('medico.acompanhamento.index', [
            'profissional_list' => $profissional_list,
            'consulta_list' => $consulta_list,
            'user' => $user,
        ]);
    }

    public function realizar(Request $request, $id)
    {
        if (!$request->user()->authorizeRoles('superadministrator') && !$request->user()->authorizeRoles('profissional'))
            abort(403, 'Você não possui autorização para realizar essa ação.');

        $consulta = DB::table('consultas')
            ->join('pacientes', 'consultas.paciente_id', 'pacientes.id')
            ->join('profissionais', 'consultas.profissional_id', 'profissionais.id')
            ->select('consultas.*', 'pacientes.nome AS paciente', 'profissionais.nome AS profissional')
            ->where('consultas.id', '=', $id)
            ->first()
        ;

        return view('medico.acompanhamento.realizar', [
            'consulta' => $consulta,
        ]);
    }

    public function listarexames(Request $request)
    {
        if (!$request->user()->authorizeRoles('superadministrator') && !$request->user()->authorizeRoles('profissional'))
            abort(403, 'Você não possui autorização para realizar essa ação.');

        return Exame::orderBy('nome')->get()->toJson();
    }

    public function listarmedicamentos(Request $request)
    {
        if (!$request->user()->authorizeRoles('superadministrator') && !$request->user()->authorizeRoles('profissional'))
            abort(403, 'Você não possui autorização para realizar essa ação.');

        return Medicamento::orderBy('nome_fabrica')->get()->toJson();
    }

    public function store(Request $request)
    {
        try {
            if (!$request->user()->authorizeRoles('superadministrator') && !$request->user()->authorizeRoles('profissional'))
                abort(403, 'Você não possui autorização para realizar essa ação.');

            DB::beginTransaction();
            $registro = Consulta::find($request->input('id'));
            $registro->anotacao = $request->input('observacao');
            $registro->realizado = true;
            $registro->update();

            $solicitacaoExame = new SolicitacaoExame();
            $solicitacaoExame->observacao = $request->input('observacaoSolic');
            $solicitacaoExame->consulta_id = $request->input('id');
            $solicitacaoExame->save();

            $linhasSolicitacao = json_decode($request->input('exameLinha'));
            foreach ($linhasSolicitacao as $linha) {
                $dadosLinha = new SolicitacaoExameLinha();
                $dadosLinha->exame_id = $linha->exame_id;
                $dadosLinha->solicitacao_exame_id = $solicitacaoExame->id;
                $dadosLinha->save();
            }

            $receita = new Receita();
            $receita->observacao = $request->input('observacaoReceita');
            $receita->consulta_id = $request->input('id');
            $receita->save();

            $linhasReceita = json_decode($request->input('receitaLinha'));
            foreach ($linhasReceita as $linha) {
                $dadosLinha = new ReceitaLinha();
                $dadosLinha->medicamento_id = $linha->medicamento_id;
                $dadosLinha->dosagem = $linha->dosagem;
                $dadosLinha->receita_id = $receita->id;
                $dadosLinha->save();
            }

            DB::commit();

            route('medico.acompanhamento.printexame', $receita->id);

            return 'Cadastrado com sucesso!';
        } catch (Exception $e) {
            DB::rollback();

            return 'Ocorreu um erro ao cadastrar.';
        }
    }

    public function historico(Request $request, $id)
    {
        if (!$request->user()->authorizeRoles('superadministrator') && !$request->user()->authorizeRoles('profissional'))
            abort(403, 'Você não possui autorização para realizar essa ação.');

        $solicitacoes_exames = DB::table('consultas')
            ->join('solicitacoes_exames', 'consultas.id', 'solicitacoes_exames.consulta_id')
            ->join('solicitacoes_exames_linha', 'solicitacoes_exames_linha.solicitacao_exame_id', 'solicitacoes_exames.id')
            ->select('solicitacoes_exames.*')
            ->where('consultas.paciente_id', '=', $id)
            ->orWhere('solicitacoes_exames.realizado', '=', '0')
            ->orWhereNull('solicitacoes_exames.realizado')
            ->distinct()
            ->get()
        ;

        $receitas = DB::table('consultas')
            ->join('receitas', 'consultas.id', 'receitas.consulta_id')
            ->select('receitas.*')
            ->where('consultas.paciente_id', '=', $id)
            ->get()
        ;

        return view('medico.acompanhamento.historico', [
            'solicitacoes_exames' => $solicitacoes_exames,
            'receitas' => $receitas,
        ]);
    }

    public function printexame(Request $request, $id)
    {
        if (!$request->user()->authorizeRoles('superadministrator') && !$request->user()->authorizeRoles('profissional'))
            abort(403, 'Você não possui autorização para realizar essa ação.');

        $solicitacoes_exames = DB::table('solicitacoes_exames')
                        ->leftJoin('solicitacoes_exames_linha', 'solicitacoes_exames.id', 'solicitacoes_exames_linha.solicitacao_exame_id')
                        ->leftJoin('consultas', 'solicitacoes_exames.consulta_id', 'consultas.id')
                        ->leftJoin('profissionais', 'consultas.profissional_id', 'profissionais.id')
                        ->leftJoin('pacientes', 'consultas.paciente_id', 'pacientes.id')
                        ->select('solicitacoes_exames.observacao', 'solicitacoes_exames.created_at', 'profissionais.nome', 'profissionais.numero_registro', 'pacientes.nome AS nome_paciente')
                        ->where('solicitacoes_exames.id', '=', $id)
                        ->first();

        $solicitacoes_exames_linha = DB::table('solicitacoes_exames_linha')
                                        ->leftJoin('exames', 'solicitacoes_exames_linha.exame_id', 'exames.id')
                                        ->leftJoin('exame_materiais', 'exames.exame_material_id', 'exame_materiais.id')
                                        ->leftJoin('exame_metodos', 'exames.exame_metodo_id', 'exame_metodos.id')
                                        ->select('exames.id AS exame_id',
                                                 'exames.nome AS nome_exame',
                                                 'exame_materiais.nome AS nome_material',
                                                 'exame_metodos.nome AS nome_metodo',
                                                 'solicitacoes_exames_linha.id AS solicitacao_exame_linha_id')
                                        ->where('solicitacoes_exames_linha.solicitacao_exame_id', '=', $id)
                                        ->distinct()
                                        ->get();

        $observacao = '<strong>Observação:</strong> ' . $solicitacoes_exames->observacao . '<br><br>';
        $profissional = '<strong>Médico:</strong> ' . $solicitacoes_exames->nome . ' <strong>- CRM:</strong> ' . $solicitacoes_exames->numero_registro . '<br><br>';
        $paciente = '<strong>Paciente:</strong> ' . $solicitacoes_exames->nome_paciente . '<br><br>';

        $conteudo = '';
        $html_linha_header_todos = '
        <tr>
            <td width="40%"></td>
            <td width="20%"></td>
        </tr>
        #####LINHAS#####';
        $html_linha_tabela_todos = '
        <tr>
            <td>#####EXAME#####</td>
            <td>#####REFERENCIA#####</td>
        </tr>';
        $tabela = '';

        foreach ($solicitacoes_exames_linha as $value) {

            $exames_linha = DB::table('exames_linha')
                                ->leftJoin('exame_grupos', 'exames_linha.exame_grupo_id', 'exame_grupos.id')
                                ->select('exame_grupos.nome AS grupo_nome',
                                         'exames_linha.valor_min',
                                         'exames_linha.valor_max',
                                         'exames_linha.unidade',
                                         'exames_linha.descricao')
                                ->where('exames_linha.exame_id', '=', $value->exame_id)
                                ->distinct()
                                ->get();

            $resultado = DB::table('exames_realizados')
                                ->select('exames_realizados.val_resultado')
                                ->where('exames_realizados.solicitacao_exame_id', '=', $id)
                                ->where('exames_realizados.solicitacao_exame_linha_id', '=', $value->solicitacao_exame_linha_id)
                                ->first();

            $linhaExame = '<strong>Valor de Referência</strong><br>';
            foreach ($exames_linha as $value_linha) {
                $linhaExame .=  $value_linha->grupo_nome . ': ' . $value_linha->descricao . ' ' .
                                ($value_linha->valor_min != null && $value_linha->valor_max != null ? $value_linha->valor_min . ' a ' . $value_linha->valor_max : $value_linha->valor_min) .
                                '     ' . $value_linha->unidade . '<br>';
            }

            $temp = $html_linha_tabela_todos;
            $temp = str_replace('#####EXAME#####', '<hr><strong>' . $value->nome_exame . '</strong>' .
                                                '<br><br>' .
                                                'Material: ' . $value->nome_material . '<br>' .
                                                'Método: ' . $value->nome_metodo . '<br><br>' .
                                                'Resultado: ' . $resultado->val_resultado . '<br>', $temp);
            $temp = str_replace('#####REFERENCIA#####', $linhaExame, $temp);
            $conteudo .= $temp;
        }

        $tabela = str_replace('#####LINHAS#####', $conteudo, $html_linha_header_todos);
        $html = str_replace('#####CONTEUDO#####', $tabela, AcompanhamentoController::html_relatorio);
        $html = str_replace('#####TITULO#####', 'Exames', $html);
        $html = str_replace('#####RODAPE#####', $observacao . $paciente . $profissional , $html);
        $html = str_replace('#####DATA#####', date('d/m/Y', strtotime($solicitacoes_exames->created_at)), $html);
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }

    public function printreceita(Request $request, $id)
    {
        if (!$request->user()->authorizeRoles('superadministrator') && !$request->user()->authorizeRoles('profissional'))
            abort(403, 'Você não possui autorização para realizar essa ação.');

        $receita = DB::table('receitas')
                        ->join('consultas', 'receitas.consulta_id', 'consultas.id')
                        ->join('profissionais', 'consultas.profissional_id', 'profissionais.id')
                        ->join('pacientes', 'consultas.paciente_id', 'pacientes.id')
                        ->select('receitas.observacao', 'receitas.created_at', 'profissionais.nome', 'profissionais.numero_registro', 'pacientes.nome AS nome_paciente')
                        ->where('receitas.id', '=', $id)
                        ->first();

        $receita_linhas = DB::table('receitas_linha')
            ->join('medicamentos', 'receitas_linha.medicamento_id', 'medicamentos.id')
            ->select('receitas_linha.*', 'medicamentos.nome_fabrica', 'medicamentos.nome_generico')
            ->where('receitas_linha.receita_id', '=', $id)
            ->get();

        $observacao = '<strong>Observação:</strong> '. $receita->observacao . '<br><br>';
        $profissional = '<strong>Médico:</strong> ' . $receita->nome . ' <strong>- CRM:</strong> ' . $receita->numero_registro . '<br><br>';
        $paciente = '<strong>Paciente:</strong> ' . $receita->nome_paciente . '<br><br>';

        $conteudo = '';
        $html_linha_header_todos = '
        <tr>
            <td width="40%"><strong>Medicamento</strong></td>
            <td width="20%"><strong>Instruções</strong></td>
        </tr>
        #####LINHAS#####';
        $html_linha_tabela_todos = '
        <tr>
            <td>#####MEDICAMENTO#####</td>
            <td>#####DOSAGEM#####</td>
        </tr>';
        $tabela = '';

        foreach ($receita_linhas as $value) {
            $temp = $html_linha_tabela_todos;
            $temp = str_replace('#####MEDICAMENTO#####', $value->nome_generico.' - '.$value->nome_fabrica, $temp);
            $temp = str_replace('#####DOSAGEM#####', $value->dosagem, $temp);
            $conteudo .= $temp;
        }

        $tabela = str_replace('#####LINHAS#####', $conteudo, $html_linha_header_todos);
        $html = str_replace('#####CONTEUDO#####', $tabela, AcompanhamentoController::html_relatorio);
        $html = str_replace('#####TITULO#####', 'Receita', $html);
        $html = str_replace('#####RODAPE#####', $observacao . $paciente . $profissional , $html);
        $html = str_replace('#####DATA#####', date('d/m/Y', strtotime($receita->created_at)), $html);
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }
}
