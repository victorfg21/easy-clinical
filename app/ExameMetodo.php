<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ExameMetodo extends Model
{
    protected $table = 'exame_metodos';

    protected $fillable = [
        'nomes'
    ];

    //Listar as areas de atuação no DataTable da página Index
    public function ListarExameMetodos(Request $request)
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
            $exameMetodos = $this;
            $totalFiltered = $this;
        }
        else {
            $search = $request->input('search.value');
            $exameMetodos =  $this->where('nome','LIKE',"%{$search}%");
            $totalFiltered = $this->where('nome','LIKE',"%{$search}%");
        }
        $data = array();
        if(!empty($exameMetodos))
        {
            $exameMetodos = $exameMetodos->offset($start)
                                 ->limit($limit)
                                 ->orderBy($order,$dir)
                                 ->get();
            foreach ($exameMetodos as $exameMetodo)
            {
                $edit =  route('admin.exame-metodos.edit', $exameMetodo->id);
                $delete =  route('admin.exame-metodos.delete', $exameMetodo->id);

                $nestedData['nome'] = $exameMetodo->nome;
                $nestedData['action'] = "<a href='#' title='Editar Método'
                                                onclick=\"modalBootstrap('{$edit}', 'Editar Método', '#modal_CRUD', '', 'true', 'true', 'false', 'Atualizar', 'Fechar')\"><span class='glyphicon glyphicon-edit'></span></a>
                                                &emsp;<a href='#' title='Excluir Método'
                                                onclick=\"modalBootstrap('{$delete}', 'Excluir Método', '#modal_CRUD', '', 'true', 'true', 'false', 'Sim', 'Não')\"><span class='glyphicon glyphicon-trash'></span></a>";


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
