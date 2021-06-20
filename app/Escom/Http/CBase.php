<?php
/**
 * Created by PhpStorm.
 * User: lescoffie
 * Date: 23/11/15
 * Time: 10:08
 */

namespace Escom\Base;


use App\Http\Requests;
use App\Http\Controllers\Controller;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

use DateTime;

use Escom\Utils\Logger\Facades\BufferLog;
use Escom\App\DEBUG\EMDebug;
use App\Escom\Http\EMResponse;


class CBase extends Controller{

    public $MResponse;
    public $monolog;
    public $route;
    protected $model;
    protected $autoCommit   = true;
    protected $errors       = array();


    public $debug;
    public static $ndebug;

    private $tz;


    public function __construct($data=[])
    {
        $this->middleware('auth', ['except' => ['createAccountClient','subscriptionPurchaseStatus']]);
        $this->MResponse = new EMResponse();

        $this->tz    = new \DateTimeZone('America/Mexico_City');
    }


    public function setLog($file='log'){

        $logFile = storage_path($file);
        $this->monolog = new Logger('log');
        $this->monolog->pushHandler(new StreamHandler($logFile), Logger::INFO);

        return $this;

    }

    /**
     * Enable or disable the autocommit transaccion
     * @param bool|true $commit
     */
    public function setAutocommit($commit=true){
        $this->autoCommit = $commit;
    }

    /**
     * Returns an associative array of object properties
     *
     * @access	public
     * @param	string  $error , name of de error cause the exception ex. error = array(code, message)
     * @param	integer $code  , code of de error
     * @param	string  $msg   , description of the message
     * @param   string  $trace , descripcion de error que paso
     * @return	array[code] = message
     */
    public function setError($error, $code, $msg, $trace=''){

        $errors = $this->getError($error);
        $object = [];


        if( false == $errors) {
            $errors['code']         = $code;
            $errors['message']      = $msg;
            $errors['trace']        = $trace;
        }


        //si existe el error
        if( is_array($errors)){
            //si existe el indice
            //siempre preservara el primer valor que le pasen, excepto si se usa
            //$this->resetError('error');
            if(isset($errors['code'])){
                if( empty($errors['code']) || is_null($errors['code']) ) $errors['code'] = $code;
            }

            if(isset($errors['message'])){
                if( empty($errors['message']) || is_null($errors['message']) ) $errors['message'] = $msg;
            }

            if(isset($errors['trace'])){
                if( empty($errors['trace']) || is_null($errors['trace']) ) $errors['trace'] = $trace;
            }

        }


        $this->errors[$error] = $errors;
    }


    /**
     * Returns an associative array of object properties
     *
     * @access	public
     * @param	string  $error, if empty return all array with errors, else return property
     * @return	array[code] = message
     */
    public function getError($error=null){
        if ($error) {
            if ( ! array_key_exists($error, $this->errors) ) {
                return false;
            }
            else {

                return $this->errors[$error];
            }
        }

        return $this->errors;
    }

    /**
     * clear error array
     */
    public function resetError($error = null){

        if ($error) {
            if ( array_key_exists($error, $this->errors) ) {
                 $this->errors[$error] = array();
            }

        }
        $this->errors = array();
    }


    /**
     * @param Exception $e
     * @return array
     */
    public function TraceError( $e){
        $error      = $this->getError('error');
        $errores    = array();
        $empresa    = \DB::raw("NULL");
        $uid        = empty($uid) ? 0 : \DB::raw("NULL");
        $login      = \DB::raw("NULL");



        if($error){
           $errors = array(
               'message'    => $error['message'],
               'code'       => $error['code'],
               'trace'      => isset($error['trace'])?$error['trace'] : "MENSAJE SIN DESCRIPCIÓN DEL ERROR"
           );
        }else{
            $errors = array(
                'message'    => $e->getMessage(),
                'code'       => $e->getCode(),
                'line'       => $e->getLine(),
                'file'       => $e->getFile()
            );

        }

         #-------------------------------------------------------------------------
         # INTENTAMOS AVERIGUAR LA EMPRESA POR EL URL
         # En ocaciones hay metodos que se invocan fuera del esquema de rutas
         # url/empresa
         # puede ser una api
         # o directamente /ur
         #------------------------------------------------------------------------
        try
        {
            #por si no esta logiado el usuario
            if( \Auth::user() ){
                $uid    = \Auth::user()->getId();
                $login  = \Auth::user()->getLogin();
            }


        }catch (Exception $e)
        {
            error_log("ERROR TRACE IN GETTING: WARNING: ".$e->getMessage());
        }




        try
        {
            if( is_object(@$errors['trace'])){
                $errors['trace'] = serialize($errors['trace']);
            }



        }catch (Exception $e)
        {
            error_log("ERROR EN TRACE IN SAVING: critical: ".$e->getMessage());
        }

        return $errors;

    }


    /**
     * Crea un log en el archivo especificado y escribe el log
     * @param string $level
     * @param string $message
     * @param null $data
     */
    public function Log($level = 'info', $message='', $data=[]){

        $loglevel = Logger::DEBUG;

        switch ($level){
            case 'info' :
                $loglevel = Logger::INFO;
                break;
            case 'error' :
                $loglevel = Logger::ERROR;
                break;
            case 'alert' :
                $loglevel = Logger::ALERT;
                break;
            case 'notice' :
                $loglevel = Logger::NOTICE;
                break;

            case 'emergency' :
                $loglevel = Logger::EMERGENCY;
                break;

            default :
                $loglevel = Logger::DEBUG;
                break;
        }


        $this->monolog->log( $loglevel, $message, $data );
    }


    /**
     * Escribe en el buffer del log el mensaje
     * @param string $level
     * @param string $message
     * @param array $data
     * @param int $index
     * @return $this
     */
    public function Debug($level = 'info', $message='',  $data=[], $index=1){

        BufferLog::Debug($level, $message, $data, $index);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDebug(){
        return BufferLog::getDebug();
    }

    /**
     * log - Registra las operaciones que hace
     */
    public function clearDebug(){
        BufferLog::clearDebug();
    }


    /**
     * @param $filename
     * @return bool
     */
    function LogToFile($filename)
    {
        BufferLog::LogToFile($filename);
    }


    /**
     * Guarda en base de datos el texto del debug
     * @param $object
     * @param string $text
     */
    function LogToDataBase($object, $text="")
    {
        BufferLog::LogToDataBase($object,$text);
    }

}
