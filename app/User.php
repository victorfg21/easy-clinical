<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $primaryKey = 'id';

    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * @param array|string $roles
     */
    public function authorizeRoles($roles)
    {
        if (is_array($roles)) {
            return false;
        }

        return true;
    }

    /**
     * Check multiple roles.
     *
     * @param array $roles
     */
    public function hasAnyRole($roles)
    {
        return null !== $this->roles()->whereIn('name', $roles)->first();
    }

    /**
     * Check one role.
     *
     * @param string $role
     */
    public function hasRole($role)
    {
        return null !== $this->roles()->where('name', $role)->first();
    }

    //Listar os usuários no DataTable da página Index
    public function ListarUsuarios(Request $request)
    {
        $columns = [
            0 => 'name',
            1 => 'email',
        ];

        $totalData = $this->count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $users = $this;
            $totalFiltered = $this;
        } else {
            $search = $request->input('search.value');
            $users = $this->where('name', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%")
            ;
            $totalFiltered = $this->where('nome', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%")
            ;
        }
        $data = [];
        if (!empty($users)) {
            $users = $users->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get()
            ;
            foreach ($users as $user) {
                $edit = route('admin.usuarios.edit', $user->id);
                $delete =  route('admin.usuarios.delete', $user->id);
                $link = "";
                if(DB::table('role_user')->where('user_id', '=', $user->id)->where('role_id', '=', '4')->count() > 0)
                {
                    $link ="<a href='#' title='Editar Usuário'
                            onclick=\"modalBootstrap('{$edit}', 'Editar Usuário', '#modal_CRUD', '', 'true', 'true', 'false', 'Atualizar', 'Fechar')\"><span class='glyphicon glyphicon-edit'></span></a>
                            &emsp;<a href='#' title='Excluir Usuário'
                            onclick=\"modalBootstrap('{$delete}', 'Excluir Usuário', '#modal_CRUD', '', 'true', 'true', 'false', 'Sim', 'Não')\"><span class='glyphicon glyphicon-trash'></span></a>";
                }
                else
                {
                    $link = "<a href='#' title='Editar Usuário' onclick=\"modalBootstrap('{$edit}', 'Editar Usuário', '#modal_CRUD', '', 'true', 'true', 'false', 'Atualizar', 'Fechar')\"><span class='glyphicon glyphicon-edit'></span></a>
                            &emsp;";
                }

                $nestedData['name'] = $user->name;
                $nestedData['email'] = $user->email;
                $nestedData['action'] = $link;
                $data[] = $nestedData;
            }
        }

        $json_data = [
            'draw' => intval($request->input('draw')),
            'recordsTotal' => intval($totalData),
            'recordsFiltered' => intval($totalFiltered->count()),
            'style' => '',
            'data' => $data,
        ];

        return json_encode($json_data);
    }
}
