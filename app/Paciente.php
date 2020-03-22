<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Paciente extends Model
{
    protected $table = 'pacientes';

    protected $fillable = [
        'nome', 'rg', 'cpf', 'ih', 'dt_nasc', 'sexo',
        'celular', 'numero', 'endereco', 'complemento',
        'bairro', 'cidade', 'estado', 'cep'
    ];

    public function User(){
        return $this->hasOne(\App\User::class, 'id', 'user_id');
    }

    public function Foto(){
        return $this->hasOne(\App\Foto::class, 'id', 'foto_id');
    }

    //Listar os pacientes no DataTable da página Index
    public function ListarPacientes(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'nome',
            3 => 'cpf',
            4 => 'ih'
        );

        $totalData = $this->count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {
            $pacientes = $this;
            $totalFiltered = $this;
        }
        else {
            $search = $request->input('search.value');
            $pacientes =  $this->where('nome','LIKE',"%{$search}%")
                                ->orWhere('cpf','LIKE',"%{$search}%")
                                ->orWhere('ih','LIKE',"%{$search}%")
                                ->orWhere('rg','LIKE',"%{$search}%");
            $totalFiltered = $this->where('nome','LIKE',"%{$search}%")
                                    ->orWhere('cpf','LIKE',"%{$search}%")
                                    ->orWhere('ih','LIKE',"%{$search}%")
                                    ->orWhere('rg','LIKE',"%{$search}%");
        }
        $data = array();
        if(!empty($pacientes))
        {
            $pacientes = $pacientes->offset($start)
                                 ->limit($limit)
                                 ->orderBy($order,$dir)
                                 ->get();
            foreach ($pacientes as $paciente)
            {
                $edit =  route('admin.pacientes.edit',$paciente->id);

                $nestedData['id'] = $paciente->id;
                $nestedData['nome'] = $paciente->nome;
                $nestedData['cpf'] = $paciente->cpf;
                $nestedData['ih'] = $paciente->ih;
                $nestedData['action'] = "<a href='#' title='Editar Paciente'
                                          onclick=\"modalBootstrap('{$edit}', 'Editar Paciente', '#modal_Large', '', 'true', 'true', 'false', 'Atualizar', 'Fechar')\"><span class='glyphicon glyphicon-edit'></span></a>";

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

    //Listar os pacientes no DataTable da página Index
    public function ListarPacientesHistorico(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'nome',
            1 => 'ih',
            1 => 'cpf'
        );

        $totalData = $this->count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {
            $pacientes = $this;
            $totalFiltered = $this;
        }
        else {
            $search = $request->input('search.value');
            $pacientes =  $this->where('nome','LIKE',"%{$search}%")
                                ->orWhere('cpf','LIKE',"%{$search}%")
                                ->orWhere('ih','LIKE',"%{$search}%")
                                ->orWhere('id','LIKE',"%{$search}%");
            $totalFiltered = $this->where('nome','LIKE',"%{$search}%")
                                    ->orWhere('cpf','LIKE',"%{$search}%")
                                    ->orWhere('ih','LIKE',"%{$search}%")
                                    ->orWhere('id','LIKE',"%{$search}%");
        }
        $data = array();
        if(!empty($pacientes))
        {
            $pacientes = $pacientes->offset($start)
                                 ->limit($limit)
                                 ->orderBy($order,$dir)
                                 ->get();
            foreach ($pacientes as $paciente)
            {
                $show = route('medico.acompanhamento.historico', $paciente->id);

                $nestedData['id'] = $paciente->id;
                $nestedData['nome'] = $paciente->nome;
                $nestedData['cpf'] = $paciente->cpf;
                $nestedData['ih'] = $paciente->ih;

                $nestedData['action'] = "<a href='#' title='Histórico Paciente'
                                          onclick=\"modalBootstrap('{$show}', 'Histórico Paciente', '#modal_Large', '', 'false', 'true', 'false', 'Atualizar', 'Fechar')\"><span class='fa fa-history fa-lg'></span></a>";

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
