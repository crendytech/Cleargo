@extends("admin")
@section("page-title")
    Staffs
@endsection
@section("content")
<div class="row">
    <div class="col-12 col-xl-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Staffs
                    <a href="javascript://" data-url="{{ route("staffs.create") }}" class="float-right" data-ajax-popup="true" data-title="Create Staffs">Create</a>
                </h5>
            </div>
            <div class="table-responsive">
                <table class="table">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Department</th>
                    <th>Faculty</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody id="result">
                @forelse($staffs as $staff)
                    <tr>
                        <td>{{ $staff->name }} </td>
                        <td>{{ $staff->email }} </td>
                        <td>@if($staff->department_id !== null){{ $staff->department()->name }} @else Nil @endif </td>
                        <td>{{ $staff->faculty()->name }} </td>
                        <td class="table-action">
                            <a href="javascript://" data-ajax-popup="true" data-title="Edit Clearance Section" data-url="{{ route("staffs.edit", $staff) }}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 align-middle"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg> Edit</a>
                            <a href="javascript://" data-message="Are you sure you want to delete?" data-url="{{ route("staffs.destroy", $staff) }}"  data-cancel="tr" class="delete ml-3" title="delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash align-middle"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg> Delete</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3">No Staff Found</td>
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