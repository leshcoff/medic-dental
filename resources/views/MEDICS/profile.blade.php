@extends('layouts.app')


@push('csscustom')
    {{ Html::style('assets/js/vendors/bootstrap-datepicker/dist/css/bootstrap-datepicker.css') }}
    {{ Html::style('assets/js/vendors/sweetalerts/sweetalert2.css') }}
@endpush

@section('js')

    {{ Html::script('assets/js/vendors/bootstrap-datepicker/dist/js/bootstrap-datepicker.js') }}
    {{ Html::script('assets/js/vendors/sweetalerts/sweetalert2.js') }}
    {{ Html::script('assets/js/vendors/jquery.blockui.min.js') }}
    {{ Html::script('assets/js/escom/em.datatables.min.js') }}
    {{ Html::script('assets/js/escom/em.modals.min.js') }}
    {{ Html::script('assets/js/escom/em.alerts.min.js') }}

@endsection

@section('content')

    <div class="main-content-wrap">
        <div class="row">
            <div class="col col-12 col-md-6 mb-4">

                {!! Form::model($model ,['method'=>'POST', 'url'=>$route, 'id'=>'form_validation' , 'class'=>'smart-form', ]) !!}
                {!! Form::hidden('rowid',       $rowid,    ['id'=>'rowid']) !!}
                {!! Form::hidden('doAction',    $doAction, ['id'=>'doAction']) !!}

                <div class="form-group avatar-box d-flex">
                    <img src="{{ asset($model->photo) }}" width="40" height="40" alt="" class="rounded-500 mr-4">

                    <button class="btn btn-outline-primary" type="button">
                        Selecciona image<span class="btn-icon icofont-ui-user ml-2"></span>
                    </button>
                </div>


                <div class="form-group">
                    <label>Nombre(s)</label>
                    {!! Form::text('name', null, ['id'=> 'name', 'placeholder'=>'Escribe el nombre(s) del medico', 'required'=>'true', 'class'=>'form-control', 'data-uppercase'=>'']) !!}
                </div>

                <div class="form-group">
                    <label>Apellidos</label>
                    {!! Form::text('lastname', null, ['id'=> 'lastname', 'placeholder'=>'Escribe los apellidos', 'required'=>'true',  'class'=>'form-control', 'data-uppercase'=>'']) !!}
                    <div class="valid-feedback">Es necesario escribir los apellidos</div>
                </div>


                <div class="row">
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            {!! Form::text('speciality', null, ['id'=> 'speciality', 'placeholder'=>'Especialidad', 'required'=>'true',  'class'=>'form-control', 'data-uppercase'=>'']) !!}
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            {!! Form::select('gender', $generos , null , ['class' => 'form-control', 'required'=>'']) !!}
                            <div class="valid-feedback">Elige el genero</div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::textarea('address', null, ['required'=>true, 'rows'=>2, 'class' => 'form-control', 'placeholder'=>"Dirección"]) !!}
                    <div class="invalid-feedback">Proporciona una dirección.</div>
                </div>




                <div>
                    <label>Social networks</label>

                    <div class="social-list">
                        <div class="social-item">
                            <div class="row">
                                <div class="col">
                                    <div class="row">
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group with-prefix-icon">
                                                <div class="prefix-icon icofont-instagram"></div>
                                                <input class="form-control" type="text" placeholder="Icon class" value="icofont-instagram" readonly>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <input class="form-control" type="text" placeholder="Link" value="#">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col col-auto">
                                    <button class="btn btn-outline-danger btn-square rounded-pill" type="button">
                                        <span class="btn-icon icofont-ui-delete"></span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="social-item">
                            <div class="row">
                                <div class="col">
                                    <div class="row">
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group with-prefix-icon">
                                                <div class="prefix-icon icofont-facebook"></div>
                                                <input class="form-control" type="text" placeholder="Icon class" value="icofont-facebook" readonly>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <input class="form-control" type="text" placeholder="Link" value="#">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col col-auto">
                                    <button class="btn btn-outline-danger btn-square rounded-pill" type="button">
                                        <span class="btn-icon icofont-ui-delete"></span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="social-item">
                            <div class="row">
                                <div class="col">
                                    <div class="row">
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group with-prefix-icon">
                                                <div class="prefix-icon icofont-twitter"></div>
                                                <input class="form-control" type="text" placeholder="Icon class" value="icofont-twitter" readonly>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <input class="form-control" type="text" placeholder="Link" value="#">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col col-auto">
                                    <button class="btn btn-outline-danger btn-square rounded-pill" type="button">
                                        <span class="btn-icon icofont-ui-delete"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="mt-0">

                    <label>Add social network</label>

                    <div class="social-list">
                        <div class="social-item">
                            <div class="row">
                                <div class="col">
                                    <div class="row">
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group with-prefix-icon mb-sm-0">
                                                <div class="prefix-icon icofont-instagram"></div>
                                                <input class="form-control" type="text" placeholder="Icon class">
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group mb-0">
                                                <input class="form-control" type="text" placeholder="Link">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col col-auto">
                                    <button class="btn btn-outline-primary btn-square rounded-pill" type="button">
                                        <span class="btn-icon icofont-plus"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col col-6 col-md-6 mb-4">
                        <button type="button" id="modal-dlg-delete" class="btn btn-danger btn-block">Eliminar Perfil</button>
                    </div>
                    <div class="col col-6 col-md-6 mb-4">
                        <button type="submit" id="modal-dlg-ok" class="btn btn-success btn-block">Guardar Perfil</button>
                    </div>
                </div>
                {!! Form::close() !!}


            </div>

            <div class="col col-12 col-md-6 mb-4">
                <div class="v-timeline align-right">
                    <div class="line"></div>

                    <div class="timeline-box">
                        <div class="box-label">
                            <span class="badge badge-primary">Today</span>
                        </div>

                        <div class="box-items">
                            <div class="item">
                                <div class="icon-block">
                                    <div class="item-icon icofont-doctor-alt bg-info"></div>
                                </div>

                                <div class="content-block">
                                    <div class="item-header">
                                        <h3 class="h5 item-title">New prescription</h3>

                                        <div class="item-date"><span>Now</span></div>
                                    </div>

                                    <div class="item-desc">Aenean lacinia bibendum nulla sed consectetur. Nullam id dolor id nibh ultricies vehicula ut id elit.</div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="icon-block">
                                    <div class="item-icon icofont-drug bg-danger"></div>
                                </div>

                                <div class="content-block">
                                    <div class="item-header">
                                        <h3 class="h5 item-title">Appointment</h3>

                                        <div class="item-date"><span>2m ago</span></div>
                                    </div>

                                    <div class="item-desc">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptate.</div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="icon-block">
                                    <div class="item-icon icofont-paralysis-disability bg-warning"></div>
                                </div>

                                <div class="content-block">
                                    <div class="item-header">
                                        <h3 class="h5 item-title">Medication</h3>

                                        <div class="item-date"><span>2h ago</span></div>
                                    </div>

                                    <div class="item-desc">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequuntur nam nisi veniam.</div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="icon-block">
                                    <div class="item-icon icofont-paralysis-disability bg-primary"></div>
                                </div>

                                <div class="content-block">
                                    <div class="item-header">
                                        <h3 class="h5 item-title">Operation</h3>

                                        <div class="item-date"><span>15h ago</span></div>
                                    </div>

                                    <div class="item-desc">Aenean lacinia bibendum nulla sed consectetur. Nullam id dolor id nibh ultricies vehicula ut id elit.</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="timeline-box">
                        <div class="box-label">
                            <span class="badge badge-success">Yesterday</span>
                        </div>

                        <div class="box-items">
                            <div class="item">
                                <div class="icon-block">
                                    <div class="item-icon icofont-paralysis-disability bg-dark"></div>
                                </div>

                                <div class="content-block">
                                    <div class="item-header">
                                        <h3 class="h5 item-title">New patient</h3>

                                        <div class="item-date"><span>Jul 10</span></div>
                                    </div>

                                    <div class="item-desc">Lorem ipsum dolor sit.</div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="icon-block">
                                    <div class="item-icon icofont-stethoscope-alt"></div>
                                </div>

                                <div class="content-block">
                                    <div class="item-header">
                                        <h3 class="h5 item-title">Examination</h3>

                                        <div class="item-date"><span>Jul 10</span></div>
                                    </div>

                                    <div class="item-desc">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequuntur nam nisi veniam.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-0 mt-4">
            <div class="card-header">
                Patients 2019
            </div>
            <div class="card-body">
                <div id="patientsEcharts" class="chat-container container-h-400"></div>
            </div>
        </div>
    </div>





