<?php
/**
 * Created by PhpStorm.
 * User: lescoffie
 * Date: 06/05/17
 * Time: 08:18
 */

namespace Escom\Utils\Date;

use App\Model\EMPRESA\EMEmpresa;
use app\Library\lib\Hash;
use Dompdf\Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\CssSelector\Parser\Reader;

class EMDate {

    /**
     * The id of the company
     * @var
     *
     */
    protected $empresa;




    public function __construct()
    {
    }


    /**
     * @autor Cesar Perez
     * @function Retorna una fecha con formato d-m-Y, recibiendo formato de base de datos
     * @param $date
     * @return string
     */
    public static function dbToView($date,$begin = 'Y-m-d H:i:s',$end = 'd-m-Y'){

        $date = Carbon::createFromFormat($begin, $date);
        return  $date->format($end);
    }

    /**
     * @autor Cesar Perez
     * @param $date
     * @return static
     */
    public static function getNextAniversary( $date ){

        $now      = Carbon::now();
        $date     = Carbon::createFromFormat('Y-m-d', $date);

        $anios    = $now->diffInYears($date);
        $date     = $date->addYears($anios);

        if( $now->format('Y-m-d') > $date->format('Y-m-d') ){
              $date->addYear();
        }

        return $date;
    }

    /**
     * @param $date
     * @return static
     */
    public static function getOldAniversary( $date ){

        $now      = Carbon::now();
        $date     = Carbon::createFromFormat('Y-m-d', $date);

        $anios    = $now->diffInYears($date);
        $date     = $date->addYears($anios);


        if(  $date->format('Y-m-d') > $now->format('Y-m-d') ) {
            $date->subYear();
        }

        return $date;
    }

    /**
     *
     * ANTIGUEDAD EN AÑOS || AÑOS ENTEROS TRANSCURRIDOS A PARTIR DE UNA FECHA DADA
     *
     * @param $data['START_DATE']   || Fecha inicial
     * @param $data['END_DATE']     || Fecha final, si no se envia nada por defecto toma la fecha actual
     * @return int                   || Retorna un entero: años transcurridos a partir de una fecha dada
     * @throws \Exception
     */
    public static function antInYears($data = []){

        if(!is_array($data) || empty($data)){
            throw new \Exception("The element isn't array or is empty. Function: antInYears",'3000');
        }


        $end_date     =   date('Y-m-d');

        if(array_key_exists('END_DATE',$data)){  $end_date =   $data['END_DATE']; }
        if(!array_key_exists('START_DATE',$data)){ throw new \Exception("The antInYears function expected an index called START_DATE in a array. Function: antInYears",'3000'); }

        $end_date       =   Carbon::createFromFormat(array_key_exists('END_FORMAT',$data)? $data['END_FORMAT'] : 'Y-m-d', $end_date);
        $start_date     =   Carbon::createFromFormat(array_key_exists('START_FORMAT',$data)? $data['START_FORMAT'] : 'Y-m-d', $data['START_DATE']);

        return $start_date->diffInYears($end_date);
    }

    /**
     *  ANTIGUEDAD POR AÑOS Y MESES TRANSCURRIDOS
     *
     * @param $date
     * @return array
     */
    public static function antiquity($date){


        $localtime = getdate();
        $today = $localtime['mday']."-".$localtime['mon']."-".$localtime['year'];
        $dob_a = explode("-", $date);
        $today_a = explode("-", $today);
        $dob_d = $dob_a[0];$dob_m = $dob_a[1];$dob_y = $dob_a[2];
        $today_d = $today_a[0];$today_m = $today_a[1];$today_y = $today_a[2];
        $years = $today_y - $dob_y;
        $months = $today_m - $dob_m;
        if ($today_m.$today_d < $dob_m.$dob_d)
        {
            $years--;
            $months = 12 + $today_m - $dob_m;
        }

        if ($today_d < $dob_d)
        {
            $months--;
        }

        $firstMonths=array(1,3,5,7,8,10,12);
        $secondMonths=array(4,6,9,11);
        $thirdMonths=array(2);

        if($today_m - $dob_m == 1)
        {
            if(in_array($dob_m, $firstMonths))
            {
                array_push($firstMonths, 0);
            }
            elseif(in_array($dob_m, $secondMonths))
            {
                array_push($secondMonths, 0);
            }elseif(in_array($dob_m, $thirdMonths))
            {
                array_push($thirdMonths, 0);
            }
        }

        return ['years' => $years, 'months' => $months];

    }

