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
        Route::post('search'                    , array('uses' => 'PACIENTE\PacienteController@search'));

    });


    Route::group(['prefix' => 'medics/']    , function () {
        Route::get('/'                          , array('uses' => 'MEDIC\MedicController@index'))->name('medics.index');
        Route::any('listado'                    , array('uses' => 'MEDIC\MedicController@listado'))->name('medics.listado');
        Route::post('form'                      , array('uses' => 'MEDIC\MedicController@postForm'));
        Route::get('{id}'                       , array('uses' => 'MEDIC\MedicController@profile'))->name('medics.profile');
        Route::post('{id}/edit'                 , array('uses' => 'MEDIC\MedicController@edit'))->name('medics.edit');
        Route::post('{id}/delete'               , array('uses' => 'MEDIC\MedicController@delete'))->name('medics.delete');
        Route::post('do-post'                   , array('uses' => 'MEDIC\MedicController@postDoPost'))->name('medics.dopost');
        Route::post('search'                    , array('uses' => 'MEDIC\MedicController@search'));
    });


    Route::group(['prefix' => 'appointments/']      , function () {
        Route::get('/'                          , array('uses' => 'APPOINTMENTS\AppointmentManagerController@index'))->name('appointments.index');
        Route::post('data-table-list'           , array('uses' => 'APPOINTMENTS\AppointmentManagerController@postDataTableList'))->name('appointments.data');
        Route::post('do-post'                   , array('uses' => 'APPOINTMENTS\AppointmentManagerController@postDoPost'))->name('appointments.dopost');
        Route::post('form'                      , array('uses' => 'APPOINTMENTS\AppointmentManagerController@postForm'));
    });

});


