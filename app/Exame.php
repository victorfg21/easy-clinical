<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Exame extends Model
{
    protected $table = 'exames';

    protected $fillable = [
        'nome'
    ];

    public function ExameMetodo(){
        return $this->hasOne(ExameMetodo::class, 'id', 'exame_metodo_id');
    }

    public function ExameMaterial(){
        return $this->hasOne(ExameMaterial::class, 'id', 'exame_material_id');
    }

    public function ValoresReferencia(){
        return $this->belongsToMany(ValorReferencia::class);
    }

    //Listar os exames no DataTable da página Index
    public function ListarExames(Request $request)
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
            $exames = $this;
            $totalFiltered = $this;
        }
        else {
            $search = $request->input('search.value');
            $exames =  $this->where('nome','LIKE',"%{$search}%");
            $totalFiltered = $this->where('nome','LIKE',"%{$search}%");
        }
        $data = array();
        if(!empty($exames))
        {
            $exames = $exames->offset($start)
                                 ->limit($limit)
                                 ->orderBy($order,$dir)
                                 ->get();
            foreach ($exames as $exame)
            {
                $edit =  route('admin.exames.edit',$exame->id);

                $nestedData['id'] = $exame->id;
                $nestedData['nome'] = $exame->nome;
                $nestedData['action'] = "<a href='#' title='Editar exame'
                                          onclick=\"modalBootstrap('{$edit}', 'Editar exame', '#modal_Large', '', 'true', 'true', 'false', 'Atualizar', 'Fechar')\"><span class='glyphicon glyphicon-edit'></span></a>";

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
