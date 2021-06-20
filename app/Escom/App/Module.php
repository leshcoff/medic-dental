<?php
/**
 * Created by PhpStorm.
 * User: lescoffie
 * Date: 03/11/15
 * Time: 19:19
 */


namespace App\Escom;


use rOpenDev\DataTablesPHP\DataTable;
use Illuminate\Support\Facades\DB;


class Module {

    protected $MODULE_UID;
    protected $MODULE_NAME;
    protected $MODULE_URL;
    protected $MODULE_TITLE;
    protected $DataTable;

    protected $config  = [];
    protected $columns = [];

    /** Tabla/Sql donde debe estraer los datos de la Base de Datos*/
    protected $sqlBase = "";

    /** Array con los datos del toolbar
     * array (
     *      'id'    => idDom del botom
     *      'text'  => Texto del botom
     *      'icon'  => Icono si es que tiene
     *      'cls'   => Clase css si es que tiene
     * )
     */
    protected $toolbar =[];


    public function __construct($moduleName, $config=[])
    {
        $this->MODULE_NAME  = $moduleName;
        $this->config       = $config;
    }


    public function getName(){
        return $this->MODULE_NAME;
    }

    public function setTitle($title=""){
        $this->MODULE_TITLE = $title;
        return $this;
    }

    public function getTitle(){
        return $this->MODULE_TITLE;
    }

    /**
     * Instancia el objeto javascrip para iniciar el DataTable, ToolBar, Etc.
     */
    public function InitJS(){



        $scripts = [
            //"assets/vendor/jquery-datatables/1.10.9/media/js/jquery.dataTables.min.js",
            //"assets/vendor/jquery-datatables/1.10.9/media/js/dataTables.bootstrap.min.js",
            //"assets/vendor/jquery-datatables/1.10.9/extensions/Responsive/js/dataTables.responsive.min.js",
        ];

        $jModule = "j".$this->getName();
        $oTable     = $this->config['table']['oTable'];
        $dom        = $this->config['table']['dom'];
        $route      = $this->config['route'];
        $scripts    = array_merge($scripts, isset($this->config['scripts'])? $this->config['scripts']: []);


        $js = "var ".$jModule.";".chr(13);


        $js.= "var pagefunction = function() {".chr(13);
        $js.= "    App.init();".chr(13);
        $js.= "     //---------------------------------------------------------------------------".chr(13);
        $js.= "     $jModule = new jG".$this->getName()."({".chr(13);
        $js.= "         controller  : '".strtoupper($this->getName())."',".chr(13);
        $js.= "	        module_name : '".strtoupper($this->getName())."',".chr(13);
        $js.= "	        module_url  : '".url($route)."',".chr(13);
        $js.= "	        table_name  : '#$dom',".chr(13);
        $js.= "	        target      : '#secction-dt-".strtolower($this->getName())."'".chr(13);

        $js.= "     });".chr(13);
        $js.= "     $jModule.init();".chr(13);
        $js.= "//---------------------------------------------------------------------------".chr(13);

        $js.= "};".chr(13);


        $js.= $this->JSModule();
        $js.= $this->loadJScripts($scripts);

        return $js;



    }



    public function loadJScripts($scripts=[], $i=0){

        $size   = (count($scripts) -1);
        $js     = "";
        $jsfile = isset($scripts[$i]) ? $scripts[$i] : null;

        if($size <= -1 ) return "";

        if($i == $size) {
            //return "loadScript('".$jsfile."',pagefunction);".chr(13);
            return "loadScript('".$jsfile."');".chr(13);
        }else {
            $js .= "loadScript('$jsfile', function(){".chr(13). $this->loadJScripts($scripts, ($i + 1)) ;

        }

        $js.= chr(13)."});";

        return $js;
    }

