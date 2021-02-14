@extends('layouts.app')

@section('content')

    <div class="jumbotron text-primary bg_photo_3 mb-0 d-flex flex-wrap">
        <div class="bg-white mt-3 p-4 jumb_1_vignette" style="width:50%;margin:auto">

            <div class="text-center mt-3">
                <h1 class="display-4 lobster">Vous n'avez pas encore de compte ?</h1>
            </div>

            <hr>

            <div class="text-center mt-5">
                <h1 class="display-4 lobster text-center">Créer un compte</h1>
            </div>

            <div style="width:80%;margin:auto;">

                <form method="POST" action="{{ route('register') }}" class="mt-3">
                    @csrf

                    <div>
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
                        <div class="text-center mt-5">
                            <button type="submit" class="btn btn-primary btn-lg p_texte_1 text-white">
                                S'enregistrer
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>


        <div class="bg-white mt-3 p-3 jumb_1_vignette" style="width:40%;margin:auto">

            <div class="text-center mt-3">
                <h1 class="display-4 lobster">Déjà membre ?</h1>
            </div>

            <hr>

            <div class="text-center mt-5">
                <h1 class="display-4 lobster">Connectez-vous</h1>
            </div>

            <div style="width:80%;margin:auto;">

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div>
                        <label for="email" class="text-white col-form-label"></label>

                        <div class="input-group-lg">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                                placeholder="Votre Email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div  class="mb-3">
                        <label for="password" class="col-form-label"></label>

                        <div class="input-group-lg">
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="current-password" placeholder="Votre mot de passe">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>


                    <div class="text-center">

                        <div class="mt-3">
                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                            <label class="text-dark" for="remember">
                                <h4> {{ __('Remember me') }}</h4>
                            </label>
                        </div>

                        <div class="mb-5">
                            <button type="submit" class="btn btn-primary btn-lg p_texte_1 text-white">
                                Connexion
                            </button>

                            @if (Route::has('password.request'))
                                <a class="btn btn-link btn-lg" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                        </div>
                </form>
            </div>
        </div>
    </div>

@endsection
