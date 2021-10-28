@php
    $dir= public_path("assets");
@endphp
        <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"><!-- CSRF Token -->

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Clearance Management System</title>
    <style>
        body{
            font-family: "Agency FB";
        }
    </style>
</head>

<body>
<div class="wrapper">
    <div class="main">
        <main class="content">
            <div style="width: 600px; margin: 0 auto; padding: 20px;">
                <div class="row">
                    <div class="col-8 ml-auto mr-auto">
                        <div class="card py-5">
                            <div style="text-align: left;"><img src="assets/images/uniosun logo.jpg" class="text-left" style="height: 80px; width: 80px; text-align: left; margin-top: 20px;" alt=""></div>
                            <div>

                                <h3  style="text-align: center;">Osun State University</h3>
                                <h3  style="text-align: center;">Osun State University Clearance Report  </h3>

                            </div>
                            <div class="card-header" style="background: #eee; height: 100px; padding: 20px;">
                                <table>
                                    <tr>
                                        <td width="250"><p style="font-size: 16px;"> Name:<span style="font-weight: bold;">{{\Auth::user()->name}} </span></p></td>
                                        <td width="250"><p style="font-size: 16px;">Matric: <span style="font-weight: bold;">{{\Auth::user()->matric}} </span></p></td>
                                    </tr>
                                    <tr>
                                        <td width="250"><p style="font-size: 16px;">Department: <span style="font-weight: bold;">{{\Auth::user()->department()->name}} </span></p></td>
                                        <td width="250"><p style="font-size: 16px;">Faculty: <span style="font-weight: bold;">{{\Auth::user()->faculty()->name}} </span></p></td>
                                    </tr>
                                </table>
                            </div>
                            <div style="clear: both;"></div>
                            <div class="card-body">
                                <div style="border-bottom: 1px solid #ececec; padding: 20px; min-height: 80px;">
                                    <table>
                                        @foreach($clearances as $clearance)
                                            <tr style="height: 70px; border-bottom: 1px solid #333;">
                                                <td width="200" style="height: 70px; border-bottom: 1px solid #eee;">
                                                    <p style="margin-bottom: 10px;">{{$clearance->name}}</p>
                                                    <small class="text-muted">{{$clearance->description}}</small>
                                                </td>
                                                <td width="100" style="height: 70px; border-bottom: 1px solid #eee;">
                                                    @if($clearance->submission() !== null)
                                                        <div id="hh">
                                                            <img src="{{$dir."/images/".$clearance->submission()->status.".jpg"}}" width="70">
                                                        </div>
                                                    @endif
                                                </td>
                                                <td width="100" style="height: 70px; border-bottom: 1px solid #eee;">
                                                    {{$clearance->submission()->updated_at}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
</body>
</html>
