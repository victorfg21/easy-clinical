<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class AreaAtuacao extends Model
{
    protected $table = 'areas_atuacao';

    protected $fillable = [
        'nome'
    ];

    public function Profissionais(){
        return $this->belongsToMany(Profissional::class);
    }

    //Listar as areas de atuação no DataTable da página Index
    public function ListarAreasAtuacao(Request $request)
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
            $areasAtuacao = $this;
            $totalFiltered = $this;
        }
        else {
            $search = $request->input('search.value');
            $areasAtuacao =  $this->where('nome','LIKE',"%{$search}%");
            $totalFiltered = $this->where('nome','LIKE',"%{$search}%");
        }
        $data = array();
        if(!empty($areasAtuacao))
        {
            $areasAtuacao = $areasAtuacao->offset($start)
                                 ->limit($limit)
                                 ->orderBy($order,$dir)
                                 ->get();
            foreach ($areasAtuacao as $areaAtuacao)
            {
                $edit =  route('admin.areas-atuacao.edit', $areaAtuacao->id);
                $delete =  route('admin.areas-atuacao.delete', $areaAtuacao->id);

                $nestedData['nome'] = $areaAtuacao->nome;
                $nestedData['action'] = "<a href='#' title='Editar Área de Atuação'
                                                onclick=\"modalBootstrap('{$edit}', 'Editar Área de Atuação', '#modal_CRUD', '', 'true', 'true', 'false', 'Atualizar', 'Fechar')\"><span class='glyphicon glyphicon-edit'></span></a>
                                                &emsp;<a href='#' title='Excluir Área de Atuação'
                                                onclick=\"modalBootstrap('{$delete}', 'Excluir Área de Atuação', '#modal_CRUD', '', 'true', 'true', 'false', 'Sim', 'Não')\"><span class='glyphicon glyphicon-trash'></span></a>";


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
