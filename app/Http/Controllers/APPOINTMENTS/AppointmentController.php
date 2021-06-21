<?php

namespace App\Http\Controllers\APPOINTMENTS;


use App\Http\Controllers\Controller;


use App\Models\APPOINTMENTS\EMAppointment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

use App\Models\PACIENTE\EMPaciente;
use App\Models\EMGenero;

use Escom\Base\CBase;
use App\Escom\Http\EMResponse;
use App\Escom\Module;
use App\Escom\Utils\EMLib;


class AppointmentController extends CBase
{


    public $module_name = "appointments";
    public $view        = null;
    public $title       = null;
    public $toolbar     = "S";

    /**
     * Parametros adicionales que recibe el controllador para armar el SQL()
     * @var array
     */
    public $params      = [];

    public function __construct($config = [] ){

        parent::__construct();
        $this->route        = isset($config['route'])? $config['route'] : 'Pacientes';
        $this->view         = isset($config['view'])? $config['view'] :'SHARED.datatables';
        $this->title        = isset($config['title'])? $config['title'] :'Patients';
        $this->setLog('logs/apontmenrs.log.php');
    }



    /**
     * BuildSQL
     * Construct the query
     */

    public function buildSQL( $params =[] )
    {

        $where = "";

        $sql = "
        (
            SELECT  
                    a.id,
                    a.date,
                    a.comments,
                    p.id patient_id,
                    p.name,
                    p.lastname,
                    p.birthday,
                    p.gender,
                    p.phone,
                    p.email,
                    p.address,
                    p.notes,
                    p.photo,
                    m.id medic_id,
                    m.name medic_name,
                    m.lastname medic_last_name
                    
              FROM `appointments` a, `patients` p, `medics` m
              WHERE a.patient_id = p.id 
                AND a.medic_id   = m.id
        )";

        return $sql;
    }

