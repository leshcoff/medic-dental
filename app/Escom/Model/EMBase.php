<?php

namespace Escom\Model;
use Illuminate\Database\Eloquent\Model;


class EMBase extends Model{


    var $errors = array();

    public function __construct($attributes=[])
    {
        parent::__construct($attributes);
    }



    /**
     * Set up event listeners for all Item types.
     * Named events are mapped to trait methods in $events.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::created(function($model)
        {
            //dd($model);
        });

        static::updated(function($model)
        {
            //dd($model);
        });


    }







    /**
     * Build the sql whith bindings params
     * @return mixed
     */
    public function getSql( $query = null )
    {


        if( !is_null( $query )) {

            return $this->binding( $query );
        }



        return $this->binding( $this->getBuilder() );



    }


    /**
     * Build the sql whith bindings params
     * @return mixed
     */
    public function binding( $builder )
    {
        $sql = $builder->toSql();
        foreach($builder->getBindings() as $binding)
        {
            $value = is_numeric($binding) ? $binding : "'".$binding."'";
            $sql = preg_replace('/\?/', $value, $sql, 1);
        }
        return $sql;

        #$builder = $this->getBuilder();
        #$sql = $builder->toSql();
        #foreach($builder->getBindings() as $binding)
        #{
        #    $value = is_numeric($binding) ? $binding : "'".$binding."'";
        #    $sql = preg_replace('/\?/', $value, $sql, 1);
        #}
        #return $sql;
    }


    /**
     * Returns an associative array of object properties
     *
     * @access	public
     * @param	string  $error, name of de error cause the exception ex. error = array(code, message)
     * @param	integer $code , code of de error
     * @param	string  $msg  , description of the message
     * @return	array[code] = message
     */
    public function setError($error, $code, $msg){
        $this->errors[$error] = array('code'=>$code, 'message'=>$msg);
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
     * Reset object errors
     */
    public function resetError(){
        $this->errors = array();
    }


    /**
     * @param Exception $e
     * @return array
     */
    public function WhatHappen(Exception $e){
        $error = $this->getError('error');
        $errores = array();

        if($error){
            $errors = array(
                'message'    => $error['message'],
                'code'       => $error['code'],
                'trace'      => isset($error['trace'])?$error['trace'] : "SIN MENSAJE DESCRIPCIÓN"
            );
        }else{
            $errors = array(
                'message'    => $e->getMessage(),
                'code'       => $e->getCode(),
                'line'       => $e->getLine()
            );

        }

        return $errors;

    }




} 