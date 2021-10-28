@php
    $dir=url('/uploads/clearance');
@endphp
@extends('admin')
@section('page-title')
    Manage Clearance
@endsection
@section('content')
    <div class="row">
        <div class="col-12 col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Approve Clearance </h5>
                </div>
                <div class="card-body">
                    @foreach($submissions as $submission)
                        <div class="row align-items-center shadow-md my-3" style="border-bottom: 1px solid #ececec; min-height: 80px;">
                            <div class="col-md-6">
                                <p class="my-0">{{$submission->user()->name}} ({{$submission->user()->matric}})</p>
                                <small class="text-muted">{{$submission->user()->name}}</small>
                            </div>
                            <div class="col-md-3">
                                <input type="hidden" name="submission" value="{{$submission->id}}">
                                @if($submission->submission !== null)
                                    <div id="hh">
                                        <img id="status" src="{{url("/public/assets/images/".$submission->status.".jpg")}}" width="70">
                                        <a target="_blank" class="btn btn-outline-dark" href="{{$dir.'/'.$submission->submission}}">View Submission</a>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-3">
                                <button type="button" class="btn btn-success align-items-center update" data-id="{{$submission->id}}" data-value="approved" data-url="{{route("submissions.update", $submission)}}"><span style="margin-left: 10px;">Approve</span></button>
                                <button type="button" class="btn btn-danger align-items-center update" data-id="{{$submission->id}}" data-value="rejected" data-url="{{route("submissions.update", $submission)}}"><span style="margin-left: 10px;">Reject</span></button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
@push("scripts")
<script>
    $(".update").each(function () {
        $(this).on("click", function (e) {
            e.preventDefault();
            var url = $(this).data("url");
            var status = $(this).data("value");
            var id = $(this).data("id");
            var _this = $(this);
            var img = "{{url("/public/assets/images/")}}";
            $.ajax({
                url: url,
                type: "PATCH",
                cache: false,
                data: {
                    status: status,
                    id: id,
                    _method: "PATCH"
                },
                success: function (data) {
                    _this.parent().parent().find("#status").attr("src", img+"/"+data.status+".jpg");
                    show_toastr('Success', data.message, 'success');
                },
                error: function (data) {
                    show_toastr('Error', data.message, 'error');
                }
            });
        });
    });
</script>
@endpush
