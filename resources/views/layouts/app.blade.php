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

    <!-- JQuery && AXIOS && AJAX-->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.0/axios.min.js" rel="stylesheet">

    <!-- LEAFLET -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
        integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
        crossorigin="" />



</head>

<body>
    <nav class="bg_gradient_2 p-3 shadow-sm">
        <div class="d-sm-flex justify-content-between align-items-center">
            <div class="mq_flex">
                <a class="mq_margin_bottom btn btn-primary p_texte_1 text-white mr-4 media_button_welcome_page_nav"
                    href="{{ url('/') }}">
                    <img src="{{ asset('img/stethoscope.png') }}" alt="" class="icon_img media_icon_nav">
                    aubonmedecin.com
                </a>
                <a class="btn btn-primary p_texte_1 text-white mr-4 media_button_welcome_page_nav"
                    href="{{ url('contact_page') }}">
                    <img src="{{ asset('img/email.png') }}" alt="" class="icon_img media_icon_nav"> Contactez-nous
                </a>
            </div>

            @guest
                <div class="d-sm-flex justify-content-around align-items-center">
                    <div class="mq_flex">
                        <a class="mq_margin_bottom btn btn-primary p_texte_1 text-white mr-4 media_button_welcome_page_nav"
                            href="{{ route('login') }}"><img src="{{ asset('img/login.png') }}" alt=""
                                class="icon_img media_icon_nav"> Se connecter</a>
                        <a class="btn btn-primary p_texte_1 text-white media_button_welcome_page_nav"
                            href="{{ route('login') }}"><img src="{{ asset('img/sign-in.png') }}" alt=""
                                class="icon_img media_icon_nav"> S'enregistrer</a>
                    </div>
                @else
                    <div class="d-sm-flex justify-content-around align-items-center">
                        <div class="mq_flex_2 d-flex">
                            <a class="mq_margin_bottom btn btn-primary p_texte_1 text-white mr-4 media_button_welcome_page_nav"
                                href="{{ route('accueil_compte') }}">
                                <img src="{{ asset('img/espace-personnel.png') }}" alt=""
                                    class="icon_img media_icon_nav"> Mon espace
                                personnel
                            </a>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="btn_logout_width btn btn-primary p_texte_1 text-white media_button_welcome_page_nav"
                                    href="{{ route('logout') }}">
                                    <img src="{{ asset('img/logout.jpg') }}" class="icon_img media_icon_nav">
                                    Déconnexion
                                </button>
                            </form>
                        </div>
                    </div>
                @endguest
            </div>
        </div>
    </nav>

    <div>
        @yield('content')
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


    <!-- LEAFLET -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
        integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
        crossorigin=""></script>
    <script src="{{ asset('js/leaflet_app.js') }}"></script>


    <!-- JS -->
    <script src="{{ asset('js/app.js') }}"></script>

</body>

</html>
