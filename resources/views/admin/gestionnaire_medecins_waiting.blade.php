@extends('admin.app_admin')
@section('content')

    <div class="jumbotron text-primary bg_photo_4 mb-0">
        <div id="medecin_waiting">

            @if ($medecin_status_waiting->isEmpty())
            <div class="text-center d-flex justify-content-center">
                <h1 class="display-4 lobster bg-white p-2 rounded">Il n'y a pas de résultat pour le moment...</h1>
            </div>

            <div class="p_texte_2 text-center pl-4 pt-4">
                {{ $medecin_status_waiting->links() }}
            </div>
     
            <div class="text-center">
                <a href="{{ route('gestionnaire') }}" class="btn btn-lg btn-primary">Revenir au gestionnaire</a>
            </div>

            @else

            <div class="text-center">
                <a href="{{ route('gestionnaire') }}" class="btn btn-lg btn-primary">Revenir au gestionnaire</a>
            </div>

            <div class="d-flex justify-content-between flex-wrap p-4">
                <table class="table table-striped bg-white table-white border">
                    <thead>
                        <tr>
                            <th scope="col" class="bg-warning p_texte_2 text-dark p-3 border">Nom</th>
                            <th scope="col" class="bg-warning p_texte_2 text-dark p-3 border">Spécialité</th>
                            <th scope="col" class="bg-warning p_texte_2 text-dark p-3 border">Adresse</th>
                            <th scope="col" class="bg-warning p_texte_2 text-dark p-3 border">Téléphone</th>
                            <th scope="col" class="bg-warning p_texte_2 text-dark p-3 border">Statut de validation</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($medecin_status_waiting as $medecin)
                            <tr>
                                <td class="border align-middle text-center font-weight-bold p-2">
                                    {{ $medecin->medecin_name }}</td>
                                <td class="border align-middle text-center font-weight-bold p-2">
                                    </td>
                                <td class="border align-middle text-center lora p-2 p_texte_2 ">{{ $medecin->speciality }}
                                </td>
                                <td class="border align-middle p-2">{{ $medecin->address }}</td>
                                <td class="border align-middle text-center p-2">{{ $medecin->phone }}</td>
                                <td>
                                    <div class="d-flex justify-content-center mt-3 mb">
                                        <form
                                            action="{{ route('medecin_waiting_to_validate', ['medecin_id' => $medecin->id]) }}"
                                            method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <div>
                                                <button type="submit" class="btn btn-success mr-3 p_texte_3 text-white"><img
                                                        src="{{ asset('img/checked.png') }}" alt=""
                                                        class="icon_avis_button mr-1">Accepter la soumission</button>
                                            </div>
                                        </form>
                                        <form
                                            action="{{ route('medecin_waiting_to_refuse', ['medecin_id' => $medecin->id]) }}"
                                            method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <div>
                                                <button type="submit" class="btn btn-danger p_texte_3 text-white"><img
                                                        src="{{ asset('img/red-cross.png') }}" alt=""
                                                        class="icon_avis_button mr-1">Rejeter la soumission</button>
                                            </div>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-center p_texte_2 mb-4">
                    {{ $medecin_status_waiting->links() }}
                </div>
            </div>
            @endif
        </div>
    </div>

@endsection
