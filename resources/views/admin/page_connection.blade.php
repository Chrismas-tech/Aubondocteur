<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>aubonmedecin</title>

    <!-- Fonts -->

    <link rel="preconnect" href="https://fonts.gstatic.com">

    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital@1&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital@1&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Domine&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cardo&display=swap" rel="stylesheet">

    <!-- BOOTSTRAP-->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <!-- CSS STYLES-->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">


</head>

<body>
    <div class="my_min_height_admin_connection bg_photo_3 d-flex justify-content-center">
        <div class="bg-white border border-secondary p-5 jumb_1_vignette" style="width:40%;margin:auto">
            <div class="text-center mt-3">
                <h1 class="display-4 lobster text-primary">Administration</h1>
            </div>

            <hr>

            <div style="margin:auto;">

                <form method="POST" action="{{ route('verify_admin_connection') }}" class="mt-3">

                    @csrf

                    <div>
                        <label for="name" class="col-md-4 col-form-label text-md-right"></label>

                        <div class=" input-group input-group-lg">
                            <input id="name" type="text" class="input_text_lg form-rounded" name="name" autocomplete="name" autofocus
                                placeholder="Name...">
                        </div>

                    </div>

                    <div>
                        <label for="password" class="col-md-4 col-form-label text-md-right"></label>
                        <div class="input-group input-group-lg">
                            <input id="password" name="password" type="password" class="input_text_lg form-rounded" name="password"
                                autocomplete="new-password" placeholder="Password...">
                        </div>
                        @error('password')
                            <div class="mt-3">
                                <h4 class="alert alert-danger">{{ $message }}</h4>
                            </div>
                        @enderror
                        @error('name')
                            <div class="mt-3">
                                <h4 class="alert alert-danger">{{ $message }}</h4>
                            </div>
                        @enderror

                        <div class="mt-3">
                            @if (Session::has('error'))
                                <h4 class="alert alert alert-danger">
                                    {{ Session::get('error') }}</h4>
                            @endif
                        </div>
                    </div>

                    <div>
                        <div class="text-center mt-5">
                            <button type="submit" class="btn btn-primary btn-lg p_texte_1 text-white">
                                Se connecter
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div>
        <footer class="text-center bg-primary text-white p-4">
            <h3 class="font-italic m-0 p-0 p_texte_2 text-white media_footer_font_size">Copyright
                &copy; 2020 Christophe Luciani, all Rights Reserved</h3>
        </footer>
    </div>


    <!-- JQUERY AND BOOTSTRAP -->

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"
        integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous">
    </script>

</body>

</html>
