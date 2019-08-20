<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Agenda extends Model
{
    protected $table = 'agendas';

    protected $fillable = [
        'segunda', 'terca', 'quarta', 'quinta', 'sexta', 'sabado', 'domingo',
        'inicio_periodo', 'fim_periodo', 'tempo_consulta', 'inicio_horario_1', 'fim_horario_1',
        'inicio_horario_2', 'fim_horario_2', 'ativo'
    ];

    public function Profissional(){
        return $this->hasOne(\App\Profissional::class, 'id', 'profissional_id');
    }

    //Listar os pacientes no DataTable da página Index
    public function ListarAgendas(Request $request)
    {
        $columns = array(
            0 => 'nome',
            1 => 'inicio_periodo',
            2 => 'fim_periodo'
        );

        $totalData = $this->count();
        $limit = $request->input('length');
        $start = $request->input('start');
        //$order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {
            $agendas = $this;
            $totalFiltered = $this;
        }
        else {
            $search = $request->input('search.value');
            $agendas =  $this->select('profissionais.nome', 'agendas.*')
                                ->join('profissionais', 'agendas.profissional_id', '=', 'profissionais.id')
                                ->where('profissionais.nome','LIKE',"%{$search}%")
                                ->whereDate('inicio_periodo', '>=', "{$search}")
                                ->whereDate('fim_periodo', '<=', "{$search}");
            $totalFiltered = $this->join('profissionais', 'agendas.profissional_id', '=', 'profissionais.id')
                                    ->where('profissionais.nome','LIKE',"%{$search}%")
                                    ->whereDate('inicio_periodo', '>=', "{$search}")
                                    ->whereDate('fim_periodo', '<=', "{$search}");
        }
        $data = array();
        if(!empty($agendas))
        {
            $agendas = $agendas->offset($start)
                                 ->limit($limit)
                                 //->orderBy($order,$dir)
                                 ->get();
            foreach ($agendas as $agenda)
            {
                //$show =  route('admin.pacientes.editar',$agenda->id);
                $edit =  route('admin.pacientes.edit',$agenda->id);

                $nestedData['id'] = $agenda->id;
                $nestedData['nome'] = $agenda->nome;
                $nestedData['inicio_periodo'] = $agenda->inicio_periodo;
                $nestedData['fim_periodo'] = $agenda->fim_periodo;

                $nestedData['action'] = "<a href='#' title='Editar Agenda'
                                          onclick=\"modalBootstrap('{$edit}', 'Editar Agenda', '#modal_Large', '', 'true', 'true', 'false', 'Atualizar', 'Fechar')\"><span class='glyphicon glyphicon-edit'></span></a>";

                $data[] = $nestedData;
            }
        }

        $json_data = array(
                    "draw"            => intval($request->input('draw')),
                    "recordsTotal"    => intval($totalData),
                    "recordsFiltered" => intval($totalFiltered->count()),
                    "style"           => '',
                    "data"            => $data
                    );

        return json_encode($json_data);
    }
}
