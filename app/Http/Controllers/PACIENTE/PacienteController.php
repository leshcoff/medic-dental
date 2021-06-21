<?php

namespace App\Http\Controllers\PACIENTE;


use App\Http\Controllers\Controller;


use Carbon\Carbon;
use Illuminate\Support\Facades\Request;
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


class PacienteController extends CBase
{


    public $module_name = "patients";
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
        $this->setLog('logs/pacientes.log.php');
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
            SELECT  p.id,
                    p.name,
                    p.lastname,
                    p.birthday,
                    p.gender,
                    g.name as ngenero,
                    p.rfc,
                    p.phone,
                    p.email,
                    p.address,
                    p.notes,
                    p.photo,
                    p.created_at,
                    p.updated_at
              FROM `patients` p, `cat_genero` g
              WHERE g.id =  gender
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
                'title'      => 'Nombre',
                'tooltip'    => 'Nombre(s) del paciente',
                'visible'    => true,
                'searchable' => true,
                'width'      => '10%',
                'sFilter'    => array(
                    'type'  => 'text'
                ),
                'formatter'   => function($data, $row, $col){
                    return "<img src=\"".asset($data)."\" alt=\"\" width=\"40\" height=\"40\" class=\"rounded-500\">";
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
                'data'       => 'birthday',
                'title'      => 'F Nacimiento',
                'tooltip'    => 'Fecha de nacimiento',
                'visible'    => true,
                'searchable' => true,
                'width'      => '5%',
                'sFilter'    => array(
                    'type'  => 'text'
                ),
                'formatter'   => function($data, $row, $col){
                    return Carbon::parse($data)->format('d/m/Y');
                }
            ),


            array(
                'parent'     => '',
                'data'       => 'ngenero',
                'title'      => 'Genero',
                'tooltip'    => 'Genero',
                'visible'    => true,
                'searchable' => true,
                'width'      => '2%',
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
                'data'       => 'address',
                'title'      => 'Dirección',
                'tooltip'    => 'Direccion',
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
                'alias'            => "pacientes",
                'params'           => ['responsive' => false],
                'callbacks'        => $callbacks
            ),
            'modal'            => 'modal-pacientes',
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

        $rowid       = \Request::get('rowid');
        $doAction    = \Request::get('doAction');
        $route       = EMLib::routeController($this->route, $rowid, $doAction);


        $generos = [''=>'Elige genero']+EMGenero::orderBy('id')
                ->pluck('name','id')
                ->toArray();


        $model  = EMPaciente::find($rowid);
        if( !is_null($model) ){



        }

