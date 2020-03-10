<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Broadcast;

Auth::routes();
Broadcast::routes();

Route::get('/', function () {
    return view('auth/login');
});

Route::get('home', ['as' => 'home', 'uses' => 'HomeController@index']);

//Route::get('/tasks', 'TaskController@index');

//Usuários
Route::get('admin/usuarios', ['as' => 'admin.usuarios', 'uses' => 'Admin\UsuarioController@index']);
Route::get('admin/usuarios/create', ['as' => 'admin.usuarios.create', 'uses' => 'Admin\UsuarioController@create']);
Route::post('admin/usuarios/store', ['as' => 'admin.usuarios.store', 'uses' => 'Admin\UsuarioController@store']);
Route::get('admin/usuarios/edit/{id}', ['as' => 'admin.usuarios.edit', 'uses' => 'Admin\UsuarioController@edit']);
Route::put('admin/usuarios/update/{id}', ['as' => 'admin.usuarios.update', 'uses' => 'Admin\UsuarioController@update']);
Route::get('admin/usuarios/listarusuarios', ['as' => 'admin.usuarios.listarusuarios', 'uses' => 'Admin\UsuarioController@listarusuarios']);

//Medicamentos
Route::get('admin/medicamentos', ['as' => 'admin.medicamentos', 'uses' => 'Admin\MedicamentoController@index']);
Route::get('admin/medicamentos/create', ['as' => 'admin.medicamentos.create', 'uses' => 'Admin\MedicamentoController@create']);
Route::post('admin/medicamentos/store', ['as' => 'admin.medicamentos.store', 'uses' => 'Admin\MedicamentoController@store']);
Route::get('admin/medicamentos/edit/{id}', ['as' => 'admin.medicamentos.edit', 'uses' => 'Admin\MedicamentoController@edit']);
Route::put('admin/medicamentos/update/{id}', ['as' => 'admin.medicamentos.update', 'uses' => 'Admin\MedicamentoController@update']);
Route::get('admin/medicamentos/listarmedicamentos', ['as' => 'admin.medicamentos.listarmedicamentos', 'uses' => 'Admin\MedicamentoController@listarmedicamentos']);
Route::get('admin/medicamentos/delete/{id}', ['as' => 'admin.medicamentos.delete', 'uses' => 'Admin\MedicamentoController@delete']);
Route::post('admin/medicamentos/confirmardelete/{id}', ['as' => 'admin.medicamentos.confirmardelete', 'uses' => 'Admin\MedicamentoController@confirmardelete']);

//Pacientes
Route::get('admin/pacientes', ['as' => 'admin.pacientes', 'uses' => 'Admin\PacienteController@index']);
Route::get('admin/pacientes/create', ['as' => 'admin.pacientes.create', 'uses' => 'Admin\PacienteController@create']);
Route::post('admin/pacientes/store', ['as' => 'admin.pacientes.store', 'uses' => 'Admin\PacienteController@store']);
Route::get('admin/pacientes/edit/{id}', ['as' => 'admin.pacientes.edit', 'uses' => 'Admin\PacienteController@edit']);
Route::put('admin/pacientes/update/{id}', ['as' => 'admin.pacientes.update', 'uses' => 'Admin\PacienteController@update']);
Route::get('admin/pacientes/listarpacientes', ['as' => 'admin.pacientes.listarpacientes', 'uses' => 'Admin\PacienteController@listarpacientes']);

//Profissionais
Route::get('admin/profissionais', ['as' => 'admin.profissionais', 'uses' => 'Admin\ProfissionalController@index']);
Route::get('admin/profissionais/create', ['as' => 'admin.profissionais.create', 'uses' => 'Admin\ProfissionalController@create']);
Route::post('admin/profissionais/store', ['as' => 'admin.profissionais.store', 'uses' => 'Admin\ProfissionalController@store']);
Route::get('admin/profissionais/edit/{id}', ['as' => 'admin.profissionais.edit', 'uses' => 'Admin\ProfissionalController@edit']);
Route::put('admin/profissionais/update/{id}', ['as' => 'admin.profissionais.update', 'uses' => 'Admin\ProfissionalController@update']);
Route::get('admin/profissionais/listarpacientes', ['as' => 'admin.profissionais.listarprofissionais', 'uses' => 'Admin\ProfissionalController@listarprofissionais']);

