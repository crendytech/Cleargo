<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"><!-- CSRF Token -->

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Osun State University CMS @yield('page-title')</title>

    <link href="{{ asset("assets/css/app.css") }}" rel="stylesheet">
    @stack('css-page')
</head>

<body>
<div class="wrapper">
    @include('partial.menu')

    <div class="main">
        @include('partial.header')

        <main class="content">
            <div class="container-fluid p-0">


                <h1 class="h3 mb-3">@yield("page-title")</h1>
                @yield('content')

            </div>
        </main>

        @include('partial.footer')
    </div>
</div>

<div class="modal fade" id="commonModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="h4 font-weight-400 float-left modal-title" id="exampleModalLabel"></h4>
                <a href="#" class="more-text widget-text float-right close-icon" data-dismiss="modal" aria-label="Close">{{__('Close')}}</a>
            </div>
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>

<script src="{{ asset("assets/js/jquery.js") }}"></script>
<script src="{{ asset("assets/js/app.js") }}"></script>
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
