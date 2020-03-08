<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SolicitacaoExame extends Model
{
    protected $table = 'solicitacoes_exames';

    protected $fillable = [
        'observacao'
    ];

    public function SolicitacaoExameLinha(){
        return $this->belongsToMany(SolicitacaoExameLinha::class);
    }

    public function Consulta(){
        return $this->hasOne(Consulta::class, 'id', 'consulta_id');
    }

    //Listar as solicitações no DataTable da página Index
    public function ListarSolicitacoes(Request $request)
    {
        $profissional_id = $request->profissional_id;
        $solicitacao_id = $request->solicitacao_id;
        $solicitacao_data = date('Y-m-d', strtotime($request->solicitacao_data));

        $columns = [
            0 => 'id',
            1 => 'data',
            2 => 'paciente_nome',
            3 => 'profissional_nome'
        ];

        $solicitacoes = null;
        $data = [];
        $totalData = 0;
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (!isset($profissional_id) && !isset($solicitacao_id)) {
            $json_data = [
                'draw' => intval($request->input('draw')),
                'recordsTotal' => intval($totalData),
                'recordsFiltered' => intval($totalData),
                'style' => '',
                'data' => $data,
            ];

            return json_encode($json_data);
        }
        if (isset($profissional_id)) {
            $this->{$solicitacoes} = DB::table('solicitacoes_exames')
                ->join('consultas', 'solicitacoes_exames.consulta_id', 'consultas.id')
                ->join('profissionais', 'consultas.profissional_id', 'profissionais.id')
                ->join('pacientes', 'consultas.paciente_id', 'pacientes.id')
                ->select('solicitacoes_exames.*', 'profissionais.nome AS profissional_nome', 'pacientes.nome AS paciente_nome')
                ->where('profissional_id', '=', $profissional_id)
                ->get()
            ;
        }

        if (isset($solicitacao_id)) {
            $this->{$solicitacoes} = DB::table('solicitacoes_exames')
                ->join('consultas', 'solicitacoes_exames.consulta_id', 'consultas.id')
                ->join('profissionais', 'consultas.profissional_id', 'profissionais.id')
                ->join('pacientes', 'consultas.paciente_id', 'pacientes.id')
                ->select('solicitacoes_exames.*', 'profissionais.nome AS profissional_nome', 'pacientes.nome AS paciente_nome')
                ->where('solicitacoes_exames.id', '=', $solicitacao_id)
                ->get()
            ;
        }

        if (isset($solicitacao_data)) {
            $this->{$solicitacoes} = DB::table('solicitacoes_exames')
                ->join('consultas', 'solicitacoes_exames.consulta_id', 'consultas.id')
                ->join('profissionais', 'consultas.profissional_id', 'profissionais.id')
                ->join('pacientes', 'consultas.paciente_id', 'pacientes.id')
                ->select('solicitacoes_exames.*', 'profissionais.nome AS profissional_nome', 'pacientes.nome AS paciente_nome')
                ->where('solicitacoes_exames.created_at', '=', $solicitacao_data)
                ->get()
            ;
        }

        $totalData = 0;$this->{$solicitacoes}->count();
        if(empty($request->input('search.value')))
        {
            $solicitacoes = $this;
            $totalFiltered = $this;
        }
        else {
            $search = $request->input('search.value');
            $solicitacoes =  $this->where('nome','LIKE',"%{$search}%");
            $totalFiltered = $this->where('nome','LIKE',"%{$search}%");
        }

        if(!empty($solicitacoes))
        {
            $solicitacoes = $solicitacoes->offset($start)
                                 ->limit($limit)
                                 ->orderBy($order,$dir)
                                 ->get();
            foreach ($solicitacoes as $solicitacao)
            {
                $create =  route('atendimento.resultado-exame.create', $solicitacao->id);

                $nestedData['id'] = $solicitacao->id;
                $nestedData['data'] = $solicitacao->created_at;
                $nestedData['paciente_nome'] = $solicitacao->paciente_nome;
                $nestedData['profissional_nome'] = $solicitacao->profissional_nome;
                $nestedData['action'] = "<a href='#' title='Lançar Resultado'
                                          onclick=\"modalBootstrap('{$create}', 'Lançar Resultado', '#modal_CRUD', '', 'true', 'true', 'false', 'Salvar', 'Fechar')\"><span class='glyphicon glyphicon-save'></span></a>";
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
