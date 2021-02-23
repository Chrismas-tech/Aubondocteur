@extends('layouts.app')
@section('extra-js')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endsection
@section('content')

    <div class="jumbotron text-primary bg_photo_3 min_height m-0 d-flex justify-content-center">

        <div class="bg-white mt-3 p-4 jumb_1_vignette">

            @if (Session::has('message'))
                <div class="text-center">
                    <h1 class="lobster text-success">{{ Session::get('message') }}</h1>
                </div>
            @else
                <div class="text-center">
                    <h1 class="display-4 lobster">Contactez-nous</h1>
                </div>
            @endif


            <div class="" style="width:80%;margin:auto;">

                <form action="{{ route('contact_form_send') }}" method="POST">
                    @csrf
                    <div>
                        <label for="name" class="col-form-label"></label>

                        <div class="input-group-lg">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                placeholder="Votre nom" value="{{ old('name') }}">

                            @error('name')
                                <div class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="email" class="text-white col-form-label"></label>

                        <div class="input-group-lg">
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                                value="{{ old('email') }}" placeholder="Votre email">

                            @error('email')
                                <div class="invalid-feedback role=" alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="message" class="text-white col-form-label"></label>

                        <div class="input-group-lg">

                            <textarea class="form-control @error('message') is-invalid @enderror" id="message" rows="10"
                                placeholder="Votre message" name="message">{{ old('message') }}</textarea>

                            @error('message')
                                <div class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div  class="d-flex justify-content-center mt-3">
                        <div class="g-recaptcha" data-sitekey="6Lc772QaAAAAANbFVholjUJylbRyJkXcnDpGplR6">
                            @if ($errors->has('g-recaptcha-response'))
                            <div class="invalid-feedback" role="alert">
                                <strong>Vous devez cliquer sur le captcha</strong>
                            </div>
                            @endif
                        </div>
                    </div>


                    <div class="text-center mt-3">
                        <div>
                            <button type="submit" class="btn btn-primary btn-lg">
                                Envoyer le message
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
