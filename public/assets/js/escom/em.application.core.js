$.ajaxSetup({
  headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')}
});
/*
 * JS ARRAY SCRIPT STORAGE
 * Description: used with loadScript to store script path and file name
 * so it will not load twice
 */
jsArray = {};




/***
 * Core extend
 *
 **/

/**
 * VARIABLES GLOBALES DE LA APLICACION QUE USA EL ARCHIVO CONFIG
 */
var EMConfig =  {
    settings : {
        NOTIFICATION_ROUTE    : '/',
        NOTIFICATION_INTERVAL : null,
        NOTIFICATION_INTERVAL_TIME : 1, //MIN
    }

};


/**
 Core script to handle the entire theme and core functions
 **/
var App = function () {
    'use strict';

    // IE mode
    var isRTL = false;
    var isIE8 = false;
    var isIE9 = false;
    var isIE10 = false;
    var isMobile = false;

    var sidebarWidth = 215;
    var sidebarCollapsedWidth = 35;

    var responsiveHandlers = [];

    // theme layout color set
    var layoutColorCodes = {
        'blue': '#4b8df8',
        'red': '#e02222',
        'green': '#35aa47',
        'purple': '#852b99',
        'grey': '#555555',
        'light-grey': '#fafafa',
        'yellow': '#ffb848'
    };

    // To get the correct viewport width based on  http://andylangton.co.uk/articles/javascript/get-viewport-size-javascript/
    var _getViewPort = function () {
        var e = window, a = 'inner';
        if (!('innerWidth' in window)) {
            a = 'client';
            e = document.documentElement || document.body;
        }
        return {
            width: e[a + 'Width'],
            height: e[a + 'Height']
        };
    };


    var handeleTooltip = function(){

    };


    // masked_inputs
    var masked_inputs = function() {
        var $maskedInput = $('.masked_input');
        if($maskedInput.length) {
            $maskedInput.inputmask();
        }
    };

    // initializes main settings
    var handleInit = function () {

        isIE8 = !!navigator.userAgent.match(/MSIE 8.0/);
        isIE9 = !!navigator.userAgent.match(/MSIE 9.0/);
        isIE10 = !!navigator.userAgent.match(/MSIE 10.0/);
        isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(window.navigator.userAgent);


        // page onload functions

        $.ajaxSetup({
            error: function (jqXHR, textStatus, errorThrown) {
                if (jqXHR.status == 500) {
                    App.handleResponse(jqXHR.responseText, errorThrown);
                }
            }
        });



    };

    var fitModal = function(modal){
        var body, bodypaddings, header, headerheight, height, modalheight, modaldialog, modalpaddigns,footer,footerheight,bodyheight;
        var $window     = $(window);
        var limit       = 500;
        modaldialog     = $(".modal-dialog", modal);
        header          = $(".modal-header", modal);
        footer          = $(".modal-footer", modal);
        body            = $(".modal-body", modal);
        modalheight     = parseInt(modal.css("height"));
        modalpaddigns   = parseInt(modaldialog.css("margin-top")) + parseInt(modaldialog.css("margin-top"));
        headerheight    = parseInt(header.css("height")) + parseInt(header.css("padding-top")) + parseInt(header.css("padding-bottom"));
        footerheight    = parseInt(footer.css("height")) + parseInt(footer.css("padding-top")) + parseInt(footer.css("padding-bottom"));
        bodypaddings    = parseInt(body.css("padding-top")) + parseInt(body.css("padding-bottom")) ;
        bodyheight      = body.height();
        height 		    = bodyheight - ( headerheight + footerheight );

        var ajust  	    = $window.height() - headerheight - footerheight ;

        body.css("min-height", "" + bodyheight + "px");
        body.css("height", "" + bodyheight + "px");


        if((height - 50)  > $window.height() ){
            body.css("max-height", "" + ajust + "px");
        };




        return height;


    };

    //* END:CORE HANDLERS *//

    return {
        interval : null,

        //main function to initiate the theme
        init: function () {

            //IMPORTANT!!!: Do not modify the core handlers call order.
            //core handlers
            handleInit(); // initialize core variables
            handeleTooltip();// initialize tooltips

            $.ajaxSetup({
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
            });

        },

        masked_inputs : function(){
            masked_inputs();
        },

        // check for device touch support
        isTouchDevice: function () {
            try {
                document.createEvent("TouchEvent");
                return true;
            } catch (e) {
                return false;
            }
        },

        // check IE8 mode
        isIE8: function () {
            return isIE8;
        },

        // check IE9 mode
        isIE9: function () {
            return isIE9;
        },
        isMobile : function(){
            return isMobile;
        },

        //check RTL mode
        isRTL: function () {
            return isRTL;
        },

        // get layout color code by color name
        getLayoutColorCode: function (name) {
            if (layoutColorCodes[name]) {
                return layoutColorCodes[name];
            } else {
                return '';
            }
        },

        handleScrollers : function(){
            return handleScrollers();
        },

        getContextPath : function (){
            return "/nomina/srh/public/";
        },

        ltrim  : function(str, chars) {
            chars = chars || "\\s";
            return str.replace(new RegExp("^[" + chars + "]+", "g"), "");
        },

        pad : function(n, width, z) {
            z = z || '0';
            n = n + '';
            return n.length >= width ? n : new Array(width - n.length + 1).join(z) + n;
        },

        // wrapper function to  block element(indicate loading)
        blockUI: function (el, centerY, path) {
            path = path || './';
            var el = jQuery(el);
            if (el.height() <= 400) {
                centerY = true;
            }
            el.block({
                // message: '<img src="assets/img/ajax-loader.gif" align="">',
                message: '<i class="fa fa-circle-o-notch fa-spin"></i> Cargando',
                centerY: centerY != undefined ? centerY : true,
                css: {
                    top: '10%',
                    border: 'none',
                    padding: '2px',
                    backgroundColor: 'none'
                },
                overlayCSS: {
                    backgroundColor: '#999',
                    opacity: 0.5,
                    cursor: 'wait'
                }
            });
        },

        // wrapper function to  un-block element(finish loading)
        unblockUI: function (el) {
            jQuery(el).unblock({
                onUnblock: function () {
                    jQuery(el).removeAttr("style");
                }
            });
        },



        /**
         * Realiza una peticion ajax al servidor
         * @params url
         * @params data
         *
         */
        request : function(config){

            var $this = this;

            $.ajax({
                url		: config.url,
                type	: config.type||'POST',
                dataType: config.dataType||"html",
                async	: true,
                cache   : false,
                //processData : false,
                crossDomain: config.crossDomain||false,
                data    : config.data || {},
                beforeSend: function(){
                    if(config.beforeSend){
                        config.beforeSend.call();
                    }
                },
                success: function (data, textStatus, jqXHR) {

                    if(config.success){
                        config.success.call(this, data, textStatus, jqXHR);
                    }

                },
                error: function (xhr, error, errorThrown ) {

                    if(config.error)
                    {
                        config.error.call(this, xhr , error, errorThrown);
                    }
                    else
                    {
                        App.handleResponse(xhr.responseText, xhr.status);

                    }
                },
                complete: function( jqXHR,  textStatus){

                    if(config.complete){
                        config.complete.call(this, textStatus);
                    }
                }
            });

        },

        menuAction : function(el, config, scope){
            el.bind('click', { scope: scope, action : config.action, required:config.required, item : config}, function(event) {
                var data 	 = event.data;
                var scope    = data.scope;
                var required = data.required || null;
                var item     = data.item;
                scope._pClik(data.action, config);
            });

            return el;

        },




        /**
         * crea un menu a partir de un objeto json
         *
         */
        menu : function(target, menu, scope){


            var $this = this;
            var iconsize    = "btn-sm";


            $.each(menu, function (idx, row) {
                var btngroup    = $('<div class="btn-group">');
                var type        = this.class;
                var parent      = this.parent;
                var items       = this.items;
                var showLabel   = this.showLabel;
                var btncls      = this.btncls || 'btn-default';

                if(type=='btn-group'){

                    $.each(items, function(index, value){
                        var config = value;
                        var cls    = config.class || 'btn-default';
                        var size   = config.size  || 'btn-sm';
                        var icono  = config.icon  || undefined;


                        if (icono.indexOf("fa-") === -1 ){
                            icono = '<i class="material-icons">'+config.icon+'</i>';

                        }else {

                            icono = '<i class="fa ' + icono + '"></i> ';

                        }

                        var btn    = $('<button id="'+config.id+'"ss/>').addClass('btn btn-outline-primary btn-responsive '+cls).addClass(size).append(icono);
                        var tip    = config.tooltip||undefined;

                        if(showLabel){
                            btn.append('<span> '+ config.text + '</span>');
                        }

                        if(tip){
                            btn.attr('rel','tooltip').attr('title',tip).attr('data-placement',"bottom");
                        }

                        $this.menuAction(btn, config, scope);
                        btngroup.append(btn);

                    });
                    target.append(btngroup);

                };

                if(type=='dropdown'){


                    var tip    = this.tooltip||undefined;
                    var size   = this.size || 'btn-sm';
                    var container = $('<div aria-haspopup="true" data-uk-dropdown="{mode:\'click\'}" >').addClass('uk-button-dropdown');
                    var btn   = $('<button id="'+this.id+'">').addClass(iconsize).addClass('md-btn md-btn-small btn-responsive '+btncls+'');
                    var btndrop = $('<div class="uk-dropdown uk-dropdown-bottom">');

                    //var btn   = $('<button id="'+this.id+'" data-toggle="dropdown" aria-expanded="false">').addClass('btn btn-responsive '+btncls+'').append('<i class="fa '+this.icon+'"></i>');


                    if(showLabel){
                        btn.append(this.title);
                    }
                    btn.append('<i class="material-icons"></i>');

                    if(tip){
                        btn.attr('rel','tooltip').attr('title',tip).attr('data-placement',"bottom");
                    }

                    btn.addClass(size);
                    container.append(btn);
                    container.append(btndrop);

                    var ul = $("<ul class='uk-nav uk-nav-dropdown'></ul>");
                    btndrop.append(ul);
                    $this.buildUL(ul, items, scope);

                    target.append(container);
                }

            });
        },


        buildUL : function(parent, items, scope){
            var $this = this;

            $.each(items, function (index, value) {
                var config      = value;
                var childrens   = false;

                if (this.items && this.items.length > 0){
                    childrens = true;
                }


                var icono = '';
                if( config.icon != undefined ) {


                    if ( icono.search("/fa-/") ){
                        icono = '<i class="fa ' + config.icon + '"></i> ';
                    }else {
                        icono = '<i class="material-icons">'+config.icon+'</i>';
                    }


                }

                var a  = $('<a href="javascript:void(0);">'+ icono + config.text + '</a>');
                if(!childrens) {
                    $this.menuAction(a, config, scope);
                }

                var li = $("<li class='js-menu'></li>").append(a);
                parent.append(li);
                if ( childrens) {
                     var ul = $("<ul class='dropdown-menu js-menu'></ul>");

                     li.addClass('dropdown-submenu');
                     li.append(ul);
                     $this.buildUL(ul, this.items, scope);
                }

            });

        },




        /**
         * Intenta ejecutar una function apartir de un string
         * executeFunction("My.Namespace.functionName", window, arguments);
         *
         **/
        executeFunction : function(functionName, context) {


            if(functionName==null || functionName==''){
                alert ("--> No definiste la funcion a ejecutar");
                return false;
            }
            var args = Array.prototype.slice.call(arguments, 2);
            var namespaces = functionName.split(".");
            var func = namespaces.pop();
            for (var i = 0; i < namespaces.length; i++) {
                context = context[namespaces[i]];
            }



            try
            {
                if(context[func]==undefined || context[func]==null)
                {
                    alert ("-->  No existe la funcion a ejecutar");
                    return false;
                }
                return context[func].apply(context, args);

            }catch (e){
                alert("ERROR DE PROGRAMACION -> No existe la funcion :\n"+ functionName + " \n["+ e.message + "]");
            }

        },


        /**
         * Recibe como parametro el Response, para que funcione debe de contener un JSON valido
         * los parametros que debe devolver el response son
         *
         * success : true, indica si la peticion fue correcta
         * request : {
		*	transaccion : Boolean true or false ,
		*   message     : String
		*   session     : Object { connected : true, token : JSID }
	    *	errors      : Object { String code: , String : msg }
		*	data        : { }
		*}
         *
         *
         **/
        handleResponse: function (responseText, status, line) {

            //validamos que el estatus = 200 OK.
            if (status != 200) {
                this.showError(status, "No se proceso la petición :" + responseText, responseText);
                return false;
            }


            //VERIFICAMOS EL RESPONSE
            var json  = this.decode(responseText);

            // no es un objeto json valido
            if (!json) {


                var a = new String(responseText);
                if (a.trim().length == 0) {
                    a = 'HTTP/1.1 400 Http Empty';
                }

                this.showError(status, a);
                return false;
            }


            //VERIFICA LA PETICION QUE HAYA SIDO CORRECTA
            if (json.success === false || json.success == false) {
                this.showError(500, "Upss ocurrio un error, <br> <h1>Bad Request</h1>", 0);
                return false;
            }

            //VERIFICA LA SESSION
            if (json.request.session.connected != true) {
                this.showLoginAgain();
                return false;
            }

            //VERIFICAMOS LA TRANSACCION
            if (json.request.transaction != true) {
                this.showError(json.request.errors.code, json.request.errors.message, json.request.errors.trace||'');
                return false;
            }

            return json.request;
        },

        showError: function (code, message, trace) {

            if(message.length > 500){
                message = '<div style="max-height:500px;overflow-y: scroll;">' + message + '<div>';
            }

            var options = {
                title       : code,
                message     : message,
                color       : 'dark',
                position    : 'topRight',
                icon        : 'fa fa-warning',
                transitionIn: 'fadeInDown',
                progressBarColor: 'rgb(0, 255, 184)',
                iconColor: 'rgb(0, 255, 184)',
                layout:1
            };

            if (trace) {
                options.buttons =  [
                    ['<button>Ver</button>', function (instance, toast) {
                        instance.hide({},toast, 'close', 'btn1');
                        App.modal({code:code, message: message, trace: trace});
                    }]
                ];
            }


            $.toast({
                text    : message, // Text that is to be shown in the toast
                heading : code, // Optional heading to be shown on the toast

                showHideTransition: 'fade', // fade, slide or plain
                allowToastClose: true, // Boolean value true or false
                hideAfter: 10000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
                stack: 5, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time
                position: 'bottom-left', // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values

                bgColor: '#000',  // Background color of the toast
                textColor: '#fff',  // Text color of the toast
                textAlign: 'left',  // Text alignment i.e. left, right or center
                loader: false,  // Whether to show loader or not. True by default
                loaderBg: '#9EC600',  // Background color of the toast loader
                beforeShow: function () {}, // will be triggered before the toast is shown
                afterShown: function () {}, // will be triggered after the toat has been shown
                beforeHide: function () {}, // will be triggered before the toast gets hidden
                afterHidden: function () {}  // will be triggered after the toast has been hidden
            });


        },


        showLoginAgain: function () {
            var customModal;
            customModal = '<div class="modal fade" id="modal-login-again" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">';
            customModal+= '  <div class="modal-dialog">';
            customModal+= '    <div class="modal-content">';
            customModal+= '      <div class="modal-header">';
            customModal+= '        <h4 class="modal-title" id="myModalLabel">Inicia Session</h4>';
            customModal+= '      </div>';
            customModal+= '      <div class="modal-body">';
            customModal+= '        <div class="panel panel-danger">';
            customModal+= '            <div class="panel-heading">';
            customModal+= '              <h3 class="panel-title">Session Caducada</h3>';
            customModal+= '            </div>';
            customModal+= '            <div class="panel-body">';
            customModal+= '              <p> Tu session ha caducado, por favor inicia session de nuevo en el sistema </p>';
            customModal+= '            </div>';
            customModal+= '        </div>';
            customModal+= '      </div">';
            customModal+= '      <div class="modal-footer">';
            customModal+= '        <a href="'+ App.getContextPath() +'login" class="btn btn-success">Iniciar Session</a>';
            customModal+= '      </div>';
            customModal+= '    </div>';
            customModal+= '  </div>';
            customModal+= '</div>';

            $('body').append(customModal);
            $('#modal-login-again').show();
            $('#modal-login-again').modal({keyboard : false, backdrop : 'static'});

            $('#modal-login-again').on('hidden.bs.modal', function(){
                $('#modal-login-again').remove();
            });


        },

        /**
         *
         * @param config
         */
        modal : function (config) {

            config.id = config.id ||'modal-error';


             var customModal = '';;
             customModal+= '<div class="modal fade" id="'+config.id+'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">';
             customModal+= '  <div class="modal-dialog">';
             customModal+= '    <div class="modal-content">';
             customModal+= '      <div class="modal-header">';
             customModal+= '        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
             customModal+= '        <h2 class="modal-title" id="myModalLabel">'+ config.code +'</h2>';
             customModal+= '      </div>';
             customModal+= '      <div class="modal-body" style="overflow: auto">';
             customModal+= '        	<div class="">'+ config.message +'</div><br><br>';
             if	(config.trace){
                 var tracer = '';
                 tracer+= '<div id="accordion" class="panel-group smart-accordion-default">';
                 tracer+='		<div class="panel panel-default">';
                 tracer+='			<div class="panel-heading">';
                 tracer+='					<h4 class="panel-title"><a class="collapsed" href="#collapse-trace" data-parent="#accordion" data-toggle="collapse" aria-expanded="false"> <i class="fa fa-fw fa-plus-circle txt-color-green"></i><i class="fa fa-fw fa-minus-circle txt-color-red"></i> INFORMACIÓN DEL ERROR </a></h4>';
                 tracer+='			</div>';
                 tracer+='			<div class="panel-collapse collapse" id="collapse-trace" aria-expanded="false" style="height: 0px;">';
                 tracer+='				<div class="panel-body" style="overflow:hidden;">';
                 tracer+='                   <div class="well well-sm "> <small class="text-muted">' + config.trace + '</small></div> ';
                 tracer+='				</div>';
                 tracer+='			</div>';
                 tracer+='		</div>';
                 tracer+='</div>';
                 customModal+= '        	<div>'+ tracer +'</div>';
             }
             customModal+= '      </div>';
             customModal+= '      <div class="modal-footer">';
             customModal+= '        <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>';
             customModal+= '      </div>';
             customModal+= '    </div>';
             customModal+= '  </div>';
             customModal+= '</div>';

             $('body').append(customModal);
             $('#'+config.id).show();
             $('#'+config.id).modal();
             $('#'+config.id).on('hidden.bs.modal', function(){
             $('#'+config.id).remove();
             });

        },


        /**
         *
         * @param message
         */
        stickyNotification : function(atype, config) {

            var $area = $('#top-alert-container');
            jQuery.fn.exists = function(){ return this.length > 0; };

            if (! $area.exists()) {
                $area  = $('<div id="top-alert-container"></div>');
                $('body').prepend($area);
            }



            if(atype == 'alert'){
                config.bgColor = "#e3354b";
                config.ftColor = "#FFF";
            }

            $area.stickyalert({
                barColor        : config.barColor || '#222', // alert background color
                barFontColor    : config.barFontColor || '#FFF', // text font color
                barFontSize     : '1.1rem', // text font size
                barText         : config.message, // the text to display, linked with barTextLink
                barTextLink     : config.url || '#', // url for anchor
                cookieRememberDays: '1', // in days
                displayDelay    : config.displayDelay || '5000' // in milliseconds, 3 second default
            });

        },


        resize : function(modal){
            $(window).resize(function() {
                return fitModal(modal);
            });
            return fitModal(modal);

        },

        /**
         * decode - Try to decode a json string
         *
         * @param response string response, respuesta del la peticion
         * @return if a valid json string return object else return false
         */
        decode: function (response) {
            try {
                return jQuery.parseJSON(response);
            } catch (e) {
                return false;
            }
        },


        expired : function( route ){

            var $screen = $('.inner-wrapper');

            $(document).bind("contextmenu",function(e){
                return false;
            });

            /**
             * CON ESTE SCRIPT SE BLOQUEA LA PANTALLA
             **/
            $screen.addClass('block-screen');
            var modal = new EMModal();


            modal.Open({
                url: route.plans ,
                modal :'modal_block_screen',
                title :' EL PLAN HA CADUCADO ',
                msize: 'modal-lg'
            });


            $('.modal-header .close').remove();

            var btn_cl = $('#modal_block_screen #modal-dlg-close');
            var btn_ok = $('#modal_block_screen #modal-dlg-ok').remove();

            btn_cl.removeAttr("data-dismiss").unbind('click').html("<i class=\"fa fa-mail-reply\"></i> <b>Mi subscripción</b>").bind('click',function(){
                window.location.href = route.subscription;
            });


        },



    };

}();