    /**
     * -----------------------------------------------------
     * PARAMETROS DE CONFIGURACION DEL MODULO
     * -----------------------------------------------------
     *
     */
    public function Config($data = []){
        $btn = "";

        $sql = $this->buildSQL( $data );

        $items  = [];

        $items[] = array('id'=>'btn_insert'    , 'text'=>'Nueva entrada'      , 'class'=>$btn, 'icon'=>'fa- icon icofont-plus-circle'      , 'action'=>'01'            , 'scope'=>'$this', 'required'=>false , 'handler'=>'', 'width' => '800', 'height'=>'500', 'tooltip'=>'Agregar empleado');
        $items[] = array('id'=>'btn_edit'      , 'text'=>'Modificar'          , 'class'=>$btn, 'icon'=>'fa- icon icofont-ui-edit '              , 'action'=>'02'            , 'scope'=>'$this', 'required'=>true  , 'handler'=>'', 'width' => '800', 'height'=>'500', 'tooltip'=>'Editar empleado');
        $items[] = array('id'=>'btn_delete'    , 'text'=>'Borrar'             , 'class'=>$btn, 'icon'=>'fa- icon icofont-trash '                , 'action'=>'03'            , 'scope'=>'$this', 'required'=>true  , 'handler'=>'', 'tooltip'=>'Eliminar empleado');
        $items[] = array('id'=>'btn_search'    , 'text'=>'Buscar'             , 'class'=>$btn, 'icon'=>'fa- icon icofont-search '                , 'action'=>'seach'         , 'scope'=>'$this', 'required'=>false  , 'handler'=>'HEntrada.postFormSearch', 'tooltip'=>'Buscar');
        $items[] = array('id'=>'btn_refresh'   , 'text'=>'Recargar'           , 'class'=>$btn, 'icon'=>'fa- icon icofont-refresh'                , 'action'=>'05'            , 'scope'=>'$this', 'required'=>false , 'handler'=>'', 'tooltip'=>'Recargar lista de empleados');

        $menu = array(
            array(
                'class' => 'btn-group',
                'parent'=> '',
                'title' => '',
                'icon'  => '',
                'showLabel' => true,
                'items'     => $items
            )
        );

        $columns = array(
            array(
                'parent'     => '',
                'data'       => 'id',
                'title'      => 'ID',
                'tooltip'    => '',
                'visible'    => false,
                'searchable' => false,
                'width'      => '1%'
            ),

            array(
                'parent'     => '',
                'data'       => 'photo',
                'title'      => 'Foto',
                'tooltip'    => 'Nombre(s) del paciente',
                'visible'    => true,
                'searchable' => true,
                'width'      => '5%',
                'sFilter'    => array(
                    'type'  => 'text'
                ),
                'formatter'   => function($data, $row, $col){
                    return "<img src=\"".asset($data)."\" alt=\"\" width=\"40\" height=\"40\" class=\"rounded-500\">";
                }
            ),

            array(
                'parent'     => '',
                'data'       => 'date',
                'title'      => 'Fecha',
                'tooltip'    => 'Fecha de la cita',
                'visible'    => true,
                'searchable' => true,
                'width'      => '5%',
                'sFilter'    => array(
                    'type'  => 'text'
                ),
                'formatter'   => function($data, $row, $col){
                    $date = Carbon::parse($data);
                    return "<div> <span> ". $date->format('d/m/Y') ." </span><br><smal> a las ". $date->format('H:i') ." </smal></div>";
                }
            ),

            array(
                'parent'     => '',
                'data'       => 'name',
                'title'      => 'Nombre',
                'tooltip'    => 'Nombre(s) del paciente',
                'visible'    => true,
                'searchable' => true,
                'width'      => '10%',
                'sFilter'    => array(
                    'type'  => 'text'
                ),
                'formatter'   => function($data, $row, $col){
                    return "<b>$data</b>";
                }
            ),
            array(
                'parent'     => '',
                'data'       => 'lastname',
                'title'      => 'Apellidos',
                'tooltip'    => 'Apellidos del paciente',
                'visible'    => true,
                'searchable' => true,
                'width'      => '15%',
                'sFilter'    => array(
                    'type'  => 'text'
                )
            ),

            array(
                'parent'     => '',
                'data'       => 'phone',
                'title'      => 'Telefono',
                'tooltip'    => 'Numero de telefono',
                'visible'    => true,
                'searchable' => true,
                'width'      => '2%',
                'sFilter'    => array(
                    'type'  => 'text'
                ),
                'formatter'   => function($data, $row, $col){
                    return "
                        <div class=\"d-flex align-items-center nowrap text-primary\"><span class=\"icofont-ui-cell-phone p-0 mr-2\"></span> $data</div>
                    ";
                }
            ),
            array(
                'parent'     => '',
                'data'       => 'email',
                'title'      => 'Email',
                'tooltip'    => 'Email',
                'visible'    => true,
                'searchable' => false,
                'width'      => '10%',
                'sFilter'    => array(
                    'type'  => 'text'
                ),
                'formatter'   => function($data, $row, $col){
                    return "<a href='mailto:".$data."'>" .$data. "</a>";
                }
            ),


            array(
                'parent'     => '',
                'data'       => 'medic_name',
                'title'      => 'Medico',
                'tooltip'    => 'Medico',
                'visible'    => true,
                'searchable' => false,
                'width'      => '10%',
                'sFilter'    => array(
                    'type'  => 'text'
                ),
                'formatter'   => function($data, $row, $col){
                    return "Dr. $data";
                }
            ),


            array(
                'parent'     => '',
                'data'       => 'comments',
                'title'      => 'Motivo',
                'tooltip'    => 'Motivo',
                'visible'    => true,
                'searchable' => false,
                'width'      => '10%',
                'sFilter'    => array(
                    'type'  => 'text'
                )
            ),

        );


        $ajax = [
            "ajax" => "function (data, callback, settings) {
               
               $.ajax({
                 url   : '".url($this->route . '/data-table-list')."',
                 type  : 'POST',
                 data  : data,
                 success:function(data, textStatus, xhr){
                   var json = App.handleResponse(xhr.responseText, xhr.status);
                   callback ( data.request.data );
                   // Do whatever you want.
                 }
               });
           }"
        ];