//Especialidades
Route::get('admin/especialidades', ['as' => 'admin.especialidades', 'uses' => 'Admin\EspecialidadeController@index']);
Route::get('admin/especialidades/create', ['as' => 'admin.especialidades.create', 'uses' => 'Admin\EspecialidadeController@create']);
Route::post('admin/especialidades/store', ['as' => 'admin.especialidades.store', 'uses' => 'Admin\EspecialidadeController@store']);
Route::get('admin/especialidades/edit/{id}', ['as' => 'admin.especialidades.edit', 'uses' => 'Admin\EspecialidadeController@edit']);
Route::put('admin/especialidades/update/{id}', ['as' => 'admin.especialidades.update', 'uses' => 'Admin\EspecialidadeController@update']);
Route::get('admin/especialidades/listarespecialidades', ['as' => 'admin.especialidades.listarespecialidades', 'uses' => 'Admin\EspecialidadeController@listarespecialidades']);
Route::get('admin/especialidades/delete/{id}', ['as' => 'admin.especialidades.delete', 'uses' => 'Admin\EspecialidadeController@delete']);
Route::post('admin/especialidades/confirmardelete/{id}', ['as' => 'admin.especialidades.confirmardelete', 'uses' => 'Admin\EspecialidadeController@confirmardelete']);

//Area Atuações
Route::get('admin/areas-atuacao', ['as' => 'admin.areas-atuacao', 'uses' => 'Admin\AreaAtuacaoController@index']);
Route::get('admin/areas-atuacao/create', ['as' => 'admin.areas-atuacao.create', 'uses' => 'Admin\AreaAtuacaoController@create']);
Route::post('admin/areas-atuacao/store', ['as' => 'admin.areas-atuacao.store', 'uses' => 'Admin\AreaAtuacaoController@store']);
Route::get('admin/areas-atuacao/edit/{id}', ['as' => 'admin.areas-atuacao.edit', 'uses' => 'Admin\AreaAtuacaoController@edit']);
Route::put('admin/areas-atuacao/update/{id}', ['as' => 'admin.areas-atuacao.update', 'uses' => 'Admin\AreaAtuacaoController@update']);
Route::get('admin/areas-atuacao/listarareasatuacao', ['as' => 'admin.areas-atuacao.listarareasatuacao', 'uses' => 'Admin\AreaAtuacaoController@listarareasatuacao']);
Route::get('admin/areas-atuacao/delete/{id}', ['as' => 'admin.areas-atuacao.delete', 'uses' => 'Admin\AreaAtuacaoController@delete']);
Route::post('admin/areas-atuacao/confirmardelete/{id}', ['as' => 'admin.areas-atuacao.confirmardelete', 'uses' => 'Admin\AreaAtuacaoController@confirmardelete']);

//Exame Materiais
Route::get('admin/exame-materiais', ['as' => 'admin.exame-materiais', 'uses' => 'Admin\ExameMaterialController@index']);
Route::get('admin/exame-materiais/create', ['as' => 'admin.exame-materiais.create', 'uses' => 'Admin\ExameMaterialController@create']);
Route::post('admin/exame-materiais/store', ['as' => 'admin.exame-materiais.store', 'uses' => 'Admin\ExameMaterialController@store']);
Route::get('admin/exame-materiais/edit/{id}', ['as' => 'admin.exame-materiais.edit', 'uses' => 'Admin\ExameMaterialController@edit']);
Route::put('admin/exame-materiais/update/{id}', ['as' => 'admin.exame-materiais.update', 'uses' => 'Admin\ExameMaterialController@update']);
Route::get('admin/exame-materiais/listarexamemateriais', ['as' => 'admin.exame-materiais.listarexamemateriais', 'uses' => 'Admin\ExameMaterialController@listarexamemateriais']);
Route::get('admin/exame-materiais/delete/{id}', ['as' => 'admin.exame-materiais.delete', 'uses' => 'Admin\ExameMaterialController@delete']);
Route::post('admin/exame-materiais/confirmardelete/{id}', ['as' => 'admin.exame-materiais.confirmardelete', 'uses' => 'Admin\ExameMaterialController@confirmardelete']);

