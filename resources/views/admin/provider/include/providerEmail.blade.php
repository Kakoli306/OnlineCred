<div class="col-md-4">
    <div class="email_div mb-2">
        <label class="font-weight-bold d-block">Email<span class="text-danger">*</span>
        </label>
        <div class="input-group">
            <input type="email" class="form-control form-control-sm" name="email" value="{{$provider->email}}" required>
            <button type="button" class="btn btn-sm btn-primary ml-1" id="add_more_emal">
                <i class="ri-add-line"></i>
            </button>
            <button class="btn btn-sm btn-danger ml-1" type="button">
                <i class="fa fa-trash" aria-hidden="true"></i>
            </button>
        </div>
    </div>

    @foreach($provider_emails as $pemail)
    <div class="email_div mb-2 existsemailsection">
        <label class="font-weight-bold d-block">Email<span class="text-danger">*</span>
        </label>
        <div class="input-group">
            <input type="email" class="form-control form-control-sm" name="new_email[]" value="{{$pemail->email}}" required>
            <input type="hidden" class="form-control form-control-sm" name="edit_email_id[]" value="{{$pemail->id}}">
            <button class="btn btn-sm btn-danger ml-1 deleteexistsemail" type="button" data-id="{{$pemail->id}}">
                <i class="fa fa-trash" aria-hidden="true"></i>
            </button>
        </div>
    </div>
    @endforeach


    <div class="new_email"></div>
</div>
