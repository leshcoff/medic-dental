

@if ( count($medics) == 0)

    <div class="alert alert-danger outline" role="alert">No se encontrarion registros. Para iniciar agrega tu primer medico!</div>

@else


    @foreach( $medics as $medic)

        <div class="col-12 col-md-4">
            <div class="contact">
                <div class="img-box">
                    <img src="{{ asset($medic->photo) }}" width="400" height="400" alt="">
                </div>

                <div class="info-box">
                    <h4 class="name">Dr. {{ ucfirst(strtolower($medic->name)) }}</h4>

                    <p class="role">{{  $medic->specialist }}</p>

                    <div class="social">
                        <a href="#" class="link icofont-instagram"></a>
                        <a href="#" class="link icofont-facebook"></a>
                        <a href="#" class="link icofont-twitter"></a>
                    </div>

                    <p class="address">{{  $medic->address }}</p>

                    <div class="button-box">
                        <a href="{{ route('medics.profile',['id'=>$medic->id]) }}" class="btn btn-primary">Ver perfil</a>
                    </div>
                </div>
            </div>
        </div>

    @endforeach


@endif
