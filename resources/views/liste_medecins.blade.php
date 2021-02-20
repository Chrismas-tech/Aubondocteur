@extends('layouts.app')
@section('content')

    <div class="d-flex justify-content-center pt-5 pb-5 banner_list_medecins">
        <div class="p-3 jumb_1_vignette bg-white opacity_1">
            <div class="text-center">
                <h1 class="display-6 lobster text-primary mb-4 mt-3 media_title_welcome_page">Nouvelle recherche</h1>
            </div>
            @include('search_bar.search_bar_accueil')
        </div>
    </div>

    <!-- FOREACH MEDECINS LIST -->
    <!-- FOREACH MEDECINS LIST -->
    <!-- FOREACH MEDECINS LIST -->
    <!-- FOREACH MEDECINS LIST -->
    <!-- FOREACH MEDECINS LIST -->

    <div class="bg_gradient_1 p-sm-3">

        @if (Session::has('review_error'))
            <div class="d-flex justify-content-center pt-lg-3 pb-lg-3 pt-sm-2 pb-sm-2 pt-2 p_texte_2 ">
                <div class="alert alert-danger text-danger">{{ Session::get('review_error') }}</div>
            </div>
            <div class="d-flex justify-content-center p_texte_3">
                {{ $medecins->appends(['select_accueil' => $result_speciality, 'input_search_accueil' => $result_city])->links() }}
            </div>
        @else
            <div class="d-flex justify-content-center pt-4 p_texte_3">
                {{ $medecins->appends(['select_accueil' => $result_speciality, 'input_search_accueil' => $result_city])->links() }}
            </div>
        @endif

        @php
            $i = 0;
        @endphp

        @foreach ($medecins as $medecin)

            <div class="w-lg-70 w-sm-80">
                <div class="text-primary m-0 p-4 rounded">
                    <div class="d-md-flex justify-content-center opacity_1">

                        <div class="card border-black p-0 window_shadow mr-md-5 media_medecin_card mb-sm-5">
                            <div class="card-header text-white bg-success">
                                <h3 class="m-0 p-0 lora text-white media_title_card">{{ $result_speciality }}</h3>
                            </div>

                            <div class="card-body text-black p-2 p-lg-2 m-0">
                                <div class="alert alert-success p-sm-2 p-lg-4 m-0" role="alert">
                                    <div class="card p-3 domine text-dark">
                                        <div class="d-flex align-items-center p-texte mt-2 mb-4">
                                            <img src="{{ asset('img/medecin-icon.png') }}" alt=""
                                                class="icon_info_docteur media_icon_profile_medecin">
                                            <h3 class="p-0 m-0 lora ml-2 media_name_medecin">
                                                {{ $medecin->medecin_first_name }} {{ $medecin->medecin_last_name }}
                                            </h3>
                                        </div>

                                        <div class="d-flex align-items-center mt-2 mb-2">
                                            <img src="{{ asset('img/address.png') }}" alt=""
                                                class="icon_info media_icon_info_medecin">
                                            <h6 class=" p-0 m-0 roboto ml-2 media_address_medecin">
                                                @if ($medecin->address)
                                                    {{ $medecin->address }}
                                                @else
                                                    Adresse inconnue
                                                @endif
                                            </h6>
                                        </div>

                                        <div class="d-flex align-items-center mt-2 mb-2">
                                            <img src="{{ asset('img/phone.png') }}" alt=""
                                                class="icon_info media_icon_info_medecin">
                                            <h6 class=" p-0 m-0 roboto ml-2 media_phone_medecin ">
                                                @if ($medecin->phone)
                                                    <a class="text-decoration-none" href=" tel:{{ $medecin->phone }}">
                                                        {{ $medecin->phone }}</a>
                                                @else
                                                    Téléphone inconnu
                                                @endif
                                            </h6>
                                        </div>

                                        <div class="d-flex align-items-center mt-2 mb-2">
                                            <img src="{{ asset('img/email_docteur.png') }}" alt=""
                                                class="icon_info media_icon_info_medecin">
                                            <h6 class=" p-0 m-0 roboto ml-2 media_phone_medecin ">
                                                @if ($medecin->email)
                                                    <a class="text-decoration-none" href="mailto:{{ $medecin->email }}">
                                                        {{ $medecin->email }}</a>
                                                @else
                                                    Email inconnu
                                                @endif
                                            </h6>
                                        </div>
                                    </div>

                                    <div class="card mt-2 mb-2 mt-lg-4 mb-lg-4 mt-md-3 mb-md-3">
                                        <div class="card-body p-2 m-0 alert-warning text-center">
                                            @if ($medecin->nb_reviews == 1)
                                                <p class="card-text lobster p_texte_2 media_nb_review_medecin">
                                                    Il existe 1
                                                    commentaire
                                                    sur
                                                    ce
                                                    médecin
                                                </p>
                                            @elseif ($medecin->nb_reviews > 1)
                                                <p class="card-text lobster p_texte_2 media_nb_review_medecin">
                                                    Il y a {{ $medecin->nb_reviews }} commentaires sur ce médecin
                                                </p>
                                            @else
                                                <p class="card-text lobster p_texte_2 media_nb_review_medecin">
                                                    Il n'y a pas encore de commentaire sur ce médecin
                                                </p>
                                            @endif
                                        </div>
                                    </div>

                                    <div
                                        class="d-flex text-center justify-content-center mt-lg-2 mb-lg-2 button_review_medecin">
                                        <form
                                            action="{{ route('give_review_medecin_form', [$medecin->id, $result_city]) }}">
                                            @csrf
                                            <div>
                                                <button type="submit"
                                                    class="btn btn-success mr-3 p_texte_2 text-white media_give_review_medecin"><img
                                                        src="{{ asset('img/bloc-notes.png') }}" alt=""
                                                        class="icon_avis_button mr-1 media_icon_review_liste_medecin">Donnez
                                                    votre
                                                    avis
                                                    sur ce
                                                    médecin</button>
                                            </div>
                                        </form>

                                        <form action="{{ route('read_reviews_medecin', [$medecin->id, $result_city]) }}">
                                            @csrf
                                            <div>
                                                <button type="submit"
                                                    class="btn btn-primary p_texte_2 text-white media_see_review_medecin"><img
                                                        src="{{ asset('img/glasses.png') }}" alt=""
                                                        class="icon_avis_button mr-1  media_icon_review_liste_medecin">Consulter
                                                    les avis
                                                    sur
                                                    ce
                                                    médecin</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- LEAFLET -->
                        <!-- LEAFLET -->
                        <!-- LEAFLET -->
                        <!-- LEAFLET -->
                        <!-- LEAFLET -->
                        <!-- LEAFLET -->
                        <!-- LEAFLET -->
                        <!-- LEAFLET -->
                        <!-- LEAFLET -->
                        <!-- LEAFLET -->
                        <!-- LEAFLET -->
                        <!-- LEAFLET -->

                        <div class="media_leaflet_card mt-3 mt-sm-0 ">
                            <div class="card p-0 window_shadow">
                                <div class="card-header text-white lora text-center bg-primary">
                                    <h3 class="m-0 p-0 media_title_card">Mappy</h3>
                                </div>

                                <div hidden id="count" value="{{ $count_medecins }}">{{ $count_medecins }}</div>
                                <div hidden id="gps_lat_{{ $i }}">{{ $medecin->gps_lat }}</div>
                                <div hidden id="gps_lng_{{ $i }}">{{ $medecin->gps_lng }}</div>

                                <div class="map" id="leaflet_carte_{{ $i }}">Carte</div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            @php
                $i++;
            @endphp

        @endforeach
        <div class="d-flex justify-content-center pt-4 p_texte_3">
            {{ $medecins->appends(['select_accueil' => $result_speciality, 'input_search_accueil' => $result_city])->links() }}
        </div>
    </div>
@endsection
