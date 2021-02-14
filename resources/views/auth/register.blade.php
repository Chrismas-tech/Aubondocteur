@extends('layouts.app')

@section('content')

    <div class="jumbotron text-primary bg_photo_3 d-flex justify-content-center mb-0">

        <div class="bg-white mt-3 p-4 jumb_1_vignette">

            <div class="text-center">
                <h1 class="display-3 lobster text-center">Créer un compte</h1>
            </div>

            <div style="width:80%;margin:auto;">

                <form method="POST" action="{{ route('register') }}" class="mt-5">
                    @csrf

                    <div class="">
                        <label for="name" class="col-md-4 col-form-label text-md-right"></label>

                        <div class="input-group-lg">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
                                placeholder="Votre Nom">

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="">
                        <label for="email" class="col-md-4 col-form-label text-md-right"></label>

                        <div class="input-group-lg">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required autocomplete="email"
                                placeholder="Votre Email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="">
                        <label for="password" class="col-md-4 col-form-label text-md-right"></label>

                        <div class="input-group-lg">
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="new-password" placeholder="Votre mot de passe">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="">
                        <label for="password-confirm" class="col-md-4 col-form-label text-md-right"></label>

                        <div class="input-group-lg">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                                required autocomplete="new-password" placeholder="Confirmation du mot de passe">
                        </div>
                    </div>

                    <div>

                        <div class="text-center mb-4 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg p_texte_1 text-white">
                                S'enregistrer
                            </button>
                        </div>

                    </div>

                </form>

                <div>
                    <p class="lead lora p_texte_1 mt-5 mb-5">Notre plateforme <span class="bold">AuBonMedecins.ml</span>
                        vous
                        propose sans frais de consulter
                        uniquement
                        les profils des médecins de votre région qui ont laissé une expérience positive à leurs patients.
                    </p>

                    <hr class="my-4">

                    <p class="p_texte_2 mt-5 mb-5 text-center">Pour accéder à la liste de nos médecins, vous devrez créer un
                        compte
                        et partager au moins
                        une
                        expérience positive que vous avez eu avec un médecin de votre région.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
