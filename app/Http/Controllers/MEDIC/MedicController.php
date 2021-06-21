<?php

namespace App\Http\Controllers\MEDIC;


use App\Http\Controllers\Controller;


use App\Models\MEDIC\EMMedic;
use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Request;

use App\Models\PACIENTE\EMPaciente;
use App\Models\EMGenero;

use Escom\Base\CBase;
use App\Escom\Http\EMResponse;
use App\Escom\Module;
use App\Escom\Utils\EMLib;


class MedicController extends CBase
{


    public $module_name = "medics";
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
        $this->route        = isset($config['route'])? $config['route'] : 'medics';
        $this->view         = isset($config['view'])? $config['view'] :'SHARED.datatables';
        $this->title        = isset($config['title'])? $config['title'] :'Medics';
        $this->setLog('logs/medics.log.php');
    }


    /**
     * Display a listing of the resource.
     *
     * $view - Donde se renderizaran los datos
     * @return Response
     */
    public function index()
    {

        $medics  = EMMedic::orderBy('name','asc')->get();
        $generos = [''=>'Elige genero']+EMGenero::orderBy('id')
                ->pluck('name','id')
                ->toArray();

        $view_medics =  \View::make('MEDICS.listado')->with('medics', $medics);

        $view =  \View::make('MEDICS.manager')
            ->with('view_medics' , $view_medics)
        ;

        return $view;

    }


    /**
     * @return mixed
     */
    public function listado(){

        $medics  = EMMedic::orderBy('name','asc')->get();
        $view    = \View::make('MEDICS.listado')->with('medics', $medics)->render();
        $this->MResponse->success( ['html'=>$view] );
        return $this->MResponse->built()->json();
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


        $model  = EMMedic::find($rowid);

        return View::make( 'MEDICS.form' )
            ->with('route'      , $route)
            ->with('rowid'      , $rowid)
            ->with('doAction'   , $doAction)
            ->with('model'      , $model)
            ->with('generos'    , $generos)
            ;

    }




    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function profile($rowid){

        $doAction    = "02";
        $route       = EMLib::routeController($this->route, $rowid, $doAction);

        $generos = [''=>'Elige genero']+EMGenero::orderBy('id')
                ->pluck('name','id')
                ->toArray();

        $model  = EMMedic::find($rowid);


        return View::make( 'MEDICS.profile')
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
            'speciality'      => 'required',
            'gender'        => 'required',
            'address'       => 'required',
        );

        $messsages = array(
            'name.required'         => 'El campo Nombre es requerido ',
            'lastname.required'     => 'El campo Apellidos es requerido',
            'speciality.required'     => 'El campo Fecha de Nacimiento es requerido',
            'gender.required'       => 'El campo Genero es requerido',
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

        try
        {


            DB::beginTransaction();

            $this->Validator($data);

            $photos =[
                'assets/content/doctor-400-1.jpg',
                'assets/content/doctor-400-2.jpg',
                'assets/content/doctor-400-3.jpg',
                'assets/content/doctor-400-4.jpg',
                'assets/content/doctor-400-5.jpg',
                'assets/content/doctor-400-6.jpg',
                'assets/content/doctor-400-7.jpg',
                'assets/content/doctor-400-8.jpg',
                'assets/content/doctor-400-9.jpg',
                'assets/content/doctor-400-10.jpg',
            ];

            $count  = EMMedic::count();
            $index  = number_format(($count % 10),0);

            $medic     = new EMMedic();
            $medic->name      = $data['name'];
            $medic->lastname   = $data['lastname'];
            $medic->gender  = $data['gender'];
            $medic->speciality    = $data['speciality'];
            $medic->address   = $data['address'];
            $medic->photo     = $photos[$index];
            $medic->save();

            DB::commit();

            $response = array(
                'message'       =>"Se ha guardado la información del medico",
                'medic'         => $medic->toArray()
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

            DB::beginTransaction();

            $this->Validator($data);

            /*** VERIFICAMOS SI SE PUEDE EDITAR ***/
            $medic = EMMedic::find($rowid);
            if(is_null($medic)){
                $m = "No se encontro el registro del paciente.";
                $this->setError('error',1000, $m,'');
                throw new \Exception($m,'1000');
            }

            $medic->name      = $data['name'];
            $medic->lastname   = $data['lastname'];
            $medic->gender  = $data['gender'];
            $medic->speciality    = $data['speciality'];
            $medic->address   = $data['address'];
            $medic->save();

            DB::commit();

            $response = array(
                'message'       =>"Se ha guardado la entrada del producto",
                'paciente'      => $medic->toArray()
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

            $medic = EMMedic::find($rowid);
            if(is_null($medic)){
                $m = "No se encontro el registro del paciente.";
                $this->setError('error',1000, $m,'');
                throw new \Exception($m,'1000');
            }


            $medic->delete();

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


            $query = EMMedic::select(
                DB::raw("
                    SQL_CALC_FOUND_ROWS medics.*,
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

            $pickup = EMMedic::from(DB::raw('(' . str_replace("SQL_CALC_FOUND_ROWS","",$query->toSql()) . ')  as tb '))
                ->select(DB::raw('SQL_CALC_FOUND_ROWS tb.*'))
                ->OrderBy('name','ASC');
            $pickup->mergeBindings( $query->getQuery() );

            $medics = $pickup->get();

            /*********************
             * TERMINO DE EDICION
             *********************/

            $items = array();
            foreach($medics as $medic){

                $items[] = [
                    'id'        => $medic->id,
                    'idisplay'  => $medic->id,
                    'text'      => $medic->full_name,
                    'image'     => "<img src=\"".asset($medic->photo) . "\" width='50' style=\"border-radius:50%;\">",


                    'descrip'   => "
                        <small class='text info'> <b>". $medic->id ."</b> - " . ($medic->speciality ? " : {$medic->speciality}</i>" : "") . "</small><br>
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
