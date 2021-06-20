<?php

namespace App\Escom\Utils;

class Date {

    public static function formato($str, $reg){
        if($str){
            $a = explode('-',$str);
            if(checkdate($a[1],$a[2],$a[0])){
                if($reg != ''){

                    $meses = array('01'=>'Enero','02'=>'Febrero','03'=>'Marzo','04'=>'Abril','05'=>'Mayo','06'=>'Junio',
                                    '07'=>'Julio','08'=>'Agosto','09'=>'Septiembre','10'=>'Octubre','11'=>'Noviembre','12'=>'Diciembre');

                    $buscar = ['D','d','A','a','MMM','mmm','MM','mm','Mm','X','x'];
                    $reemplazar = [
                        str_pad($a[2],2,'0',STR_PAD_LEFT),
                        $a[2],
                        $a[0],
                        substr($a[0],2,2),
                        strtoupper(substr($meses[$a[1]],0,3)),
                        strtolower(substr($meses[$a[1]],0,3)),
                        strtoupper($meses[$a[1]]),
                        strtolower($meses[$a[1]]),
                        $meses[$a[1]],
                        str_pad($a[1],2,'0'),
                        $a[1]
                    ];

                    return str_replace($buscar, $reemplazar, $reg);

                }else{
                    return $str;
                }
            }else{
                return 'N/A';
            }
        }else{
            return 'N/A';
        }
    }

    public static function fecha_letras($fecha){

          list($anio,$mes,$dia) = explode("-",$fecha);
          $tmp_anio = substr($anio,2);
          $dia = Date::basico($dia);
          $mes = Date::meses($mes);
          $anio = Date::basico($tmp_anio);

          $texto = "{$dia} DIAS DEL MES DE {$mes} DEL AÑO DOS MIL {$anio}";

          return $texto;

    }

    public static function basico($numero) {
            $valor = array ('uno','dos','tres','cuatro','cinco','seis','siete','ocho','nueve','diez','once','doce','trece','catorce','quince','dieciseis','diecisiete','dieciocho','diecinueve','veinte','veintiuno','veintidós','veintitrés','veinticuatro','veinticinco','veintiséis','veintisiete','veintiocho','veintinueve','treinta','treinta y un');
            return $valor[$numero - 1];
    }

    public static function meses($numero){
            $valor = array ('enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre');
            return $valor[$numero - 1];

    }

    public static function diferencia_letras($inicial , $final){
        $datetime1 = date_create($inicial);
        $datetime2 = date_create($final);
        $datetime2->modify('+1 day');
        $interval = date_diff($datetime1, $datetime2);
        $anio = "";
        $mes = "";
        $dias = "";

        if($interval->y > 0){
            if($interval->y > 1){
                $anio = $interval->y.' AÑOS ';
            } else{
               $anio = $interval->y.' AÑO ' ;
            }
        }

       if($interval->m > 0){
            if($interval->m > 1){
                $mes = $interval->m.' MESES ';
            } else{
               $mes = $interval->m.' MES ' ;
            }
        }

        if($interval->d > 0){
            if($interval->d > 1){
                $dias = $interval->d.' DÍAS ';
            } else{
               $dias = $interval->d.' DÍA ' ;
            }
        }

        $text = $anio.$mes.$dias;
        return $text;
    }
}
