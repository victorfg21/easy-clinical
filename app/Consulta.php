<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\AgendaLivreProfissional;
use Config;

class Consulta extends Model
{
    protected $table = 'consultas';

    protected $fillable = [
        'data_consulta', 'horario_consulta', 'anotacao', 'realizado', 'cancelado'
    ];

    public function Profissional()
    {
        return $this->hasOne(\App\Profissional::class, 'id', 'profissional_id');
    }

    public function Paciente()
    {
        return $this->hasOne(\App\Paciente::class, 'id', 'paciente_id');
    }

    public function SolicitacaoExame()
    {
        return $this->hasOne(\App\SolicitacaoExame::class, 'id', 'solicitacao_exame_id');
    }

    public function ListarConsultas(Request $request)
    {
        $profissional_id = $request->profissional_id;
        $especialidade_id = $request->especialidade_id;
        $area_atuacao_id = $request->area_atuacao_id;
        $data = date('Y-m-d', strtotime($request->data));
        $horarios = [];

        if (!isset($profissional_id) && !isset($especialidade_id) && !isset($area_atuacao_id))
            return $this->preparaJson($request, $horarios);

        $agendas = null;
        if (isset($profissional_id))
            $this->$agendas = DB::table('agendas')
                ->join('profissionais', 'agendas.profissional_id', 'profissionais.id')
                ->select('agendas.*', 'profissionais.nome')
                ->where('profissional_id', $profissional_id)
                ->where('agendas.inicio_periodo', '<=', $data)
                ->where('agendas.fim_periodo', '>=', $data)
                ->get();

        if (isset($especialidade_id))
            $this->$agendas = DB::table('especialidades')
                ->join('especialidade_profissional', 'especialidades.id', 'especialidade_profissional.especialidade_id')
                ->join('agendas', 'especialidade_profissional.profissional_id', 'agendas.profissional_id')
                ->join('profissionais', 'agendas.profissional_id', 'profissionais.id')
                ->select('agendas.*', 'profissionais.nome')
                ->where('especialidades.id', $especialidade_id)
                ->where('agendas.inicio_periodo', '<=', $data)
                ->where('agendas.fim_periodo', '>=', $data)
                ->get();

        if (isset($area_atuacao_id))
            $this->$agendas = DB::table('areas_atuacao')
                ->join('area_atuacao_profissional', 'areas_atuacao.id', 'area_atuacao_profissional.area_atuacao_id')
                ->join('agendas', 'area_atuacao_profissional.profissional_id', 'agendas.profissional_id')
                ->join('profissionais', 'agendas.profissional_id', 'profissionais.id')
                ->select('agendas.*', 'profissionais.nome')
                ->where('areas_atuacao.id', $area_atuacao_id)
                ->where('agendas.inicio_periodo', '<=', $data)
                ->where('agendas.fim_periodo', '>=', $data)
                ->get();

        foreach ($this->$agendas as $agenda) {
            if ($agenda->inicio_periodo <= $data && $agenda->fim_periodo >= $data) {

                $diaSemana = date('w', strtotime($data));
                $montarAgenda = true;

                switch ($diaSemana) {
                    case Config::get('constants.options.domingo'):
                        if ($agenda->domingo == 1)
                            $this->$montarAgenda = true;
                        break;

                    case Config::get('constants.options.segunda'):
                        if ($agenda->segunda == 1)
                            $this->$montarAgenda = true;
                        break;

                    case Config::get('constants.options.terca'):
                        if ($agenda->terca == 1)
                            $this->$montarAgenda = true;
                        break;

                    case Config::get('constants.options.quarta'):
                        if ($agenda->quarta == 1)
                            $this->$montarAgenda = true;
                        break;

                    case Config::get('constants.options.quinta'):
                        if ($agenda->quinta == 1)
                            $this->$montarAgenda = true;
                        break;

                    case Config::get('constants.options.sexta'):
                        if ($agenda->sexta == 1)
                            $this->$montarAgenda = true;
                        break;

                    case Config::get('constants.options.sabado'):
                        if ($agenda->sabado == 1)
                            $this->$montarAgenda = true;
                        break;
                }

                if ($this->$montarAgenda)
                    $horarios = $this->MontarAgenda($agenda, $data);
            }
        }

        return $this->preparaJson($request, $horarios);
    }

