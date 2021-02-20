<div class="flex">

    <div class="search_bar_flex_basis_1">
        <form action="{{ route('liste_medecins') }}" method="get">
            @csrf

            <select type="text" name="select_accueil" id="select_accueil" class="form-control">
                <option id="media_queries_option">Spécialité du médecin</option>
                @foreach ($specialities as $speciality)
                    <option @if (Request::get('select_accueil') == $speciality->speciality_name) selected @endif value="{{ $speciality->speciality_name }}">
                        {{ $speciality->speciality_name }}
                    </option>
                @endforeach
            </select>
    </div>

    <div class="search_bar_flex_basis_2">
        <input name="input_search_accueil" type="text" id="input_search_accueil" class="form-control"
            placeholder="{{ Request::get('input_search_accueil') ? Request::get('input_search_accueil') : 'Recherchez une ville ou un code postal' }}" value="{{ Request::get('input_search_accueil') ? Request::get('input_search_accueil') :'' }}">

        <div id="city_list" class="text-left"></div>
        @csrf
    </div>

    <div class="search_bar_flex_basis_3">
        <button type="submit" style="outline:none;" class="bg-gray mb-3" id="input_accueil_button"><img class="loupe"
                src="{{ asset('img/loupe-1.png') }}"></button>
    </div>
    </form>
</div>


<!-- GESTION DES ERREURS SEARCH BAR -->
<!-- GESTION DES ERREURS SEARCH BAR -->
<!-- GESTION DES ERREURS SEARCH BAR -->
<!-- GESTION DES ERREURS SEARCH BAR -->
<!-- GESTION DES ERREURS SEARCH BAR -->


@error('select_accueil')
    <div class="d-flex">
        <p class="alert alert-warning text-dark m-0 p_texte_2 lora media_accueil_error_1 mt-2 mt-sm-2 mt-md-3">Vous devez
            choisir la
            spécialité du
            médecin !
        </p>
    </div>
@enderror

@error('input_search_accueil')
    <div class="d-flex">
        <p class="alert alert-warning text-dark m-0 p_texte_2 lora media_accueil_error_1 mt-2 mt-sm-2 mt-md-3">Vous n'avez
            pas choisi de
            localité !</p>
    </div>
@enderror

<div>
    @if ($count_medecins == 0)
        <p class="p_texte_28 lora text-dark m-0 p-0 text-center media_accueil_error_2 mt-2 mt-sm-2 mt-md-3">Il n'y a pas
            de
            résultats pour
            votre recherche
        </p>

    @elseif ($count_medecins == 1)
        <p class="p_texte_28 lora text-dark m-0 p-0 text-center media_accueil_error_2 mt-2 mt-sm-2 mt-md-3">Il y a 1
            résultat pour
            votre
            recherche : <br>
            {{ $result_speciality }} dans la ville de {{ ucfirst($result_city) }}
        </p>

    @elseif($count_medecins > 1)
        <p class="p_texte_28 lora text-dark m-0 p-0 text-center media_accueil_error_2 mt-2 mt-md-3">Il y a
            {{ $count_medecins }}
            résultats pour votre
            recherche : <br> {{ $result_speciality }} dans la ville de {{ ucfirst($result_city) }}</p>
    @endif
</div>

</div>

<script>

    /* REQUETE AJAX BDD POUR AFFICHER LES VILLES EN AUTOCOMPLETION */
    $('document').ready(function() {

        $('#input_search_accueil').keyup(function() {
            var query = $(this).val();

            if (query != '' && query.length > 2) {
                var _token = $('input[name="_token"]').val();

                $.ajax({
                    url: "{{ route('autocomplete_search') }}",
                    method: "POST",
                    data: {
                        query: query,
                        _token: _token
                    },

                    success: function(res) {

                        $('#city_list').fadeIn();
                        $('#city_list').html(res);
                    }
                });
            }
        });

        // SI ON CLIQUE SUR UN RESULTAT AJAX
        $(document).on('click', '.p_result', function() {

            /* L'INPUT PREND LE NOM DE LA VILLE SUR LAQUELLE ON A CLIQUE */
            $('#input_search_accueil').val($(this).text());
            $('#city_list').fadeOut();

            if ($('#input_search_accueil').val().length > 2 && $('#select_accueil').val()) {

                $('#input_accueil_button').removeClass('bg-gray');
                $('#input_accueil_button').addClass('bg_green');

            } else {

                $('#input_accueil_button').removeClass('bg_green');
                $('#input_accueil_button').addClass('bg-gray');
            }
        });

        
        /* SI ON CLIQUE EN DEHORS LA LISTE DES VILLES DISPARAIT */
        $("body").click(function() {
            $('#city_list').empty();
        });

        /* LORSQU'UNE SPECIALITE EST CHOISIE - L'INPUT VILLE EST DISPONIBLE*/
        $('#select_accueil').change(function() {
            $('#input_search_accueil').removeAttr('disabled');
        })

        /* LORSQUE LA FENETRE EST INFERIEURE A 1100px -> ON CHANGE LE NOM DES INPUTS */
        if (window.innerWidth < 1100) {
            $('#media_queries_option').html('Spécialité');
            $('#input_search_accueil').attr('placeholder', 'Ville ou CP');
        }
    });

</script>
