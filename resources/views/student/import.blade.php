<div class="form-box">
    <form method="POST" enctype="multipart/form-data" action="{{route("students.import")}}">
        @csrf
        <div class="row">
        <div class="form-group col-12">
            <div class="float-left col-4">
                <label for="document" class="float-left pt-1 form-control-label">File to import <span class="text-danger">* (.xlsx)</span> </label>
            </div>
            <div class="float-right col-8">
                <input type="hidden" name="emp_doc_id[]" id="" value="">
                <div class="choose-file form-group">
                    <label for="file">
                        <div>Choose File</div>
                        <input class="form-control  @error('file') is-invalid @enderror border-0" required name="file" type="file" id="file" data-filename="file">
                    </label>
                    <p class="file"></p>
                </div>

            </div>

        </div>
        <div class="col-12">
            <input type="submit" value="Import" class="btn btn-primary">
            <input type="button" value="Cancel" class="btn btn-white" data-dismiss="modal">
        </div>
    </div>
    </form>
</div>