//Exame Metodos
Route::get('admin/exame-metodos', ['as' => 'admin.exame-metodos', 'uses' => 'Admin\ExameMetodoController@index']);
Route::get('admin/exame-metodos/create', ['as' => 'admin.exame-metodos.create', 'uses' => 'Admin\ExameMetodoController@create']);
Route::post('admin/exame-metodos/store', ['as' => 'admin.exame-metodos.store', 'uses' => 'Admin\ExameMetodoController@store']);
Route::get('admin/exame-metodos/edit/{id}', ['as' => 'admin.exame-metodos.edit', 'uses' => 'Admin\ExameMetodoController@edit']);
Route::put('admin/exame-metodos/update/{id}', ['as' => 'admin.exame-metodos.update', 'uses' => 'Admin\ExameMetodoController@update']);
Route::get('admin/exame-metodos/listarexamemetodos', ['as' => 'admin.exame-metodos.listarexamemetodos', 'uses' => 'Admin\ExameMetodoController@listarexamemetodos']);
Route::get('admin/exame-metodos/delete/{id}', ['as' => 'admin.exame-metodos.delete', 'uses' => 'Admin\ExameMetodoController@delete']);
Route::post('admin/exame-metodos/confirmardelete/{id}', ['as' => 'admin.exame-metodos.confirmardelete', 'uses' => 'Admin\ExameMetodoController@confirmardelete']);

//Exame Grupos
Route::get('admin/exame-grupos', ['as' => 'admin.exame-grupos', 'uses' => 'Admin\ExameGrupoController@index']);
Route::get('admin/exame-grupos/create', ['as' => 'admin.exame-grupos.create', 'uses' => 'Admin\ExameGrupoController@create']);
Route::post('admin/exame-grupos/store', ['as' => 'admin.exame-grupos.store', 'uses' => 'Admin\ExameGrupoController@store']);
Route::get('admin/exame-grupos/edit/{id}', ['as' => 'admin.exame-grupos.edit', 'uses' => 'Admin\ExameGrupoController@edit']);
Route::put('admin/exame-grupos/update/{id}', ['as' => 'admin.exame-grupos.update', 'uses' => 'Admin\ExameGrupoController@update']);
Route::get('admin/exame-grupos/listarexamegrupos', ['as' => 'admin.exame-grupos.listarexamegrupos', 'uses' => 'Admin\ExameGrupoController@listarexamegrupos']);
Route::get('admin/exame-grupos/delete/{id}', ['as' => 'admin.exame-grupos.delete', 'uses' => 'Admin\ExameGrupoController@delete']);
Route::post('admin/exame-grupos/confirmardelete/{id}', ['as' => 'admin.exame-grupos.confirmardelete', 'uses' => 'Admin\ExameGrupoController@confirmardelete']);

//Fabricantes
Route::get('admin/fabricantes', ['as' => 'admin.fabricantes', 'uses' => 'Admin\FabricanteController@index']);
Route::get('admin/fabricantes/create', ['as' => 'admin.fabricantes.create', 'uses' => 'Admin\FabricanteController@create']);
Route::post('admin/fabricantes/store', ['as' => 'admin.fabricantes.store', 'uses' => 'Admin\FabricanteController@store']);
Route::get('admin/fabricantes/edit/{id}', ['as' => 'admin.fabricantes.edit', 'uses' => 'Admin\FabricanteController@edit']);
Route::put('admin/fabricantes/update/{id}', ['as' => 'admin.fabricantes.update', 'uses' => 'Admin\FabricanteController@update']);
Route::get('admin/fabricantes/listarfabricantes', ['as' => 'admin.fabricantes.listarfabricantes', 'uses' => 'Admin\FabricanteController@listarfabricantes']);
Route::get('admin/fabricantes/delete/{id}', ['as' => 'admin.fabricantes.delete', 'uses' => 'Admin\FabricanteController@delete']);
Route::post('admin/fabricantes/confirmardelete/{id}', ['as' => 'admin.fabricantes.confirmardelete', 'uses' => 'Admin\FabricanteController@confirmardelete']);

//Medicamentos
Route::get('admin/medicamentos', ['as' => 'admin.medicamentos', 'uses' => 'Admin\MedicamentoController@index']);
Route::get('admin/medicamentos/create', ['as' => 'admin.medicamentos.create', 'uses' => 'Admin\MedicamentoController@create']);
Route::post('admin/medicamentos/store', ['as' => 'admin.medicamentos.store', 'uses' => 'Admin\MedicamentoController@store']);
Route::get('admin/medicamentos/edit/{id}', ['as' => 'admin.medicamentos.edit', 'uses' => 'Admin\MedicamentoController@edit']);
Route::put('admin/medicamentos/update/{id}', ['as' => 'admin.medicamentos.update', 'uses' => 'Admin\MedicamentoController@update']);
Route::get('admin/medicamentos/listarmedicamentos', ['as' => 'admin.medicamentos.listarmedicamentos', 'uses' => 'Admin\MedicamentoController@listarmedicamentos']);
Route::get('admin/medicamentos/delete/{id}', ['as' => 'admin.medicamentos.delete', 'uses' => 'Admin\MedicamentoController@delete']);
Route::post('admin/medicamentos/confirmardelete/{id}', ['as' => 'admin.medicamentos.confirmardelete', 'uses' => 'Admin\MedicamentoController@confirmardelete']);

