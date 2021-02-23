@extends('layouts.app')
@section('content')

    <div class="text-primary bg_photo_3 m-0 d-flex justify-content-center py-md-4 px-md-4 py-sm-3 px-sm-3" id="jumbotron">

        <div class="bg-white mt-5 mb-5 jumb_1_vignette p-md-5 p-sm-4 p-3 media_window_white_width">

            <div class="text-center">
                <h1 class="display-4 lobster media_title_welcome_page">Vous avez trouvé un médecin prés de chez vous mais vous hésitez à le consulter ?</h1>

                <div class="text-left">
                    <p class="lead lora p_texte_1 lobster mt-5 mb-5 media_info_welcome_page">Sur notre plateforme <span class="bold">aubondocteur.com</span>, consultez les avis positifs sur vos praticiens et trouvez en un rapidement près de chez vous !</p>
                </div>
 
                <hr>

                <div class="text-center mt-5 mb-4">
                    <h1 class="display-4 lobster text-primary media_title_welcome_page">Recherchez un médecin</h1>
                </div>

                <!-- INCLUDE SEARCHBAR_ACCUEIL-->
                <!-- INCLUDE SEARCHBAR_ACCUEIL-->
                <!-- INCLUDE SEARCHBAR_ACCUEIL-->
                <!-- INCLUDE SEARCHBAR_ACCUEIL-->

                @include('search_bar.search_bar_accueil')
                
            </div>
        </div>
    </div>

    <div class="bg_gradient_2 d-flex justify-content-center pt-5 pb-5 pl-3 pr-3 media_button_end_welcome_page">
        <a href="{{ route('accueil_compte') }}" class="btn btn-primary p-3 text-white text-center lora">
            <h2 class="media_button_end_welcome_page">Le médecin que vous avez consulté n'existe pas dans les résultats de
                recherche ?</h2>
            <h2 class="media_button_end_welcome_page">Créez un compte, renseignez ses coordonnées et laissez-lui une note
                positive dès maintenant !</h2>
        </a>
    </div>
@endsection
