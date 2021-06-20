<?php

use Illuminate\Support\Facades\Route;

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


Route::get ('login'   , 'LOGIN\LoginController@login')->name('login');   // Login, redirecciona al metodo getLogin
Route::post('signin'  , 'LOGIN\LoginController@signin')->name('signin'); // Verificar datos
Route::post('signup'  , 'LOGIN\LoginController@signup')->name('signup'); // Verificar datos
Route::get ('logout'  , 'LOGIN\LoginController@logout')->name('logout'); // Finalizar sesión



#----------------------------------------------------------------------------------------------------------------------------------
# Routes for authenticated users
#----------------------------------------------------------------------------------------------------------------------------------
Route::group(['middleware'=>'auth'], function () {

    Route::get('/', 'DASHBOARD\DashboardController@index')->name('home');

    Route::group(['prefix' => 'patients/']    , function () {
        Route::get('/'                          , array('uses' => 'PACIENTE\PacienteManagerController@index'))->name('patients.index');
        Route::post('data-table-list'           , array('uses' => 'PACIENTE\PacienteManagerController@postDataTableList'))->name('patients.data');
        Route::post('do-post'                   , array('uses' => 'PACIENTE\PacienteManagerController@postDoPost'))->name('patients.dopost');
        Route::post('form'                      , array('uses' => 'PACIENTE\PacienteManagerController@postForm'));
        Route::any('form-ver-pdf'               , array('uses' => 'PACIENTE\PacienteManagerController@postFormPreview'));
        Route::any('{id}/form-detalle'          , array('uses' => 'PACIENTE\PacienteDetallesManagerController@index'));
    });

});