@endsection




@push('jscustom')
    <!-- SCRIPTS ON PAGE EVENT -->
    <script type="text/javascript">

        var jFPaciente = function(){

            return {
                mode : null,
                form : null,
                Init : function(){
                    var $this       = this;

                    this.section 	= ".main-content-wrap";
                    this.form 		= $("form", this.section);
                    this.mode 		= $('#doAction', this.section ).val();
                    this.btn_ok     = $("#modal-dlg-ok");
                    this.btn_dl     = $("#modal-dlg-delete");
                    this.mask       = $('.main-content-wrap');


                    this.btn_ok.bind('click',function(e){  $this.submit(); }).show();
                    this.btn_dl.bind('click',function(e){  $this.confirmDelete(); });

                    $('[data-uppercase]').blur(function(){ $(this).val( $(this).val().toUpperCase()); });
                    this.formSubmit(this.form);

                },

                formSubmit : function(form){
                    var $this = this;

                    var $registerForm = $(form).validate({

                        rules 		: this.rules(),     // Rules for form validation
                        messages 	: this.messages(),  // Messages for form validation

                        // Do not change code below
                        errorPlacement : function(error, element) {
                            error.insertAfter(element);
                        },
                        // Ajax form submition
                        submitHandler : function(form) {

                            if (!$(form).valid()) {
                                return false;
                            }

                            $(form).ajaxSubmit({
                                type : 'POST', // 'get' or 'post', override for form's 'method' attribute
                                url  : $(form).attr('action'),
                                data : { MODULE: 'TREGIMEN' },
                                beforeSubmit: function () {
                                    // now programmatically get the submit button and disable it
                                    App.blockUI($this.mask);
                                    $this.btn_ok.attr('disabled', 'disabled' ).addClass( 'ui-state-disabled' );
                                    $this.btn_ok.prop("disabled", true);

                                },

                                success: function (responseText, statusText, xhr, form) {
                                    // now programmatically get the submit button and disable it
                                    var json = App.handleResponse(xhr.responseText, xhr.status);

                                    if (json.transaction == true) {
                                        EMAlerts.success({
                                            title   : "Operación realizada con exito",
                                            message : json.data.message,
                                        });

                                    }
                                },
                                complete : function(){
                                    App.unblockUI($this.mask);
                                    $this.btn_ok.removeAttr('disabled').removeClass( 'ui-state-disabled' );
                                }
                            });
                        },
                    });

                },


                confirmDelete : function(){
                    $this = this;

                    var options = {
                        'CONTROLLER': '',
                        'MODULE'    : '',
                        'doAction'  : '03',
                        'rowid'     : $("#rowid").val()
                    }

                    EMAlerts.confirmCancel({
                        title   :  "Eliminar Registro",
                        message :  "¿ Deseas eliminar definitivamente el Registro(s) *** ",
                        confirmText : "Eliminar definitivamente",
                        callback   : function(){
                            $this.deleteRow(options);
                        }
                    });
                },


                deleteRow : function(obj) {

                    $this = this;

                    $.ajax({
                        url		:  "/medics/do-post",
                        type	: 'POST',
                        async	: true,
                        cache   : false,
                        data    : obj,
                        success: function (data, textStatus, jqXHR) {
                            var json = App.handleResponse(jqXHR.responseText, jqXHR.status);
                            if(!json) return false;
                            window.location.href = '/medics';

                        },
                        error: function (xhr) {
                            App.handleResponse(xhr.responseText, xhr.status);
                        }
                    });

                },






                rules : function(){

                    return {
                        TREG_NOMBRE         : {  required : true, minlength : 2, maxlength : 50 },
                        TREG_CODIGO         : {  required : true, min : 1, max : 100 },
                        TREG_DESCRIPCION    : {  minlength : 2, maxlength : 100 }
                    };
                },

                messages : function(){
                    return {
                        TREG_NOMBRE         : {  required : "El campo Nombre es requerido, proporciona la información", minlength : "Por favor ingresa al menos 2 carácteres.", maxlength : "Por favor ingresa un valor menor a 50  carácteres."  },
                        TREG_CODIGO         : {  required : "El campo Código es requerido proporciona la información", min : "Por favor ingresa un valor mayor a cero.", max : "Por favor ingresa un valor menor a 100"  },
                        TREG_DESCRIPCION    : {  minlength : "Por favor ingresa al menos 2 carácteres.", maxlength : "Por favor ingresa un valor menor a 100  carácteres."  }

                    };
                },

                success : function(json){
                    var html;

                    $(this.form).hide();

                    html = '<div class="animated alert alert-success">';
                    html+= '	<strong></strong> ' + json.message;
                    html+= '</div>';


                    $('.widget-body', this.section).append(html);
                    $('.widget-body div.alert-success', this.section).addClass('bounceInDown');


                },

                submit : function(form){
                    var form = form || this.form;
                    $(form).submit();
                },

                setMode : function(m){ this.mode = m;}
            }
        }();


        // end pagefunction

        // Load form valisation dependency
        //    loadScript("assets/js/libs/jquery-ui-1.10.3.min.js", function(){
        loadScript('{{  url("assets/js/vendors/forms/jquery.form.js") }}', function(){
            loadScript('{{ url("assets/js/vendors/jquery-validate/jquery.validate.min.js") }}', function(){
                jFPaciente.Init();
            });
        });
        //	});

    </script>

@endpush
