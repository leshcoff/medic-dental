
<!-- aditional inputs-->
@if(is_array(@$cssfiles))
	<script>
		@foreach($cssfiles as $css )
            loadCss("{{ $css }}");
		@endforeach
	</script>
@endif
<!-- end aditional inputs-->


<div class="card" id="secction-dt-{{ strtolower($emgrid->getName()) }}">
    <div class="card-header">
        {!! $emgrid->getTitle() !!}
    </div>
    <div class="card-body">
        {!!  $emgrid->getHtml()  !!}

        <!-- aditional inputs-->
            @if(is_array(@$inputs))
                @foreach($inputs as $input => $value)
                    <input type="hidden" name="{{$input}}" value="{{$value}}" id="{{$input}}" historia-seccion="{{$value}}" class="extra-params">
            @endforeach
        @endif
        <!-- end aditional inputs-->
    </div>
</div>



@push('jscustom')

<script type="text/javascript">

	{!!  $emgrid->InitJS()  !!}

	pagefunction();
	App.init();
	var pagedestroy = function() {
		{{ ("j".$emgrid->getName()) }} = null;
	}

</script>
@endpush

