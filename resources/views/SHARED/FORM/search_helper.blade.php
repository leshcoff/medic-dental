@php
    $rand             = rand(10000, 99999);
    $name_input       = "INPUT_SEARCH_{$rand}";
    $name_btn_cancel  = "btn-cancel-search-info-{$rand}";
    $name_work        = "area-work-{$rand}";
    $name_searh_registros_insumo = "searh-registros-insumo-{$rand}";
@endphp
<style>
    .selector-table-info{
        background-color: #e8f0fe;
    }
</style>
<section>
    <div class="uk-width-medium-1-3">
        <div class="uk-modal" id="{!! $model_name !!}">
            <div class="uk-modal-dialog">
                <div class="uk-modal-header"><h3>Buscar insumos</h3></div>

                <section id="modal-banda">
                    <div class="uk-overflow-container">
                        <!---  AREA DE TRABAJO  -->

                        <div class="md-card">
                            <div class="md-card-content ">
                                <div class="uk-grid">

                                    <div class="uk-width-medium-1-1">
                                        <div class="wrapper-select2">
                                            {!! Form::text('ENTD_INSUMO',null, ['id'=> $name_input,'required'=>'true', 'placeholder' =>$placeholder, "class"=>"md-input uk-width-1-1"] ) !!}
                                        </div>
                                        <span class="uk-text-bold">Escribe el nombre/clave/descripción del insumo y seguido presiona la tecla enter</span>
                                    </div>

                                </div>

                                <div class="uk-width-medium-1-1">

                                    <div class="uk-overflow-container" style="height: 300px">
                                        <table class="uk-table uk-table-hover table_check">
                                            <thead>
                                            <tr>
                                                <th class="uk-text-center uk-width-2-10">Clave Insumo</th>
                                                <th class="uk-text-center uk-width-8-10">Descripción</th>
                                            </tr>
                                            </thead>
                                            <tbody id="{!! $name_work !!}"></tbody>
                                        </table>
                                    </div>

                                </div>

                            </div>
                        </div>

                        <!---  AREA DE TRABAJO  -->
                    </div>
                </section>

                <div class="uk-modal-footer uk-text-right">
                    <button id ="{!! $name_btn_cancel !!}" type="button" class="md-btn md-btn-flat uk-modal-close">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</section>

<script>

    $('#{!! $name_input !!}').on('keydown',function(e){

        if(e.which === 13){

            if( $(this).val().length == 0 ){
                $("#{!! $name_work !!}").html( "" );
                return true;
            }

            App.request({
                url     : '{!! $data_url !!}',
                dataType: "json",
                data    : {
                    doAction    : '{!! $doAction !!}',
                    q           : $(this).val(),
                },
                beforeSend : function(){

                },
                success : function (responseText, statusText, xhr ) {

                    var json = App.handleResponse( xhr.responseText, xhr.status );


                    if (json.transaction == true) {

                        var html = "";

                        $.each( json.data.items, function( key, value ){
                            html += "<tr class='pointer' id='"+key+"'>";
                            html += "<td class='{!! $name_searh_registros_insumo !!}' data-id='"+value.id+"' data-descripcion='"+value.text+"'>"+value.clave+"</td>";
                            html += "<td class='{!! $name_searh_registros_insumo !!}' data-id='"+value.id+"' data-descripcion='"+value.text+"'>";
                            html += "<span><strong>Descripción :</strong> "+value.descripcion+"</span><br>";
                            html += "<span><strong>Presentación :</strong> "+value.presentacion+"</span><br>";
                            html += "<span><strong>Concentración :</strong> "+value.concentracion+"</span><br>";
                            html += "<span><strong>Sustacia activa :</strong> "+value.Sactiva+"</span> ";
                            html += "</td>";
                            html += "</tr>";
                        });

                        $("#{!! $name_work !!}").html( html );

                    }

                }

            });
        }
    });

    $("body").on('click','.{!! $name_searh_registros_insumo !!}',function () {

        $("#{!! $name_work !!} tr").each(function(){ $(this).removeClass('selector-table-info'); });
        $(this).closest('tr').addClass('selector-table-info');

        $("{!! $selector !!}").val( $(this).data('id') );
        $("{!! $selector !!}").trigger('click');
        $("#{!! $name_btn_cancel !!}").click();

        @if( isset($input_focus) && !empty(trim($input_focus)) )
            $("{!! $input_focus !!}").focus();
        @endif
    });

</script>
