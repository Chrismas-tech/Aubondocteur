@extends('admin.app_admin')
@section('content')

    <div class="jumbotron text-primary bg_photo_4 mb-0">
        <div id="review_refused">

            @if ($review_status_refused->isEmpty())
                <div class="text-center d-flex justify-content-center">
                    <h1 class="display-4 lobster bg-white p-2 rounded">Il n'y a pas de résultat pour le moment...</h1>
                </div>
         

                <div class="d-flex justify-content-center p_texte_2 mt-4">
                    {{ $review_status_refused->links() }}
                </div>

                <div class="text-center">
                    <a href="{{ route('gestionnaire') }}" class="btn btn-lg btn-primary">Revenir au gestionnaire</a>
                </div>
                @else


                <div class="d-flex justify-content-between flex-wrap p-4">

                    <table class="table table-striped bg-white table-white border">
                        <thead>
                            <tr>
                                <th class="bg-danger p_texte_3 text-white p-3 border">Ajouté par l'utilisateur
                                </th>
                                <th class="bg-danger p_texte_3 text-white p-3 border">Médecin</th>
                                <th class="bg-danger p_texte_3 text-white p-3 border">Date du Rendez-vous</th>
                                <th class="bg-danger p_texte_3 text-white p-3 border">Commentaire</th>
                                <th class="bg-danger p_texte_3 text-white p-3 border">Statut de la validation</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($review_status_refused as $review)
                                <tr>
                                    <td class="border align-middle text-center font-weight-bold p-2 ">
                                        ID #{{ $review->user->id }} <br>
                                        Nom # {{ $review->user->name }}
                                    </td>
                                    <td class="border align-middle text-center font-weight-bold p-2 ">
                                        Médecin : {{ $review->medecin->medecin_name }}
                                        {{ $review->medecin->medecin_last_name }} <br>
                                        {{ $review->medecin->speciality }}
                                    </td>
                                    <td class="border align-middle text-center p-2 ">

                                        {{ App\Http\Controllers\DateChangeController::date_created_at_to_string($review->date_rdv) }}
                                    </td>
                                    <td class="border align-middle p-3 cell_width_30">
                                        <div class="bg-info p-1 text-white rounded-top lora">
                                            Créé le
                                            {{ \App\Http\Controllers\DateChangeController::date_created_at_to_string($review->created_at) }}
                                        </div>

                                        <div class="p-2 bg-white rounded border border-black">
                                            {{ $review->review }}
                                        </div>
                                    </td>
                                    <td class="">
                                        <div class="d-flex justify-content-center mt-3 mb">
                                            <form
                                                action="{{ route('review_refuse_to_validate', ['review_id' => $review->id, 'medecin_id' => $review->medecin->id, 'user_id' => $review->user->id]) }}"
                                                method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <div>
                                                    <button type="submit"
                                                        class="btn btn-success mr-3 p_texte_3 text-white"><img
                                                            src="{{ asset('img/checked.png') }}" alt=""
                                                            class="icon_avis_button mr-1">Accepter la soumission</button>
                                                </div>
                                            </form>
                                            <form
                                                action="{{ route('review_refuse_to_waiting', ['review' => $review->id, 'user_id' => $review->user->id]) }}"
                                                method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <div>
                                                    <button type="submit" class="btn btn-warning p_texte_3 text-dark"><img
                                                            src="{{ asset('img/sablier.png') }}" alt=""
                                                            class="icon_avis_button mr-1">Remettre en attente</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center p_texte_2 mt-4">
                    {{ $review_status_refused->links() }}
                </div>
            @endif
        </div>
    </div>


@endsection
