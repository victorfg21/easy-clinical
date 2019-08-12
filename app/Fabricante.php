<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Fabricante extends Model
{
    protected $table = 'fabricantes';

    protected $fillable = [
        'nome'
    ];

    //Listar as fabricantes no DataTable da página Index
    public function ListarFabricantes(Request $request)
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
            $fabricantes = $this;
            $totalFiltered = $this;
        }
        else {
            $search = $request->input('search.value');
            $fabricantes =  $this->where('nome','LIKE',"%{$search}%");
            $totalFiltered = $this->where('nome','LIKE',"%{$search}%");
        }
        $data = array();
        if(!empty($fabricantes))
        {
            $fabricantes = $fabricantes->offset($start)
                                 ->limit($limit)
                                 ->orderBy($order,$dir)
                                 ->get();
            foreach ($fabricantes as $fabricante)
            {
                $edit =  route('admin.fabricantes.edit', $fabricante->id);
                $delete =  route('admin.fabricantes.delete', $fabricante->id);

                $nestedData['nome'] = $fabricante->nome;
                $nestedData['action'] = "<a href='#' title='Editar Fabricantes'
                                        onclick=\"modalBootstrap('{$edit}', 'Editar Fabricantes', '#modal_CRUD', '', 'true', 'true', 'false', 'Atualizar', 'Fechar')\"><span class='glyphicon glyphicon-edit'></span></a>
                                        &emsp;<a href='#' title='Excluir Fabricantes'
                                        onclick=\"modalBootstrap('{$delete}', 'Excluir Fabricantes', '#modal_CRUD', '', 'true', 'true', 'false', 'Sim', 'Não')\"><span class='glyphicon glyphicon-trash'></span></a>";
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
