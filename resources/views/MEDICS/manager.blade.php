@extends('layouts.app')

@section('title')
    Medicos
@stop

@push('csscustom')
    {{ Html::style('assets/js/vendors/bootstrap-datepicker/dist/css/bootstrap-datepicker.css') }}
    {{ Html::style('assets/js/vendors/sweetalerts/sweetalert2.css') }}
@endpush




@section('content')
    <div class="main-content-wrap">

        <header class="page-header">
            <h1 class="page-title">Medicos</h1>
        </header>

        <div class="row medic-list">
            {!!  $view_medics !!}
        </div>



        <div class="add-action-box">
            <button class="btn btn-dark btn-lg btn-square rounded-pill add-medic">
                <span class="btn-icon icofont-contact-add"></span>
            </button>
        </div>


    </div>


@endsection




@section('js')

    {{ Html::script('assets/js/vendors/bootstrap-datepicker/dist/js/bootstrap-datepicker.js') }}
    {{ Html::script('assets/js/vendors/sweetalerts/sweetalert2.js') }}
    {{ Html::script('assets/js/vendors/jquery.blockui.min.js') }}
    {{ Html::script('assets/js/escom/em.datatables.min.js') }}
    {{ Html::script('assets/js/escom/em.modals.min.js') }}
    {{ Html::script('assets/js/escom/em.alerts.min.js') }}


    <script>
        var jMedics = function(){

            return {
                mode : null,
                form : null,
                modal: null,

                Init : function(){
                    var $this       = this;

                    $('.add-medic').click(function (e) {

                        var options = new Object();
                        options.params = {};
                        options.title  = 'Agregar Medico';
                        options.url    =  '/medics/form';
                        options.msize  = "modal-md";
                        options.modal  = 'modal-medics';
                        options.width  = '800';
                        options.height = '420';
                        options.params = {'doAction':'01'};


                        if(! $this.modal )
                        {

                            $this.modal = new EMModal();
                            $this.modal.Open(options);
                            return $this.modal;
                        }
                        else
                        {
                            $this.modal.load(options);
                            $this.modal.modal.modal('show');

                        }


                    })

                },

                loadListMedic : function(){

                    App.request({
                        url     :  "/medics/listado",
                        dataType: "json",
                        data    : {},
                        beforeSend : function(){
                        },
                        success : function (responseText, statusText, xhr ) {
                            var json = App.handleResponse( xhr.responseText, xhr.status );
                            if (json) {
                                $('.medic-list').html(json.data.html);
                            }

                        }
                    });


                }





            }
        }();

        jMedics.Init();
    </script>


@stop
