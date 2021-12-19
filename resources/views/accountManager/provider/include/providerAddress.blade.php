<div class="col-md-6 col-xl-4 mb-2">
    <div class="address-div mb-2">
        <label class="font-weight-bold d-block">Address
            <span class="text-danger">*</span>
        </label>
        <div class="input-group mb-2">
            <input type="text" class="form-control form-control-sm" placeholder="Street" name="address_name"
                   value="{{$provider->address_name}}" required>
            <button type="button" class="btn btn-sm btn-primary ml-1" title="Add" id="add_more_address"><i
                    class="ri-add-line"></i></button>
            <button class="btn btn-sm btn-danger ml-1" type="button" title="Delete"><i class="fa fa-trash"
                                                                                       aria-hidden="true"></i></button>
        </div>
        <input type="text" class="form-control form-control-sm mb-2" name="street" placeholder="Street"
               value="{{$provider->street}}" required>
        <input type="text" class="form-control form-control-sm mb-2" name="city" placeholder="City"
               value="{{$provider->city}}" required>
        <div class="row">
            <div class="col-md-6">
                <select class="form-control form-control-sm" name="state" required>
                    <option>State</option>
                    <option value="AL" {{$provider->state == "AL" ? 'selected' : ''}}>AL</option>
                    <option value="AK" {{$provider->state == "AK" ? 'selected' : ''}}>AK</option>
                    <option value="AZ" {{$provider->state == "AZ" ? 'selected' : ''}}>AZ</option>
                    <option value="AR" {{$provider->state == "AR" ? 'selected' : ''}}>AR</option>
                    <option value="CA" {{$provider->state == "CA" ? 'selected' : ''}}>CA</option>
                    <option value="CO" {{$provider->state == "CO" ? 'selected' : ''}}>CO</option>
                    <option value="CT" {{$provider->state == "CT" ? 'selected' : ''}}>CT</option>
                    <option value="DE" {{$provider->state == "DE" ? 'selected' : ''}}>DE</option>
                    <option value="DC" {{$provider->state == "DC" ? 'selected' : ''}}>DC</option>
                    <option value="FL" {{$provider->state == "FL" ? 'selected' : ''}}>FL</option>
                    <option value="GA" {{$provider->state == "GA" ? 'selected' : ''}}>GA</option>
                    <option value="HI" {{$provider->state == "HI" ? 'selected' : ''}}>HI</option>
                    <option value="ID" {{$provider->state == "ID" ? 'selected' : ''}}>ID</option>
                    <option value="IL" {{$provider->state == "IL" ? 'selected' : ''}}>IL</option>
                    <option value="IN" {{$provider->state == "IN" ? 'selected' : ''}}>IN</option>
                    <option value="IA" {{$provider->state == "IA" ? 'selected' : ''}}>IA</option>
                    <option value="KS" {{$provider->state == "KS" ? 'selected' : ''}}>KS</option>
                    <option value="KY" {{$provider->state == "KY" ? 'selected' : ''}}>KY</option>
                    <option value="LA" {{$provider->state == "LA" ? 'selected' : ''}}>LA</option>
                    <option value="ME" {{$provider->state == "ME" ? 'selected' : ''}}>ME</option>
                    <option value="MD" {{$provider->state == "MD" ? 'selected' : ''}}>MD</option>
                    <option value="MA" {{$provider->state == "MA" ? 'selected' : ''}}>MA</option>
                    <option value="MI" {{$provider->state == "MI" ? 'selected' : ''}}>MI</option>
                    <option value="MN" {{$provider->state == "MN" ? 'selected' : ''}}>MN</option>
                    <option value="MS" {{$provider->state == "MS" ? 'selected' : ''}}>MS</option>
                    <option value="MO" {{$provider->state == "MO" ? 'selected' : ''}}>MO</option>
                    <option value="MT" {{$provider->state == "MT" ? 'selected' : ''}}>MT</option>
                    <option value="NE" {{$provider->state == "NE" ? 'selected' : ''}}>NE</option>
                    <option value="NV" {{$provider->state == "NV" ? 'selected' : ''}}>NV</option>
                    <option value="NH" {{$provider->state == "NH" ? 'selected' : ''}}>NH</option>
                    <option value="NJ" {{$provider->state == "NJ" ? 'selected' : ''}}>NJ</option>
                    <option value="NM" {{$provider->state == "NM" ? 'selected' : ''}}>NM</option>
                    <option value="NY" {{$provider->state == "NY" ? 'selected' : ''}}>NY</option>
                    <option value="NC" {{$provider->state == "NC" ? 'selected' : ''}}>NC</option>
                    <option value="ND" {{$provider->state == "ND" ? 'selected' : ''}}>ND</option>
                    <option value="OH" {{$provider->state == "OH" ? 'selected' : ''}}>OH</option>
                    <option value="OK" {{$provider->state == "OK" ? 'selected' : ''}}>OK</option>
                    <option value="OR" {{$provider->state == "OR" ? 'selected' : ''}}>OR</option>
                    <option value="PA" {{$provider->state == "PA" ? 'selected' : ''}}>PA</option>
                    <option value="PR" {{$provider->state == "PR" ? 'selected' : ''}}>PR</option>
                    <option value="RI" {{$provider->state == "RI" ? 'selected' : ''}}>RI</option>
                    <option value="SC" {{$provider->state == "SC" ? 'selected' : ''}}>SC</option>
                    <option value="SD" {{$provider->state == "SD" ? 'selected' : ''}}> SD</option>
                    <option value="TN" {{$provider->state == "TN" ? 'selected' : ''}}>TN</option>
                    <option value="TX" {{$provider->state == "TX" ? 'selected' : ''}}>TX</option>
                    <option value="UT" {{$provider->state == "UT" ? 'selected' : ''}}>UT</option>
                    <option value="VT" {{$provider->state == "VT" ? 'selected' : ''}}>VT</option>
                    <option value="VA" {{$provider->state == "VA" ? 'selected' : ''}}>VA</option>
                    <option value="WA" {{$provider->state == "WA" ? 'selected' : ''}}>WA</option>
                    <option value="WV" {{$provider->state == "WV" ? 'selected' : ''}}>WV</option>
                    <option value="WI" {{$provider->state == "WI" ? 'selected' : ''}}>WI</option>
                    <option value="WY" {{$provider->state == "WY" ? 'selected' : ''}}>WY</option>
                    <option value="AA" {{$provider->state == "AA" ? 'selected' : ''}}>AA</option>
                    <option value="AE" {{$provider->state == "AE" ? 'selected' : ''}}>AE</option>
                    <option value="AP" {{$provider->state == "AP" ? 'selected' : ''}}>AP</option>
                    <option value="GU" {{$provider->state == "GU" ? 'selected' : ''}}>GU</option>
                    <option value="VI" {{$provider->state == "VI" ? 'selected' : ''}}>VI</option>
                    <option value="AB" {{$provider->state == "AB" ? 'selected' : ''}}>AB</option>
                    <option value="BC" {{$provider->state == "BC" ? 'selected' : ''}}>BC</option>
                    <option value="MB" {{$provider->state == "MB" ? 'selected' : ''}}>MB</option>
                    <option value="NB" {{$provider->state == "NB" ? 'selected' : ''}}>NB</option>
                    <option value="NL" {{$provider->state == "NL" ? 'selected' : ''}}>NL</option>
                    <option value="NT" {{$provider->state == "NT" ? 'selected' : ''}}>NT</option>
                    <option value="NS" {{$provider->state == "NS" ? 'selected' : ''}}>NS</option>
                    <option value="NU" {{$provider->state == "NU" ? 'selected' : ''}}>NU</option>
                    <option value="ON" {{$provider->state == "ON" ? 'selected' : ''}}>ON</option>
                    <option value="PE" {{$provider->state == "PE" ? 'selected' : ''}}>PE</option>
                    <option value="QC" {{$provider->state == "QC" ? 'selected' : ''}}>QC</option>
                    <option value="SK" {{$provider->state == "SK" ? 'selected' : ''}}>SK</option>
                    <option value="YT" {{$provider->state == "YT" ? 'selected' : ''}}>YT</option>
                </select>
            </div>
            <div class="col-md-6">
                <input type="text" class="form-control form-control-sm" name="zip" value="{{$provider->zip}}"
                       placeholder="Zip" required>
            </div>
        </div>
    </div>


    @foreach($provider_address as $paddress)
        <div class="address-div mb-2 existsaddresssection">
            <label class="font-weight-bold d-block">Address
                <span class="text-danger">*</span>
            </label>
            <div class="input-group mb-2">
                <input type="text" class="form-control form-control-sm" placeholder="Address Name"
                       name="new_address_name[]"
                       value="{{$paddress->address_name}}" required>
                <input type="hidden" class="form-control form-control-sm" name="edit_address_id[]"
                       value="{{$paddress->id}}" required>
                <button class="btn btn-sm btn-danger ml-1 deleteexistsaddress" data-id="{{$paddress->id}}" type="button"
                        title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button>
            </div>
            <input type="text" class="form-control form-control-sm mb-2" name="new_street[]" placeholder="Street"
                   value="{{$paddress->street}}" required>
            <input type="text" class="form-control form-control-sm mb-2" name="new_city[]" placeholder="City"
                   value="{{$paddress->city}}" required>
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
                    <input type="text" class="form-control form-control-sm" name="new_zip[]" value="{{$paddress->zip}}"
                           placeholder="Zip" required>
                </div>
            </div>
        </div>
    @endforeach


    <div class="new_address"></div>
</div>



