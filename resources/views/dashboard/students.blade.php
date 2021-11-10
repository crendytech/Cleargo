@php
    $dir=url('/uploads/clearance');
@endphp
@extends('admin')
@section('page-title')
    Clearance Section
@endsection
@section('content')
    <div class="row">
        <div class="col-12 col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h1>Follow the instruction below </h1>
                    <div class="hero-copy">
                        <h3 class="hero-title mt-0">You are required to upload the following Documents </h3>
                        <h5>Scan your documents and covert it to pdf before uploading</h5>
                        <h5>Make sure your print out have approval from each necessary clearance department</h5>



                    </div>
                </div>
                <div class="card-body">
                    @foreach($clearances as $clearance)
                        <form method="post" enctype="multipart/form-data" action="{{route("submissions.store")}}">
                            @csrf
                            <div class="row align-items-center shadow-md my-3" style="border-bottom: 1px solid #ececec; min-height: 80px;">
                                <div class="col-md-6">
                                    <p class="my-0">{{$clearance->name}}</p>
                                    <small class="text-muted">{{$clearance->description}}</small>
                                </div>
                                <div class="col-md-3">
                                    <input type="hidden" name="clearance" value="{{$clearance->id}}">
                                    <div class="choose-file form-group" id="ss" @if($clearance->submission() !== null) style="display: none"@endif>
                                        <label for="file">
                                            <div>Choose File</div>
                                            <input class="form-control  @error('file') is-invalid @enderror border-0" required name="file" type="file" id="file" data-filename="file">
                                        </label>
                                        <p class="file"></p>
                                    </div>
                                    @if($clearance->submission() !== null)
                                    <div id="hh">
                                        <img src="{{url("/assets/images/".$clearance->submission()->status.".jpg")}}" width="70">
                                        <a target="_blank" class="btn btn-outline-dark" href="{{$dir.'/'.$clearance->submission()->submission}}">View Submission</a>
                                    </div>
                                    @endif
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" @if($clearance->submission() != null && $clearance->submission()->status === "approved") disabled @endif class="btn btn-dark align-items-center @if($clearance->submission() !== null) edit @endif" name="submit">@if($clearance->submission() !== null)<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 align-middle"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg> <span style="margin-left: 10px;">Edit</span> @else Upload @endif</button>
                                </div>
                            </div>
                        </form>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
@push("scripts")
<script>
    $(".edit").each(function () {
        $(this).on("click", function (e) {
            if ($(this).html() === "Submit") {

            } else {
                e.preventDefault();
                $(this).parent().parent().find("#ss").show();
                $(this).parent().parent().find("#hh").hide();
                $(this).html("Submit").removeClass("edit");
            }
        });
    });
</script>
@endpush
