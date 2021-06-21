<?php


namespace Escom\Form;

use App\Model\CONCEPTO\EMConcepto;
use App\Model\EMPLEADO\EMEmpleado;
use App\Model\NOMINA\PERIODOPAGO\CALENDARIO\EMFechaperiodo;
use App\Model\NOMINA\PERIODOPAGO\PERIODONOMINA\EMPeripago;
use App\Model\PLANTILLA\EMPlantilla;
use App\Model\PLAZA\EMPlaza;
use App\Model\TFALTA\EMTFalta;
use App\Model\TINCAPACIDAD\EMTincapacidad;
use App\Model\TMODIFICACION\EMTmodificacion;
use App\Model\TPERIODOS\EMTperiodo;
use Illuminate\Support\Facades\DB;

use App\Model\SYSTEM\USUARIO\EMUsuario;
use App\Model\DEPARTAMENTO\EMDepartamento;
use App\Model\SUCURSAL\EMSucursal;
use App\Model\INCTIPORIESGO\EMInctiporiesgo;
use App\Model\INCCONCECUENCIA\EMIncconcecuencia;
use App\Model\INCCONTROL\EMInccontrol;
use App\Model\TJORNADA\EMTjornada;
use App\Model\PLAZA\EMTplaza;

use App\Model\HISTORIAL\EMHistorialUma;
use App\Model\SALARIOMINIMO\EMSalariominimo;
use App\Model\PUESTO_CATEGORIA\EMJerarquiaPuestoCategoria;
use App\Models\SALARIOMINIMO\EMGSMinimoZona;
use App\Model\TIPO_CONCEPTO\EMTipoconcepto;

/*** MODELS GLOBALS ***/
use App\Model\GLOBALS\EMGPuestosCategorias;
use App\Model\GLOBALES\EMGMetodoPago;
use App\Model\GLOBALES\EMGCateNomina;
/*****/

use Escom\Utils\Date\EMDate;
use App\Model\RPATRONAL\EMRegistroPatronal;
use App\Model\EMPRESA\EMEmpresa;
use App\Model\TIMBRADO\EMNominaFolio;
use app\Library\lib\Hash;

class FieldBuilder {

    protected $model;


    public function __construct()
    {

    }


    /**
     * Construye un campo select2, que funcionara por ajax para buscar los datos
     * @param string $name
     * @param string $nname
     * @param array $atributes
     * @return string
     */
    public function select2($name='id', $options=[], $value =null, $atributes=[]){

        $data['id']         = $name;
        $data['data-url']   = $atributes['url'];
        $data['len']        = isset($data['len']) ? $data['len'] : 1;
        $data['allowClear'] = isset($atributes['allowClear'])? $atributes['allowClear'] : true;
        //fix, choca con las reglas del validator.url
        unset($atributes['url']);

        $atributes = array_merge($atributes,$data);

        $script  = \View::make("SHARED.FORM.select2")->with('attributes',$atributes)->render();

        unset($atributes['source']);
        unset($atributes['status']);

        $target  = \Form::select($name , $options, $value,   $atributes);

        return $target.PHP_EOL.$script;


    }





}
