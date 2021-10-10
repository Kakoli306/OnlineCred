<div class="col-md-4">
    <div class="phone_div mb-2">
        <label class="font-weight-bold d-block">Phone
            <span class="text-danger">*</span>
        </label>
        <div class="input-group">
            <input type="text" class="form-control form-control-sm" name="phone" value="{{$provider->phone}}" data-mask="(000)-000-0000" pattern=".{14,}" required>
            <button type="button" class="btn btn-sm btn-primary ml-1 addPhn_btn" id="add_more_phone">
                <i class="ri-add-line"></i>
            </button>
        </div>
    </div>



    @foreach($provider_phones as $pphone)
    <div class="phone_div mb-2 removeexistphondiv">
        <label class="font-weight-bold d-block">Phone
            <span class="text-danger">*</span>
        </label>
        <div class="input-group">
            <input type="text" class="form-control form-control-sm" name="new_phone[]" value="{{$pphone->phone}}" data-mask="(000)-000-0000" pattern=".{14,}" required>
            <input type="hidden" class="form-control form-control-sm" name="edit_phone_id[]" value="{{$pphone->id}}">
            <button class="btn btn-sm btn-danger ml-1 existsphonedelete" data-id="{{$pphone->id}}" type="button" >
                <i class="fa fa-trash" aria-hidden="true"></i>
            </button>
        </div>
    </div>
    @endforeach

    <div class="new_phone"></div>
</div>