/*
 * LOAD SCRIPTS
 * Usage:
 * Define function = myPrettyCode ()...
 * loadScript("js/my_lovely_script.js", myPrettyCode);
 */
function loadScript(scriptName, callback) {

    if (!jsArray[scriptName]) {
        jsArray[scriptName] = true;

        // adding the script tag to the head as suggested before
        var body = document.getElementsByTagName('body')[0],
            script = document.createElement('script');
        script.type = 'text/javascript';
        script.src = scriptName;

        // then bind the event to the callback function
        // there are several events for cross browser compatibility
        script.onload = callback;

        // fire the loading
        body.appendChild(script);

        // clear DOM reference
        //body = null;
        //script = null;

    } else if (callback) {
        // changed else to else if(callback)

        //execute function
        callback();
    }

}
/* ~ END: LOAD SCRIPTS */


/*
 * ScrollToFixed
 * https://github.com/bigspotteddog/ScrollToFixed
 *
 * Copyright (c) 2011 Joseph Cava-Lynch
 * MIT license
 */
(function($) {
    $.isScrollToFixed = function(el) {
        return !!$(el).data('ScrollToFixed');
    };

    $.ScrollToFixed = function(el, options) {
        // To avoid scope issues, use 'base' instead of 'this' to reference this
        // class from internal events and functions.
        var base = this;

        // Access to jQuery and DOM versions of element.
        base.$el = $(el);
        base.el = el;

        // Add a reverse reference to the DOM object.
        base.$el.data('ScrollToFixed', base);

        // A flag so we know if the scroll has been reset.
        var isReset = false;

        // The element that was given to us to fix if scrolled above the top of
        // the page.
        var target = base.$el;

        var position;
        var originalPosition;
        var originalFloat;
        var originalOffsetTop;
        var originalZIndex;

        // The offset top of the element when resetScroll was called. This is
        // used to determine if we have scrolled past the top of the element.
        var offsetTop = 0;

        // The offset left of the element when resetScroll was called. This is
        // used to move the element left or right relative to the horizontal
        // scroll.
        var offsetLeft = 0;
        var originalOffsetLeft = -1;

        // This last offset used to move the element horizontally. This is used
        // to determine if we need to move the element because we would not want
        // to do that for no reason.
        var lastOffsetLeft = -1;

        // This is the element used to fill the void left by the target element
        // when it goes fixed; otherwise, everything below it moves up the page.
        var spacer = null;

        var spacerClass;

        var className;

        // Capture the original offsets for the target element. This needs to be
        // called whenever the page size changes or when the page is first
        // scrolled. For some reason, calling this before the page is first
        // scrolled causes the element to become fixed too late.
        function resetScroll() {
            // Set the element to it original positioning.
            target.trigger('preUnfixed.ScrollToFixed');
            setUnfixed();
            target.trigger('unfixed.ScrollToFixed');

            // Reset the last offset used to determine if the page has moved
            // horizontally.
            lastOffsetLeft = -1;

            // Capture the offset top of the target element.
            offsetTop = target.offset().top;

            // Capture the offset left of the target element.
            offsetLeft = target.offset().left;

            // If the offsets option is on, alter the left offset.
            if (base.options.offsets) {
                offsetLeft += (target.offset().left - target.position().left);
            }

            if (originalOffsetLeft == -1) {
                originalOffsetLeft = offsetLeft;
            }

            position = target.css('position');

            // Set that this has been called at least once.
            isReset = true;

            if (base.options.bottom != -1) {
                target.trigger('preFixed.ScrollToFixed');
                setFixed();
                target.trigger('fixed.ScrollToFixed');
            }
        }

        function getLimit() {
            var limit = base.options.limit;
            if (!limit) return 0;

            if (typeof(limit) === 'function') {
                return limit.apply(target);
            }
            return limit;
        }

        // Returns whether the target element is fixed or not.
        function isFixed() {
            return position === 'fixed';
        }

        // Returns whether the target element is absolute or not.
        function isAbsolute() {
            return position === 'absolute';
        }

        function isUnfixed() {
            return !(isFixed() || isAbsolute());
        }

        // Sets the target element to fixed. Also, sets the spacer to fill the
        // void left by the target element.
        function setFixed() {
            // Only fix the target element and the spacer if we need to.
            if (!isFixed()) {
                //get REAL dimensions (decimal fix)
                //Ref. http://stackoverflow.com/questions/3603065/how-to-make-jquery-to-not-round-value-returned-by-width
                var dimensions = target[0].getBoundingClientRect();

                // Set the spacer to fill the height and width of the target
                // element, then display it.
                spacer.css({
                    'display' : target.css('display'),
                    'width' : dimensions.width,
                    'height' : dimensions.height,
                    'float' : target.css('float')
                });

                // Set the target element to fixed and set its width so it does
                // not fill the rest of the page horizontally. Also, set its top
                // to the margin top specified in the options.

                cssOptions={
                    'z-index' : base.options.zIndex,
                    'position' : 'fixed',
                    'top' : base.options.bottom == -1?getMarginTop():'',
                    'bottom' : base.options.bottom == -1?'':base.options.bottom,
                    'margin-left' : '0px'
                };
                if (!base.options.dontSetWidth){ cssOptions['width']=target.css('width'); };

                target.css(cssOptions);

                target.addClass(base.options.baseClassName);

                if (base.options.className) {
                    target.addClass(base.options.className);
                }

                position = 'fixed';
            }
        }

        function setAbsolute() {

            var top = getLimit();
            var left = offsetLeft;

            if (base.options.removeOffsets) {
                left = '';
                top = top - offsetTop;
            }

            cssOptions={
                'position' : 'absolute',
                'top' : top,
                'left' : left,
                'margin-left' : '0px',
                'bottom' : ''
            };
            if (!base.options.dontSetWidth){ cssOptions['width']=target.css('width'); };

            target.css(cssOptions);

            position = 'absolute';
        }

        // Sets the target element back to unfixed. Also, hides the spacer.
        function setUnfixed() {
            // Only unfix the target element and the spacer if we need to.
            if (!isUnfixed()) {
                lastOffsetLeft = -1;

                // Hide the spacer now that the target element will fill the
                // space.
                spacer.css('display', 'none');

                // Remove the style attributes that were added to the target.
                // This will reverse the target back to the its original style.
                target.css({
                    'z-index' : originalZIndex,
                    'width' : '',
                    'position' : originalPosition,
                    'left' : '',
                    'top' : originalOffsetTop,
                    'margin-left' : ''
                });

                target.removeClass('scroll-to-fixed-fixed');

                if (base.options.className) {
                    target.removeClass(base.options.className);
                }

                position = null;
            }
        }

        // Moves the target element left or right relative to the horizontal
        // scroll position.
        function setLeft(x) {
            // Only if the scroll is not what it was last time we did this.
            if (x != lastOffsetLeft) {
                // Move the target element horizontally relative to its original
                // horizontal position.
                target.css('left', offsetLeft - x);

                // Hold the last horizontal position set.
                lastOffsetLeft = x;
            }
        }

        function getMarginTop() {
            var marginTop = base.options.marginTop;
            if (!marginTop) return 0;

            if (typeof(marginTop) === 'function') {
                return marginTop.apply(target);
            }
            return marginTop;
        }

        // Checks to see if we need to do something based on new scroll position
        // of the page.
        function checkScroll() {
            if (!$.isScrollToFixed(target) || target.is(':hidden')) return;
            var wasReset = isReset;
            var wasUnfixed = isUnfixed();

            // If resetScroll has not yet been called, call it. This only
            // happens once.
            if (!isReset) {
                resetScroll();
            } else if (isUnfixed()) {
                // if the offset has changed since the last scroll,
                // we need to get it again.

                // Capture the offset top of the target element.
                offsetTop = target.offset().top;

                // Capture the offset left of the target element.
                offsetLeft = target.offset().left;
            }

            // Grab the current horizontal scroll position.
            var x = $(window).scrollLeft();

            // Grab the current vertical scroll position.
            var y = $(window).scrollTop();

            // Get the limit, if there is one.
            var limit = getLimit();

            // If the vertical scroll position, plus the optional margin, would
            // put the target element at the specified limit, set the target
            // element to absolute.
            if (base.options.minWidth && $(window).width() < base.options.minWidth) {
                if (!isUnfixed() || !wasReset) {
                    postPosition();
                    target.trigger('preUnfixed.ScrollToFixed');
                    setUnfixed();
                    target.trigger('unfixed.ScrollToFixed');
                }
            } else if (base.options.maxWidth && $(window).width() > base.options.maxWidth) {
                if (!isUnfixed() || !wasReset) {
                    postPosition();
                    target.trigger('preUnfixed.ScrollToFixed');
                    setUnfixed();
                    target.trigger('unfixed.ScrollToFixed');
                }
            } else if (base.options.bottom == -1) {
                // If the vertical scroll position, plus the optional margin, would
                // put the target element at the specified limit, set the target
                // element to absolute.
                if (limit > 0 && y >= limit - getMarginTop()) {
                    if (!wasUnfixed && (!isAbsolute() || !wasReset)) {
                        postPosition();
                        target.trigger('preAbsolute.ScrollToFixed');
                        setAbsolute();
                        target.trigger('unfixed.ScrollToFixed');
                    }
                    // If the vertical scroll position, plus the optional margin, would
                    // put the target element above the top of the page, set the target
                    // element to fixed.
                } else if (y >= offsetTop - getMarginTop()) {
                    if (!isFixed() || !wasReset) {
                        postPosition();
                        target.trigger('preFixed.ScrollToFixed');

                        // Set the target element to fixed.
                        setFixed();

                        // Reset the last offset left because we just went fixed.
                        lastOffsetLeft = -1;

                        target.trigger('fixed.ScrollToFixed');
                    }
                    // If the page has been scrolled horizontally as well, move the
                    // target element accordingly.
                    setLeft(x);
                } else {
                    // Set the target element to unfixed, placing it where it was
                    // before.
                    if (!isUnfixed() || !wasReset) {
                        postPosition();
                        target.trigger('preUnfixed.ScrollToFixed');
                        setUnfixed();
                        target.trigger('unfixed.ScrollToFixed');
                    }
                }
            } else {
                if (limit > 0) {
                    if (y + $(window).height() - target.outerHeight(true) >= limit - (getMarginTop() || -getBottom())) {
                        if (isFixed()) {
                            postPosition();
                            target.trigger('preUnfixed.ScrollToFixed');

                            if (originalPosition === 'absolute') {
                                setAbsolute();
                            } else {
                                setUnfixed();
                            }

                            target.trigger('unfixed.ScrollToFixed');
                        }
                    } else {
                        if (!isFixed()) {
                            postPosition();
                            target.trigger('preFixed.ScrollToFixed');
                            setFixed();
                        }
                        setLeft(x);
                        target.trigger('fixed.ScrollToFixed');
                    }
                } else {
                    setLeft(x);
                }
            }
        }

        function getBottom() {
            if (!base.options.bottom) return 0;
            return base.options.bottom;
        };

        function postPosition() {
            var position = target.css('position');

            if (position == 'absolute') {
                target.trigger('postAbsolute.ScrollToFixed');
            } else if (position == 'fixed') {
                target.trigger('postFixed.ScrollToFixed');
            } else {
                target.trigger('postUnfixed.ScrollToFixed');
            }
        };

        var windowResize = function(event) {
            // Check if the element is visible before updating it's position, which
            // improves behavior with responsive designs where this element is hidden.
            if(target.is(':visible')) {
                isReset = false;
                checkScroll();
            } else {
                // Ensure the spacer is hidden
                setUnfixed();
            }
        };

        var windowScroll = function(event) {
            (!!window.requestAnimationFrame) ? requestAnimationFrame(checkScroll) : checkScroll();
        };

        // From: http://kangax.github.com/cft/#IS_POSITION_FIXED_SUPPORTED
        var isPositionFixedSupported = function() {
            var container = document.body;

            if (document.createElement && container && container.appendChild && container.removeChild) {
                var el = document.createElement('div');

                if (!el.getBoundingClientRect) { return null; };

                el.innerHTML = 'x';
                el.style.cssText = 'position:fixed;top:100px;';
                container.appendChild(el);

                var originalHeight = container.style.height,
                    originalScrollTop = container.scrollTop;

                container.style.height = '3000px';
                container.scrollTop = 500;

                var elementTop = el.getBoundingClientRect().top;
                container.style.height = originalHeight;

                var isSupported = (elementTop === 100);
                container.removeChild(el);
                container.scrollTop = originalScrollTop;

                return isSupported;
            }

            return null;
        };

        var preventDefault = function(e) {
            e = e || window.event;
            if (e.preventDefault) {
                e.preventDefault();
            }
            e.returnValue = false;
        };

        // Initializes this plugin. Captures the options passed in, turns this
        // off for devices that do not support fixed position, adds the spacer,
        // and binds to the window scroll and resize events.
        base.init = function() {
            // Capture the options for this plugin.
            base.options = $.extend({}, $.ScrollToFixed.defaultOptions, options);

            originalZIndex = target.css('z-index');

            // Turn off this functionality for devices that do not support it.
            // if (!(base.options && base.options.dontCheckForPositionFixedSupport)) {
            //     var fixedSupported = isPositionFixedSupported();
            //     if (!fixedSupported) return;
            // }

            // Put the target element on top of everything that could be below
            // it. This reduces flicker when the target element is transitioning
            // to fixed.
            base.$el.css('z-index', base.options.zIndex);

            // Create a spacer element to fill the void left by the target
            // element when it goes fixed.
            spacer = $('<div />');

            position = target.css('position');
            originalPosition = target.css('position');
            originalFloat = target.css('float');
            originalOffsetTop = target.css('top');

            // Place the spacer right after the target element.
            if (isUnfixed()) base.$el.after(spacer);

            // Reset the target element offsets when the window is resized, then
            // check to see if we need to fix or unfix the target element.
            $(window).bind('resize.ScrollToFixed', windowResize);

            // When the window scrolls, check to see if we need to fix or unfix
            // the target element.
            $(window).bind('scroll.ScrollToFixed', windowScroll);

            // For touch devices, call checkScroll directlly rather than
            // rAF wrapped windowScroll to animate the element
            if ('ontouchmove' in window) {
                $(window).bind('touchmove.ScrollToFixed', checkScroll);
            }

            if (base.options.preFixed) {
                target.bind('preFixed.ScrollToFixed', base.options.preFixed);
            }
            if (base.options.postFixed) {
                target.bind('postFixed.ScrollToFixed', base.options.postFixed);
            }
            if (base.options.preUnfixed) {
                target.bind('preUnfixed.ScrollToFixed', base.options.preUnfixed);
            }
            if (base.options.postUnfixed) {
                target.bind('postUnfixed.ScrollToFixed', base.options.postUnfixed);
            }
            if (base.options.preAbsolute) {
                target.bind('preAbsolute.ScrollToFixed', base.options.preAbsolute);
            }
            if (base.options.postAbsolute) {
                target.bind('postAbsolute.ScrollToFixed', base.options.postAbsolute);
            }
            if (base.options.fixed) {
                target.bind('fixed.ScrollToFixed', base.options.fixed);
            }
            if (base.options.unfixed) {
                target.bind('unfixed.ScrollToFixed', base.options.unfixed);
            }

            if (base.options.spacerClass) {
                spacer.addClass(base.options.spacerClass);
            }

            target.bind('resize.ScrollToFixed', function() {
                spacer.height(target.height());
            });

            target.bind('scroll.ScrollToFixed', function() {
                target.trigger('preUnfixed.ScrollToFixed');
                setUnfixed();
                target.trigger('unfixed.ScrollToFixed');
                checkScroll();
            });

            target.bind('detach.ScrollToFixed', function(ev) {
                preventDefault(ev);

                target.trigger('preUnfixed.ScrollToFixed');
                setUnfixed();
                target.trigger('unfixed.ScrollToFixed');

                $(window).unbind('resize.ScrollToFixed', windowResize);
                $(window).unbind('scroll.ScrollToFixed', windowScroll);

                target.unbind('.ScrollToFixed');

                //remove spacer from dom
                spacer.remove();

                base.$el.removeData('ScrollToFixed');
            });

            // Reset everything.
            windowResize();
        };

        // Initialize the plugin.
        base.init();
    };

    // Sets the option defaults.
    $.ScrollToFixed.defaultOptions = {
        marginTop : 0,
        limit : 0,
        bottom : -1,
        zIndex : 1000,
        baseClassName: 'scroll-to-fixed-fixed'
    };

    // Returns enhanced elements that will fix to the top of the page when the
    // page is scrolled.
    $.fn.scrollToFixed = function(options) {
        return this.each(function() {
            (new $.ScrollToFixed(this, options));
        });
    };
})(jQuery);



