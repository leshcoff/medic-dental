@if( session()->has('error_message') )

    <div class="alert alert-danger outline" role="alert">
        {{ session()->get('error_message') }}
    </div>

@endif