        return View::make( $this->view )
            ->with('route'      , $route)
            ->with('rowid'      , $rowid)
            ->with('doAction'   , $doAction)
            ->with('model'      , $model)
            ->with('generos'    , $generos)
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
            'name'          => 'required',
            'lastname'      => 'required',
            'birthday'      => 'required|date_format:"d/m/Y"',
            'gender'        => 'required',
            'phone'         => 'required',
            'email'         => 'required',
            'address'       => 'required',
        );

        $messsages = array(
            'name.required'         => 'El campo Nombre es requerido ',
            'lastname.required'     => 'El campo Apellidos es requerido',
            'birthday.required'     => 'El campo Fecha de Nacimiento es requerido',
            'birthday.date_format'  => 'El campo Fecha de Nacimiento debe tener el formato dd/mm/aaaa',
            'gender.required'       => 'El campo Genero es requerido',
            'phone.required'        => 'El campo Telefono es requerido',
            'email.required'        => 'El campo Correo es requerido',
            'address.required'      => 'El campo Dirección es requerido',
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
        $birthday       = Carbon::createFromFormat('d/m/Y',$data['birthday'])->format('Y-m-d');

        try
        {


            DB::beginTransaction();

            $this->Validator($data);

            $photos =[
                'assets/content/user-40-1.jpg',
                'assets/content/user-40-2.jpg',
                'assets/content/user-40-3.jpg',
                'assets/content/user-40-4.jpg',
                'assets/content/user-40-5.jpg',
                'assets/content/user-40-6.jpg',
                'assets/content/user-40-7.jpg',
                'assets/content/user-40-8.jpg',
                'assets/content/user-40-9.jpg',
                'assets/content/user-40-10.jpg',
            ];

            $patient     = new EMPaciente();
            $patient->name      = $data['name'];
            $patient->lastname   = $data['lastname'];
            $patient->birthday  = $birthday;
            $patient->gender    = $data['gender'];
            $patient->rfc       = @$data['rfc'];
            $patient->phone     = $data['phone'];
            $patient->email     = $data['email'];
            $patient->address   = $data['address'];
            $patient->notes     = $data['notes'];
            $patient->photo     = $photos[rand(0,9)];
            $patient->save();

            DB::commit();

            $response = array(
                'message'       =>"Se ha guardado la información del paciente",
                'paciente'      => $patient->toArray()
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
            $birthday       = Carbon::createFromFormat('d/m/Y',$data['birthday'])->format('Y-m-d');

            DB::beginTransaction();

            $this->Validator($data);

            /*** VERIFICAMOS SI SE PUEDE EDITAR ***/
            $paciente = EMPaciente::find($rowid);
            if(is_null($paciente)){
                $m = "No se encontro el registro del paciente.";
                $this->setError('error',1000, $m,'');
                throw new \Exception($m,'1000');
            }

            $paciente->name      = $data['name'];
            $paciente->lastname   = $data['lastname'];
            $paciente->birthday  = $birthday;
            $paciente->gender    = $data['gender'];
            $paciente->rfc       = @$data['rfc'];
            $paciente->phone     = $data['phone'];
            $paciente->email     = $data['email'];
            $paciente->address   = $data['address'];
            $paciente->notes     = $data['notes'];
            $paciente->save();

            DB::commit();

            $response = array(
                'message'       =>"Se ha guardado la entrada del producto",
                'paciente'      => $paciente->toArray()
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

            $paciente = EMPaciente::find($rowid);
            if(is_null($paciente)){
                $m = "No se encontro el registro del paciente.";
                $this->setError('error',1000, $m,'');
                throw new \Exception($m,'1000');
            }


            $paciente->delete();

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



    /**
     * @return string
     */
    public function search(){

        try
        {

            $search    = Request::get('q');
            $page      = Request::get('page') ? Request::get('page') : 1;
            $limit     = Request::get('page_limit') ? Request::get('page_limit') : 20;
            $source    = Request::get('source') ? Request::get('source') : 'P';
            $offset    = ($page-1) * $limit;

            $MResponse = new EMResponse();


            $query = EMPaciente::select(
                DB::raw("
                    SQL_CALC_FOUND_ROWS patients.*,
                    CONCAT_WS(' ', name, lastname) full_name
                    "
                )
            )
                ->where(function ($q) use ($search) {
                    $q->orWhere( DB::raw("CONCAT(name,' ', lastname) "), 'LIKE', '%' . $search . '%');
                })
                ->skip($offset)
                ->take($limit);

            $query->get();

            $total = DB::selectOne( DB::raw("SELECT FOUND_ROWS() AS cnt;") );

            $pickup = EMPaciente::from(DB::raw('(' . str_replace("SQL_CALC_FOUND_ROWS","",$query->toSql()) . ')  as tb '))
                ->select(DB::raw('SQL_CALC_FOUND_ROWS tb.*'))
                ->OrderBy('name','ASC');
            $pickup->mergeBindings( $query->getQuery() );

            $patients = $pickup->get();

            /*********************
             * TERMINO DE EDICION
             *********************/

            $items = array();
            foreach($patients as $patient){

                $items[] = [
                    'id'        => $patient->id,
                    'idisplay'  => $patient->id,
                    'text'      => $patient->full_name,
                    'image'     => "<img src=\"".asset($patient->photo) . "\" width='50' style=\"border-radius:50%;\">",


                    'descrip'   => "
                        <small class='text info'> <b>". $patient->id ."</b> - " . ($patient->email ? " : {$patient->email}</i>" : "") . "</small><br>
                        <div>
                        </div>

                    "
                ];

            }

            $data['total_count'] =  $total->cnt;
            $data['items'] =  $items;
            $MResponse->success($data);

        }catch (Exception $e){
            $MResponse->fail(array('code'=>$e->getCode(), 'message'=>$e->getMessage(), 'line'=>$e->getLine() ));
        }

        return $MResponse->built()->json();
    }
}
