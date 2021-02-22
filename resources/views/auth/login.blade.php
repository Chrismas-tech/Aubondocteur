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
                                name="name" value="{{ old('name') }}" autocomplete="name" autofocus
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
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                                value="{{ old('email') }}" autocomplete="email" placeholder="Votre Email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="password" class="col-md-4 col-form-label text-md-right"></label>

                        <div class="input-group-lg d-flex">
                            <input type="password"
                                class="password_register_reveal input_rounded_right_0 form-control  @error('password') is-invalid @enderror"
                                name="password" autocomplete="new-password" placeholder="Votre mot de passe">

                            <button type="button" class="reveal_password_register border border-secondary ">
                                <img src="{{ asset('img/eye.png') }}" alt="" class="eye_icon eye_open_register">
                                <img class="eye_off_register eye_icon d-none" src="{{ asset('img/cross_eye.png') }}"
                                    alt="">
                            </button>
                        </div>
                        @error('password')
                            <div class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>
                    <div>
                        <label for="password-confirm" class="col-md-4 col-form-label text-md-right"></label>

                        <div class="input-group-lg d-flex">
                            <input id="password-confirm" type="password"
                                class="input_rounded_right_0 form-control password_confirmation_register_reveal"
                                name="password_confirmation" autocomplete="new-password"
                                placeholder="Confirmation du mot de passe">

                            <button type="button" class="reveal_password_register border border-secondary ">
                                <img src="{{ asset('img/eye.png') }}" alt="" class="eye_icon eye_open_register">
                                <img class="eye_off_register eye_icon d-none" src="{{ asset('img/cross_eye.png') }}"
                                    alt="" class="eye_icon d-none">
                            </button>
                        </div>
                        @error('password')
                            <div class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror


                    </div>
                    <div>
                        <div class="text-center mt-4 mb-4  mt-lg-5 mb-lg-5">
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
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                                value="{{ old('email') }}" autocomplete="email" autofocus placeholder="Votre Email">

                            @error('email')
                                <div class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="col-form-label"></label>

                        <div class="input-group-lg d-flex">
                            <input type="password"
                                class="password_login_reveal input_rounded_right_0 form-control @error('password') is-invalid @enderror"
                                name="password" autocomplete="current-password" placeholder="Votre mot de passe">

                            <button type="button" class="reveal_password_login border border-secondary">
                                <img src="{{ asset('img/eye.png') }}" alt="" class="eye_icon eye_open_login">
                                <img src="{{ asset('img/cross_eye.png') }}" alt="" class="eye_icon eye_off_login d-none">
                            </button>
                        </div>
                        @error('password')
                            <div class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>


                    <div class="text-center">

                        <div class="mt-10">
                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                            <label class="text-dark" for="remember">
                                <h4>Remember me</h4>
                            </label>
                        </div>

                        <div class="mt-4 mb-4 mt-md-5 mb-md-5">
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
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script>
        $('document').ready(function() {

            /* REVELER LE PASSWORD REGISTER*/
            $('.reveal_password_register').click(function() {

                /* SI L'OEIL EST NORMAL -> ON CHANGE IMAGE + ON REVELE LE PASSWORD */
                if (!$('.eye_open_register').hasClass('d-none')) {

                    $('.eye_open_register').addClass('d-none');
                    $('.eye_off_register').removeClass('d-none');
                    $('.password_register_reveal').attr('type', 'text');
                    $('.password_confirmation_register_reveal').attr('type', 'text');

                } else {

                    $('.eye_off_register').addClass('d-none');
                    $('.eye_open_register').removeClass('d-none');
                    $('.password_register_reveal').attr('type', 'password');
                    $('.password_confirmation_register_reveal').attr('type', 'password');

                }
            });

            $('.reveal_password_login').click(function() {
                /* REVELER LE PASSWORD LOGIN*/
                if (!$('.eye_open_login').hasClass('d-none')) {

                    $('.eye_open_login').addClass('d-none');
                    $('.eye_off_login').removeClass('d-none');
                    $('.password_login_reveal').attr('type', 'text');

                } else {

                    $('.eye_off_login').addClass('d-none');
                    $('.eye_open_login').removeClass('d-none');
                    $('.password_login_reveal').attr('type', 'password');

                }
            });

        });

    </script>
@endsection
