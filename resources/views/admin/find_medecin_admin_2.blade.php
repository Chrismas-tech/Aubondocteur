@extends('admin.app_admin')
@section('content')

    <div class="jumbotron text-primary bg_photo_3 min_height mb-0">
        <div class="text-center">
            <a href="{{ route('gestionnaire')}}" class="p_texte_1 text-white btn-primary btn btn-lg lora mb-4 mt-3">Revenir au gestionnaire de recherche</a>
        </div>

        @if ($medecins->isEmpty())
            <div class="bg-white p-4 rounded">
                <div class="text-center">
                    <h2 class="lora text-primary mb-4 mt-3">Il n'y a pas de résultat pour cette recherche...</h2>
                </div>
            </div>

        @else
            <div class="bg-white p-4 rounded">
                <div class="d-flex justify-content-center p_texte_2 mb-3">
                    {{ $medecins->appends(['first_or_last_name_input_admin' => $name])->links() }}
                </div>
                <div class="d-flex justify-content-between flex-wrap">
                    <table class="table table-striped table-white border">
                        <thead>
                            <tr>
                                <th scope="col" class="bg-primary p_texte_2 text-white p-3 border">Prénom</th>
                                <th scope="col" class="bg-primary p_texte_2 text-white p-3 border">Nom</th>
                                <th scope="col" class="bg-primary p_texte_2 text-white p-3 border">Spécialité</th>
                                <th scope="col" class="bg-primary p_texte_2 text-white p-3 border">Adresse</th>
                                <th scope="col" class="bg-primary p_texte_2 text-white p-3 border">Téléphone</th>
                                <th scope="col" class="bg-primary p_texte_2 text-white p-3 border">Statut de validation</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($medecins as $medecin)
                                <tr>
                                    <td class="border align-middle text-center font-weight-bold p-2">
                                        
                                    </td>
                                    <td class="border align-middle text-center font-weight-bold p-2">
                                        {{ $medecin->medecin_name }}
                                    </td>
                                    <td class="border align-middle text-center lora p-1 p_texte_2 ">
                                        {{ $medecin->speciality }}
                                    </td>
                                    <td class="border align-middle p-2">{{ $medecin->address }}</td>
                                    <td class="border align-middle text-center p-2">{{ $medecin->phone }}</td>
                                    <td>

                                        <div>
                                            @if ($medecin->validation_status_medecin == 1)
                                                <span class="badge badge-success">Statut de validation : validé</span>
                                            @elseif($medecin->validation_status_medecin == 2)
                                                <span class="badge badge-danger">Statut de validation : refusé</span>
                                            @elseif($medecin->validation_status_medecin == 3)
                                                <span class="badge badge-warning">Statut de validation : en
                                                    attente</span>
                                            @endif
                                        </div>

                                        <div class="d-flex mt-3 justify-content-center">

                                            <form action="{{ route('form_medecin_admin', ['medecin_id' => $medecin->id]) }}"
                                                method="POST">
                                                @csrf
                                                <div>
                                                    <button type="submit"
                                                        class="px-2 m-0 btn btn-info p_texte_3 mr-3 text-white"><img
                                                            src="{{ asset('img/edit.png') }}" alt=""
                                                            class="icon_avis_button mr-1">Modifier les informations sur le
                                                        médecin</button>
                                                </div>
                                            </form>

                                            @if ($medecin->validation_status_medecin == 1)
                                                <form
                                                    action="{{ route('medecin_validate_to_waiting', ['medecin_id' => $medecin->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <div>
                                                        <button type="submit"
                                                            class="px-2 m-0 btn btn-warning p_texte_3 mr-3 text-dark"><img
                                                                src="{{ asset('img/sablier.png') }}" alt=""
                                                                class="icon_avis_button mr-1">Remettre en attente</button>
                                                    </div>
                                                </form>
                                                <form
                                                    action="{{ route('medecin_validate_to_refuse', ['medecin_id' => $medecin->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <div>
                                                        <button type="submit"
                                                            class="px-2 m-0 btn btn-danger p_texte_3 text-white"><img
                                                                src="{{ asset('img/red-cross.png') }}" alt=""
                                                                class="icon_avis_button mr-1">Refuser la soumission</button>
                                                    </div>
                                                </form>
                                            @elseif ($medecin->validation_status_medecin == 2)
                                                <form
                                                    action="{{ route('medecin_refuse_to_validate', ['medecin_id' => $medecin->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <div>
                                                        <button type="submit"
                                                            class="px-2 m-0 btn btn-success p_texte_3 text-white mr-3"><img
                                                                src="{{ asset('img/checked.png') }}" alt=""
                                                                class="icon_avis_button mr-1">Accepter la
                                                            soumission</button>
                                                    </div>
                                                </form>
                                                <form
                                                    action="{{ route('medecin_refuse_to_waiting', ['medecin_id' => $medecin->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <div>
                                                        <button type="submit"
                                                            class="px-2 m-0 btn btn-warning p_texte_3 text-dark"><img
                                                                src="{{ asset('img/sablier.png') }}" alt=""
                                                                class="icon_avis_button mr-1">Remettre en attente</button>
                                                    </div>
                                                </form>
                                            @elseif ($medecin->validation_status_medecin == 3)
                                                <form
                                                    action="{{ route('medecin_waiting_to_validate', ['medecin_id' => $medecin->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <div>
                                                        <button type="submit"
                                                            class="px-2 m-0 btn btn-success p_texte_3 text-white mr-3"><img
                                                                src="{{ asset('img/checked.png') }}" alt=""
                                                                class="icon_avis_button mr-1">Accepter la
                                                            soumission</button>
                                                    </div>
                                                </form>
                                                <form
                                                    action="{{ route('medecin_waiting_to_refuse', ['medecin_id' => $medecin->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <div>
                                                        <button type="submit"
                                                            class="px-2 m-0 btn btn-danger mr-3 p_texte_3 text-white"><img
                                                                src="{{ asset('img/red-cross.png') }}" alt=""
                                                                class="icon_avis_button mr-1">Refuser la soumission</button>
                                                    </div>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center p_texte_2 mb-3">
                    {{ $medecins->appends(['first_or_last_name_input_admin' => $name])->links() }}
                </div>
            </div>
        @endif
    </div>

@endsection
