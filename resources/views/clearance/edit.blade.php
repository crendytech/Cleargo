<div class="form-box">
    <form method="post" action="{{route("clearance.update", $clearance)}}">
        {{ csrf_field() }}

        <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="name">Title</label>
                <input id="name" type="text" name="name" class="form-control" placeholder="Clearance Section Title" value="{{ $clearance->name }}" required>
                @error('name')
                <span class="invalid-name" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="type">Type</label>
                <select id="type" name="type" class="form-control" required>
                    <option value="general" @if($clearance->type == "general") selected @endif>General</option>
                    <option value="departmental" @if($clearance->type == "departmental") selected @endif>Departmental</option>
                    <option value="faculty" @if($clearance->type == "faculty") selected @endif>Faculty</option>
                </select>
                @error('type')
                <span class="invalid-name" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group" id="managedBy">
                <label for="managed-by">Managed by</label>
                <select id="managed-by" name="managed_by" class="form-control" required>
                    @if($clearance->type == "faculty")
                        @foreach($faculties as $key => $value)
                            <option value="{{$value}}" @if($clearance->managed_by == $value) selected @endif>{{$key}}</option>
                        @endforeach
                    @else
                        @if($clearance->type == "general")
                        <option value="0" @if($clearance->type == "general" && $clearance->managed_by == 0) selected @endif>Administrator</option>
                        @endif
                        @foreach($departments as $key => $value)
                            <option value="{{$value}}" @if($clearance->managed_by == $value) selected @endif>{{$key}}</option>
                        @endforeach
                    @endif
                </select>
                @error('managed_by')
                <span class="invalid-name" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="description">Instruction</label>
                <textarea id="description" name="description" class="form-control" placeholder="Enter Instructions" required>{{ $clearance->description }}</textarea>
                @error('description')
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
    $("#type").trigger("change");
    $("#type").on("change", function (e) {
        val = $(this).val();
        $.post("{{route("clearance.fetch")}}", {type: val}, function (data) {
            if(data.status)
            {
                $("#managed-by").html(data.message);
                $("#managedBy").show();
            }
        })
    })
</script>
