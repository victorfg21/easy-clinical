<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Profissional extends Model
{
    protected $table = 'profissionais';

    protected $fillable = [
        'nome', 'rg', 'cpf', 'conselho', 'numero_registro',
        'dt_nasc', 'sexo', 'celular', 'telefone', 'numero',
        'endereco', 'complemento', 'bairro', 'cidade', 'estado',
        'cep'
    ];

    public function User(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function Foto(){
        return $this->hasOne(Foto::class, 'id', 'foto_id');
    }

    public function AreasAtuacao(){
        return $this->belongsToMany(AreaAtuacao::class);
    }

    public function Especialidades(){
        return $this->belongsToMany(Especialidade::class);
    }

    //Listar os profissionais no DataTable da página Index
    public function ListarProfissionais(Request $request)
    {
        $columns = array(
            0 => 'nome',
            1 => 'conselho',
            2 => 'numero_registro'
        );

        $totalData = $this->count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {
            $profissionais = $this;
            $totalFiltered = $this;
        }
        else {
            $search = $request->input('search.value');
            $profissionais =  $this->where('nome','LIKE',"%{$search}%")
                                ->orWhere('conselho','LIKE',"%{$search}%")
                                ->orWhere('numero_registro','LIKE',"%{$search}%");
            $totalFiltered = $this->where('nome','LIKE',"%{$search}%")
                                    ->orWhere('conselho','LIKE',"%{$search}%")
                                    ->orWhere('numero_registro','LIKE',"%{$search}%");
        }
        $data = array();
        if(!empty($profissionais))
        {
            $profissionais = $profissionais->offset($start)
                                 ->limit($limit)
                                 ->orderBy($order,$dir)
                                 ->get();
            foreach ($profissionais as $profissional)
            {
                $edit =  route('admin.profissionais.edit',$profissional->id);

                $nestedData['id'] = $profissional->id;
                $nestedData['nome'] = $profissional->nome;
                $nestedData['numero_registro'] = $profissional->numero_registro;
                $nestedData['conselho'] = $profissional->conselho;
                $nestedData['action'] = "<a href='#' title='Editar Profissional'
                                          onclick=\"modalBootstrap('{$edit}', 'Editar Profissional', '#modal_Large', '', 'true', 'true', 'false', 'Atualizar', 'Fechar')\"><span class='glyphicon glyphicon-edit'></span></a>";

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
