<?php
namespace rOpenDev\PHPToJS;
use rOpenDev\DataTablesPHP\DataTable;

/**
 * PHPToJS
 * PHPToJS's class convert php variable's content to js variable's content preserving javascript expression (like function)
 * This class is perfect if you were limited by php function `json_encode`, json's validity and/or `JSON.parse` when you have a function.
 *
 * @author     Robin <contact@robin-d.fr> http://www.robin-d.fr/
 * @link       https://github.com/RobinDev/curlRequest
 * @since      File available since Release 2014.10.12
 */
class PHPToJS
{
    /**
     * Render the variable's content from PHP to Javascript
     *
     * @param mixed $mixed
     *
     * @return string Javascript code
     */
    public static function render($mixed, DataTable $dataTable=null)
    {
        if (!is_array($mixed) && !is_object($mixed)) {
            //return strpos(str_replace(' ', '', $mixed), 'function(') === 0 ? $mixed : json_encode($mixed);
            if ( strpos(str_replace(' ', '', $mixed), 'function(') === 0  || strpos(str_replace(' ', '', $mixed), '$') === 0) {
                return $mixed;
            }

            return json_encode($mixed);

        }


        $isNumArr = array_keys((array) $mixed) === range(0, count((array) $mixed) - 1);
        $isObject = is_object($mixed) || !$isNumArr;

        $r = array();
        $i = 0;
        foreach ($mixed as $k => $m) {
            $append = "";

            if( @$dataTable->getJsInitParam()['responsive']==true){

            }

            if($k=='visible' and $m == false ){
               $append = ', className: "none" ';
            }

            if ($isObject) {
                $r[$i] = $k.':'.self::render($m,$dataTable).$append;
            } elseif ($isNumArr) {
                $r[$i] = self::render($m,$dataTable);
            } else {
                $r[$i] = json_encode($k).':'.self::render($m,$dataTable);
            }
            ++$i;
        }

        return  ($isObject ? '{' : '[').implode(',', $r).($isObject ? '}'.PHP_EOL : ']'.PHP_EOL);
    }
}