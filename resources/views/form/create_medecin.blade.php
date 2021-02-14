@extends('layouts.app')

@section('content')

    <div class="bg_photo_3 py-5">
        <div class="mt-5 mb-5 container">

            <div class="card">

                <div class="card-header text-center ">
                    <h1 class="display-5 lora">Ajouter les coordonnées du médecin récemment consulté</h1>
                </div>

                <div class="card-body pd-4 bg_gradient_1">

                    <div style="width:80%;margin:auto">
                        <form action="{{ route('store_medecin') }}" method="POST" class="text-center">
                            @csrf

                            <div class="input-group-lg mt-4 mb-4">

                                <input id="medecin_first_name" type="text"
                                    class="form-control @error('medecin_first_name') is-invalid @enderror"
                                    name="medecin_first_name" value="{{ old('medecin_first_name') }}"
                                    autocomplete="medecin_first_name" autofocus placeholder="Prénom du médecin">

                                @error('medecin_first_name')
                                    <div class="text-white mt-1 text-left">{{ $errors->first('medecin_first_name') }}</div>
                                @enderror

                            </div>

                            <div class="input-group-lg mt-4 mb-4">
                                <input id="medecin_last_name" type="text"
                                    class="form-control @error('medecin_last_name') is-invalid @enderror"
                                    name="medecin_last_name" value="{{ old('medecin_last_name') }}"
                                    autocomplete="medecin_last_name" autofocus placeholder="Nom du médecin">

                                @error('medecin_last_name')
                                    <div class="text-white mt-1 text-left">{{ $errors->first('medecin_last_name') }}</div>
                                @enderror
                            </div>


                            <div class="input-group-lg mt-4 mb-4">
                                <select id="speciality" class="form-control @error('speciality') is-invalid @enderror"
                                    name="speciality" autofocus>

                                    <option>Spécialité du médecin consulté</option>

                                    @foreach ($specialities as $speciality)

                                        <option
                                            value=" {{$speciality->speciality_name }}"
                                            {{ old('speciality') == $speciality->speciality_name ? 'selected' : '' }}>
                                            {{ $speciality->speciality_name }}
                                        </option>

                                    @endforeach
                                </select>

                                @error('speciality')
                                    <div class="text-white mt-1 text-left">{{ $errors->first('speciality') }}</div>
                                @enderror
                            </div>

                            <div class="input-group-lg mt-4 mb-4">
                                <input id="address" type="text" class="form-control @error('address') is-invalid @enderror"
                                    name="address" autocomplete="address" autofocus
                                    placeholder="Adresse du cabinet médical">

                                @error('address')
                                    <div class="text-white mt-1 text-left mb-0 pb-0">{{ $errors->first('address') }}</div>
                                @enderror
                                @error('gps_lat')
                                    <div class="text-white mt-1 text-left">Vous devez sélectionner une adresse suggérée par
                                        notre site web</div>
                                @enderror

                                <div id="div_address">
                                </div>

                            </div>

                            <div>
                                <input hidden name="gps_lat" id="gps_lat" type="text">
                                <input hidden name="gps_lng" id="gps_lng" type="text">

                                <input hidden name="city" id="city" type="text">
                                <input hidden name="zip_code" id="zip_code" type="text">


                            </div>

                            <div class="input-group-lg mt-4 mb-4">
                                <input id="phone" type="tel" class="form-control @error('phone') is-invalid @enderror"
                                    name="phone" value="{{ old('phone') }}" autocomplete="phone" autofocus
                                    placeholder="Téléphone du cabinet médical">

                                @error('phone')
                                    <div class="text-white mt-1 text-left">{{ $errors->first('phone') }}</div>
                                @enderror

                            </div>

                            <div>
                                <input id="user_id" name="user_id" hidden class="form-control" value="{{ $user->id }}">
                            </div>

                            <div>
                                <input id="validation_status_medecin" name="validation_status_medecin" hidden
                                    class="form-control" value="3">
                            </div>
                            <button type="submit" class="btn btn-success btn-lg">
                                Ajouter un médecin
                            </button>
                    </div>
                </div>
            </div>
            </form>

            <div class="text-center mt-5 mb-5">
                <a href="{{ route('compte.index') }}" class="btn btn-primary btn-lg">
                    Revenir sur votre espace personnel
                </a>
            </div>

        </div>
    </div>



    <script>
        /* ADRESSE GEO.GOUV */
        /* ADRESSE GEO.GOUV */
        /* ADRESSE GEO.GOUV */
        /* ADRESSE GEO.GOUV */
        /* ADRESSE GEO.GOUV */
        /* ADRESSE GEO.GOUV */

        var timeout;

        $(document).ready(function() {

            $('#address').keyup(function() {

                clearTimeout(timeout)

                timeout = setTimeout(() => {

                    console.log('timeout');

                    $('#div_address').empty();

                    $address_space = $(this).val();
                    $address_without_spaces = $address_space.replace(/\s/g, '+');

                    var url_geo_api_gouv = "https://api-adresse.data.gouv.fr/search/?q=" +
                        $address_without_spaces;

                    axios.get(url_geo_api_gouv).then(res => {

                        $('#div_address').append(
                            '<h5 class="lora text-primary border-primary border-bottom border-top text-left bg-white m-0 p-3">Choisissez parmi les résultats suggérés <img src="{{ asset('img/arrow-down.png')}}" alt="" class="icon_info "></h5>'
                        );

                        $.each(res.data.features, function(key, val) {
                            $('#div_address').fadeIn().append(
                                '<li class="li_address">' + val
                                .properties
                                .label + '</li>');
                        })
                    });

                }, 300)

            });

        });



        /*GEOGRAPHY LAT - LONG */
        /*GEOGRAPHY LAT - LONG */
        /*GEOGRAPHY LAT - LONG */
        /*GEOGRAPHY LAT - LONG */
        /*GEOGRAPHY LAT - LONG */


        $(document).ready(function() {

            $(document).on('click', 'li', function() {

                $li_value = $(this).html();
                console.log($li_value);
                $('#address').val($li_value);

                // GPS LATITUDE - LONGITUDE DE L'ADRESSE SELECTIONNEE 

                $address_space = $('#address').val();
                $address_without_spaces = $address_space.replace(/\s/g, '+');

                var url_geo_api_gouv = "https://api-adresse.data.gouv.fr/search/?q=" +
                    $address_without_spaces;

                //  console.log(url_geo_api_gouv);


                axios.get(url_geo_api_gouv).then(res => {

                    $.each(res.data.features[0].geometry.coordinates, function(key,
                        val) {
                        console.log(res.data.features[0].geometry.coordinates);

                        $('#gps_lng').val(res.data.features[0].geometry.coordinates[
                            0]);
                        $('#gps_lat').val(res.data.features[0].geometry.coordinates[
                            1]);

                    })

                    $('#div_address').empty();

                });

            });

        });


        $(document).ready(function() {

            $(document).on('click', 'li', function() {

                // GPS LATITUDE - LONGITUDE DE L'ADRESSE SELECTIONNEE 

                $address_space = $('#address').val();
                $address_without_spaces = $address_space.replace(/\s/g, '+');

                var url_geo_api_gouv = "https://api-adresse.data.gouv.fr/search/?q=" +
                    $address_without_spaces;

                axios.get(url_geo_api_gouv).then(res => {

                    console.log(res.data.features[0].properties.city);
                    console.log(res.data.features[0].properties.postcode);

                    $('#city').val(res.data.features[0].properties.city);
                    $('#zip_code').val(res.data.features[0].properties.postcode);

                })
            });
        });

        $(document).ready(function() {
            $('body').click(function() {
                $('#div_address').empty();
            })
        });

    </script>

@endsection
