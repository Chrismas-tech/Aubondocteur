@extends('layouts.app')
@section('content')

    <div class="bg_photo_1 py-5">

        <div class="mt-5 mb-5 container">

            <form action="{{ route('send_review_form_medecin') }}" method="POST" class="text-center">
                @csrf

                <div class="card">

                    <div class="card-header text-center ">
                    <h1 class="display-5 lora">Vos impressions sur le Docteur {{$medecin->medecin_first_name}} {{$medecin->medecin_last_name}} </h1>
                    </div>

                    <div class="card-body pd-4 bg_gradient_1">

                        <div style="width:80%;margin:auto">

                            <div class="input-group-lg mt-4 mb-4">

                                <div class="d-flex">
                                <label class="text-white p_texte_1" for="date_rdv" >Date de votre dernier rendez-vous</label>
                            </div>
                            
                                <input id="date_rdv" type="date" name="date_rdv"
                                    class="form-control @error('date_rdv') is-invalid @enderror" name="date_rdv"
                                    value="{{ old('date_rdv') }}" autocomplete="date_rdv" autofocus
                                    placeholder="Date du dernier rendez-vous">

                                @error('date_rdv')
                                    <div class="alert alert-danger">{{ $errors->first('date_rdv') }}</div>
                                @enderror
                            </div>

                            <div class="input-group-lg mt-4 mb-4">

                                <div class="d-flex">
                                    <label class="text-white p_texte_1" for="review" >Décrivez-nous comment s'est déroulé votre consultation :) </label>
                                </div>

                                <textarea id="review" name="review" type="text" cols="10" rows="10"
                                    class="form-control @error('review') is-invalid @enderror" name="review"
                            autocomplete="review" autofocus>{{ old('review') }}Ecrivez ici...</textarea>
                            </div>
                            
                            @error('review')
                            <div class="alert alert-danger">{{ $errors->first('review') }}</div>
                        @enderror
                        </div>

                        <div>
                            <input id="validation_status_review" hidden name="validation_status_review" class="form-control" value=3>
                        </div>

                        <div>
                            <input id="user_id" hidden name="user_id" class="form-control" value="{{ $user_id }}">
                        </div>

                        <div>
                            <input id="medecin_id" hidden name="medecin_id" class="form-control" value="{{ $medecin->id }}">
                        </div>

                        <button type="submit" class="btn btn-success btn-lg">
                            Confirmer votre commentaire sur ce médecin
                        </button>
                    </div>
                </div>

        </div>

        </form>

        <div class="text-center mt-5 mb-5">
            <a href="{{ url()->previous() }}" class="btn btn-primary btn-lg">
                Revenir sur la page précédente
            </a>
        </div>

    </div>
    </div>


    <script>
        $(document).ready(function() {

            $('#region').change(function() {

                $('#department').empty();

                //$(this).val est la valeur du select d'id #region
                var url_department = '/compte/get-department/' + $(this).val();

                //axios.get 
                axios.get(url_department).then((res) => {

                    $('#department').append('<option>Choissisez un département</option>');

                    $.each(res.data, function(index, value) {

                        $('#department').append('<option value="' + value.code + '">' +
                            value.name + '</option>');

                    });

                });

            });

        });


        $(document).ready(function() {

            $('#department').change(function() {

                $('#city').empty();
                //$(this).val est la valeur du select d'id #region

                var url_city = '/compte/get-city/' + $(this).val();

                //axios.get 
                axios.get(url_city).then((res) => {

                    $('#city').append('<option>Choissisez une ville</option>');

                    $.each(res.data, function(index, value) {

                        $('#city').append('<option value="' +
                            value.name + ' (' + value.zip_code + ')">' + value.name +
                            ' (' + value.zip_code + ')</option>');

                    });

                });

            });

        });


        $(document).ready(function() {

            $('select[name="region"]').change(function() {

                var optionSelected = $(this).find("option:selected");
                var textSelected = optionSelected.text();
                console.log(textSelected);

                $('#region_convert').attr("value", textSelected)

            });

        });


        $(document).ready(function() {

            $('select[name="department"]').change(function() {

                var optionSelected = $(this).find("option:selected");
                var textSelected = optionSelected.text();
                console.log(textSelected);

                $('#department_convert').attr("value", textSelected)

            });

        });


        $(document).ready(function() {

            $('select[name="city"]').change(function() {

                var optionSelected = $(this).find("option:selected");
                var textSelected = optionSelected.text();

                $zip_code = textSelected.slice(-6).slice(0, -1);
                console.log(zip_code);

                $('#zip_code').attr("value", $zip_code)

            });

        });


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

                        $.each(res.data.features, function(key, val) {
                            $('#div_address').fadeIn().append(
                                '<li class="li_address">' + val
                                .properties
                                .label + '</li>');
                        })
                    });

                }, 400)

            });

        });


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

                console.log(url_geo_api_gouv);


                axios.get(url_geo_api_gouv).then(res => {

                    $.each(res.data.features[0].geometry.coordinates, function(key,
                        val) {
                        console.log(res.data.features[0].geometry.coordinates);

                        $('#lat').val(res.data.features[0].geometry.coordinates[
                            0]);
                        $('#lng').val(res.data.features[0].geometry.coordinates[
                            1]);
                    })

                    $('#div_address').empty();

                });

            });

        });

    </script>

@endsection
