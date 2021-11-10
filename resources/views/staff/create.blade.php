<div class="form-box">
    <form method="post" action="{{route("staffs.store")}}">
        {{ csrf_field() }}
        <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="name">Name</label>
                <input id="name" type="text" name="name" class="form-control" placeholder="Staff Name" required>
                @error('name')
                <span class="invalid-name" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="text" name="email" class="form-control" placeholder="Staff Email" required>
                @error('email')
                <span class="invalid-name" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="type">Type</label>
                <select id="type" name="faculty" class="form-control" required>
                    <option value="faculty">Faculty Officer</option>
                    <option value="department">Departmental Officer</option>
                </select>
                @error('type')
                <span class="invalid-name" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="faculty">Faculty</label>
                <select id="faculty" name="faculty" class="form-control" required>
                    @foreach($faculty as $key => $value)
                        <option value="{{$value}}">{{$key}}</option>
                    @endforeach
                </select>
                @error('faculty')
                <span class="invalid-name" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group" id="dept">
                <label for="department">Department</label>
                <select id="department" name="department" class="form-control" required>

                </select>
                @error('department')
                <span class="invalid-name" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" class="form-control" placeholder="Choose Password" required>
                @error('password')
                <span class="invalid-name" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="col-12">
            <input type="submit" value="Submit" class="btn btn-primary">
            <input type="button" value="Cancel" class="btn btn-white" data-dismiss="modal">
        </div>
    </div>
    </form>
</div>

<script>
    loadDepartment("#faculty");
    $("#faculty").on("change", function (e) {
        loadDepartment(this);
    });

    $("#type").on("change", function (e) {
        loadDepartment("#faculty");
    });

    function loadDepartment(elem)
    {
        var type = $("#type");
        if(type.val() === "faculty")
        {
            var option = '<option value="null">Nil</option>';
            $("#department").html(option);
            $("#dept").show();
        }else {
            val = $(elem).val();
            $.post("{{route("department.fetch")}}", {faculty: val}, function (data) {
                if (data.status) {
                    $("#department").html(data.message);
                    $("#dept").show();
                }
            });
        }
    }
</script>
