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
//Route::get('admin/pacientes/show/{id}', ['as' => 'admin.pacientes.show', 'uses' => 'Admin\PacienteController@show']);
Route::get('admin/pacientes/edit/{id}', ['as' => 'admin.pacientes.edit', 'uses' => 'Admin\PacienteController@edit']);
Route::put('admin/pacientes/update/{id}', ['as' => 'admin.pacientes.update', 'uses' => 'Admin\PacienteController@update']);
Route::get('admin/pacientes/listarpacientes', ['as' => 'admin.pacientes.listarpacientes', 'uses' => 'Admin\PacienteController@listarpacientes']);
//Route::get('admin/pacientes/listarpacientes', ['as' => 'admin.pacientes.listarpacientes', 'uses' => 'Admin\PacienteController@listarpacientes']);
//Route::get('admin/pacientes/deletar/{id}', ['as' => 'admin.pacientes.deletar', 'uses' => 'Admin\PacienteController@deletar']);