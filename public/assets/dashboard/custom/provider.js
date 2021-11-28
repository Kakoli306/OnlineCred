$('#add_more_phone').click(function () {
    $('.new_phone').append(
        `
           <div class="phone_div mb-2 removephondiv">
        <label class="font-weight-bold d-block">Phone
            <span class="text-danger">*</span>
        </label>
        <div class="input-group">
            <input type="text" class="form-control form-control-sm phone_appned" name="new_phone[]" data-mask="(000)-000-0000" pattern=".{14,}" required>
            <input type="hidden" class="form-control form-control-sm" name="edit_phone_id[]">

            <button class="btn btn-sm btn-danger ml-1 delPhn_btn" type="button" id="">
                <i class="fa fa-trash" aria-hidden="true"></i>
            </button>
        </div>
    </div>
        `
    );


    $('.phone_appned').mask('(000)-000-0000');
    $('.phone_appned').pattern = ".{14,}";


    $('.delPhn_btn').click(function () {
        $(this).closest('.removephondiv').remove();
        return false;
    })
});


$('#add_more_emal').click(function () {
    $('.new_email').append(
        `
            <div class="email_div mb-2 removeemdiv">
        <label class="font-weight-bold d-block">Email<span class="text-danger">*</span>
        </label>
        <div class="input-group">
            <input type="email" class="form-control form-control-sm" name="new_email[]" required>
            <input type="hidden" class="form-control form-control-sm" name="edit_email_id[]">

            <button class="btn btn-sm btn-danger ml-1 delem_btn" type="button">
                <i class="fa fa-trash" aria-hidden="true"></i>
            </button>
        </div>
    </div>
        `
    );

    $('.delem_btn').click(function () {
        $(this).closest('.removeemdiv').remove();
        return false;
    })
});

$('#add_more_address').click(function () {
    $('.new_address').append(
        `
            <div class="address-div mb-2 removeadddiv">
        <label class="font-weight-bold d-block">Address
            <span class="text-danger">*</span>
        </label>
        <div class="input-group mb-2">
            <input type="text" class="form-control form-control-sm" placeholder="Address Name" name="new_address_name[]" required>
            <input type="hidden" class="form-control form-control-sm" name="edit_address_id[]" required>

            <button class="btn btn-sm btn-danger ml-1 delad_btn" type="button" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button>
        </div>
        <input type="text" class="form-control form-control-sm mb-2" name="new_street[]" placeholder="Street"  required>
        <input type="text" class="form-control form-control-sm mb-2" name="new_city[]" placeholder="City"  required>
        <div class="row">
            <div class="col-md-6">
                <select class="form-control form-control-sm" name="new_state[]" required>
                    <option>State</option>
                    <option value="AL">AL</option>
                    <option value="AK">AK</option>
                    <option value="AZ">AZ</option>
                    <option value="AR">AR</option>
                    <option value="CA">CA</option>
                    <option value="CO">CO</option>
                    <option value="CT">CT</option>
                    <option value="DE">DE</option>
                    <option value="DC">DC</option>
                    <option value="FL">FL</option>
                    <option value="GA">GA</option>
                    <option value="HI">HI</option>
                    <option value="ID">ID</option>
                    <option value="IL">IL</option>
                    <option value="IN">IN</option>
                    <option value="IA">IA</option>
                    <option value="KS">KS</option>
                    <option value="KY">KY</option>
                    <option value="LA">LA</option>
                    <option value="ME">ME</option>
                    <option value="MD">MD</option>
                    <option value="MA">MA</option>
                    <option value="MI">MI</option>
                    <option value="MN">MN</option>
                    <option value="MS">MS</option>
                    <option value="MO">MO</option>
                    <option value="MT">MT</option>
                    <option value="NE">NE</option>
                    <option value="NV">NV</option>
                    <option value="NH">NH</option>
                    <option value="NJ">NJ</option>
                    <option value="NM">NM</option>
                    <option value="NY">NY</option>
                    <option value="NC">NC</option>
                    <option value="ND">ND</option>
                    <option value="OH">OH</option>
                    <option value="OK">OK</option>
                    <option value="OR">OR</option>
                    <option value="PA">PA</option>
                    <option value="PR">PR</option>
                    <option value="RI">RI</option>
                    <option value="SC">SC</option>
                    <option value="SD">SD</option>
                    <option value="TN">TN</option>
                    <option value="TX">TX</option>
                    <option value="UT">UT</option>
                    <option value="VT">VT</option>
                    <option value="VA">VA</option>
                    <option value="WA">WA</option>
                    <option value="WV">WV</option>
                    <option value="WI">WI</option>
                    <option value="WY">WY</option>
                    <option value="AA">AA</option>
                    <option value="AE">AE</option>
                    <option value="AP">AP</option>
                    <option value="GU">GU</option>
                    <option value="VI">VI</option>
                    <option value="AB">AB</option>
                    <option value="BC">BC</option>
                    <option value="MB">MB</option>
                    <option value="NB">NB</option>
                    <option value="NL">NL</option>
                    <option value="NT">NT</option>
                    <option value="NS">NS</option>
                    <option value="NU">NU</option>
                    <option value="ON">ON</option>
                    <option value="PE">PE</option>
                    <option value="QC">QC</option>
                    <option value="SK">SK</option>
                    <option value="YT">YT</option>
                </select>
            </div>
            <div class="col-md-6">
                <input type="text" class="form-control form-control-sm" name="new_zip[]" placeholder="Zip" required>
            </div>
        </div>
    </div>
        `
    );


    $('.delad_btn').click(function () {
        $(this).closest('.removeadddiv').remove();
        return false;
    })
})
