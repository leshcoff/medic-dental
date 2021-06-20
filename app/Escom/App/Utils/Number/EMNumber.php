<?php
/**
 * Created by PhpStorm.
 * User: lescoffie
 * Date: 06/05/17
 * Time: 08:18
 */

namespace Escom\Utils\Number;

use App\Model\EMPRESA\EMEmpresa;
use app\Library\lib\Hash;
use Dompdf\Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\CssSelector\Parser\Reader;

class EMNumber {

    /**
     * The id of the company
     * @var
     *
     */
    protected $empresa;




    public function __construct()
    {
    }

    /****
     * @author Marcos Escamilla
     * @version 1.0.1
     * @date 22/03/2018
     * @params $Numero [string]
     * @params $Signo  [string ]
     * @function QUITA LA COMA DEL NUMERO STRING Y LO COMBIERTE A FLOAT : FORMATO DEL NUMERO  "1,233.44" , "22,433.3344"
     * @return  float
     ****/

    public static function StringToNumber( $Numero , $Signo = '' ){

        return str_replace(',', $Signo , $Numero );

    }


}