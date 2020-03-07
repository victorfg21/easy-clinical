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
            ->first()
        ;

        dd($consulta);
        return view('medico.acompanhamento.realizar', [
            'consulta' => $consulta,
        ]);
    }

    public function listarexames(Request $request)
    {
        //if (Auth::user()->authorizeRoles() == false)
        //    abort(403, 'Você não possui autorização para realizar essa ação.');
        return Exame::orderBy('nome')->get()->toJson();
    }

    public function listarmedicamentos(Request $request)
    {
        //if (Auth::user()->authorizeRoles() == false)
        //    abort(403, 'Você não possui autorização para realizar essa ação.');
        return Medicamento::orderBy('nome_fabrica')->get()->toJson();
    }

    public function store(Request $req)
    {
        try {
            DB::beginTransaction();
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
                $dadosLinha->exame_id = $linha->exame_id;
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
                $dadosLinha->medicamento_id = $linha->medicamento_id;
                $dadosLinha->dosagem = $linha->dosagem;
                $dadosLinha->receita_id = $idReceita;
                $dadosLinha->save();
            }

            DB::commit();

            return 'Cadastrado com sucesso!';
        } catch (Exception $e) {
            DB::rollback();

            return 'Ocorreu um erro ao cadastrar.';
        }
    }

    public function historico($id)
    {
        //if (Auth::user()->authorizeRoles() == false)
        //    abort(403, 'Você não possui autorização para realizar essa ação.');
        dd($id);
        $user = Auth::id();
        $solicitacoes_exames = DB::table('consultas')
            ->join('solicitacoes_exames', 'consultas.id', 'solicitacoes_exames.consulta_id')
            ->select('solicitacoes_exames.*')
            ->where('consultas.paciente_id', '=', $id)
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

    public function printexame(Request $request)
    {
        /*$request->validate([
          'servico_ret' => 'required',
          'inicioServico' => 'required|date_format:Y-m-d|before:fimServico',
          'fimServico' => 'required|date_format:Y-m-d|after:inicioServico',
        ], $mensagensErro = [
            'required' => 'Campo obrigatório',
            'max' => 'Quantidade caracteres excedido',
            'date' => 'Data inválida',
            'before' => 'Data inicial deve ser anterior a data final',
            'after' => 'Data final deve ser posterior a data inicial',
            'unique' => 'O :attribute já está cadastrado! Não é permitido registro duplicado',
        ]);

        $dados = $request->all();
        $id_servico = $dados['servico_ret'];
        $ini = date("d/m/Y", strtotime($dados['inicioServico']));
        $fim = date("d/m/Y", strtotime($dados['fimServico']));

        $servico = '';
        $conteudo = '';
        $html_linha_header_todos = '
        <tr>
          <td width="20%"><strong>CNPJ</strong></td>
          <td width="20%"><strong>Descrição</strong></td>
        </tr>
        #####LINHAS#####';
        $html_linha_header_declaracao = '
        <tr>
          <td width="20%"><strong>CNPJ</strong></td>
          <td width="20%"><strong>Ano</strong></td>
          <td width="20%"><strong>Valor</strong></td>
        </tr>
        #####LINHAS#####';
        $html_linha_tabela_todos = '
        <tr>
          <td>#####CNPJ#####</td>
          <td>#####DESCRICAO#####</td>
        </tr>';
        $html_linha_tabela_declaracao = '
        <tr>
          <td>#####CNPJ#####</td>
          <td>#####ANO#####</td>
          <td>#####VALOR#####</td>
        </tr>';
        $tabela = '';
        $rodape_label = '';
        $tot = 0;
        if ($id_servico == '4') {
            $registros = DB::table('atendimentos')
                          ->leftJoin('empresas', 'atendimentos.empresa_id', '=', 'empresas.id')
                          ->leftJoin('atendimento_servicos', 'atendimentos.id', '=', 'atendimento_servicos.atendimento_id')
                          ->leftJoin('servicos', 'atendimento_servicos.servico_id', '=', 'servicos.id')
                          ->where('atendimento_servicos.servico_id', '=', $id_servico)
                          ->whereRaw('CAST(atendimentos.data AS DATE) BETWEEN ? AND ?', [$ini, $fim])
                          ->select(DB::raw('cnpj, ano_declaracao, to_char(valor_total, \'L9G999G990D99\') as valor_total, descricao'))
                          ->get();

            if (!empty($registros->first())) {
                $servico = $registros->first()->descricao;
                foreach ($registros as $key => $value) {
                    $temp = $html_linha_tabela_declaracao;
                    $temp = str_replace('#####CNPJ#####', $value->cnpj, $temp);
                    $temp = str_replace('#####ANO#####', $value->ano_declaracao, $temp);
                    $temp = str_replace('#####VALOR#####', 'R$ ' . $value->valor_total, $temp);
                    $conteudo .= $temp;
                }

                $registros = DB::table('atendimentos')
                          ->leftJoin('atendimento_servicos', 'atendimentos.id', '=', 'atendimento_servicos.atendimento_id')
                          ->where('atendimento_servicos.servico_id', '=', $id_servico)
                          ->select(DB::raw('to_char(sum(valor_total), \'L9G999G990D99\') as valor_total'))
                          ->get();
                $tot = $registros->first()->valor_total;

                $tabela = str_replace('#####LINHAS#####', $conteudo, $html_linha_header_declaracao);
                $rodape_label = 'VALOR TOTAL';
            }
            else{
              return response()->view('errors.relatorio_erro');
            }
        } else {
            $registros = DB::table('atendimentos')
                          ->leftJoin('empresas', 'atendimentos.empresa_id', '=', 'empresas.id')
                          ->leftJoin('atendimento_servicos', 'atendimentos.id', '=', 'atendimento_servicos.atendimento_id')
                          ->leftJoin('servicos', 'atendimento_servicos.servico_id', '=', 'servicos.id')
                          ->where('atendimento_servicos.servico_id', '=', $id_servico)
                          ->whereRaw('CAST(atendimentos.data AS DATE) BETWEEN ? AND ?', [$ini, $fim])
                          ->get();

            if (!empty($registros->first())) {
                $servico = $registros->first()->descricao;
                foreach ($registros as $key => $value) {
                    $temp = $html_linha_tabela_todos;
                    $temp = str_replace('#####CNPJ#####', $value->cnpj, $temp);
                    $temp = str_replace('#####DESCRICAO#####', $value->observacao, $temp);
                    $conteudo .= $temp;
                    $tot++;
                }
            }
            else{
              return response()->view('errors.relatorio_erro');
            }

            $tabela = str_replace('#####LINHAS#####', $conteudo, $html_linha_header_todos);
            $rodape_label = 'TOTAL';
        }

        $html = str_replace('#####CONTEUDO#####', $tabela, AcompanhamentoController::html_servico);
        $html = str_replace('#####TITULO#####', 'Empresa X Setor', $html);
        $html = str_replace('#####TOTAL#####', $tot, $html);
        $html = str_replace('#####INI#####', $ini, $html);
        $html = str_replace('#####FIM#####', $fim, $html);
        $html = str_replace('#####RODAPE#####', $rodape_label, $html);
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML($html);
        $mpdf->Output();
        */
    }

    public function printreceita($id)
    {
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
        //$html = str_replace('#####CORPOTOPO#####', $inicio, $html);
        $html = str_replace('#####RODAPE#####', $observacao . $paciente . $profissional , $html);
        $html = str_replace('#####DATA#####', date('d/m/Y', strtotime($receita->created_at)), $html);
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }
}
