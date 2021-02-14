@extends('admin.app_admin')
@section('content')
    <div class="jumbotron text-primary bg_photo_4 d-flex justify-content-center mb-0">

        <div class="bg-white mt-3 p-4 rounded" style="width:98%;margin:auto;">
            <div class="text-center">
                <h1 class="display-3 lobster text-center">Gestionnaire de validation</h1>
            </div>
            @if (session()->has('message'))
                <div class="container mt-3">
                    <div class="alert alert-success" role="alert">
                        {{ session()->get('message') }}
                    </div>
                </div>
            @endif

            <div class="d-flex align-items-center justify-content-center mt-3 mb-3">

                <div class="mt-3 mb-3">
                    <a href="{{ route('add_medecin_form') }}"
                        class="btn-lg btn-success text-decoration-none p_texte_1 text-white">Ajouter
                        manuellement un médecin dans la base de
                        donnée</a>
                </div>
            </div>

            <!-- Buttons en attente de validation -->
            <!-- Buttons en attente de validation -->
            <!-- Buttons en attente de validation -->
            <!-- Buttons en attente de validation -->

            <hr>
            <div class="d-flex justify-content-center">
                <div>
                    <div class="m-0 mr-5 mb-3" role="alert">
                        <a href="{{ route('gestionnaire_reviews_waiting') }}"" type=" button" id="btn_waiting_reviews"
                            class="btn btn-lg btn-warning">Afficher les commentaires
                            en attente de validation : <span class="bold">({{ $review_count_waiting }})</span> </a>
                    </div>
                    <div class="m-0 mr-5 mb-3" role="alert">
                        <a href="{{ route('gestionnaire_reviews_validated') }}" type="button" id="btn_validated_reviews"
                            class="btn btn-lg btn-success">Afficher les commentaires
                            validées : <span class="bold">({{ $review_count_validated }})</span> </a>
                    </div>
                    <div class="m-0 mr-5" role="alert">
                        <a href="{{ route('gestionnaire_reviews_refused') }}" type="button" id="btn_refused_reviews"
                            class="btn btn-lg btn-danger">Afficher les commentaires
                            refusés : <span class="bold">({{ $review_count_refused }})</span> </a>
                    </div>
                </div>

                <div>
                    <div class="m-0 ml-3 mb-3" role="alert">
                        <a href="{{ route('gestionnaire_medecins_waiting') }}"" type=" button" id="btn_waiting_medecins"
                            class="btn btn-lg btn-warning">Afficher les médecins
                            en attente de validation : <span class="bold">({{ $medecin_count_waiting }})</span> </a>
                    </div>
                    <div class="m-0 ml-3 mb-3" role="alert">
                        <a href="{{ route('gestionnaire_medecins_validated') }}" type="button" id="btn_validated_medecins"
                            class="btn btn-lg btn-success">Afficher les médecins
                            validés : <span class="bold">({{ $medecin_count_validated }})</span> </a>
                        <p></p>
                    </div>
                    <div class="m-0 ml-3" role="alert">
                        <a href="{{ route('gestionnaire_medecins_refused') }}" type="button" id="btn_refused_medecins"
                            class="btn btn-lg btn-danger">Afficher les médecins
                            refusés : <span class="bold">({{ $medecin_count_refused }})</span> </a>
                        <p></p>
                    </div>
                </div>
            </div>

            <!-- Buttons validés ou rejetés -->
            <!-- Buttons validés ou rejetés -->
            <!-- Buttons validés ou rejetés -->
            <!-- Buttons validés ou rejetés -->


            @include('admin.search_bar_gestionnaire')
            @yield('content_medecin')
            @yield('content_reviews')
        </div>
    </div>

@endsection
