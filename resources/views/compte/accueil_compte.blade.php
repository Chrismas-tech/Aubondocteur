@extends('layouts.app')

@section('content')

    <div class="bg_photo_1 pt-5">

        <div style="width:90%;margin:auto">

            <div>
                <div>
                    <h1 class="display-5 lobster bg-white py-2 px-3 rounded mb-5 mt-4">Bienvenue sur votre espace personnel
                        {{ $user->name }} !
                    </h1>
                </div>


                @if (session()->has('message'))
                    <div class="alert alert-warning" role="alert">
                        {{ session()->get('message') }}
                    </div>
                @endif

            </div>

            <div class="d-flex mb-5 mt-5 justify-content-between">
                <div class="card mr-4 opacity_1 col-3">
                    <div class="p-4 mb-2 ">

                        <div>
                            <h5 class="card-title lobster p_texte_1 mb-4">Vos informations de compte</h5>
                            <p class="card-text m-0 p-0">Name : {{ $user->name }}</p>
                            <p class="card-text m-0 p-0"> Email : {{ $user->email }}</p>
                        </div>


                        <div id="modify_account" class="mt-3 mb-3">
                            <a href="#" data-toggle="modal" data-target="#myModal"
                                class="card-link btn btn-primary">Modifier
                                mes informations de compte</a>
                        </div>


                        <div>
                            <button id="delete_button" class="card-link btn btn-danger">Supprimer mon
                                compte
                            </button>

                            <div class="mt-3 mb-3 card text-center" id="delete_form" hidden>

                                <form action="{{ route('compte.destroy', ['user_id' => $user->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <p class="lobster card-header m-0 p_texte_1">Supprimer votre compte entraînera la
                                        suppression de toutes vos
                                        reviews</p>
                                    <div class=" mt-3 mb-3 d-flex justify-content-center">
                                        <div>
                                            <button type="submit" class="card-link btn btn-danger btn-lg mr-3">Oui</button>
                                        </div>
                                        <div>
                                            <p id="cancel_delete_button" class="card-link btn btn-primary btn-lg">Annuler
                                            </p>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>


                    <div class="p-4">

                        <h5 class="card-title lobster p_texte_1 mb-4">Vos commentaires personnels</h5>
                        <p class="card-text alert alert-success mt-2 mb-3 p-1">Commentaires validés :
                            {{ $user->nb_reviews_validated }}
                        </p>
                        <p class="card-text alert alert-warning mt-2 mb-3 p-1">Commentaires en attente de validation :
                            {{ $user->nb_reviews_waiting }}
                        </p>
                        <p class="card-text alert alert-danger mt-2 mb-3 p-1">Commentaires refusés par nos modérateurs
                            :
                            {{ $user->nb_reviews_refused }}
                        </p>
                    </div>

                </div>

                <!-- COLONNE DROITE-->
                <!-- COLONNE DROITE-->
                <!-- COLONNE DROITE-->
                <!-- COLONNE DROITE-->
                <!-- COLONNE DROITE-->
                <!-- COLONNE DROITE-->


                <div class="jumbotron m-0 p-5 opacity_1">

                    @if (Session::has('review_error'))
                        <div class="d-flex justify-content-center">
                            <div class="alert alert-danger p_texte_1 text-danger">{{ Session::get('review_error') }}</div>
                        </div>
                    @endif

                    @if ($user->nb_reviews_waiting < 1)
                        <h1 class=" display-5 lora mb-5 p-0">Vous n'avez pas encore publié de commentaires pour le moment !
                        </h1>
                    @endif
                    <p class="lead p_texte_1 mt-5">Nous vous rappelons que notre site est totalement participatif et se
                        construit grâce à l'expérience de chacun !</p>
                    <hr class="mt-5 mb-5">
                    <h3>Toutes vos soumissions seront évaluées par nos modérateurs afin de s'assurer du
                        bon fonctionnement du site.</h3>

                    <div class="text-center mt-5 mb-5 ">
                        <a class="btn btn-primary btn-lg p_texte_28 text-white" href="{{ '/' }}" role="button">Effectuez une
                            recherche et laissez une note positive sur votre médecin favoris !</a>
                    </div>

                    <div class="mb-2 mt-3">
                        <p class="lead p_texte_1 mt-5">Vous connaissez un médecin qui n'existe pas sur notre site web ?
                            <br>Aidez-nous à nous mettre à jour, soumettez le médecin consulté à nos modérateurs et donnez
                            lui une note positive dès
                            maintenant !
                        </p>
                        <hr class="mt-5 mb-5">
                        <div class="text-center">
                            <a class="btn btn-success btn-lg btn p_texte_28 text-white" href="{{ route('compte.create') }}"
                                role="button">Cliquez ici</a>
                        </div>
                    </div>

                </div>
            </div>



            <!-- MODAL MODIFIER INFORMATIONS DE COMPTE UTILISATEUR-->

            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                aria-hidden="true">
                <div class="table">
                    <div class="table-cell">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="lobster">Modifier vos informations</h3>
                                    <button type="button" class="close" data-dismiss="modal"><span
                                            aria-hidden="true">x</span><span class="sr-only">Close</span></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('change_password') }}" method="POST">
                                        @csrf

                                        <div class="input-group-lg mb-3">
                                            <label for="current_password">Votre mot de passe actuel</label>

                                            <input id="current_password" type="password"
                                                class="form-control @error('current_password') is-invalid @enderror"
                                                name="current_password" type="text">
                                        </div>

                                        @error('current_password')
                                            <p class="text-danger"">{{ $message }}</p>
                                                                                @enderror

                                                                                <div class=" input-group-lg mb-3">
                                            <label for="new_password">Votre nouveau mot de passe</label>

                                            <input id="new_password" type="password"
                                                class="form-control @error('new_password') is-invalid @enderror"
                                                name="new_password" type="text">
                                </div>

                                @error('new_password')
                                    <p class="text-danger">{{ $message }}</^p>
                                    @enderror

                                <div class="input-group-lg mb-3">
                                    <label for="new_confirm_password">Confimation de votre nouveau mot de passe</label>

                                    <input id="new_confirm_password" type="password"
                                        class="form-control @error('new_confirm_password') is-invalid @enderror"
                                        name="new_confirm_password" type="text">
                                </div>

                                @error('new_confirm_password')
                                    <p class="text-danger"">{{ $message }}</p>
                                                                                @enderror

                                                                                <div class=" text-right">
                                    <button type=" submit" class="btn btn-primary">Modifier le mot de
                                        passe</button>
                            </div>
                            </form>
                        </div>



                        <div class="modal-body">
                            <form action="{{ route('change_name_user', ['user_id' => $user->id]) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="input-group-lg mb-3">
                                    <label for="name">Modifier votre Nom d'utilisateur</label>

                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" type="text" placeholder="{{ $user->name }}">
                                </div>
                                @error('name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary">Modifier le nom</button>
                                </div>
                            </form>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>





    <script>
        $(document).ready(function() {

            $('#delete_button').click(function() {

                $("#delete_form").removeAttr('hidden').fadeIn();

            });

            $('#cancel_delete_button').click(function() {
                $("#delete_form").fadeOut()
                $("#delete_button").fadeIn();
            });

        });

    </script>
@endsection
