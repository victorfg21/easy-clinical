<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use App\User;
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

    public function index()
    {
        //if (Auth::user()->authorizeRoles() == false)
        //    abort(403, 'Você não possui autorização para realizar essa ação.');
        $users = User::orderBy('name')->get();
        return view('admin.usuarios.index', compact('users'));
    }
    //Método que lista todos os usuarios no DataTable da Tela
    public function listarusuarios(Request $request)
    {
        //if (Auth::user()->authorizeRoles() == false)
        //    abort(403, 'Você não possui autorização para realizar essa ação.');
        $users = new User;
        return $users->ListarUsuarios($request);
    }

    public function create()
    {
        //if (Auth::user()->authorizeRoles() == false)
        //    abort(403, 'Você não possui autorização para realizar essa ação.');
        return view('admin.usuarios.create');
    }

    public function store(UserRequest $req)
    {
        $dados = new User;
        $dados->name = $req->input('name');
        $dados->email = $req->input('email');
        $dados->password = Hash::make($req->input('password'));
        $dados->tipo_cadastro = Config::get('constants.options.administrativo');

        $dados->save();
        return "Cadastrado com sucesso!";
    }

    public function show($id)
    {
        //if (Auth::user()->authorizeRoles() == false)
        //    abort(403, 'Você não possui autorização para realizar essa ação.');
        $registro = User::find($id);
        return view('admin.usuarios.show', compact('registro'));
    }

    public function edit($id)
    {
        //if (Auth::user()->authorizeRoles() == false)
        //    abort(403, 'Você não possui autorização para realizar essa ação.');
        $registro = User::find($id);
        return view('admin.usuarios.edit', compact('registro'));
    }

    public function update(UserRequest $req, $id)
    {
        try {
            //if (Auth::user()->authorizeRoles() == false)
            //    abort(403, 'Você não possui autorização para realizar essa ação.');

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
