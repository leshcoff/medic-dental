@extends('layouts.app')

@section('title')
    Entradas
@stop

@push('csscustom')
    {{ Html::style('assets/js/vendors/bootstrap-datepicker/dist/css/bootstrap-datepicker.css') }}
    {{ Html::style('assets/js/vendors/sweetalerts/sweetalert2.css') }}
    {{ Html::style('assets/js/vendors/select2/select2.css') }}}

@endpush

@section('js')

    {{ Html::script('assets/js/vendors/bootstrap-datepicker/dist/js/bootstrap-datepicker.js') }}
    {{ Html::script('assets/js/vendors/select2/select2-4.0.3/dist/js/select2.full.js') }}

    {{ Html::script('assets/js/vendors/sweetalerts/sweetalert2.js') }}
    {{ Html::script('assets/js/vendors/jquery.blockui.min.js') }}
    {{ Html::script('assets/js/escom/em.datatables.min.js') }}
    {{ Html::script('assets/js/escom/em.modals.min.js') }}
    {{ Html::script('assets/js/escom/em.alerts.min.js') }}

    <script>
        $('.add-patient').click(function (e) {
            jAppointments._pClik('01',{action:'01'});
        })
    </script>


@stop


@section('content')
    <div class="main-content-wrap">

        <div class="page-content">
            {!! $view !!}
        </div>

        <div class="add-action-box">
            <button  class="btn btn-primary btn-lg btn-square rounded-pill add-patient">
                <span class="btn-icon icofont-plus"></span>
            </button>
        </div>


    </div>


@endsection