    private function MontarAgenda($agenda, $data)
    {
        $inicio_horario_1 = new \DateTime(date('Y-m-d H:i', strtotime($agenda->inicio_horario_1)));
        $fim_horario_1 = new \DateTime(date('Y-m-d H:i', strtotime($agenda->fim_horario_1)));
        $inicio_horario_2 = new \DateTime(date('Y-m-d H:i', strtotime($agenda->inicio_horario_2)));
        $fim_horario_2 = new \DateTime(date('Y-m-d H:i', strtotime($agenda->fim_horario_2)));
        $tempo_consulta = date('H:i', strtotime($agenda->tempo_consulta));

        //Formata em minutos o tempo de cada consulta
        $tempo_consulta = \explode(':', $tempo_consulta);
        $tempo_consulta = $tempo_consulta[0] + ($tempo_consulta[1] / 60);

        //Tempo total de cada horário
        $tempoTotalAtendimentoHorario1 = $fim_horario_1->Diff($inicio_horario_1);
        $tempoTotalAtendimentoHorario2 = $fim_horario_2->Diff($inicio_horario_2);

        //Total de tempo de consulta por horário 1 e 2 em horas
        $tempoTotalAtendimentoHorario1 = ($tempoTotalAtendimentoHorario1->h) + ($tempoTotalAtendimentoHorario1->i / 60);
        $tempoTotalAtendimentoHorario2 = ($tempoTotalAtendimentoHorario2->h) + ($tempoTotalAtendimentoHorario2->i / 60);

        //Quantidade de atendimentos por horário
        $quantidadeConsultasHorario1 = abs($tempoTotalAtendimentoHorario1 / $tempo_consulta);
        $quantidadeConsultasHorario2 = abs($tempoTotalAtendimentoHorario2 / $tempo_consulta);

        //Gera a agenda do dia para os parametros do filtro
        $horaConsulta = date("H:i", strtotime($agenda->inicio_horario_1));
        $horarios = array();
        for ($i = 0; $i < $quantidadeConsultasHorario1; $i++) {

            $horario = array(
                'profissional_id' => $agenda->profissional_id,
                'profissional_nome' => $agenda->nome,
                'paciente_id' => '',
                'paciente_nome' => '',
                'data' => date("Y-m-d", strtotime($data)),
                'hora' => $horaConsulta,
                'status' => Config::get('constants.options.disponivel'),
                'consulta_id' => ''
            );

            array_push($horarios, $horario);
            //Próximo horário
            $horaConsulta = date("H:i", strtotime($horaConsulta) + 60 * (60 * $tempo_consulta));
        }

        $horaConsulta = date("H:i", strtotime($agenda->inicio_horario_2));
        for ($i = 0; $i < $quantidadeConsultasHorario2; $i++) {

            $horario = array(
                'profissional_id' => $agenda->profissional_id,
                'profissional_nome' => $agenda->nome,
                'paciente_id' => '',
                'paciente_nome' => '',
                'data' => date("Y-m-d", strtotime($data)),
                'hora' => $horaConsulta,
                'status' => Config::get('constants.options.disponivel'),
                'consulta_id' => ''
            );

            array_push($horarios, $horario);
            //Próximo horário
            $horaConsulta = date("H:i", strtotime($horaConsulta) + 60 * (60 * $tempo_consulta));
        }

        //Preenche as consultas já marcadas
        $consultas = DB::table('consultas')
            ->join('pacientes', 'consultas.paciente_id', 'pacientes.id')
            ->select('consultas.*', 'pacientes.nome')
            ->where('consultas.profissional_id', '=', $agenda->profissional_id)
            ->where('data_consulta', '=', $data)
            ->get();
        for ($i = 0; $i < sizeof($horarios); $i++) {

            foreach ($consultas as $consulta) {
                $horario = $horarios[$i];
                $horaConsultaMarcada = $consulta->horario_consulta;

                if ($horaConsultaMarcada == $horario["hora"]) {
                    if ($consulta->cancelado == 0 || $consulta->cancelado == null)
                        $horario["status"] = Config::get('constants.options.marcado');
                    else if ($consulta->cancelado == 1)
                        $horario["status"] = Config::get('constants.options.cancelado');

                    if ($consulta->realizado == 1)
                        $horario["status"] = Config::get('constants.options.realizado');
                    else if ($consulta->realizado == 0 && $consulta->realizado != null)
                        $horario["status"] = Config::get('constants.options.nao_realizado');

                    $horario["paciente_id"] = $consulta->paciente_id;
                    $horario["paciente_nome"] = $consulta->nome;
                    $horario["consulta_id"] = $consulta->id;
                    $horarios[$i] = $horario;

                    if ($horario["status"] == Config::get('constants.options.cancelado')) {

                        $horario["status"] = Config::get('constants.options.disponivel');
                        array_splice($horarios, $i, 0, $horario);
                    }
                }
            }
        }

        //Preenche os horários livre da agenda do profissional
        $agendaLivreProfissional = AgendaLivreProfissional::where('profissional_id', '=', $agenda->profissional_id)
            ->where('data_livre', '=', $data)
            ->get();
        for ($i = 0; $i < sizeof($horarios); $i++) {
            foreach ($agendaLivreProfissional as $agendaLivre) {
                $horario = $horarios[$i];
                $horaAgendaLivreInicio = strtotime($agendaLivre->inicio_periodo);
                $horaAgendaLivreFim = strtotime($agendaLivre->fim_periodo);

                if (strtotime($horario["hora"]) >= $horaAgendaLivreInicio && strtotime($horario["hora"]) <= $horaAgendaLivreFim) {
                    $horario["status"] = Config::get('constants.options.nao_disponivel');
                    $horarios[$i] = $horario;
                }
            }
        }

        return $horarios;
    }

