<div class="form-box">
    <form method="post" action="{{route("faculties.update", $faculty)}}">
        {{ csrf_field() }}
        {{method_field('PUT')}}
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input id="name" type="text" name="name" class="form-control" placeholder="Faculty name" value="{{$faculty->name}}" required>
                    @error('name')
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
