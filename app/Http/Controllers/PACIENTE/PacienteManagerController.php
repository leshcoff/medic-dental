<?php

namespace App\Http\Controllers\PACIENTE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use Escom\Base\CBase;

class PacienteManagerController extends CBase
{

    protected $page = "/patients";


    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index(){

        $config = [
            "route"     => $this->page,
            "view"      => "SHARED.datatables",
            'title'     => "Listado de Pacientes",
        ];

        $CPacientes     = new PacienteController($config);
        $view        = $CPacientes->index();

        return View::make('PACIENTE.manager')
            ->with('page',$this->page)
            ->with('view', $view);

    }


    /**
     * @param Request $request
     * @return |null
     */
    public function postDataTableList(Request $request)
    {
        $response = null;

        try
        {

            $config = [
                "route"     => $this->page,
                "view"      => "SHARED.datatables",
                'title'     => "PATIENTS",
            ];
            $CPacientes   = new PacienteController($config);
            $CPacientes->setConfig([]);
            $response =   $CPacientes->postDataTableList($request);


        }catch (Exception $e){

        }

        return $response;
    }


    public function postForm(){

        $config = [
            "route"     => $this->page,
            "view"      => "PACIENTE.form",
            'title'     => "PATIENTS",
        ];

        $CPacientes   = new PacienteController($config);
        return  $CPacientes->postForm( );

    }


    /**
     * @param Request $request
     * @return mixed|string
     */
    public function postDoPost(Request $request){

        $config = [
            "route"     => $this->page,
            "view"      => "PACIENTE.form",
            'title'     => "PATIENTS",
        ];

        $CPacientes   = new PacienteController($config);

        /**
         * Envia el ID de la empresa que se esta configurando
         */
        return  $CPacientes->postDoPost( );


    }

}