/*!
 * jQuery Sticky Alert v0.1.4
 * https://github.com/tlongren/jquery-sticky-alert
 *
 * Copyright 2016 Tyler Longren
 * Released under the MIT license.
 * http://jquery.org/license
 *
 * Date: November 16, 2016
 */
(function($){

    $.fn.extend({

        stickyalert: function(options) {

            var defaults = {
                barColor: '#222', // alert background color
                barFontColor: '#FFF', // text font color
                barFontSize: '1.1rem', // text font size
                barText: 'I like bass and car audio :)', // the text to display, linked with barTextLink
                barTextLink: 'https://www.longren.io/', // url for anchor
                cookieRememberDays: '2', // in days
                displayDelay: '3000' // in milliseconds, 3 second default
            };

            var options = $.extend(defaults, options);

            return this.each(function() {


                    // show the alert
                    var alertBar = $('<div class="alert-box" style="background-color:' + options.barColor + '">' +
                        '<a href="' + options.barTextLink + '" ' +
                            'style="color:' + options.barFontColor + '; font-size:' + options.barFontSize + '">' + options.barText + '' +
                        '</a>' +
                        '<a href="#" class="close">&#10006;</a></div>');
                    var parent_id = $(this).closest("div").prop("id");
                    setTimeout(function () {
                        $("#" + parent_id).append(alertBar);
                    }, options.displayDelay);

                    // close the alert
                    alertBar.find("a.close").on("click", function(event) {
                        event.preventDefault();
                        alertBar.remove();

                    });

            });
        }
    });
})(jQuery);


