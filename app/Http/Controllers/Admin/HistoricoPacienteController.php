<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Paciente;
use Illuminate\Http\Request;

class HistoricoPacienteController extends Controller
{
    //construtor
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $req)
    {
        if (!$req->user()->authorizeRoles('superadministrator') && !$req->user()->authorizeRoles('atendente'))
            abort(403, 'Você não possui autorização para realizar essa ação.');

        $paciente_list = Paciente::orderBy('nome')->get();

        return view('admin.historico-paciente.index', compact('paciente_list'));
    }

    //Método que lista todos os usuarios no DataTable da Tela
    public function listarpacienteshistorico(Request $req)
    {
        if (!$req->user()->authorizeRoles('superadministrator') && !$req->user()->authorizeRoles('atendente'))
            abort(403, 'Você não possui autorização para realizar essa ação.');

        $pacientes = new Paciente;
        return $pacientes->ListarPacientesHistorico($req);
    }
}
