<?php

namespace App\Http\Controllers\Atendimento;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Consulta;
use App\Profissional;
use App\Especialidade;
use App\AreaAtuacao;
use App\AgendaLivreProfissional;
use Config;

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
            'area_atuacao_list' => $area_atuacao_list
        ]);
    }

    public function listaragenda(Request $request)
    {
        $profissional_id = $request->profissional_id;
        $especialidade_id = $request->especialidade_id;
        $area_atuacao_id = $request->area_atuacao_id;
        $data = date('Y-m-d', strtotime($request->data));

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

        $horarios = [];
        foreach ($this->$agendas as $agenda) {
            if ($agenda->inicio_periodo <= $data && $agenda->fim_periodo = $data) {

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

        return response()->json($horarios);
        //return $this->preparaJson($request, $horarios);
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
                $horaConsultaMarcada = date("H:i", strtotime($consulta->horario_consulta));

                if ($horaConsultaMarcada == $horario["hora"]) {
                    if ($consulta->cancelado != 0)
                        $horario["status"] = Config::get('constants.options.marcado');
                    else if ($consulta->cancelado == 1)
                        $horario["status"] = Config::get('constants.options.cancelado');

                    if ($consulta->realizado == 1)
                        $horario["status"] = Config::get('constants.options.realizado');
                    else if ($consulta->realizado == 0)
                        $horario["status"] = Config::get('constants.options.nao_realizado');

                    $horario["paciente_id"] = $consulta->paciente_id;
                    $horario["paciente_nome"] = $consulta->nome;
                    $horarios[$i] = $horario;
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
        //dd($horarios);
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

        dd($start);


        for ($i = 0; $i < sizeof($horarios); $i++) {
            if ($start >= $i && $limit < ($start + $i)) {
                $horario = $horarios[$i];

                dd($horario['status']);
                /*$show =  route('admin.pacientes.editar', $horario[""]);
                $edit =  route('admin.pacientes.edit', $paciente->id);

                $nestedData['id'] = $paciente->id;
                $nestedData['nome'] = $paciente->nome;
                $nestedData['cpf'] = $paciente->cpf;
                $nestedData['ih'] = $paciente->ih;
                $nestedData['action'] = "<a href='#' title='Editar Paciente'
                                        onclick=\"modalBootstrap('{$edit}', 'Editar Paciente', '#modal_Large', '', 'true', 'true', 'false', 'Atualizar', 'Fechar')\"><span class='glyphicon glyphicon-edit'></span></a>";

                $data[] = $nestedData;*/
            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered->count()),
            "style"           => '',
            "data"            => $horarios
        );

        return json_encode($json_data);
    }
}
