@extends('app')

@section('content')
    <main class="login-form">
        <div class="cotainer">
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <div class="card">
                        <div style="text-align: center;"><img src="{{ asset("assets/images/uniosun logo.jpg") }}" class="text-center" style="height: 100px; width: 100px; text-align: center; margin-top: 20px;" alt=""></div>
                        <h3 class="card-header text-center">Register For Clearance</h3>
                        <div class="card-body">
                            <form method="POST" id="form" action="{{ route('student.submit') }}" autocomplete="off">
                                @csrf
                                <div class="form-group mb-3">
                                    <label for="matric">Enter your Matric Number</label>
                                    <input type="text" placeholder="Matric" id="matric" class="form-control" name="matric" required
                                           autofocus>
                                    <span class="text-success" id="msg">{{ $errors->first('matric') }}</span>
                                    @if ($errors->has('matric'))
                                        <span class="text-danger">{{ $errors->first('matric') }}</span>
                                    @endif
                                </div>

                                <div class="form-group mb-3" id="pass" style="display: none">
                                    <label for="password"></label><input type="password" placeholder="Choose Password" id="password" class="form-control" name="password" autocomplete="off" required>
                                    @if ($errors->has('password'))
                                        <span class="text-danger">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>

                                <div class="d-grid mx-auto">
                                    <button type="submit" id="submit" class="btn btn-dark btn-block">Check</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@push("scripts")
<script>
    $("#submit").on("click", function (e) {
        var password = $("#password").val();
        if(password !== "")
        {
            $("#form").submit();
        }else {
            e.preventDefault();
            var val = $("#matric").val();
            $.post("{{route("matric.check")}}", {matric: val}, function (data) {
                var msg = $("#msg");
                if(data.status)
                {
                    $("#submit").html("Submit");
                    $("#pass").css("display", "block");
                    msg.removeClass("text-danger").addClass("text-success").html("Matric found.");
                }else {
                    msg.removeClass("text-success").addClass("text-danger").html("Matric not found. Contact ICT");
                }
            });
        }
    })
</script>
@endpush