//jqToast https://kamranahmed.info/toast#quick-demos
"function"!=typeof Object.create&&(Object.create=function(t){function o(){}return o.prototype=t,new o}),function(t,o,i,s){"use strict";var n={_positionClasses:["bottom-left","bottom-right","top-right","top-left","bottom-center","top-center","mid-center"],_defaultIcons:["success","error","info","warning"],init:function(o,i){this.prepareOptions(o,t.toast.options),this.process()},prepareOptions:function(o,i){var s={};"string"==typeof o||o instanceof Array?s.text=o:s=o,this.options=t.extend({},i,s)},process:function(){this.setup(),this.addToDom(),this.position(),this.bindToast(),this.animate()},setup:function(){var o="";if(this._toastEl=this._toastEl||t("<div></div>",{class:"jq-toast-single"}),o+='<span class="jq-toast-loader"></span>',this.options.allowToastClose&&(o+='<span class="close-jq-toast-single">&times;</span>'),this.options.text instanceof Array){this.options.heading&&(o+='<h2 class="jq-toast-heading">'+this.options.heading+"</h2>"),o+='<ul class="jq-toast-ul">';for(var i=0;i<this.options.text.length;i++)o+='<li class="jq-toast-li" id="jq-toast-item-'+i+'">'+this.options.text[i]+"</li>";o+="</ul>"}else this.options.heading&&(o+='<h2 class="jq-toast-heading">'+this.options.heading+"</h2>"),o+=this.options.text;this._toastEl.html(o),!1!==this.options.bgColor&&this._toastEl.css("background-color",this.options.bgColor),!1!==this.options.textColor&&this._toastEl.css("color",this.options.textColor),this.options.textAlign&&this._toastEl.css("text-align",this.options.textAlign),!1!==this.options.icon&&(this._toastEl.addClass("jq-has-icon"),-1!==t.inArray(this.options.icon,this._defaultIcons)&&this._toastEl.addClass("jq-icon-"+this.options.icon)),!1!==this.options.class&&this._toastEl.addClass(this.options.class)},position:function(){"string"==typeof this.options.position&&-1!==t.inArray(this.options.position,this._positionClasses)?"bottom-center"===this.options.position?this._container.css({left:t(o).outerWidth()/2-this._container.outerWidth()/2,bottom:20}):"top-center"===this.options.position?this._container.css({left:t(o).outerWidth()/2-this._container.outerWidth()/2,top:20}):"mid-center"===this.options.position?this._container.css({left:t(o).outerWidth()/2-this._container.outerWidth()/2,top:t(o).outerHeight()/2-this._container.outerHeight()/2}):this._container.addClass(this.options.position):"object"==typeof this.options.position?this._container.css({top:this.options.position.top?this.options.position.top:"auto",bottom:this.options.position.bottom?this.options.position.bottom:"auto",left:this.options.position.left?this.options.position.left:"auto",right:this.options.position.right?this.options.position.right:"auto"}):this._container.addClass("bottom-left")},bindToast:function(){var t=this;this._toastEl.on("afterShown",function(){t.processLoader()}),this._toastEl.find(".close-jq-toast-single").on("click",function(o){o.preventDefault(),"fade"===t.options.showHideTransition?(t._toastEl.trigger("beforeHide"),t._toastEl.fadeOut(function(){t._toastEl.trigger("afterHidden")})):"slide"===t.options.showHideTransition?(t._toastEl.trigger("beforeHide"),t._toastEl.slideUp(function(){t._toastEl.trigger("afterHidden")})):(t._toastEl.trigger("beforeHide"),t._toastEl.hide(function(){t._toastEl.trigger("afterHidden")}))}),"function"==typeof this.options.beforeShow&&this._toastEl.on("beforeShow",function(){t.options.beforeShow(t._toastEl)}),"function"==typeof this.options.afterShown&&this._toastEl.on("afterShown",function(){t.options.afterShown(t._toastEl)}),"function"==typeof this.options.beforeHide&&this._toastEl.on("beforeHide",function(){t.options.beforeHide(t._toastEl)}),"function"==typeof this.options.afterHidden&&this._toastEl.on("afterHidden",function(){t.options.afterHidden(t._toastEl)}),"function"==typeof this.options.onClick&&this._toastEl.on("click",function(){t.options.onClick(t._toastEl)})},addToDom:function(){var o=t(".jq-toast-wrap");if(0===o.length?(o=t("<div></div>",{class:"jq-toast-wrap",role:"alert","aria-live":"polite"}),t("body").append(o)):this.options.stack&&!isNaN(parseInt(this.options.stack,10))||o.empty(),o.find(".jq-toast-single:hidden").remove(),o.append(this._toastEl),this.options.stack&&!isNaN(parseInt(this.options.stack),10)){var i=o.find(".jq-toast-single").length-this.options.stack;i>0&&t(".jq-toast-wrap").find(".jq-toast-single").slice(0,i).remove()}this._container=o},canAutoHide:function(){return!1!==this.options.hideAfter&&!isNaN(parseInt(this.options.hideAfter,10))},processLoader:function(){if(!this.canAutoHide()||!1===this.options.loader)return!1;var t=this._toastEl.find(".jq-toast-loader"),o=(this.options.hideAfter-400)/1e3+"s",i=this.options.loaderBg,s=t.attr("style")||"";s=s.substring(0,s.indexOf("-webkit-transition")),s+="-webkit-transition: width "+o+" ease-in;                       -o-transition: width "+o+" ease-in;                       transition: width "+o+" ease-in;                       background-color: "+i+";",t.attr("style",s).addClass("jq-toast-loaded")},animate:function(){t=this;if(this._toastEl.hide(),this._toastEl.trigger("beforeShow"),"fade"===this.options.showHideTransition.toLowerCase()?this._toastEl.fadeIn(function(){t._toastEl.trigger("afterShown")}):"slide"===this.options.showHideTransition.toLowerCase()?this._toastEl.slideDown(function(){t._toastEl.trigger("afterShown")}):this._toastEl.show(function(){t._toastEl.trigger("afterShown")}),this.canAutoHide()){var t=this;o.setTimeout(function(){"fade"===t.options.showHideTransition.toLowerCase()?(t._toastEl.trigger("beforeHide"),t._toastEl.fadeOut(function(){t._toastEl.trigger("afterHidden")})):"slide"===t.options.showHideTransition.toLowerCase()?(t._toastEl.trigger("beforeHide"),t._toastEl.slideUp(function(){t._toastEl.trigger("afterHidden")})):(t._toastEl.trigger("beforeHide"),t._toastEl.hide(function(){t._toastEl.trigger("afterHidden")}))},this.options.hideAfter)}},reset:function(o){"all"===o?t(".jq-toast-wrap").remove():this._toastEl.remove()},update:function(t){this.prepareOptions(t,this.options),this.setup(),this.bindToast()},close:function(){this._toastEl.find(".close-jq-toast-single").click()}};t.toast=function(t){var o=Object.create(n);return o.init(t,this),{reset:function(t){o.reset(t)},update:function(t){o.update(t)},close:function(){o.close()}}},t.toast.options={text:"",heading:"",showHideTransition:"fade",allowToastClose:!0,hideAfter:3e3,loader:!0,loaderBg:"#9EC600",stack:5,position:"bottom-left",bgColor:!1,textColor:!1,textAlign:"left",icon:!1,beforeShow:function(){},afterShown:function(){},beforeHide:function(){},afterHidden:function(){},onClick:function(){}}}(jQuery,window,document);

