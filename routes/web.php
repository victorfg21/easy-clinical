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

Auth::routes();

Route::get('/', function(){
    return view('auth/login');
});

Route::get('home', ['as' => 'home', 'uses' => 'HomeController@index']);

Route::get('/tasks', 'TaskController@index');

//Pacientes
Route::get('admin/pacientes', ['as' => 'admin.pacientes', 'uses' => 'Admin\PacienteController@index']);
Route::get('admin/pacientes/create', ['as' => 'admin.pacientes.create', 'uses' => 'Admin\PacienteController@create']);
Route::post('admin/pacientes/store', ['as' => 'admin.pacientes.store', 'uses' => 'Admin\PacienteController@store']);
Route::get('admin/pacientes/edit/{id}', ['as' => 'admin.pacientes.edit', 'uses' => 'Admin\PacienteController@edit']);
Route::put('admin/pacientes/update/{id}', ['as' => 'admin.pacientes.update', 'uses' => 'Admin\PacienteController@update']);
Route::get('admin/pacientes/listarpacientes', ['as' => 'admin.pacientes.listarpacientes', 'uses' => 'Admin\PacienteController@listarpacientes']);
//Route::get('admin/pacientes/deletar/{id}', ['as' => 'admin.pacientes.deletar', 'uses' => 'Admin\PacienteController@delete']);

//Profissionais
Route::get('admin/profissionais', ['as' => 'admin.profissionais', 'uses' => 'Admin\ProfissionalController@index']);
Route::get('admin/profissionais/create', ['as' => 'admin.profissionais.create', 'uses' => 'Admin\ProfissionalController@create']);
Route::post('admin/profissionais/store', ['as' => 'admin.profissionais.store', 'uses' => 'Admin\ProfissionalController@store']);
Route::get('admin/profissionais/edit/{id}', ['as' => 'admin.profissionais.edit', 'uses' => 'Admin\ProfissionalController@edit']);
Route::put('admin/profissionais/update/{id}', ['as' => 'admin.profissionais.update', 'uses' => 'Admin\ProfissionalController@update']);
Route::get('admin/profissionais/listarpacientes', ['as' => 'admin.profissionais.listarprofissionais', 'uses' => 'Admin\ProfissionalController@listarprofissionais']);
//Route::get('admin/profissionais/deletar/{id}', ['as' => 'admin.profissionais.deletar', 'uses' => 'Admin\ProfissionalController@delete']);

//Especialidades
Route::get('admin/especialidades', ['as' => 'admin.especialidades', 'uses' => 'Admin\EspecialidadeController@index']);
Route::get('admin/especialidades/create', ['as' => 'admin.especialidades.create', 'uses' => 'Admin\EspecialidadeController@create']);
Route::post('admin/especialidades/store', ['as' => 'admin.especialidades.store', 'uses' => 'Admin\EspecialidadeController@store']);
Route::get('admin/especialidades/edit/{id}', ['as' => 'admin.especialidades.edit', 'uses' => 'Admin\EspecialidadeController@edit']);
Route::put('admin/especialidades/update/{id}', ['as' => 'admin.especialidades.update', 'uses' => 'Admin\EspecialidadeController@update']);
Route::get('admin/especialidades/listarespecialidades', ['as' => 'admin.especialidades.listarespecialidades', 'uses' => 'Admin\EspecialidadeController@listarespecialidades']);
Route::get('admin/especialidades/delete/{id}', ['as' => 'admin.especialidades.delete', 'uses' => 'Admin\EspecialidadeController@delete']);

//Area Atuações
Route::get('admin/areas-atuacao', ['as' => 'admin.areas-atuacao', 'uses' => 'Admin\AreaAtuacaoController@index']);
Route::get('admin/areas-atuacao/create', ['as' => 'admin.areas-atuacao.create', 'uses' => 'Admin\AreaAtuacaoController@create']);
Route::post('admin/areas-atuacao/store', ['as' => 'admin.areas-atuacao.store', 'uses' => 'Admin\AreaAtuacaoController@store']);
Route::get('admin/areas-atuacao/edit/{id}', ['as' => 'admin.areas-atuacao.edit', 'uses' => 'Admin\AreaAtuacaoController@edit']);
Route::put('admin/areas-atuacao/update/{id}', ['as' => 'admin.areas-atuacao.update', 'uses' => 'Admin\AreaAtuacaoController@update']);
Route::get('admin/areas-atuacao/listarareasatuacao', ['as' => 'admin.areas-atuacao.listarareasatuacao', 'uses' => 'Admin\AreaAtuacaoController@listarareasatuacao']);
Route::get('admin/areas-atuacao/delete/{id}', ['as' => 'admin.areas-atuacao.delete', 'uses' => 'Admin\AreaAtuacaoController@delete']);
