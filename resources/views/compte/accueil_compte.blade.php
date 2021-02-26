@extends('layouts.app')

@section('content')

    <div class="bg_photo_1 pt-5">

        <div class="mq_width" style="margin:auto">

            <div>
                <div>
                    <h1 class="mq_title_first_title display-5 lobster bg-white py-3 px-3 rounded mb-5">Bienvenue sur votre
                        espace personnel
                        {{ $user->name }} !
                    </h1>
                </div>

                @if (session()->has('password_modified'))
                    <div class="alert alert-success" role="alert">
                        <h2>{{ session()->get('password_modified') }}<h2>
                    </div>
                @endif

                @if (session()->has('name_modified'))
                    <div class="alert alert-success" role="alert">
                        <h2>{{ session()->get('name_modified') }}</h2>
                    </div>
                @endif

                @if (session()->has('message'))
                    <div class="alert alert-warning" role="alert">
                        {{ session()->get('message') }}
                    </div>
                @endif

            </div>

            <div class=" d-lg-flex justify-content-between">
                
                <div class="col-12 col-lg-4 p-3 card mr-4 opacity_1 col-4 mb-5">
                    <div>

                        <div>
                            <h5 class="mq_title_col_left card-title lobster p_texte_1 mb-4">Vos informations de compte</h5>
                            <p class="card-text m-0 p-0">Name : {{ $user->name }}</p>
                            <p class="card-text m-0 p-0"> Email : {{ $user->email }}</p>
                        </div>


                        <div id="modify_account" class="mt-3 mb-3">
                            <a href="#" data-toggle="modal" data-target="#myModal"
                                class="mq_btn_delete card-link btn btn-primary">Modifier
                                mes informations de compte</a>
                        </div>


                        <div>
                            <button id="delete_button" class="mq_btn_modify card-link btn btn-danger mb-5">Supprimer mon
                                compte
                            </button>

                            <div class="mt-3 mb-3 card text-center" id="delete_form" hidden>

                                <form action="{{ route('compte_destroy', ['user_id' => $user->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <p class="card-header m-0 p_texte_2">Supprimer votre compte entraînera la
                                        suppression de tous vos commentaires</p>
                                    <div class="mt-3 mb-3 d-flex justify-content-center">
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

                    <div>

                        <h5 class="mq_title_col_left card-title lobster p_texte_1 mb-4">Vos commentaires personnels</h5>
                        <div class="d-flex justify-content-between">
                            <p class="mq_comment_txt card-text alert alert-success mt-2 mb-3 p-1">Commentaires validés :
                                {{ $user->nb_reviews_validated }}
                            </p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="mq_comment_txt card-text alert alert-warning mt-2 mb-3 p-1">Commentaires en attente de
                                validation : {{ $user->nb_reviews_waiting }}
                            </p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="mq_comment_txt card-text alert alert-danger mt-2 mb-3 p-1">Commentaires refusés par
                                nos modérateurs : {{ $user->nb_reviews_refused }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- COLONNE DROITE-->
                <!-- COLONNE DROITE-->
                <!-- COLONNE DROITE-->
                <!-- COLONNE DROITE-->
                <!-- COLONNE DROITE-->
                <!-- COLONNE DROITE-->

                <div class="mq_pad_col_left bg-white opacity_2 p-5 mb-5 rounded opacity_1">

                    @if (Session::has('review_error'))
                        <div class="d-flex justify-content-center">
                            <div class="alert alert-danger text-danger">{{ Session::get('review_error') }}
                            </div>
                        </div>
                    @endif

                    <!-- Si l'utilisateur n'a aucun commentaire en attente et aucun commentaire validé -->
                    @if ($user->nb_reviews_waiting == 0 && $user->nb_reviews_validated == 0)
                        <p class="mq_txt_light display-5 lora mb-5 p-0">Vous n'avez pas encore publié de commentaires pour
                            le moment !
                        </p>
                        <p class="mq_txt_light lead mt-5">Nous vous rappelons que notre site est totalement participatif et
                            se construit grâce à l'expérience de chacun !</p>
                    @else
                        <p class="mq_txt_light lead">Nous vous rappelons que notre site est totalement participatif et se
                            construit grâce à l'expérience de chacun !</p>
                    @endif

                    <hr class="mt-5 mb-5">
                    <h3 class="mq_txt_bold">Toutes vos soumissions seront évaluées par nos modérateurs afin de s'assurer du
                        bon fonctionnement du site.</h3>

                    <div class="text-center mt-5 mb-5 ">
                        <a class="mq_txt_new_research btn btn-primary btn-lg text-white" href="{{ '/' }}"
                            role="button">Effectuez
                            une
                            recherche et laissez une note positive sur votre médecin favoris !</a>
                    </div>

                    <div class="mb-2 mt-3">
                        <p class="mq_txt_light lead p_texte_1 mt-5">Vous connaissez un médecin qui n'existe pas sur notre
                            site web ?
                            <br><br>Aidez-nous à nous mettre à jour, soumettez le médecin consulté à nos modérateurs et
                            donnez
                            lui une note positive dès
                            maintenant !
                        </p>
                        <hr class="mt-5 mb-5">
                        <div class="text-center">
                            <a class="mq_txt_new_research btn btn-success btn-lg btn p_texte_28 text-white"
                                href="{{ route('create_medecin') }}" role="button">Cliquez ici</a>
                        </div>
                    </div>

                </div>
            </div>

            <!-- MODAL MODIFIER INFORMATIONS DE COMPTE UTILISATEUR-->
            <!-- MODAL MODIFIER INFORMATIONS DE COMPTE UTILISATEUR-->
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
                                            @enderror                                                                        <div class="
                                    text-right">
                                    <button type=" submit" class="btn btn-primary">Modifier le mot de passe<button>
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
