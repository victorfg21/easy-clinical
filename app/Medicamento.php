<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Medicamento extends Model
{
    protected $table = 'medicamentos';

    protected $fillable = [
        'nome_generico', 'nome_fabrica'
    ];

    public function Fabricante(){
        return $this->hasOne(\App\Fabricante::class, 'id', 'fabricante_id');
    }

    //Listar as medicamentos no DataTable da página Index
    public function ListarMedicamentos(Request $request)
    {
        $columns = array(
            0 => 'nome_generico',
            1 => 'nome_generico',
            2 => 'fabricante_id'
        );

        $totalData = $this->count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {
            $medicamentos = $this;
            $totalFiltered = $this;
        }
        else {
            $search = $request->input('search.value');
            $medicamentos =  $this->join('fabricantes', 'medicamentos.fabricante_id', '=', 'fabricantes.id')
                                    ->where('nome_fabrica','LIKE',"%{$search}%")
                                    ->orWhere('nome_generico','LIKE',"%{$search}%")
                                    ->orWhere('nome','LIKE',"%{$search}%");
            $totalFiltered = $this->join('fabricantes', 'medicamentos.fabricante_id', '=', 'fabricantes.id')
                                    ->where('nome_fabrica','LIKE',"%{$search}%")
                                    ->orWhere('nome_generico','LIKE',"%{$search}%")
                                    ->orWhere('fabricantes.nome','LIKE',"%{$search}%");
        }
        $data = array();
        if(!empty($medicamentos))
        {
            $medicamentos = $medicamentos->offset($start)
                                 ->limit($limit)
                                 ->orderBy($order,$dir)
                                 ->get();
            foreach ($medicamentos as $medicamento)
            {
                $fabricante = Fabricante::find($medicamento->fabricante_id);

                $edit =  route('admin.medicamentos.edit', $medicamento->id);
                $delete =  route('admin.medicamentos.delete', $medicamento->id);

                $nestedData['nome_fabrica'] = $medicamento->nome_fabrica;
                $nestedData['nome_generico'] = $medicamento->nome_generico;
                $nestedData['fabricante'] = $fabricante->nome;
                $nestedData['action'] = "<a href='#' title='Editar Medicamentos'
                                        onclick=\"modalBootstrap('{$edit}', 'Editar Medicamentos', '#modal_CRUD', '', 'true', 'true', 'false', 'Atualizar', 'Fechar')\"><span class='glyphicon glyphicon-edit'></span></a>
                                        &emsp;<a href='#' title='Excluir Medicamentos'
                                        onclick=\"modalBootstrap('{$delete}', 'Excluir Medicamentos', '#modal_CRUD', '', 'true', 'true', 'false', 'Sim', 'Não')\"><span class='glyphicon glyphicon-trash'></span></a>";
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
