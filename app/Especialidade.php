<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Especialidade extends Model
{
    protected $table = 'especialidades';

    protected $fillable = [
        'nome'
    ];

    public function Profissionais(){
        return $this->belongsToMany(Profissional::class);
    }

    //Listar as especialidades no DataTable da página Index
    public function ListarEspecialidades(Request $request)
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
            $especialidades = $this;
            $totalFiltered = $this;
        }
        else {
            $search = $request->input('search.value');
            $especialidades =  $this->where('nome','LIKE',"%{$search}%");
            $totalFiltered = $this->where('nome','LIKE',"%{$search}%");
        }
        $data = array();
        if(!empty($especialidades))
        {
            $especialidades = $especialidades->offset($start)
                                 ->limit($limit)
                                 ->orderBy($order,$dir)
                                 ->get();
            foreach ($especialidades as $especialidade)
            {
                $edit =  route('admin.especialidades.edit', $especialidade->id);

                $nestedData['nome'] = $especialidade->nome;
                $nestedData['action'] = "<a href='#' title='Editar Especialidades'
                                          onclick=\"modalBootstrap('{$edit}', 'Editar Especialidades', '#modal_CRUD', '', 'true', 'true', 'false', 'Atualizar', 'Fechar')\"><span class='glyphicon glyphicon-edit'></span></a>";

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
