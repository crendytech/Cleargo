<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"><!-- CSRF Token -->

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Cleargo - @yield('page-title')</title>

    <link href="{{ asset("assets/css/app.css") }}" rel="stylesheet">
    @stack('css-page')
</head>

<body>
<div class="wrapper">
    @yield("menu")

    <div class="main">
        @yield("header")

        <main class="content">
            <div class="container-fluid p-0">


                <h1 class="h3 mb-3">@yield("page-title")</h1>
                @yield('content')

            </div>
        </main>

        @yield("footer")
    </div>
</div>

<script src="{{ asset("assets/js/jquery.js") }}"></script>
<script src="{{ asset('assets/js/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
<script src="{{ asset('assets/js/custom.js') }}"></script>
@stack('scripts')
@if($message = Session::get('success'))
    <script>
        show_toastr('Success', '{!! $message !!}', 'success');
    </script>
@endif
@if($message = Session::get('error'))
    <script>
        show_toastr('Error', '{!! $message !!}', 'error');
    </script>
@endif

</body>

</html>
