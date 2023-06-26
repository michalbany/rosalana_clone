<!DOCTYPE html>
<html lang="cs">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title')</title>
        <link rel="icon" href="{{ asset('images/icon.png') }}" sizes="128x128" type="image/png">
        <link rel="stylesheet" href="{{ asset('css/login.css') }}">
        <link rel="stylesheet" href="{{ asset('css/animations.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" charset="utf-8"></script>
        <script src="{{ asset('js/login.js') }}" charset="utf-8"></script>
    </head>
    <body>
    <div class="container">
            <div class="content">
                <!--funkce asset generuje cestu k této složce ať je kdekoli-->
                <div class="title">
                <img src="{{ asset('images/icon.png') }}" alt="logo">
                        <h3>Rosalana</h3>
                        
                </div>
                @yield('content')
            </div>
            <div class="image"> <!--background image-->
                <div class="overlay">
                    <h3>
                    Je čas probudit <br>vaši <strong>kreativitu</strong>! 
                </h3>
                <!--IDEA: toto muze byt odkaz na registraci treba-->
                <p>Objev co je v tobě<i class="icon fa-solid fa-arrow-right"></i></p>
                </div>
        </div>
    </div>

    <div class="footer">
    <!--VERSION 2.0-->
    <p>Rosalana OPEN BETA 2.0</p>
    <div class="links">

        <a href="#">Nahlásit problém</a>
        <a href="#">Podmínky použití</a>
        <a href="#">Ochrana osobních údajů</a>
        <a href="#">O aplikaci</a>
        <a href="#">Pomoc</a>
    </div>    
    </div>
    
    @yield('scripts')
    
    </body>
</html>
