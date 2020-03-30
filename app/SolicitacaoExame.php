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

    public function ListarSolicitacoes(Request $request)
    {
        $profissional_id = $request->profissional_id;
        $solicitacao_id = $request->solicitacao_id;
        $solicitacao_data = date('Y-m-d', strtotime($request->solicitacao_data));

        $columns = array(
            0 => 'id',
            1 => 'data',
            2 => 'paciente_nome',
            3 => 'profissional_nome',
        );

        $totalData = $this->count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {
            $solicitacoes = $this->join('consultas', 'solicitacoes_exames.consulta_id', 'consultas.id')
                                ->join('profissionais', 'consultas.profissional_id', 'profissionais.id')
                                ->join('pacientes', 'consultas.paciente_id', 'pacientes.id')
                                ->select('solicitacoes_exames.*', 'profissionais.nome AS profissional_nome', 'pacientes.nome AS paciente_nome')
                                ->orWhere('solicitacoes_exames.realizado', '=', '0')
                                ->orWhereNull('solicitacoes_exames.realizado')
                                ->orderBy('created_at');
            $totalFiltered = $this->join('consultas', 'solicitacoes_exames.consulta_id', 'consultas.id')
                                ->join('profissionais', 'consultas.profissional_id', 'profissionais.id')
                                ->join('pacientes', 'consultas.paciente_id', 'pacientes.id')
                                ->select('solicitacoes_exames.*', 'profissionais.nome AS profissional_nome', 'pacientes.nome AS paciente_nome')
                                ->orWhere('solicitacoes_exames.realizado', '=', '0')
                                ->orWhereNull('solicitacoes_exames.realizado')
                                ->orderBy('created_at');
        }
        else {
            $search = $request->input('search.value');
            $solicitacoes =  $this->join('consultas', 'solicitacoes_exames.consulta_id', 'consultas.id')
                                ->join('profissionais', 'consultas.profissional_id', 'profissionais.id')
                                ->join('pacientes', 'consultas.paciente_id', 'pacientes.id')
                                ->select('solicitacoes_exames.*', 'profissionais.nome AS profissional_nome', 'pacientes.nome AS paciente_nome')
                                ->orWhere('solicitacoes_exames.created_at', '=', 'LIKE',"%{$search}%")
                                ->orWhere('profissionais.nome', '=', 'LIKE',"%{$search}%")
                                ->orWhere('solicitacoes_exames.id', '=', 'LIKE',"%{$search}%")
                                ->orWhere('solicitacoes_exames.realizado', '=', '0')
                                ->orWhereNull('solicitacoes_exames.realizado')
                                ->orderBy('created_at');
            $totalFiltered = $this->join('consultas', 'solicitacoes_exames.consulta_id', 'consultas.id')
                                ->join('profissionais', 'consultas.profissional_id', 'profissionais.id')
                                ->join('pacientes', 'consultas.paciente_id', 'pacientes.id')
                                ->select('solicitacoes_exames.*', 'profissionais.nome AS profissional_nome', 'pacientes.nome AS paciente_nome')
                                ->orWhere('solicitacoes_exames.created_at', '=', 'LIKE',"%{$search}%")
                                ->orWhere('profissionais.nome', '=', 'LIKE',"%{$search}%")
                                ->orWhere('solicitacoes_exames.id', '=', 'LIKE',"%{$search}%")
                                ->orWhere('solicitacoes_exames.realizado', '=', '0')
                                ->orWhereNull('solicitacoes_exames.realizado')
                                ->orderBy('created_at');
        }
        $data = array();
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
                $nestedData['data'] = date('d/m/Y', strtotime($solicitacao->created_at));
                $nestedData['paciente_nome'] = $solicitacao->paciente_nome;
                $nestedData['profissional_nome'] = $solicitacao->profissional_nome;
                $nestedData['action'] = "<a href='#' title='Lançar Resultado'
                                          onclick=\"modalBootstrap('{$create}', 'Lançar Resultado', '#modal_Large', '', 'true', 'true', 'false', 'Salvar', 'Fechar')\"><span class='glyphicon glyphicon-check'></span></a>";
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalFiltered->count()),
            "recordsFiltered" => intval($totalFiltered->count()),
            "style"           => '',
            "data"            => $data
            );

        return json_encode($json_data);
    }
}
