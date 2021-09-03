@extends("admin")
@section("page-title")
    Submissions
@endsection
@section("content")
<div class="row">
    <div class="col-12 col-xl-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Submissions<a href="javascript://" data-url="{{ route("clearance.create") }}" class="float-right" data-ajax-popup="true" data-title="Create Clearance">Create</a> </h5>
            </div>
            <div class="table-responsive">
                <table class="table">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Managed by</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody id="result">
                @forelse($submissions as $submission)
                    <tr>
                        <td>{{ $submission->clearance()->name }} </td>
                        <td>{{ $submission->user()->name }} </td>
                        <td>{{ $submission->submission }} </td>
                        <td>{{ $submission->status }} </td>
                        <td class="table-action">
                            <a href="javascript://" data-ajax-popup="true" data-title="Edit Clearance Section" data-url="{{ route("clearance.edit", $clearance) }}">Approve</a>
                            <a href="javascript://" data-message="Are you sure you want to delete?" data-url="{{ route("clearance.destroy", $clearance) }}"  data-cancel="tr" class="delete" title="delete">Decline</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3">No Clearance Section Found</td>
                @endforelse
                </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@push("scripts")
<script>
    deleteData();
    function deleteData()
    {
        $(".delete").on("click", function(e){
            $elem = $(this);
            var confirmation = confirm($elem.data("message"));
            if(confirmation) {
                url = $elem.data("url");
                $.ajax({
                    url: url,
                    type: "POST",
                    data: {
                        _method: 'DELETE'
                    },
                    success: function (data) {
                        // alert(data);
                        // return false;
                        if (data.status) {
                            $elem.closest($elem.data("cancel")).remove();
                            show_toastr('Success', data.message, 'success');
                        } else {
                            show_toastr('Error', data.message, 'error');
                        }
                    },
                    error: function (data) {
                        show_toastr('Error', data.message, 'error');
                    }
                });
            }
        });
    }
    function load_data(query)
    {
        $.ajax({
            url:"/admin/beneficiaries/search/"+query,
            method:"POST",
            data:{_ajax:true},
            success:function(data)
            {
                $('#result').html(data.html);
            }
        });
    }

    $('#searchButton').on("click", function(){
        var search = $("#search").val();
        if(search.length > 4)
        {
            if(search != '')
            {
                $("#result").html("Loading");
                load_data(search);
            }
            else
            {
                alert("Please enter a valid input");
            }
        }else
        {
            alert("Please enter at lease 5 Characters");
        }
    });

</script>
    @endpush