        $callbacks = [
            "drawCallback" => 'function( settings ) {

                    
            }',
        ];

        $config =[
            'table'            => array(
                'oTable'           => 'oTable',
                'dom'              => 'table-' . $this->module_name,
                'ajax'             => $ajax,
                'columns'          => $columns,
                'source'           => $sql,
                'pkey'             => 'id',
                'alias'            => "appointments",
                'params'           => ['responsive' => false],
                'callbacks'        => $callbacks
            ),
            'modal'            => 'modal-appointments',
            'route'            => $this->route,
            'menu'             => $menu,
            'scripts'          => []
        ];

        return $config;

    }


    /**
     * Es necesario llamarlo antes de ejecutar los metodos buildSQL, dataTableData()
     * @param array $params
     */
    public function setConfig($params = []){
        $this->params = $params;

    }



    /**
     * Display a listing of the resource.
     *
     * $view - Donde se renderizaran los datos
     * @return Response
     */
    public function index()
    {
        $config = $this->Config();

        $emgrid = new Module(ucfirst($this->module_name), $config);
        $emgrid->DataTable($config)
            ->setTitle($this->title)
            ->getDataTable()
            ->setJsInitParam("fixedHeader", ["header" => true])
            ->setJsInitParam("order", [array('1', "ASC")]);

        $view =  \View::make($this->view)
            ->with('config', $config)
            ->with('emgrid', $emgrid)
            ->with('toolbar', 'S');


        return $view;

    }

    /**
     * Extrae los valores del dataTable directamente de la base de datos
     * @return mixed
     */
    public function postDataTableList()
    {
        try
        {
            $post_filters  = \Request::all();
            $MResponse = new EMResponse();

            $config    = $this->Config($post_filters);

            $module    = new Module(ucfirst($this->module_name), $config);

            $data = $module->DataTable($config)->getDataTable()->exec($_REQUEST);
            $MResponse->success($data);

        }catch (Exception $e){
            $MResponse->fail(array('code'=>$e->getCode(), 'message'=>$e->getMessage(), 'line'=>$e->getLine() ));
        }

        return $MResponse->built()->json();
    }


    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function postForm(){

        $medicos     = [];
        $pacientes   = [];
        $rowid       = \Request::get('rowid');
        $doAction    = \Request::get('doAction');
        $route       = EMLib::routeController($this->route, $rowid, $doAction);


        $generos = [''=>'Elige genero']+EMGenero::orderBy('id')
                ->pluck('name','id')
                ->toArray();


        $model  = EMAppointment::find($rowid);
        if ($model){

            $pacientes  = [$model->patient_id => $model->patient->getFullName()];
            $medicos    = [$model->medic_id => $model->medic->getFullName()];
        }

        return View::make( $this->view )
            ->with('route'      , $route)
            ->with('rowid'      , $rowid)
            ->with('doAction'   , $doAction)
            ->with('model'      , $model)
            ->with('generos'    , $generos)
            ->with('medicos'    , $medicos)
            ->with('pacientes'  , $pacientes)
            ->with('psearch'    , url("/patients/search"))
            ->with('msearch'    , url("/medics/search"))
            ;

    }









    /**
     * Captura las peticiones que vienen por el formulario
     * @return mixed
     */
    public function postDoPost(  ){
        try
        {
            $this->MResponse->reset();

            $doAction = \Request::get("doAction");
            $rowid    = \Request::get("rowid");

            switch ($doAction){
                case  '01' :
                    $trans   = $this->insert( \Request::all());
                    break;
                case  '02' :
                    $trans   = $this->edit( $rowid, \Request::all());
                    break;
                case '03':
                    $trans   = $this->delete( $rowid);
                    break;

                default:
                    abort(404);
            }

        }catch (Exception $e){

            $this->MResponse->fail(array('code'=>$e->getCode(), 'message'=>$e->getMessage(), 'line'=>$e->getLine() ));
        }

        return $this->MResponse->built()->json();
    }


    /**
     * @param array $data
     * @throws \Exception
     */
    public function Validator ($data=[]){

        $rules = array(
            'medic_id'          => 'required',
            'patient_id'        => 'required',
            'date'              => 'required|date_format:"d/m/Y"',
            'hour1'             => 'required'
        );

        $messsages = array(
            'medic_id.required'         => 'El campo Medico es requerido ',
            'patient_id.required'       => 'El campo Paciente es requerido',
            'date.required'             => 'El campo Fecha  es requerido',
            'birthday.date_format'      => 'El campo Fecha  debe tener el formato dd/mm/aaaa',
            'hour1.required'            => 'El campo Hora es requerido',
        );

        $validator = Validator::make($data, $rules, $messsages);
        if ($validator->fails()) {
            $messages = $validator->messages();
            $this->setError('error','3000', $messages->first(), "Error de validacion, para poder continuar pimero debes de proporcionar todos los datos");
            throw new \Exception($messages->first(),'3000');
        }

    }



    /**
     * Crea un registro
     * @param array $data       - Datos que provienen del formulario
     * @return bool             - true or false
     */
    public function insert( array $data = [] )
    {
        $user           = \Auth::user();
        $date           = Carbon::createFromFormat('d/m/Y H:i',$data['date'] . ' '. $data['hour1'] )->format('Y-m-d H:i:s');

        try
        {


            DB::beginTransaction();

            $this->Validator($data);


            $appointment                = new EMAppointment();
            $appointment->medic_id      = $data['medic_id'];
            $appointment->patient_id    = $data['patient_id'];
            $appointment->date          = $date;
            $appointment->comments      = $data['comments'];
            $appointment->save();

            DB::commit();

            $response = array(
                'message'       =>"Se ha guardado la información del paciente",
                'paciente'      => $appointment->toArray()
            );

            $this->MResponse->success( $response );
            return true;

        } catch (\Exception $e) {

            DB::rollback();
            $this->Log('error', $e->getMessage());
            $this->MResponse->fail(['message'   => $e->getMessage(), 'code'=>'100']);
        }

        return false;

    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Support\Facades\Request $request
     * @param  int  $id
     * @return Response
     */
    public function edit( $rowid, $data = [] ){


        try
        {
            $date           = Carbon::createFromFormat('d/m/Y H:i',$data['date'] . ' '. $data['hour1'] )->format('Y-m-d H:i:s');

            DB::beginTransaction();

            $this->Validator($data);

            /*** VERIFICAMOS SI SE PUEDE EDITAR ***/
            $appointment = EMAppointment::find($rowid);
            if(is_null($appointment)){
                $m = "No se encontro el registro del paciente.";
                $this->setError('error',1000, $m,'');
                throw new \Exception($m,'1000');
            }

            $appointment->medic_id      = $data['medic_id'];
            $appointment->patient_id    = $data['patient_id'];
            $appointment->date          = $date;
            $appointment->comments      = $data['comments'];
            $appointment->save();

            DB::commit();

            $response = array(
                'message'       =>"Se ha guardado la entrada del producto",
                'paciente'      => $appointment->toArray()
            );

            $this->MResponse->success( $response );

            return true;

        }catch(Exception $e) {

            DB::rollback();
            $this->MResponse->fail($this->TraceError($e));

        }

        return false;
    }


    /**
     * @param $rowid
     */
    public function delete( $rowid ){

        try
        {

            $this->MResponse->reset();

            DB::beginTransaction();

            $appointment = EMAppointment::find($rowid);
            if(is_null($appointment)){
                $m = "No se encontro el registro del paciente.";
                $this->setError('error',1000, $m,'');
                throw new \Exception($m,'1000');
            }


            $appointment->delete();

            DB::commit();

            $message = "Se ha eliminado el registro del paciente";
            $this->MResponse->success(['message' => $message]);

            return true;

        } catch (Exception $e) {

            DB::rollback();
            $this->MResponse->fail($this->TraceError($e));
        }

        return false;

    }
}
