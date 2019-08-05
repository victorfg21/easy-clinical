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
                //$show =  route('admin.pacientes.editar',$paciente->id);
                $edit =  route('admin.pacientes.atualizar',$paciente->id);
                
                $nestedData['id'] = $paciente->id;
                $nestedData['nome'] = $paciente->nome;
                $nestedData['cpf'] = $paciente->cpf;
                $nestedData['ih'] = $paciente->ih;
                $nestedData['editar'] = "<a href='#' title='Editar Paciente' 
                                          onclick=\"modalBootstrap('{$edit}', 'Editar Paciente', '#modal_CRUD', '', 'true', 'true', 'false', 'Atualizar', 'Fechar')\"><span class='glyphicon glyphicon-edit'></span></a>";
                
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
