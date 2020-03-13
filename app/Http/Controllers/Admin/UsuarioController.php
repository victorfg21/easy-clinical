<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Config;

class UsuarioController extends Controller
{
    //construtor
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $req)
    {
        if (!$req->user()->authorizeRoles('superadministrator'))
            abort(403, 'Você não possui autorização para realizar essa ação.');

        $users = User::orderBy('name')->get();
        return view('admin.usuarios.index', compact('users'));
    }
    //Método que lista todos os usuarios no DataTable da Tela
    public function listarusuarios(Request $req)
    {
        if (!$req->user()->authorizeRoles('superadministrator'))
            abort(403, 'Você não possui autorização para realizar essa ação.');

        $users = new User;
        return $users->ListarUsuarios($req);
    }

    public function create(Request $req)
    {
        if (!$req->user()->authorizeRoles('superadministrator'))
            abort(403, 'Você não possui autorização para realizar essa ação.');

        return view('admin.usuarios.create');
    }

    public function store(UserRequest $req)
    {
        if (!$req->user()->authorizeRoles('superadministrator'))
            abort(403, 'Você não possui autorização para realizar essa ação.');

        $dados = new User;
        $dados->name = $req->input('name');
        $dados->email = $req->input('email');
        $dados->password = Hash::make($req->input('password'));

        $dados->save();

        $role_administrativo  = Role::where('name', 'superadministrator')->first();
        $role_atendente  = Role::where('name', 'atendente')->first();
        
        if($req->input('tipo_cadastro') == "3")
            $dados->roles()->attach($role_administrativo);
        else if($req->input('tipo_cadastro') == "4")
            $dados->roles()->attach($role_atendente);

        return "Cadastrado com sucesso!";
    }

    public function show(Request $req, $id)
    {
        if (!$req->user()->authorizeRoles('superadministrator'))
            abort(403, 'Você não possui autorização para realizar essa ação.');

        $registro = User::find($id);
        return view('admin.usuarios.show', compact('registro'));
    }

    public function edit(Request $req, $id)
    {
        if (!$req->user()->authorizeRoles('superadministrator'))
            abort(403, 'Você não possui autorização para realizar essa ação.');

        $registro = User::find($id);

        $role = DB::table('roles')
                    ->join('role_user', 'roles.id', 'role_user.role_id')
                    ->join('users', 'role_user.user_id', 'users.id')
                    ->where('users.id', '=', $id)
                    ->select('roles.id')
                    ->get()
                    ;

        return view('admin.usuarios.edit', [
            'registro' => $registro,
            'role' => $role[0]->id
        ]);
    }

    public function update(UserRequest $req, $id)
    {
        try {
            if (!$req->user()->authorizeRoles('superadministrator'))
                abort(403, 'Você não possui autorização para realizar essa ação.');

            $dados = User::find($id);
            $dados->name = $req->input('name');
            $dados->email = $req->input('email');
            if ($dados->password != $req->input('password'))
                $dados->password = Hash::make($req->input('password'));

            $dados->update();
            return "Alterado com sucesso!";
        } catch (Exception $e) {
            return "Ocorreu um erro ao alterar!";
        }
    }
}