    /**
     * ---------------------------------------------------------------
     * CREA UN OBJETO JS QUE SIRVE  PARA USARLO EN EL FRONT-END
     * ---------------------------------------------------------------
     */
    public  function JSModule(){

        $moduloName = $this->MODULE_NAME;
        $oTable     = $this->config['table']['oTable'];
        $dom        = $this->config['table']['dom'];
        $pkey       = isset($this->config['table']['pkey'])? $this->config['table']['pkey']:'KEY';
        $modal      = isset($this->config['modal'])? $this->config['modal']:'modal-dlg';
        $exParams   = isset($this->config['extra_params'])? $this->config['extra_params']: [];


        $js  = "var jG".$moduloName."= function(options) {".chr(13);
        $js .= "   EMGrid.apply(this, arguments); // Call parent class constructor".chr(13);
        $js .= "}; ".chr(13);


        $js .= "$.extend(jG".$moduloName.".prototype, EMGrid.prototype, {".chr(13);
        $js .= "   isLoaded 	: false,".chr(13);
        $js .= "   modal 	    : '{$modal}',".chr(13); //ventana principal donde se abrira el modal

        $js .= "    init: function() {".chr(13);
        $js .= "        this.config(); ".chr(13);
        $js .= "        if (this.isLoaded) { return true;} ".chr(13);
        $js .= "        this.oTable = this.grid(); ".chr(13);
        $js .= "        this.tbar(); ".chr(13);
        $js .= "        this.fixed(); ".chr(13);

        $js .= "    },  ".chr(13);

        $js .= "    grid : function () {".chr(13);
        $js .= '        var $this = this; '.chr(13);
        $js .=          $this->getDataTable()->getJavascript();




        $js .= "        //----------------initialize FixedHeader--------------------------------".chr(13);
        $js .= "        var offsetTop = 0;".chr(13);
        $js .= "        if ($('#header').length > 0) {".chr(13);
        $js .= "            offsetTop = $('#header').eq(0).innerHeight();".chr(13);
        $js .= "        }".chr(13);
        $js .= "        //-----------------------------------------------------------------------".chr(13);


        $js .= "        //----------------Key Up Search --------------------------".chr(13);
        $js .= "       $('#".$dom."_filter input').unbind().bind( 'keyup', function (e) {".chr(13);
        $js .= "          if ( e.keyCode == 13) {".chr(13);
        $js .= '              '.$oTable.''.chr(13);
        $js .= "               .search( this.value )".chr(13);
        $js .= "               .draw();".chr(13);
        $js .= "           }".chr(13);
        $js .= "       });".chr(13);

        //$js .= "        $('div.dataTables_filter input').unbind().bind('keyup', function(e){".chr(13);
        //$js .= "            if ( e.keyCode == 13) {".chr(13);
        //$js .= "                console.log(".$oTable .")".chr(13);
        //$js .= " 	            ".$oTable.".fnFilter($(this).val());".chr(13);
        //$js .= "            }".chr(13);
        //$js .= "        });".chr(13);
        $js .= "        //-----------------------------------------------------------------------".chr(13);


        $js .= $this->RowSelect();
        $js .= $this->DblClickRowSelect();

        $js .= '        return '.$oTable.';'.chr(13);
        $js .= '    },'.chr(13);


        $js .= '   tbar: function () {'.chr(13);
        $js .= '        var toolbar = $(this.TARGET + " .table-toolbar");'.chr(13);
        $js .= '        $this       = this;'.chr(13);
        $js .= '        var menu    = ' . json_encode($this->getMenu()).chr(13);

        $js .= '        App.menu(toolbar, menu, $this);'.chr(13);
        $js .= '   },'.chr(13);

        $js .= '   fixed: function () {'.chr(13);
        $js .= '      var offset        = 0;'.chr(13);
        $js .= '      var header_h      = $(\'header.header\');'.chr(13);
        $js .= '      var header_title  = $(\'header.page-header\');'.chr(13);
        $js .= '      if( header_h.is(":visible"))     { offset = header_h.height(); }'.chr(13);
        $js .= '      if( header_title.is(":visible")) { offset+= header_title.height(); }'.chr(13);
        $js .= '      if( !$(\'html\').hasClass(\'fixed\')){ '.chr(13);
        $js .= '           offset = 0; '.chr(13);
        $js .= '           var logo = $(\'.logo-container\');'.chr(13);
        $js .= '           if( logo.is(":visible")) { offset = logo.height(); }'.chr(13);
        $js .= '      }'.chr(13);

        $js .= '      $(".table-tb").scrollToFixed({ '.chr(13);
        $js .= '         marginTop: offset ,'.chr(13);
        $js .= '         preFixed: function()  { $(this).find(\'.dataTables_length\').hide(); }, '.chr(13);
        $js .= '         postFixed: function() { $(this).find(\'.dataTables_length\').show(); } '.chr(13);
        $js .= '      });'.chr(13);
        $js .= '   },'.chr(13);

        $js .= '   _pClik: function (action, item) { '.chr(13);

        $js .= '        var params 				= new Object();'.chr(13);
        $js .= '        params.params 			= {};'.chr(13);
        $js .= '        params.buttoms          = {};'.chr(13);
        $js .= '        params.item 			= item;'.chr(13);
        $js .= '        params.params.rowid    	= params.record = null;'.chr(13);
        $js .= '        params.params.doAction 	= action;'.chr(13);
        $js .= '        params.modal 			= this.modal  || "modal-dlg";'.chr(13);
        $js .= '        params.msize 			= item.msize  || "modal-md";'.chr(13);
        $js .= '        params.width 			= item.width  || "800px";'.chr(13);
        $js .= '        params.height 			= item.height || "800px";'.chr(13);
        $js .= '        params.url  			= this.getURL()+\'/form\';'.chr(13);
        foreach($exParams as $jsvar){
            $js .= "        params.params.{$jsvar}  		= $('#$jsvar').val();".chr(13);
        }

        $js .= '        if (item.required == true) {'.chr(13);
        $js .= '            var row = this.getSelected();'.chr(13);
        $js .= '            if (!row) {'.chr(13);
        $js .= '                 EMAlerts.error({ title: "Debes de seleccionar al menos un registro"});'.chr(13);
        $js .= '                 return false;'.chr(13);
        $js .= '            }'.chr(13);

        $js .= "            params.record         = row; ".chr(13);
        $js .= "            params.params.rowid   = row['".$pkey."'];".chr(13);
        $js .= "            params.params.record  = row;".chr(13);
        $js .= "        }else {    ".chr(13);
        $js .= "                                                ".chr(13);
        $js .= "            params.params.rowid   = null;       ".chr(13);
        $js .= "            params.params.record  = null;       ".chr(13);
        $js .= "        }          ".chr(13);


        $js .= "        if (item.action=='01') { ".chr(13);
        $js .= "            params.title = 'INSERTAR REGISTRO';".chr(13);
        $js .= "            params.buttoms.ok = false ;";
        $js .="             this.openModal(params);".chr(13);
        $js ."              return true;".chr(13);
        $js .= "        }".chr(13);

        $js .= "        else if (item.action=='02') { ".chr(13);
        $js .= "            params.title = 'EDITAR REGISTRO';".chr(13);
        $js .="             this.openModal(params);".chr(13);
        $js ."              return true;".chr(13);
        $js .= "        }".chr(13);

        $js .= "        else if (item.action=='03') { ".chr(13);
        $js .= "            params.title = 'BORRAR REGISTRO';".chr(13);
        $js .="             this.confirmDelete(params.params);".chr(13);
        $js .="             return true;".chr(13);
        $js .= "        }".chr(13);

        $js .= "        else if (item.action=='04') { ".chr(13);
        $js .= "            params.title = 'AUTORIZAR REGISTRO';".chr(13);
        $js .="             this.confirmDelete(params.params);".chr(13);
        $js .="             return true;".chr(13);
        $js .= "        }".chr(13);

        $js .= "        else if(item.action=='05') { ".chr(13);
        $js .= "           params.title = 'ACTUALIZAR VISTA';".chr(13);
        $js .="            this.reload();".chr(13);
        $js .="            return true;".chr(13);
        $js .= "        }".chr(13);

        $js .= "        else if(item.action=='10') { ".chr(13);
        $js .= "           params.title = 'APLICAR CRITERIOS';".chr(13);
        $js .="            this.openFilter();".chr(13);
        $js .="            return true;".chr(13);
        $js .= "        }".chr(13);

        $js .= "        else {".chr(13);
        //$js .= "            console.log('handler:'+ item.handler);".chr(13);
        $js .= "            var handler = App.executeFunction(item.handler, window, params, this);".chr(13);
        //$js .= "        var tmpFunc = new Function(item.handler);".chr(13);
        //$js .= "         tmpFunc();".chr(13);

        //$js .= "        handler.call(this);".chr(13);
        $js .= "        }".chr(13);



        $js .= "    }".chr(13);


        $js .= "});".chr(13);

        return $js;

    }


