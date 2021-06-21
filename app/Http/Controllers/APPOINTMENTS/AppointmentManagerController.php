<?php

namespace App\Http\Controllers\APPOINTMENTS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use Escom\Base\CBase;

class AppointmentManagerController extends CBase
{

    protected $page = "/appointments";


    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index(){

        $config = [
            "route"     => $this->page,
            "view"      => "SHARED.datatables",
            'title'     => "Listado de citas",
        ];

        $CAppointment     = new AppointmentController($config);
        $view        = $CAppointment->index();

        return View::make('APPOINTMENTS.manager')
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
                'title'     => "APPOINTMENTS",
            ];
            $CAppointment   = new AppointmentController($config);
            $CAppointment->setConfig([]);
            $response =   $CAppointment->postDataTableList($request);


        }catch (Exception $e){

        }

        return $response;
    }


    public function postForm(){

        $config = [
            "route"     => $this->page,
            "view"      => "APPOINTMENTS.form",
            'title'     => "APPOINTMENTS",
        ];

        $CAppointment   = new AppointmentController($config);
        return  $CAppointment->postForm( );

    }


    /**
     * @param Request $request
     * @return mixed|string
     */
    public function postDoPost(Request $request){

        $config = [
            "route"     => $this->page,
            "view"      => "APPOINTMENTS.form",
            'title'     => "APPOINTMENTS",
        ];

        $CAppointment   = new AppointmentController($config);

        /**
         * Envia el ID de la empresa que se esta configurando
         */
        return  $CAppointment->postDoPost( );


    }

}
