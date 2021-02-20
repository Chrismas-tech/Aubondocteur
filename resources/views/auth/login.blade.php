@extends('layouts.app')

@section('content')

    <div
        class="my_min_height_login mq_h1_font_size jumbotron text-primary bg_photo_3 mb-0 d-lg-flex justify-content-around">
        <div class="bg-white mt-xl-3 mb-5 mb-lg-0 p-1 mb-xl-0 rounded col-12 col-lg-6">

            <div class="text-center mt-2">
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

                        <div class="input-group-lg d-flex">
                            <input id="password" type="password"
                                class="input_rounded_right_0 form-control  @error('password') is-invalid @enderror" name="password"
                                required autocomplete="new-password" placeholder="Votre mot de passe">
                            <button id="reveal_password_register" class="border border-secondary "><img src="{{ asset('img/eye.png') }}" alt="" class="eye_icon"></button>

                        </div>

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="">
                        <label for="password-confirm" class="col-md-4 col-form-label text-md-right"></label>

                        <div class="input-group-lg d-flex">
                            <input id="password-confirm" type="password" class="input_rounded_right_0 form-control" name="password_confirmation"
                                required autocomplete="new-password" placeholder="Confirmation du mot de passe">
                                <button id="reveal_password_confirmation_register" class="border border-secondary "><img src="{{ asset('img/eye.png') }}" alt="" class="eye_icon"></button>
                        </div>
                    </div>
                    <div>
                        <div class="text-center mt-4 mb-4 mt-lg-5 mb-lg-5">
                            <button type="submit"
                                class="btn_login_register_font_size btn btn-primary btn-lg p_texte_1 text-white">
                                S'enregistrer
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>


        <div class="bg-white mt-xl-3 p-1 rounded col-12 col-lg-5">

            <div class="text-center mt-2">
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

                    <div class="mb-3">
                        <label for="password" class="col-form-label"></label>

                        <div class="input-group-lg d-flex">
                            <input id="password" type="password"
                                class="input_rounded_right_0 form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="current-password" placeholder="Votre mot de passe">
                                <button id="reveal_password_login" class="border border-secondary"><img src="{{ asset('img/eye.png') }}" alt="" class="eye_icon"></button>

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>


                    <div class="text-center">

                        <div class="mt-10">
                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                            <label class="text-dark" for="remember">
                                <h4>Remember me</h4>
                            </label>
                        </div>

                        <div class="mt-4 mb-4 mt-lg-5 mb-lg-5">
                            <button type="submit"
                                class="btn_login_register_font_size btn btn-primary btn-lg p_texte_1 text-white">
                                Connexion
                            </button>

                            @if (Route::has('password.request'))
                                <a class="btn btn-link btn-lg" href="{{ route('password.request') }}">
                                    Forgot your password
                                </a>
                            @endif
                        </div>
                </form>
            </div>
        </div>
    </div>

@endsection