    /**
     *
     * @param string $size      || Indica el tamaño del mes:  S(Small) - 01, M(Medium) Ene, L(Large) Enero
     * @param array $params
     *          [
     *           init   : Indica si el indice inicia desde uno, desde cero o sin indice: 0 [ 0 => "Enero"], 1 [ 1 => Enero], 2 : Sin indice
     *           index  : Indica el key de cada elemento del array:  S(Con indice) ["1"=>"Enero" ...], C(Indice considerando cero) [01=>"Enero" ...]
     *          ]
     * @return array
     * @throws \Exception
     */
    public static function months($size = "L",$params = [])
    {

        $init = (array_key_exists('init', $params)) ? $params['init'] : 2;
        $index = (array_key_exists('index', $params)) ? strtoupper($params['index']) : "C";

        switch (strtoupper($size)) {

            case "L":

                if ($init == 0) {//Indice a partir de cero

                    switch ($index) {
                        case "S":
                            return ['0' => 'Enero', '1' => 'Febrero', '2' => 'Marzo', '3' => 'Abril', '4' => 'Mayo', '5' => 'Junio', '6' => 'Julio', '7' => 'Agosto', '8' => 'Septiembre', ' 9' => 'Octubre', '10' => 'Noviembre', '11' => 'Diciembre'];
                            break;

                        case "C":
                            return ['0' => 'Enero', '01' => 'Febrero', '02' => 'Marzo', '03' => 'Abril', '04' => 'Mayo', '05' => 'Junio', '06' => 'Julio', '07' => 'Agosto', '08' => 'Septiembre', '09' => 'Octubre', '10' => 'Noviembre', '11' => 'Diciembre'];

                            break;
                        default:
                            throw new \Exception("Opción no encontrada L,1, ->", '3000');

                            break;
                    }

                } else if ($init == 1) {//Indice a partir de uno


                    switch ($index) {
                        case "S":
                            return ['1' => 'Enero', '2' => 'Febrero', '3' => 'Marzo', '4' => 'Abril', '5' => 'Mayo', '6' => 'Junio', '7' => 'Julio', '8' => 'Agosto', '9' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre'];
                            break;

                        case "C":
                            return ['01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo', '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio', '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre'];

                            break;

                        default:
                            throw new \Exception("Opción no encontrada L,1, ->", '3000');

                            break;
                    }

                } else {
                    return ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

                }

                break;

            case "M":

                if ($init == 0) {//Indice a partir de cero

                    switch ($index) {
                        case "S":
                            return ['0' => 'Ene', '1' => 'Feb', '2' => 'Mar', '3' => 'Abr', '4' => 'May', '5' => 'Jun', '6' => 'Jul', '7' => 'Ago', '8' => 'Sep', ' 9' => 'Oct', '10' => 'Nov', '11' => 'Dic'];
                            break;

                        case "C":
                            return ['0' => 'Ene', '01' => 'Feb', '02' => 'Mar', '03' => 'Abr', '04' => 'May', '05' => 'Jun', '06' => 'Jul', '07' => 'Ago', '08' => 'Sep', '09' => 'Oct', '10' => 'Nov', '11' => 'Dic'];

                            break;
                        default:
                            throw new \Exception("Opción no encontrada L,1, ->", '3000');

                            break;
                    }

                } else if ($init == 1) {//Indice a partir de uno


                    switch ($index) {
                        case "S":
                            return ['1' => 'Ene', '2' => 'Feb', '3' => 'Mar', '4' => 'Abr', '5' => 'May', '6' => 'Jun', '7' => 'Jul', '8' => 'Ago', '9' => 'Sep', '10' => 'Oct', '11' => 'Nov', '12' => 'Dic'];
                            break;

                        case "C":
                            return ['01' => 'Ene', '02' => 'Feb', '03' => 'Mar', '04' => 'Abr', '05' => 'May', '06' => 'Jun', '07' => 'Jul', '08' => 'Ago', '09' => 'Sep', '10' => 'Oct', '11' => 'Nov', '12' => 'Dic'];

                            break;

                        default:
                            throw new \Exception("Opción no encontrada L,1, ->", '3000');

                            break;
                    }

                } else {
                    return ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];

                }
                break;

            case "S":
                /**
                 *
                 * LO MISMO PERO CON MESES  NUMERICOS
                 *
                 *
                 */
                break;
        }

    }

    /**
     * @param null $from        Fecha inicial
     * @param null $until       Fecha final
     * @param string $format    Formato de las fechas
     * @return string
     */
    public static function fromUntil($from = null, $until = null, $format = "d-m-Y"){

        $label = "";

        if(!is_null($from) || !is_null($until)) {

            $months =   self::months('L', ['init'=> 1,'index'=>'S']);

            if (!is_null($from)) {

                $fecha = Carbon::createFromFormat($format, $from);
                $month = $fecha->month;
                $year = $fecha->year;
                $day = $fecha->day;

                $label .= " DEL " . $day . " DE " . $months[$month] . " DE " . $year;

            } else {
                $label .= " DEL - - - ";
            }

            if (!is_null($until)) {

                $fecha = Carbon::createFromFormat($format, $until);
                $month = $fecha->month;
                $year = $fecha->year;
                $day = $fecha->day;

                $label .= " AL " . $day . " DE " . $months[$month] . " DE " . $year;
            } else {
                $label .= " AL - - - ";
            }

        }else{ return $label; }

        return $label;

    }

    /**
     * @param null $from        Fecha inicial
     * @param null $until       Fecha final
     * @param string $format    Formato de las fechas
     * @return string
     */
    public static function from($from = null, $format = "d-m-Y"){

        $label = "";

        if(!is_null($from) ) {

            $months =   self::months('L', ['init'=> 1,'index'=>'S']);

            if (!is_null($from)) {

                $fecha = Carbon::createFromFormat($format, $from);
                $month = $fecha->month;
                $year = $fecha->year;
                $day = $fecha->day;

                $label .= $day . " de " . $months[$month] . " de " . $year;

            } else {
                $label .= " - - - ";
            }

        }else{ return $label; }

        return $label;

    }


    

}