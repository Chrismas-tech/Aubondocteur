@extends('admin.app_admin')

@section('content')

    @if (session()->has('message'))
        <div class="container mt-3 mb-3">
            <div class="alert alert-warning" role="alert">
                {{ session()->get('message') }}
            </div>
        </div>
    @endif

    <div class="p-4 bg_photo_3">

        <div style="width:70%;margin:auto">

            <div class="card opacity_1 mb-4 p-3 mt-2 rounded">

                <h1 class="display-4 lobster p-1 pl-2">Administration</h1>

                <div class="card-body">
                    <h1 class="lobster">Informations du site web :</h1>
                </div>

                <div class="alert alert-primary d-flex justify-content-between align-items-center m-3" role="alert">

                    <div>
                        <p class="m-0 p-0">Utilisateurs enregistrés : </p>
                    </div>

                    <div>
                        <p class="bold p_texte_2 text-primary m-0 p-0">{{ $nb_users }}</p>
                    </div>

                </div>


                <div class="d-flex justify-content-between">

                    <div class="card-body mr-5">

                        <h1 class="mb-4 p-3 mt-2 lobster">Médecins :</h1>
                        <div class="alert alert-success d-flex justify-content-between align-items-center" role="alert">

                            <div>
                                <p class="m-0 p-0">Médecins validés : </p>
                            </div>

                            <div>
                                <p class="bold p_texte_2 text-success m-0 p-0">{{ $nb_medecins_validated }}</p>
                            </div>

                        </div>

                        <div class="alert alert-warning d-flex justify-content-between align-items-center" role="alert">

                            <div>
                                <p class="m-0 p-0">Médecins en attente de validation : </p>
                            </div>

                            <div>
                                <p class="bold p_texte_2 text-warning m-0 p-0">{{ $nb_medecins_waiting }}</p>
                            </div>

                        </div>

                        <div class="alert alert-danger d-flex justify-content-between align-items-center" role="alert">

                            <div>
                                <p class="m-0 p-0">Médecins refusés : </p>
                            </div>

                            <div>
                                <p class="bold p_texte_2 text-danger m-0 p-0">{{ $nb_medecins_refused }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body ml-5">
                        <h1 class="mb-4 p-3 mt-2 lobster">Commentaires utilisateurs :</h1>

                        <div class="alert alert-success d-flex justify-content-between align-items-center" role="alert">

                            <div>
                                <p class="m-0 p-0">Commentaires validés : </p>
                            </div>

                            <div>
                                <p class="bold p_texte_2 text-success m-0 p-0">{{ $count_nb_reviews_validated }}</p>
                            </div>

                        </div>

                        <div class="alert alert-warning d-flex justify-content-between align-items-center" role="alert">

                            <div>
                                <p class="m-0 p-0">Commentaires en attente de validation : </p>
                            </div>

                            <div>
                                <p class="bold p_texte_2 text-warning m-0 p-0">{{ $count_nb_reviews_waiting }}</p>
                            </div>

                        </div>

                        <div class="alert alert-danger d-flex justify-content-between align-items-center" role="alert">

                            <div>
                                <p class="m-0 p-0">Commentaires refusés : </p>
                            </div>

                            <div>
                                <p class="bold p_texte_2 text-danger m-0 p-0">{{ $count_nb_reviews_refused }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-5 mb-5">
                    <a href="{{ route('gestionnaire') }}" type="button" class="btn btn-primary btn-lg">
                        Consulter le gestionnaire
                        des médecins et des commentaires utilisateurs
                    </a>
                </div>
            </div>


            <div class="mb-5">
                <div class="card p-4">
                    <h3 class="p_texte_1 mb-4 mt4 lobster">Liste des utilisateurs :</h3>

                    <div class="p_texte_2 text-center pl-4 pt-4">
                        {{ $users_all->links() }}
                    </div>

                    <table class="table table-striped table-bordered">
                        <thead class="thead-dark">
                            <tr class="">
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Date de création du compte</th>
                                <th scope="col">Suppression d'utilisateur</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users_all as $user_single)
                                <tr>
                                    <th class="p-4" scope="row">{{ $user_single->id }}</th>
                                    <td class="p-4">{{ $user_single->name }}</td>
                                    <td class="p-4">{{ $user_single->email }}</td>
                                    <td class="p-4 text-center">
                                        {{ App\Http\Controllers\DateChangeController::date_created_at_to_string($user_single->created_at) }}
                                    </td>


                                    <form action="compte_destroy/{{ $user_single->id }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <td class="text-center"><button type="submit" class="btn btn-danger ">Supprimer
                                                l'utilisateur</button>
                                        </td>
                                    </form>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="p_texte_2 text-center pl-4 pt-4">
                        {{ $users_all->links() }}
                    </div>
                </div>
            </div>
        </div>

    @endsection