//Agendas
Route::get('admin/agendas', ['as' => 'admin.agendas', 'uses' => 'Admin\AgendaController@index']);
Route::get('admin/agendas/create', ['as' => 'admin.agendas.create', 'uses' => 'Admin\AgendaController@create']);
Route::post('admin/agendas/store', ['as' => 'admin.agendas.store', 'uses' => 'Admin\AgendaController@store']);
Route::get('admin/agendas/edit/{id}', ['as' => 'admin.agendas.edit', 'uses' => 'Admin\AgendaController@edit']);
Route::get('admin/agendas/show/{id}', ['as' => 'admin.agendas.show', 'uses' => 'Admin\AgendaController@show']);
Route::put('admin/agendas/update/{id}', ['as' => 'admin.agendas.update', 'uses' => 'Admin\AgendaController@update']);
Route::get('admin/agendas/listaragendas', ['as' => 'admin.agendas.listaragendas', 'uses' => 'Admin\AgendaController@listaragendas']);

//Agenda Livre Profissionais
Route::get('admin/agenda-livre-profissionais', ['as' => 'admin.agenda-livre-profissionais', 'uses' => 'Admin\AgendaLivreProfissionalController@index']);
Route::get('admin/agenda-livre-profissionais/create', ['as' => 'admin.agenda-livre-profissionais.create', 'uses' => 'Admin\AgendaLivreProfissionalController@create']);
Route::get('admin/agenda-livre-profissionais/create-consulta', ['as' => 'admin.agenda-livre-profissionais.create-consulta', 'uses' => 'Admin\AgendaLivreProfissionalController@create']);
Route::post('admin/agenda-livre-profissionais/store', ['as' => 'admin.agenda-livre-profissionais.store', 'uses' => 'Admin\AgendaLivreProfissionalController@store']);
Route::get('admin/agenda-livre-profissionais/edit/{id}', ['as' => 'admin.agenda-livre-profissionais.edit', 'uses' => 'Admin\AgendaLivreProfissionalController@edit']);
Route::get('admin/agenda-livre-profissionais/show/{id}', ['as' => 'admin.agenda-livre-profissionais.show', 'uses' => 'Admin\AgendaLivreProfissionalController@show']);
Route::put('admin/agenda-livre-profissionais/update/{id}', ['as' => 'admin.agenda-livre-profissionais.update', 'uses' => 'Admin\AgendaLivreProfissionalController@update']);
Route::get('admin/agenda-livre-profissionais/listaragendalivreprofissionais', ['as' => 'admin.agenda-livre-profissionais.listaragendalivreprofissionais', 'uses' => 'Admin\AgendaLivreProfissionalController@listaragendalivreprofissionais']);

//Agendamento Consulta
Route::get('atendimento/agendamento-consulta', ['as' => 'atendimento.agendamento-consulta', 'uses' => 'Atendimento\AgendamentoConsultaController@index']);
Route::get('atendimento/agendamento-consulta/create', ['as' => 'atendimento.agendamento-consulta.create', 'uses' => 'Atendimento\AgendamentoConsultaController@create']);
Route::post('atendimento/agendamento-consulta/store', ['as' => 'atendimento.agendamento-consulta.store', 'uses' => 'Atendimento\AgendamentoConsultaController@store']);
Route::get('atendimento/agendamento-consulta/edit/{id}', ['as' => 'atendimento.agendamento-consulta.edit', 'uses' => 'Atendimento\AgendamentoConsultaController@edit']);
Route::get('atendimento/agendamento-consulta/show/{id}', ['as' => 'atendimento.agendamento-consulta.show', 'uses' => 'Atendimento\AgendamentoConsultaController@show']);
Route::put('atendimento/agendamento-consulta/update/{id}', ['as' => 'atendimento.agendamento-consulta.update', 'uses' => 'Atendimento\AgendamentoConsultaController@update']);
Route::get('atendimento/agendamento-consulta/cancel/{id}', ['as' => 'atendimento.agendamento-consulta.cancel', 'uses' => 'Atendimento\AgendamentoConsultaController@cancel']);
Route::get('atendimento/agendamento-consulta/transfer/{id}', ['as' => 'atendimento.agendamento-consulta.transfer', 'uses' => 'Atendimento\AgendamentoConsultaController@transfer']);
Route::post('atendimento/agendamento-consulta/confirmarcancel/{id}', ['as' => 'atendimento.agendamento-consulta.confirmardelete', 'uses' => 'Atendimento\AgendamentoConsultaController@confirmarcancel']);
Route::get('atendimento/agendamento-consulta/listarconsultas', ['as' => 'atendimento.agendamento-consulta.listarconsultas', 'uses' => 'Atendimento\AgendamentoConsultaController@listarconsultas']);
Route::post('atendimento/agendamento-consulta/reservaconsultacancel', ['as' => 'atendimento.agendamento-consulta.reservaconsultacancel', 'uses' => 'Atendimento\AgendamentoConsultaController@reservaconsultacancel']);

