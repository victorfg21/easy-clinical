<?php

namespace App\Http\Controllers\Atendimento;

use App\AgendaLivreProfissional;
use App\AreaAtuacao;
use App\Consulta;
use App\Especialidade;
use App\Http\Controllers\Controller;
use App\Http\Requests\ConsultaRequest;
use App\Notifications\ReservaHorarioNotification;
use App\Paciente;
use App\Profissional;
use App\ReservaMarcacaoConsulta;
use Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AgendamentoConsultaController extends Controller
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
        //$agendas = Agenda::all();

        $profissional_list = Profissional::orderBy('nome')->get();
        $especialidade_list = Especialidade::orderBy('nome')->get();
        $area_atuacao_list = AreaAtuacao::orderBy('nome')->get();

        return view('atendimento.agendamento-consulta.index', [
            'profissional_list' => $profissional_list,
            'especialidade_list' => $especialidade_list,
            'area_atuacao_list' => $area_atuacao_list,
        ]);
    }

    //Método que lista todos os usuarios no DataTable da Tela
    public function listarconsultas(Request $request)
    {
        //if (Auth::user()->authorizeRoles() == false)
        //    abort(403, 'Você não possui autorização para realizar essa ação.');
        /*$consultas = new Consulta();
        return $consultas->ListarConsultas($request);
        */
        $profissional_id = $request->profissional_id;
        $especialidade_id = $request->especialidade_id;
        $area_atuacao_id = $request->area_atuacao_id;
        $data = date('Y-m-d', strtotime($request->data));
        $horarios = [];

        if (!isset($profissional_id) && !isset($especialidade_id) && !isset($area_atuacao_id)) {
            return $this->preparaJson($request, $horarios);
        }
        $agendas = null;
        if (isset($profissional_id)) {
            $this->{$agendas} = DB::table('agendas')
                ->join('profissionais', 'agendas.profissional_id', 'profissionais.id')
                ->select('agendas.*', 'profissionais.nome')
                ->where('profissional_id', $profissional_id)
                ->where('agendas.inicio_periodo', '<=', $data)
                ->where('agendas.fim_periodo', '>=', $data)
                ->get()
            ;
        }

        if (isset($especialidade_id)) {
            $this->{$agendas} = DB::table('especialidades')
                ->join('especialidade_profissional', 'especialidades.id', 'especialidade_profissional.especialidade_id')
                ->join('agendas', 'especialidade_profissional.profissional_id', 'agendas.profissional_id')
                ->join('profissionais', 'agendas.profissional_id', 'profissionais.id')
                ->select('agendas.*', 'profissionais.nome')
                ->where('especialidades.id', $especialidade_id)
                ->where('agendas.inicio_periodo', '<=', $data)
                ->where('agendas.fim_periodo', '>=', $data)
                ->get()
            ;
        }

        if (isset($area_atuacao_id)) {
            $this->{$agendas} = DB::table('areas_atuacao')
                ->join('area_atuacao_profissional', 'areas_atuacao.id', 'area_atuacao_profissional.area_atuacao_id')
                ->join('agendas', 'area_atuacao_profissional.profissional_id', 'agendas.profissional_id')
                ->join('profissionais', 'agendas.profissional_id', 'profissionais.id')
                ->select('agendas.*', 'profissionais.nome')
                ->where('areas_atuacao.id', $area_atuacao_id)
                ->where('agendas.inicio_periodo', '<=', $data)
                ->where('agendas.fim_periodo', '>=', $data)
                ->get()
            ;
        }

        foreach ($this->{$agendas} as $agenda) {
            if ($agenda->inicio_periodo <= $data && $agenda->fim_periodo >= $data) {
                $diaSemana = date('w', strtotime($data));
                $montarAgenda = true;

                switch ($diaSemana) {
                    case Config::get('constants.options.domingo'):
                        if (true == $agenda->domingo) {
                            $this->{$montarAgenda} = true;
                        }

                        break;
                    case Config::get('constants.options.segunda'):
                        if (true == $agenda->segunda) {
                            $this->{$montarAgenda} = true;
                        }

                        break;
                    case Config::get('constants.options.terca'):
                        if (true == $agenda->terca) {
                            $this->{$montarAgenda} = true;
                        }

                        break;
                    case Config::get('constants.options.quarta'):
                        if (true == $agenda->quarta) {
                            $this->{$montarAgenda} = true;
                        }

                        break;
                    case Config::get('constants.options.quinta'):
                        if (true == $agenda->quinta) {
                            $this->{$montarAgenda} = true;
                        }

                        break;
                    case Config::get('constants.options.sexta'):
                        if (true == $agenda->sexta) {
                            $this->{$montarAgenda} = true;
                        }

                        break;
                    case Config::get('constants.options.sabado'):
                        if (true == $agenda->sabado) {
                            $this->{$montarAgenda} = true;
                        }

                        break;
                }

                if ($this->{$montarAgenda}) {
                    $horarios = $this->MontarAgenda($agenda, $data);
                }
            }
        }

        return $this->preparaJson($request, $horarios);
    }

    public function create(Request $request)
    {
        try {
            DB::beginTransaction();

            //if (Auth::user()->authorizeRoles() == false)
            //    abort(403, 'Você não possui autorização para realizar essa ação.');
            //dd($request);
            $profissional_list = Profissional::orderBy('nome')->get();
            $paciente_list = Paciente::orderBy('nome')->get();

            $registro = new Consulta();
            $registro->profissional_id = $request->input('profissional_id');
            $registro->data_consulta = date('Y-m-d', strtotime($request->input('data')));
            $registro->horario_consulta = $request->input('hora');

            $reserva = new ReservaMarcacaoConsulta();
            $reserva->profissional_id = $request->input('profissional_id');
            $reserva->data_consulta = date('Y-m-d', strtotime($request->input('data')));
            $reserva->horario_consulta = $request->input('hora');
            $reserva->user_id = auth()->user()->id;
            $reserva->save();
            DB::commit();

            $users = Users::where('tipo_cadastro', '=', Config::get('constants.options.administrativo'))->get();
            Notification::send($users, new ReservaHorarioNotification($registro));
            //$reserva->notify(new ReservaHorarioNotification($reserva));

            return view('atendimento.agendamento-consulta.create', [
                'profissional_list' => $profissional_list,
                'paciente_list' => $paciente_list,
                'registro' => $registro,
            ]);
        } catch (Exception $e) {
            DB::rollback();

            return 'Ocorreu um erro ao cadastrar.';
        }
    }

    public function store(ConsultaRequest $request)
    {
        try {
            DB::beginTransaction();

            $dados = new Consulta();
            $dados->profissional_id = $request->input('profissional_id');
            $dados->paciente_id = $request->input('paciente_id');
            $dados->data_consulta = date('Y-m-d H:i:s', strtotime($request->input('data_consulta')));
            $dados->horario_consulta = $request->input('horario_consulta');

            $dados->save();
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

        $registro = Consulta::find($id);
        $profissional_list = Profissional::orderBy('nome')->get();
        $paciente_list = Paciente::orderBy('nome')->get();

        return view('atendimento.agendamento-consulta.show', [
            'registro' => $registro,
            'profissional_list' => $profissional_list,
            'paciente_list' => $paciente_list,
        ]);
    }

    public function cancel(Request $request, $id)
    {
        //if (Auth::user()->authorizeRoles() == false)
        //    abort(403, 'Você não possui autorização para realizar essa ação.');
        $consulta = Consulta::find($id);

        return view('atendimento.agendamento-consulta.cancel', compact('consulta'));
    }

    public function transfer(Request $request, $id)
    {
        //if (Auth::user()->authorizeRoles() == false)
        //    abort(403, 'Você não possui autorização para realizar essa ação.');
        $consulta = Consulta::find($id);

        return view('atendimento.agendamento-consulta.cancel', compact('consulta'));
    }

    public function confirmarcancel($id)
    {
        try {
            DB::beginTransaction();

            $consulta = Consulta::find($id);
            $consulta->cancelado = true;
            $consulta->update();

            DB::commit();

            return 'Cancelado com sucesso!';
        } catch (Exception $e) {
            DB::rollback();

            return 'Ocorreu um erro ao cancelar';
        }
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
        $horaConsulta = date('H:i', strtotime($agenda->inicio_horario_1));
        $horarios = [];
        for ($i = 0; $i < $quantidadeConsultasHorario1; ++$i) {
            $horario = [
                'profissional_id' => $agenda->profissional_id,
                'profissional_nome' => $agenda->nome,
                'paciente_id' => '',
                'paciente_nome' => '',
                'data' => date('Y-m-d', strtotime($data)),
                'hora' => $horaConsulta,
                'status' => Config::get('constants.options.disponivel'),
                'consulta_id' => '',
            ];

            array_push($horarios, $horario);
            //Próximo horário
            $horaConsulta = date('H:i', strtotime($horaConsulta) + 60 * (60 * $tempo_consulta));
        }

        $horaConsulta = date('H:i', strtotime($agenda->inicio_horario_2));
        for ($i = 0; $i < $quantidadeConsultasHorario2; ++$i) {
            $horario = [
                'profissional_id' => $agenda->profissional_id,
                'profissional_nome' => $agenda->nome,
                'paciente_id' => '',
                'paciente_nome' => '',
                'data' => date('Y-m-d', strtotime($data)),
                'hora' => $horaConsulta,
                'status' => Config::get('constants.options.disponivel'),
                'consulta_id' => '',
            ];

            array_push($horarios, $horario);
            //Próximo horário
            $horaConsulta = date('H:i', strtotime($horaConsulta) + 60 * (60 * $tempo_consulta));
        }

        //Preenche as consultas já marcadas
        $consultas = DB::table('consultas')
            ->join('pacientes', 'consultas.paciente_id', 'pacientes.id')
            ->select('consultas.*', 'pacientes.nome')
            ->where('consultas.profissional_id', '=', $agenda->profissional_id)
            ->where('data_consulta', '=', $data)
            ->get()
        ;

        foreach ($consultas as $consulta) {
            $horaConsultaMarcada = date('H:i', strtotime($consulta->horario_consulta));

            for ($i = 0; $i < sizeof($horarios); ++$i) {
                $horario = $horarios[$i];

                if ($horaConsultaMarcada == $horario['hora']) {
                    if (false == $consulta->cancelado || null == $consulta->cancelado) {
                        $horario['status'] = Config::get('constants.options.marcado');
                    } elseif (true == $consulta->cancelado) {
                        $horario['status'] = Config::get('constants.options.cancelado');
                    }

                    if (true == $consulta->realizado) {
                        $horario['status'] = Config::get('constants.options.realizado');
                    } elseif (false == $consulta->realizado && $horario['data'] <= date('Y-m-d') && strtotime('+15 minutes') > strtotime($horario['hora'])) {
                        $horario['status'] = Config::get('constants.options.nao_realizado');
                    }

                    if (true == $consulta->bloqueado) {
                        $horario['status'] = Config::get('constants.options.disponivel');
                    }

                    $horario['paciente_id'] = $consulta->paciente_id;
                    $horario['paciente_nome'] = $consulta->nome;
                    $horario['consulta_id'] = $consulta->id;
                    $horarios[$i] = $horario;

                    if ($horario['status'] == Config::get('constants.options.cancelado')) {
                        $horario['paciente_id'] = '';
                        $horario['paciente_nome'] = '';
                        $horario['consulta_id'] = '';
                        $horario['status'] = Config::get('constants.options.disponivel');

                        $novosHorarios = [];
                        array_push($novosHorarios, $horario);
                        array_splice($horarios, $i, 0, $novosHorarios);
                        ++$i;
                    }
                }
            }
        }

        //Preenche os horários livre da agenda do profissional com status bloqueado
        $agendaLivreProfissional = AgendaLivreProfissional::where('profissional_id', '=', $agenda->profissional_id)
            ->where('data_livre', '=', $data)
            ->get()
        ;
        for ($i = 0; $i < sizeof($horarios); ++$i) {
            foreach ($agendaLivreProfissional as $agendaLivre) {
                $horario = $horarios[$i];
                $horaAgendaLivreInicio = strtotime($agendaLivre->inicio_periodo);
                $horaAgendaLivreFim = strtotime($agendaLivre->fim_periodo);

                if ($horaAgendaLivreInicio <= strtotime($horario['hora']) && strtotime($horario['hora']) <= $horaAgendaLivreFim) {
                    $horario['status'] = Config::get('constants.options.nao_disponivel');
                    $horarios[$i] = $horario;
                }
            }
        }

        //Horários de datas anteriores status vazio
        for ($i = 0; $i < sizeof($horarios); ++$i) {
            $horario = $horarios[$i];
            if (
                $horario['data'] < date('Y-m-d') &&
                $horario['status'] == Config::get('constants.options.disponivel')
            ) {
                $horario['status'] = Config::get('constants.options.sem_marcacao');
                $horarios[$i] = $horario;
            }
        }

        return $horarios;
    }

    private function preparaJson($request, $horarios = [])
    {
        $columns = [
            0 => 'profissional_id',
            1 => 'profissional_nome',
            2 => 'paciente_id',
            3 => 'paciente_nome',
            4 => 'data',
            5 => 'hora',
            6 => 'status',
            7 => 'consulta_id',
        ];

        $totalData = sizeof($horarios);
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $data = [];
        for ($i = $start; $i < sizeof($horarios); ++$i) {
            if ($start <= $i && $i < ($start + $limit)) {
                $horario = $horarios[$i];

                $create = ''; //route('atendimento.agendamento-consulta.create');
                $show = route('atendimento.agendamento-consulta.show', $horario['consulta_id']);
                $cancel = route('atendimento.agendamento-consulta.cancel', $horario['consulta_id']);
                $transfer = route('atendimento.agendamento-consulta.transfer', $horario['consulta_id']);

                $nestedData['profissional_id'] = $horario['profissional_id'];
                $nestedData['profissional_nome'] = $horario['profissional_nome'];
                $nestedData['paciente_id'] = $horario['paciente_id'];
                $nestedData['paciente_nome'] = $horario['paciente_nome'];
                $nestedData['data'] = date('d/m/Y', strtotime($horario['data']));
                $nestedData['hora'] = $horario['hora'];

                switch ($horario['status']) {
                    case Config::get('constants.options.disponivel'):
                        $nestedData['status'] = '<font color="Green">Disponível</font>';
                        $nestedData['action'] = "<a class=\"addConsulta\" href='#' title='Criar Consulta'><span class='glyphicon glyphicon-ok'></span></a>";

                        break;
                    case Config::get('constants.options.em_marcacao'):
                        $nestedData['status'] = '<font color="Yellow">Em Marcação</font>';
                        $nestedData['action'] = '';

                        break;
                    case Config::get('constants.options.marcado'):
                        $nestedData['status'] = '<font color="Blue">Marcado</font>';
                        $nestedData['action'] = "<a href='#' title='Visualizar Consulta'
                                                    onclick=\"modalBootstrap('{$show}', 'Visualizar Consulta', '#modal_CRUD', '', 'false', 'true', 'false', '', 'Fechar')\"><span class='glyphicon glyphicon-search'></span></a>
                                                <a href='#' title='Cancelar Consulta'
                                                    onclick=\"modalBootstrap('{$cancel}', 'Cancelar Consulta', '#modal_CRUD', '', 'true', 'true', 'false', 'Adicionar', 'Fechar')\"><span class='glyphicon glyphicon-ban-circle'></span></a>";

                        break;
                    case Config::get('constants.options.cancelado'):
                        $nestedData['status'] = '<font color="Red">Cancelado</font>';
                        $nestedData['action'] = "<a href='#' title='Visualizar Consulta'
                                                    onclick=\"modalBootstrap('{$show}', 'Visualizar Consulta', '#modal_CRUD', '', 'false', 'true', 'false', '', 'Fechar')\"><span class='glyphicon glyphicon-search'></span></a>";

                        break;
                    case Config::get('constants.options.nao_disponivel'):
                        $nestedData['status'] = '<font color="Orange">Bloqueado</font>';
                        //Bloqueado sem marcação
                        if (empty($horario['consulta_id'])) {
                            $nestedData['action'] = '';
                        }
                        //Bloqueado possibilidade de transferência
                        else {
                            $nestedData['action'] = "<a href='#' title='Visualizar Consulta'
                                                        onclick=\"modalBootstrap('{$show}', 'Visualizar Consulta', '#modal_CRUD', '', 'false', 'true', 'false', '', 'Fechar')\"><span class='glyphicon glyphicon-search'></span></a>
                                                    <a href='#' title='Transferir Consulta'
                                                        onclick=\"modalBootstrap('{$transfer}', 'Transferir Consulta', '#modal_CRUD', '', 'true', 'true', 'false', 'Adicionar', 'Fechar')\"><span class='glyphicon glyphicon-refresh'></span></a>";
                        }

                        break;
                    case Config::get('constants.options.realizado'):
                        $nestedData['status'] = '<font color="LightSkyBlue">Realizado</font>';
                        $nestedData['action'] = "<a href='#' title='Visualizar Consulta'
                                                    onclick=\"modalBootstrap('{$show}', 'Visualizar Consulta', '#modal_CRUD', '', 'false', 'true', 'false', '', 'Fechar')\"><span class='glyphicon glyphicon-search'></span></a>";

                        break;
                    case Config::get('constants.options.nao_realizado'):
                        $nestedData['status'] = '<font color="FireBrick">Faltou</font>';
                        $nestedData['action'] = "<a href='#' title='Visualizar Consulta'
                                                    onclick=\"modalBootstrap('{$show}', 'Visualizar Consulta', '#modal_CRUD', '', 'false', 'true', 'false', '', 'Fechar')\"><span class='glyphicon glyphicon-search'></span></a>";

                        break;
                    case Config::get('constants.options.sem_marcacao'):
                        $nestedData['status'] = '<font color="DarkGray">Vazio</font>';
                        $nestedData['action'] = '';

                        break;
                }

                $nestedData['consulta_id'] = $horario['consulta_id'];
                $data[] = $nestedData;
            }
        }

        $json_data = [
            'draw' => intval($request->input('draw')),
            'recordsTotal' => intval($totalData),
            'recordsFiltered' => intval($totalData),
            'style' => '',
            'data' => $data,
        ];

        return json_encode($json_data);
    }
}
