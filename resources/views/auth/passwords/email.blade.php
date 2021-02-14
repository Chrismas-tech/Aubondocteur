@extends('layouts.app')

@section('content')
@if (session('status'))
<div class="alert alert-success m-0" role="alert">
    {{ session('status') }}
</div>
@endif

    <div class="jumbotron text-primary bg_photo_3 min_height d-flex justify-content-center mb-0">

        <div class="bg-white mt-3 jumb_1_vignette d-flex justify-content-center align-items-center">
            <div>

                <div class="text-center">
                    <h1 class="display-3 lobster mt-5 mb-5">Mot de passe oublié ?</h1>
                </div>

                <div>

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="input-group-lg">

                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                                placeholder="Votre email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                        </div>

                        <div class="text-center mt-5">
                            <button type="submit" class="btn btn-primary btn-lg">
                                Réinitialiser le mot de passe
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