//Exames
Route::get('admin/exames', ['as' => 'admin.exames', 'uses' => 'Admin\ExameController@index']);
Route::get('admin/exames/create', ['as' => 'admin.exames.create', 'uses' => 'Admin\ExameController@create']);
Route::post('admin/exames/store', ['as' => 'admin.exames.store', 'uses' => 'Admin\ExameController@store']);
Route::get('admin/exames/edit/{id}', ['as' => 'admin.exames.edit', 'uses' => 'Admin\ExameController@edit']);
Route::put('admin/exames/update/{id}', ['as' => 'admin.exames.update', 'uses' => 'Admin\ExameController@update']);
Route::get('admin/exames/listarexames', ['as' => 'admin.exames.listarexames', 'uses' => 'Admin\ExameController@listarexames']);
Route::get('admin/exames/delete/{id}', ['as' => 'admin.exames.delete', 'uses' => 'Admin\ExameController@delete']);
Route::post('admin/exames/confirmardelete/{id}', ['as' => 'admin.exames.confirmardelete', 'uses' => 'Admin\ExameController@confirmardelete']);
Route::get('admin/exames/listarexamegrupos', ['as' => 'admin.exames.listarexamegrupos', 'uses' => 'Admin\ExameController@listarexamegrupos']);

//Acompanhamento Médico
Route::get('medico/acompanhamento', ['as' => 'medico.acompanhamento', 'uses' => 'Medico\AcompanhamentoController@index']);
Route::get('medico/acompanhamento/realizar/{id}', ['as' => 'medico.acompanhamento.realizar', 'uses' => 'Medico\AcompanhamentoController@realizar']);
Route::get('medico/acompanhamento/listarexames', ['as' => 'medico.acompanhamento.listarexames', 'uses' => 'Medico\AcompanhamentoController@listarexames']);
Route::get('medico/acompanhamento/listarmedicamentos', ['as' => 'medico.acompanhamento.listarmedicamentos', 'uses' => 'Medico\AcompanhamentoController@listarmedicamentos']);
Route::post('medico/acompanhamento/store', ['as' => 'medico.acompanhamento.store', 'uses' => 'Medico\AcompanhamentoController@store']);
Route::get('medico/acompanhamento/historico/{id}', ['as' => 'medico.acompanhamento.historico', 'uses' => 'Medico\AcompanhamentoController@historico']);
Route::get('medico/acompanhamento/printreceita/{id}', ['as' => 'medico.acompanhamento.printreceita', 'uses' => 'Medico\AcompanhamentoController@printreceita']);
Route::get('medico/acompanhamento/printexame/{id}', ['as' => 'medico.acompanhamento.printexame', 'uses' => 'Medico\AcompanhamentoController@printexame']);

//Resultado Exames
Route::get('atendimento/resultado-exame', ['as' => 'atendimento.resultado-exame', 'uses' => 'Atendimento\ResultadoExameController@index']);
Route::get('atendimento/resultado-exame/create/{id}', ['as' => 'atendimento.resultado-exame.create', 'uses' => 'Atendimento\ResultadoExameController@create']);
Route::post('atendimento/resultado-exame/store', ['as' => 'atendimento.resultado-exame.store', 'uses' => 'Atendimento\ResultadoExameController@store']);
Route::get('atendimento/resultado-exame/listarsolicitacoes', ['as' => 'atendimento.resultado-exame.listarsolicitacoes', 'uses' => 'Atendimento\ResultadoExameController@listarsolicitacoes']);

