@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
             
            </div>
        </div>
    </div>
</div>


<div class="jumbotron text-primary bg_photo_3 min_height d-flex justify-content-center mb-0">

    <div class="bg-white mt-3 jumb_1_vignette d-flex justify-content-center align-items-center">
        <div>

            <div class="text-center">
                <h1 class="display-3 lobster mt-5 mb-3">Réinitialiser votre mot de passe</h1>
            </div>


            <div class="card-body">
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="input-group-lg">
                       
                        <div class="mb-3">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus placeholder="Votre email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="input-group-lg">
                      

                        <div class="mb-3">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Votre nouveau mot de passe">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="input-group-lg">

                        <div class="mb-3">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirmer votre nouveau mot de passe">
                        </div>
                    </div>

                    <div class="form-group row mb-0 mt-5">
                        <div class=" offset-md-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                Réinitialiser votre mot de passe
                            </button>
                        </div>
                    </div>
                </form>
            </div>

        
        </div>
    </div>
</div>

@endsection
