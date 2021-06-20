<script type="text/javascript" >

    //$.fn.modal.Constructor.prototype.enforceFocus = function() {};

	$("#{{ $attributes['id'] }}").select2({
        dropdownParent: $('#{{ $attributes['parent'] }}'),
		placeholder: "{{ isset($attributes['placeholder']) ? $attributes['placeholder'] : "Buscar ..."  }}",
        allowClear: "{{ $attributes['allowClear'] }}",//Permitir limpiar el option seleccionado, por default true
        @if( isset($attributes['formatNoResults']))
		  formatNoMatches: {{ $attributes['formatNoResults'] }},
		@endif

		formatInputTooShort: function (input, min) { var n = min - input.length; return "Por favor escribe " + n + " o mas caracteres"  },
        minimumInputLength: 1,
		width:'100%',
		cache: true,
        theme: "{!! isset($attributes['theme'])? $attributes['theme'] : 'classic'  !!}",
        language : {
            errorLoading: function () {
                return '';
            },
            "searching": function(){
                return "Buscando...";
            },
            "noResults": function(){
                return "No se encontraron resultados";
            }
        },

        ajax : {
            url: "{{  $attributes['data-url'] }}",
            dataType: 'json',
            delay: 100,
            type     : '{{ isset($attributes['ajax_type']) ? $attributes['ajax_type']: 'POST'}}',
            data: function (params) {
                console.log(params);
                return {
                    q       : params.term, // search term
                    page    : params.page,
                    source  :'{{ (isset($attributes['source']))? $attributes['source'] :'P'}}',
                    status  : '{{ (isset($attributes['status']))? $attributes['status'] : null}}',
                    page_limit : 10,
                    doAction   : '{{ isset($attributes['doAction']) ? $attributes['doAction']: ''}}'
                    @if(isset($attributes['extra_params']))
                        {{ ','. $attributes['extra_params']}}   :  $('#{{$attributes['extra_params']}}').val(),
                    @endif
                };
            },
            processResults: function (json, params) {
                var data  = json.request.data;
                console.log(data);

                // parse the results into the format expected by Select2
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data, except to indicate that infinite
                // scrolling can be used
                params.page = params.page || 1;


                return {
                    results: data.items,
                    pagination: {
                        more: (params.page * 10) < data.total_count
                    }
                };


            },
            cache: true
        },

        templateResult:  function(item){

			var markup = "<table class='select2-item'><tr>";
			if (item.image !== undefined) {
				markup += "<td class='select2-item-image'>" + item.image + "</td>";
			}
			markup += "<td class='select2-info'><div class='select2-item-title'>" +  item.text.toUpperCase() + "</div>";
			if (item.descrip !== undefined) {
				markup += "<div class='select2-item-categ'>" + item.descrip + "</div>";
			}
			markup += "</td></tr></table>";

			return markup;

		}, // omitted for brevity, see the source of this page
        templateSelection: function(item){
			return (item.idisplay || item.id )  +' - '+ item.text ;

		} , // omitted for brevity, see the source of this page
		dropdownCssClass: "bigdrop", // apply css that makes the dropdown taller
		escapeMarkup: function (m) {
			return m;
		} // we do not want to escape markup since we are displaying html in results

	}).on("select2-open", function() {
		// fired to the original element when the dropdown opens
	});

</script>
