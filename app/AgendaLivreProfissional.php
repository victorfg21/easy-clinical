<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class AgendaLivreProfissional extends Model
{
    protected $table = 'agenda_livre_profissionais';

    protected $fillable = [
        'data_livre', 'inicio_periodo', 'fim_periodo', 'motivo'
    ];

    public function Profissional(){
        return $this->hasOne(\App\Profissional::class, 'id', 'profissional_id');
    }

    //Listar os pacientes no DataTable da página Index
    public function ListarAgendaLivreProfissionais(Request $request)
    {
        $columns = array(
            0 => 'nome',
            1 => 'data_livre'
        );

        $totalData = $this->count();
        $limit = $request->input('length');
        $start = $request->input('start');
        //$order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {
            $agendaLivreProfissionais = $this;
            $totalFiltered = $this;
        }
        else {
            $search = $request->input('search.value');
            $agendaLivreProfissionais =  $this->select('profissionais.nome', 'agenda_livre_profissionais.*')
                                ->join('profissionais', 'agenda_livre_profissionais.profissional_id', '=', 'profissionais.id')
                                ->where('profissionais.nome','LIKE',"%{$search}%")
                                ->whereDate('inicio_periodo', '>=', "{$search}")
                                ->whereDate('fim_periodo', '<=', "{$search}");
            $totalFiltered = $this->join('profissionais', 'agenda_livre_profissionais.profissional_id', '=', 'profissionais.id')
                                    ->where('profissionais.nome','LIKE',"%{$search}%")
                                    ->whereDate('inicio_periodo', '>=', "{$search}")
                                    ->whereDate('fim_periodo', '<=', "{$search}");
        }
        $data = array();
        if(!empty($agendaLivreProfissionais))
        {
            $agendaLivreProfissionais = $agendaLivreProfissionais->offset($start)
                                 ->limit($limit)
                                 //->orderBy($order,$dir)
                                 ->get();
            foreach ($agendaLivreProfissionais as $agendaLivre)
            {
                //$show =  route('admin.agendaLivreProfissionais.editar',$agendaLivre->id);
                $edit = route('admin.agenda-livre-profissionais.edit', $agendaLivre->id);

                $nestedData['id'] = $agendaLivre->id;
                $nestedData['nome'] = $agendaLivre->Profissional->nome;
                $nestedData['data_livre'] = date('d/m/Y', strtotime($agendaLivre->data_livre));

                $nestedData['action'] = "<a href='#' title='Editar Agenda Livre'
                                          onclick=\"modalBootstrap('{$edit}', 'Editar Livre', '#modal_Large', '', 'true', 'true', 'false', 'Atualizar', 'Fechar')\"><span class='glyphicon glyphicon-edit'></span></a>";

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
