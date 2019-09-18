<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ExameGrupo extends Model
{
    protected $table = 'exame_grupos';

    protected $fillable = [
        'nome'
    ];

    //Listar as areas de atuação no DataTable da página Index
    public function ListarexameGrupos(Request $request)
    {
        $columns = array(
            0 => 'nome'
        );

        $totalData = $this->count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {
            $exameGrupos = $this;
            $totalFiltered = $this;
        }
        else {
            $search = $request->input('search.value');
            $exameGrupos =  $this->where('nome','LIKE',"%{$search}%");
            $totalFiltered = $this->where('nome','LIKE',"%{$search}%");
        }
        $data = array();
        if(!empty($exameGrupos))
        {
            $exameGrupos = $exameGrupos->offset($start)
                                 ->limit($limit)
                                 ->orderBy($order,$dir)
                                 ->get();
            foreach ($exameGrupos as $exameGrupo)
            {
                $edit =  route('admin.exame-metodos.edit', $exameGrupo->id);
                $delete =  route('admin.exame-metodos.delete', $exameGrupo->id);

                $nestedData['nome'] = $exameGrupo->nome;
                $nestedData['action'] = "<a href='#' title='Editar Grupo'
                                                onclick=\"modalBootstrap('{$edit}', 'Editar Grupo', '#modal_CRUD', '', 'true', 'true', 'false', 'Atualizar', 'Fechar')\"><span class='glyphicon glyphicon-edit'></span></a>
                                                &emsp;<a href='#' title='Excluir Grupo'
                                                onclick=\"modalBootstrap('{$delete}', 'Excluir Grupo', '#modal_CRUD', '', 'true', 'true', 'false', 'Sim', 'Não')\"><span class='glyphicon glyphicon-trash'></span></a>";


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
