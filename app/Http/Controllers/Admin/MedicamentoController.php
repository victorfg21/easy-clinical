<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\MedicamentoRequest;
use App\Http\Controllers\Controller;
use App\Medicamento;
use App\Fabricante;
use Illuminate\Support\Facades\DB;
use Exception;

class MedicamentoController extends Controller
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

        $medicamentos = Medicamento::orderBy('nome_generico')->get();
        return view('admin.medicamentos.index', compact('medicamentos'));
    }
    //Método que lista todos os usuarios no DataTable da Tela
    public function listarmedicamentos(Request $req)
    {
        if (!$req->user()->authorizeRoles('superadministrator'))
            abort(403, 'Você não possui autorização para realizar essa ação.');

        $medicamentos = new Medicamento;
        return $medicamentos->ListarMedicamentos($req);
    }

    public function create(Request $req)
    {
        if (!$req->user()->authorizeRoles('superadministrator'))
            abort(403, 'Você não possui autorização para realizar essa ação.');

        $fabricante_list = Fabricante::orderBy('nome')->get();
        return view('admin.medicamentos.create', [
            'fabricante_list' => $fabricante_list
        ]);
    }

    public function store(MedicamentoRequest $req)
    {
        if (!$req->user()->authorizeRoles('superadministrator'))
            abort(403, 'Você não possui autorização para realizar essa ação.');

        $dados = new Medicamento;
        $dados->nome_generico = $req->input('nome_generico');
        $dados->nome_fabrica = $req->input('nome_fabrica');
        $dados->fabricante_id = $req->input('fabricante_id');
        $dados->save();
        return "Cadastrado com sucesso!";
    }

    public function show(Request $req, $id)
    {
        if (!$req->user()->authorizeRoles('superadministrator'))
            abort(403, 'Você não possui autorização para realizar essa ação.');

        $registro = Medicamento::find($id);
        $fabricante_list = Fabricante::orderBy('nome')->get();
        return view('admin.medicamentos.show', [
            'registro' => $registro,
            'fabricante_list' => $fabricante_list
        ]);
    }

    public function edit(Request $req, $id)
    {
        if (!$req->user()->authorizeRoles('superadministrator'))
            abort(403, 'Você não possui autorização para realizar essa ação.');

        $registro = Medicamento::find($id);
        $fabricante_list = Fabricante::orderBy('nome')->get();
        return view('admin.medicamentos.edit', [
            'registro' => $registro,
            'fabricante_list' => $fabricante_list
        ]);
    }

    public function update(MedicamentoRequest $req, $id)
    {
        try {
            if (!$req->user()->authorizeRoles('superadministrator'))
                abort(403, 'Você não possui autorização para realizar essa ação.');

            $dados = Medicamento::find($id);
            $dados->nome_generico = $req->input('nome_generico');
            $dados->nome_fabrica = $req->input('nome_fabrica');
            $dados->fabricante_id = $req->input('fabricante_id');

            $dados->update();
            return "Alterado com sucesso!";
        } catch (Exception $e) {
            return "Ocorreu um erro ao alterar!";
        }
    }

    public function delete(Request $req, $id)
    {
        if (!$req->user()->authorizeRoles('superadministrator'))
            abort(403, 'Você não possui autorização para realizar essa ação.');

        $medicamento = Medicamento::find($id);
        return view('admin.medicamentos.delete', compact('medicamento'));
    }

    public function confirmardelete(Request $req, $id)
    {
        try {
            if (!$req->user()->authorizeRoles('superadministrator'))
                abort(403, 'Você não possui autorização para realizar essa ação.');

            DB::beginTransaction();
            $medicamento = Medicamento::where('id', '=', $id)->delete();
            DB::commit();
            return "Removido com sucesso!";
        } catch (Exception $e) {
            DB::rollback();
            return "Ocorreu um erro ao remover.";
        }
    }
}