    /**
     * Crea un objeto de DataTables con los parametos proporcionados
     * @param array $config
     *
     * @return $this
     */
    public function DataTable(array $config=[])
    {

        # Definimos variables del idioma
        $language = array(
            'emptyTable' => 'No se encontraron datos en la tabla',
            'info' => "Mostrando <span class='txt-color-darken'>_START_</span> al <span class='txt-color-darken'>_END_</span> de <span class='text-primary'>_TOTAL_</span> registros",
            'infoEmpty' => "<span class='txt-color-darken'> No se encontraron registros </span>",
            'infoFiltered' => '(filtrado de _MAX_ total registros)',
            'infoPostFix' => '',
            'thousands' => ',',
            'lengthMenu' => '_MENU_',
            'loadingRecords' => 'Cargando información...',
            'processing' => '
                <div class="row"> 
                    <div class="col-md-12">
                        <button type="button" class="btn btn-primary btn-load">Light <span class="btn-loader icofont-spinner"></span></button>
                    </div>
                </div>',
            'search' => " ",
            'zeroRecords' => "<span class='txt-color-darken'> No existen conincidencia con los registros  </span>",
            'paginate' => array(
                'first' => '<<',
                'last' => '>>',
                'next' => '>',
                'previous' => '<',
            ),
            'aria' => array(
                'sortAscending' => ': activer pour trier la colonne par ordre croissant',
                'sortDescending' => ': activer pour trier la colonne par ordre décroissant',
            ),
        );


        $oTable     = $config['table']['oTable'];
        $dom        = $config['table']['dom'];
        $ajax       = $config['table']['ajax'];
        $columns    = $config['table']['columns'];
        $tableName  = $config['table']['source'];
        $lchange    = isset($config['table']['params']['bchange']) ? $config['table']['params']['bchange'] :true;
        $search     = isset($config['table']['params']['bsearch']) ? $config['table']['params']['bsearch'] :true;
        $alias      = isset($config['table']['alias']) ? $config['table']['alias'] :null;
        $footer     = isset($config['table']['footer']) ? $config['table']['footer'] :false;
        $responsive = $config['table']['params']['responsive'] ? true : false;
        $binfo      = isset($config['table']['bInfo']) ? $config['table']['bInfo'] : "S";
        $callbacks  = isset($config['table']['callbacks']) ? $config['table']['callbacks'] : [];
        $autowidth  = isset($config['table']['autowidth']) ? $config['table']['autowidth'] : false;


        #----------------------
        $schange  =  $lchange == true ? "":"";

        $dataTable = DataTable::instance($oTable);
        $dataTable->setColumns($columns)
            ->setTableDom($dom)
            //->setEvents()
              //->setDom("<'row table-tb' <'col-sm-12' l <'pull-left table-toolbar'> <'pull-right'f>r<'clearfix'>>> <'table-responsive't> <'row'<'col-sm-12'<'pull-left'i><'pull-right'p><'clearfix'>>>")
            ->setDom("<'pull-left table-toolbar'>".
                "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" .
                "<'table-responsive'tr>" .
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>")


            /*->setJsInitParam("oTableTools" , ' {
            "aButtons": [
                "copy",
                "csv",
                "xls",
	                {
                        "sExtends": "pdf",
	                    "sTitle": "SmartAdmin_PDF",
	                    "sPdfMessage": "SmartAdmin PDF Export",
	                    "sPdfSize": "letter"
	                },
	             	{
                        "sExtends": "print",
                    	"sMessage": "Generated by SmartAdmin <i>(press Esc to close)</i>"
                	}
	             ],
	            "sSwfPath": "js\plugin\datatables\swf\copy_csv_xls_pdf.swf"
	        }')*/
            ->setJsInitParam('language', $language)
            ->setJsInitParam("bLengthChange", $lchange)
            ->setJsInitParam("lengthMenu", [ 10, 25, 50, 75, 100 , 500])
            ->setJsInitParam("bFilter", $search)
            ->setJsInitParam("bSort", true)
            ->setJsInitParam("info", $binfo)
            ->setJsInitParam("bDestroy", true)
            ->setJsInitParam("responsive", $responsive)
            ->setJsInitParam("autoWidth",  $autowidth)
            ->setJsInitParam("processing", true)
            ->setJsInitParam("iDisplayLength", 25)
            //->setJsInitParam("scrollY", 300)
            ->setServerSide($ajax)
            ->setHeader(true)// To generate thead when you will call getHtml
            ->setFooter($footer);

        $dataTable->renderFilterOperators = false;

        $dataTable->setFrom($tableName, $alias)->setPdoLink(DB::connection()->getPdo());
        foreach ($callbacks as $k => $o) {
            $dataTable->setJsInitParam($k,$o);
        }
        $this->DataTable   = $dataTable;

        return $this;

    }


    /**
     * Regresa el HTML de la tabla que se va utilizar para el DataTable
     */
    public function getHtml($tAttributes = []){
        $id    = $this->config['table']['dom'];
        $class = isset($this->config['class']['class']) ? $this->config['table']['class'] : "table table-hover";

        if($this->DataTable){
            $table = $this->DataTable->getHtml(['id'=> $id, 'class'=>$class]);
            return $table;
        }

        return "<h3>No html for table ".$this->config['dataTable-id-dom']." </h3>";
    }


    /**
     * Regresa el HTML de la tabla que se va utilizar para el DataTable
     */
    public function getJavaScript(){
        if($this->DataTable){
            return $this->DataTable->getJavascript();
        }

        return "<h3>No html for table ".$this->config['dom']." </h3>";
    }


    public function RowSelect(){

        $oTable     = $this->config['table']['oTable'];
        $dom        = $this->config['table']['dom'];

        $js='// Add event listener for select a single rows'.PHP_EOL;;
        $js.='$("#'.$dom.' tbody").on( "click", "tr", function () {'.PHP_EOL;
        $js.='    var tr = $(this).closest("tr");'.PHP_EOL;
        $js.='    var row = '.$oTable.'.row( tr );'.PHP_EOL;
        $js.='    $this.index = '.$oTable.'.row( this ).index();'.PHP_EOL;

        $js.='    if ( $(this).hasClass("selected") ) {'.PHP_EOL;
        $js.='        $(this).removeClass("selected");'.PHP_EOL;
        $js.='    }'.PHP_EOL;
        $js.='    else {'.PHP_EOL;
        $js.='        '.$oTable.'.$("tr.selected").removeClass("selected");'.PHP_EOL;
        $js.='        $(this).addClass("selected");'.PHP_EOL;
        $js.='    }'.PHP_EOL;
        $js.='});'.PHP_EOL;

        return $js;
    }

    public function DblClickRowSelect(){

        $oTable     = $this->config['table']['oTable'];
        $dom        = $this->config['table']['dom'];
        $elements   = $this->config['menu'];
        $trigger    = false;
        $js         = '';

        //detectamos si existe el metodo editar
        foreach ($elements as $menu){
            $type   = $menu['class'];
            $items  = @$menu['items'];

            if($type == 'btn-group'){
                foreach ( $items as $item){
                    if($item['action']=='02'){
                        $trigger = $item['id'];
                    }
                }
            }

        }

        if($trigger){

            $js='// Add event listener for select a single rows'.PHP_EOL;;
            $js.='$("#'.$dom.' tbody").on( "dblclick", "tr", function () {'.PHP_EOL;
            $js.='    var tr = $(this).closest("tr");'.PHP_EOL;
            $js.='    var row = '.$oTable.'.row( tr );'.PHP_EOL;
            $js.='    $this.index = '.$oTable.'.row( this ).index();'.PHP_EOL;
            $js.='    '.$oTable.'.$("tr.selected").removeClass("selected");'.PHP_EOL;
            $js.='    $(this).addClass("selected");'.PHP_EOL;
            $js.='    $(\'#'.$trigger.'\').trigger(\'click\');'.PHP_EOL;
            $js.='});'.PHP_EOL;

        }






        return $js;
    }




    public  function getDataTable() {

        return $this->DataTable;
    }


    public static function Init(){


    }


    public  function getMenu(){
        $menu     = $this->config['menu'];

        return $menu;


    }


}
