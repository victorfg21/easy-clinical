<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ExameMaterial extends Model
{
    protected $table = 'exame_materiais';

    protected $fillable = [
        'nome'
    ];

    //Listar as areas de atuação no DataTable da página Index
    public function ListarExameMateriais(Request $request)
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
            $exameMateriais = $this;
            $totalFiltered = $this;
        }
        else {
            $search = $request->input('search.value');
            $exameMateriais =  $this->where('nome','LIKE',"%{$search}%");
            $totalFiltered = $this->where('nome','LIKE',"%{$search}%");
        }
        $data = array();
        if(!empty($exameMateriais))
        {
            $exameMateriais = $exameMateriais->offset($start)
                                 ->limit($limit)
                                 ->orderBy($order,$dir)
                                 ->get();
            foreach ($exameMateriais as $exameMaterial)
            {
                $edit =  route('admin.exame-materiais.edit', $exameMaterial->id);
                $delete =  route('admin.exame-materiais.delete', $exameMaterial->id);

                $nestedData['nome'] = $exameMaterial->nome;
                $nestedData['action'] = "<a href='#' title='Editar Material'
                                                onclick=\"modalBootstrap('{$edit}', 'Editar Material', '#modal_CRUD', '', 'true', 'true', 'false', 'Atualizar', 'Fechar')\"><span class='glyphicon glyphicon-edit'></span></a>
                                                &emsp;<a href='#' title='Excluir Material'
                                                onclick=\"modalBootstrap('{$delete}', 'Excluir Material', '#modal_CRUD', '', 'true', 'true', 'false', 'Sim', 'Não')\"><span class='glyphicon glyphicon-trash'></span></a>";


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