    private function preparaJson($request, $horarios = [])
    {
        $columns = array(
            0 => 'profissional_id',
            1 => 'profissional_nome',
            2 => 'paciente_id',
            3 => 'paciente_nome',
            4 => 'data',
            5 => 'hora',
            6 => 'status',
            7 => 'consulta_id',
        );

        $totalData = sizeof($horarios);
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $data = [];
        for ($i = $start; $i < sizeof($horarios); $i++) {
            if ($start <= $i && $i < ($start + $limit)) {
                $horario = $horarios[$i];

                $create =  route('atendimento.agendamento-consulta.create');
                $show =  route('atendimento.agendamento-consulta.show', $horario["consulta_id"]);
                $cancel =  route('atendimento.agendamento-consulta.cancel', $horario["consulta_id"]);

                $nestedData['profissional_id'] = $horario["profissional_id"];
                $nestedData['profissional_nome'] = $horario["profissional_nome"];
                $nestedData['paciente_id'] = $horario["paciente_id"];
                $nestedData['paciente_nome'] = $horario["paciente_nome"];
                $nestedData['data'] = date('d/m/Y', strtotime($horario["data"]));
                $nestedData['hora'] = $horario["hora"];

                switch ($horario["status"]) {
                    case Config::get('constants.options.disponivel'):
                        $statusMarcacao = "<font color=\"green\">Disponível</font>";
                        break;

                    case Config::get('constants.options.em_marcacao'):
                        $statusMarcacao = "<font color=\"yellow\">Em Marcação</font>";
                        break;

                    case Config::get('constants.options.marcado'):
                        $statusMarcacao = "<font color=\"blue\">Marcado</font>";
                        break;

                    case Config::get('constants.options.cancelado'):
                        $statusMarcacao = "<font color=\"red\">Cancelado</font>";
                        break;

                    case Config::get('constants.options.nao_disponivel'):
                        $statusMarcacao = "<font color=\"orange\">Não Disponivel</font>";
                        break;

                    case Config::get('constants.options.realizado'):
                        $statusMarcacao = "<font color=\"LightSkyBlue  \">Realizado</font>";
                        break;

                    case Config::get('constants.options.nao_realizado'):
                        $statusMarcacao = "<font color=\"FireBrick \">Faltou</font>";
                        break;
                }

                $nestedData['status'] = $statusMarcacao;
                $nestedData['consulta_id'] = $horario["consulta_id"];

                if (empty($horario["consulta_id"]))
                    $nestedData['action'] = "<a href='#' title='Criar Consulta'
                                onclick=\"modalBootstrap('{$create}', 'Criar Consulta', '#modal_CRUD', '', 'true', 'true', 'false', 'Adicionar', 'Fechar')\"><span class='glyphicon glyphicon-ok'></span></a>";
                else
                    $nestedData['action'] = "<a href='#' title='Visualizar Consulta'
                                        onclick=\"modalBootstrap('{$show}', 'Visualizar Consulta', '#modal_CRUD', '', 'false', 'true', 'false', 'Atualizar', 'Fechar')\"><span class='glyphicon glyphicon-search'></span></a>
                                        <a href='#' title='Cancelar Consulta'
                                        onclick=\"modalBootstrap('{$cancel}', 'Cancelar Consulta', '#modal_CRUD', '', 'true', 'true', 'false', 'Adicionar', 'Fechar')\"><span class='glyphicon glyphicon-ban-circle'></span></a>";

                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalData),
            "style"           => '',
            "data"            => $data
        );

        return json_encode($json_data);
    }
}
