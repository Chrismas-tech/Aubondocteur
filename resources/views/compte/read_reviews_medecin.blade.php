@extends('layouts.app')
@section('content')


    <div class="d-flex justify-content-center pt-5 pb-5 banner_list_medecins">
        <div class="p-3 jumb_1_vignette bg-white opacity_1 mt-5 mb-5">
            <div class="text-center">

                <h1 class="display-4 lora text-primary mb-3 mt-3">Commentaires</h1>

                <div class="card p-3 domine text-dark shadow-sm">
                    <div class="d-flex align-items-center mt-2 mb-2">
                        <img src="{{ asset('img/medecin-icon.png') }}" alt="" class="icon_info_docteur ">
                        <h3 class="p-0 m-0 lora ml-2">
                            {{ $medecin->medecin_first_name }} {{ $medecin->medecin_last_name }}, {{ $medecin->speciality }}
                        </h3>
                    </div>

                    <div class="d-flex align-items-center mt-2 mb-2">
                        <img src="{{ asset('img/address.png') }}" alt="" class="icon_info ">
                        <h5 class=" p-0 m-0 lora ml-2">
                            {{ $medecin->address }}
                        </h5>
                    </div>

                    <div class="d-flex align-items-center mt-2 mb-2">
                        <img src="{{ asset('img/phone.png') }}" alt="" class="icon_info ">
                        <h5 class=" p-0 m-0 roboto ml-2 media_phone_medecin ">
                            @if ($medecin->phone)
                                <a class="text-decoration-none" href=" tel:{{$medecin->phone}}">
                                    {{ $medecin->phone }}</a>
                            @else
                                Téléphone inconnu
                            @endif
                        </h5>
                    </div>

                    <div class="d-flex align-items-center mt-2 mb-2">
                        <img src="{{ asset('img/email_docteur.png') }}" alt="" class="icon_info ">
                        <h5 class=" p-0 m-0 roboto ml-2 media_phone_medecin ">
                            @if ($medecin->email)
                                <a class="text-decoration-none" href="mailto:{{$medecin->email}}">
                                    {{ $medecin->email }}</a>
                            @else
                                Email inconnu
                            @endif
                        </h5>
                    </div>
                </div>

                @if ($review_validated->isEmpty())
                    <h3 class="display-5 p-3 text-left lora text-primary mt-3">Il n'y a pas encore de commentaires sur le
                        médecin recherché :(
                    </h3>
                    <h4 class="p-3 text-left lora text-primary mb-5 ">Si votre soumission n'apparaît pas dans les résultats
                        de recherche, votre demande est peut-être en attente de validation...</h4>
                @else

                    <!-- REVIEWS -->
                    <!-- REVIEWS -->
                    <!-- REVIEWS -->
                    <!-- REVIEWS -->
                    <!-- REVIEWS -->
                    <!-- REVIEWS -->

                    <div class="text-center">
                        <a href="{{ route('back_to_liste_medecins', [$city, 'speciality' => $medecin->speciality]) }}" class=" p_texte_2 text-white btn btn-lg btn-primary mt-1 mt-5">Revenir sur
                            les résultats de recherche : {{ $medecin->speciality }} dans la ville de {{ $city }}</a>
                    </div>

                    <div class="d-flex justify-content-center mt-5 p_texte_2">
                        {{ $review_validated->links() }}
                    </div>

                    @foreach ($review_validated as $review)

                        <div class="card mt-4 text-left mb-5 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title text-left text-primary">Publié
                                    {{ $review->created_at->diffForHumans() }}
                                    par
                                    {{ $review->user->name }}
                                </h5>
                                <h5 class="card-title text-left text-primary">Date du rendez-vous :
                                    {{ \App\Http\Controllers\DateChangeController::date_created_at_to_string($review->date_rdv) }}
                                </h5>

                                <p class="alert alert-primary card-text p_texte_2">{{ $review->review }}.</p>

                            </div>
                        </div>

                    @endforeach
                @endif
            </div>

            <div class="d-flex justify-content-center mb-4 p_texte_2">
                {{ $review_validated->links() }}
            </div>

            <!-- On évite le double retour s'il y a moins de 4 reviews -->
            @if(count($review_validated) > 4)
            <div class="text-center">
                <a href="{{ route('back_to_liste_medecins', ['city' => $medecin->city, 'speciality' => $medecin->speciality]) }}" class=" p_texte_2 text-white btn btn-lg btn-primary mt-1 mb-5">Revenir sur
                    les résultats de recherche : {{ $medecin->speciality }} dans la ville de {{ $medecin->city }}</a>
            </div>
            @endif

        </div>
    </div>
@endsection
