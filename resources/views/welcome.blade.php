<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Switch Template</title>
    <link href="https://fonts.googleapis.com/css?family=Heebo:400,700|IBM+Plex+Sans:600" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset("assets/css/style.css") }}">
    <script src="https://unpkg.com/scrollreveal@4.0.0/dist/scrollreveal.min.js"></script>
</head>
<body class="has-animations lights-off">
<div class="body-wrap">
    <header class="site-header">
        <div class="container">
            <div class="site-header-inner">
                <div class="brand header-brand">
                    <h1 class="m-0">
                        <a href="{{route("index")}}">
                            <img class="header-logo-image asset-dark" style="display: inline-block;" src="{{ asset("assets/images/logo-dark.svg") }}" alt="Logo"> <span style="color: white; font-size: 28px;">ClearGo</span>
                        </a>
                    </h1>
                </div>
            </div>
        </div>
    </header>

    <main>
        <section class="hero">
            <div class="container">
                <div class="hero-inner">
                    <div class="hero-copy">
                        <h1 class="hero-title mt-0">Clearance Management System</h1>
                        <p class="hero-paragraph">This Project aims at Digitizing and Simplifying Final Clearance for Universities. A Case Study in Uniosun, Osogbo.</p>
                        <div class="hero-cta">
                            <a class="button button-primary" href="{{route("login.custom")}}">Login</a>
                            <a class="button button-primary" style="background: linear-gradient(to right, #FFBC48 0, #FE7E1F 100%); color: #fefefe;" href="{{route("student.register")}}">Create an account</a>
                        </div>
                    </div>
                    <div class="hero-media">
                        <div class="header-illustration">
                            <img class="header-illustration-image asset-light" src="{{ asset("assets/images/header-illustration-light.svg") }}" alt="Header illustration">
                            <img class="header-illustration-image asset-dark" src="{{ asset("assets/images/header-illustration-dark.svg") }}" alt="Header illustration">
                        </div>
                        <div class="hero-media-illustration">
                            <img class="hero-media-illustration-image asset-light" src="{{ asset("assets/images/hero-media-illustration-light.svg") }}" alt="Hero media illustration">
                            <img class="hero-media-illustration-image asset-dark" src="{{ asset("assets/images/hero-media-illustration-dark.svg") }}" alt="Hero media illustration">
                        </div>
                        <div class="hero-media-container">
                            <img class="hero-media-image asset-light" src="{{ asset("assets/images/hero-media-light.svg") }}" alt="Hero media">
                            <img class="hero-media-image asset-dark" src="{{ asset("assets/images/hero-media-dark.svg") }}" alt="Hero media">
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

</div>

<script src="{{ asset("assets/js/main.min.js") }}"></script>
</body>
</html>
