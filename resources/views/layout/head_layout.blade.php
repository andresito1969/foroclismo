<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">

        <title>Foroclismo</title>

        <!-- Styles and fonts -->
        <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap-grid.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap-reboot.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/animatecss/animate.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/dropdown/css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/theme/css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/gallery/style.css') }}">
        <link rel="preload" href="https://fonts.googleapis.com/css?family=Inter+Tight:100,200,300,400,500,600,700,800,900,100i,200i,300i,400i,500i,600i,700i,800i,900i&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">
        <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter+Tight:100,200,300,400,500,600,700,800,900,100i,200i,300i,400i,500i,600i,700i,800i,900i&display=swap"></noscript>

    </head>
    <body>
        @extends('layout.navbar') 
        <!--Generic App layout-->
        <section data-bs-version="5.1" class="header7 cid-tLeaLmEeFr" id="header07-h" style="margin-top: 10%">
            <div class="align-center container">
                <div class="row justify-content-center">
                    <div class="mbr-figure col-12 col-md-12">
                        @yield('content')
                    </div>
                </div>
            </div>
        </section>

        <!-- Form layout para register y login-->
        <section data-bs-version="5.1" class="form5 cid-tJS9pBcTSa" id="form02-6" style="margin-top: 5%">
            <div class="container">
                @yield('form')
            </div>
        </section>
    </body>
</html>