@extends('layouts.admin')
@section('headerselect')
    <div class="iq-search-bar">
        <?php
        $practice_name = \App\Models\practice::select('business_name')->where('id', $provider->practice_id)->first();
        ?>
        <h5>
            @if ($practice_name)
                {{$practice_name->business_name}}
            @endif
        </h5>
    </div>
@endsection
@section('admin')
    <div class="iq-card-body">
        <div class="d-flex justify-content-between mb-3">
            <div class="align-self-center">
                <h5><a href="#"
                       class="cmn_a">{{$provider->first_name}} {{$provider->middle_name}} {{$provider->last_name}}</a> |
                    <small>
                        <span class="font-weight-bold text-orange">DOB:</span>
                        {{\Carbon\Carbon::parse($provider->dob)->format('m/d/Y')}} |
                        <span class="font-weight-bold text-orange">Phone:</span>
                        {{$provider->phone}} |
                        <span class="font-weight-bold text-orange">Address:</span>
                        {{$provider->street}}, {{$provider->city}}, {{$provider->state}}, {{$provider->zip}}
                    </small>
                </h5>
            </div>
            <div class="align-self-center">
                <a href="{{route('admin.providers.list',$provider->practice_id)}}" class="btn btn-sm btn-primary">
                    <i class="ri-arrow-left-circle-line"></i>Back
                </a>
            </div>
        </div>
        <div class="d-lg-flex">
            <div class="client_menu mr-2">
                <ul class="nav flex-column setting_menu">
                    <!-- Profile Picture -->
                    <li class="nav-item border-0 text-center">
                        <div class="profile-pic-div">
                            <img src="{{asset('assets/dashboard/')}}/images/man.jpg" class="img-fluid" id="photo"
                                 alt="aba+">
                            <input type="file" id="file" class="d-none">
                            <label for="file" id="uploadBtn">Upload Photo</label>
                        </div>
                    </li>
                    <!--/ Profile Picture -->
                    <li class="nav-item">
                        <a class="nav-link active" href="{{route('admin.provider.info',$provider->id)}}">Provider
                            Info</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('admin.provider.contract',$provider->id)}}">Contracts</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('admin.provider.document',$provider->id)}}">Documents</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('admin.provider.portal',$provider->id)}}">Provider Portal</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('admin.provider.online.access',$provider->id)}}">Online
                            Access</a>
                    </li>
                    {{--                    <li class="nav-item">--}}
                    {{--                        <a class="nav-link" href="{{route('admin.provider.tracking.user',$provider->id)}}">Tracking--}}
                    {{--                            Muster</a>--}}
                    {{--                    </li>--}}
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('admin.provider.activity',$provider->id)}}">Provider
                            Activity</a>
                    </li>
                </ul>
            </div>
            <form action="{{route('admin.provider.info.update')}}" method="post" enctype="multipart/form-data"
                  class="provider-edit-form">
                @csrf
                <div class="all_content flex-fill">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h2 class="common-title">Edit Provider</h2>
                        </div>
                        <div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input" name="is_active"
                                           value="1" {{$provider->is_active == 1 ? 'checked':''}}>Active Provider
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- First Name -->
                        <div class="col-md-4 col-xl-2 mb-2">
                            <label class="font-weight-bold">First Name<span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" name="first_name"
                                   value="{{$provider->first_name}}" required>
                            <input type="hidden" class="form-control form-control-sm" name="provider_id"
                                   value="{{$provider->id}}" required>
                        </div>
                        <!-- Middle Name -->
                        <div class="col-md-4 col-xl-2 mb-2">
                            <label class="font-weight-bold">Middle Name</label>
                            <input type="text" class="form-control form-control-sm" name="middle_name"
                                   value="{{$provider->middle_name}}">
                        </div>
                        <!-- Last Name -->
                        <div class="col-md-4 col-xl-2 mb-2">
                            <label class="font-weight-bold">Last Name<span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" name="last_name"
                                   value="{{$provider->last_name}}" required>
                        </div>
                        <!-- Suffix -->
                        <div class="col-md-4 col-xl-2 mb-2">
                            <label class="font-weight-bold">Suffix</label>
                            <input type="text" class="form-control form-control-sm" name="suffix"
                                   value="{{$provider_info->suffix}}">
                        </div>
                        <!-- Date of Birth -->
                        <div class="col-md-4 col-xl-2 mb-2">
                            <label class="font-weight-bold">Date of Birth<span class="text-danger">*</span></label>
                            <input type="date" class="form-control form-control-sm" name="dob"
                                   value="{{$provider->dob}}" required>
                        </div>
                        <!-- Gender -->
                        <div class="col-md-4 col-xl-2 mb-2">
                            <label class="font-weight-bold">Gender<span class="text-danger">*</span></label>
                            <select class="form-control form-control-sm" name="gender" required>
                                <option value="Male" {{$provider->gender == "Male" ? 'selected' :''}}>Male</option>
                                <option value="Female" {{$provider->gender == "Female" ? 'selected' :''}}>Female
                                </option>
                            </select>
                        </div>
                        <!-- Speciality -->
                        <div class="col-md-4 col-xl-2 mb-2">
                            {{--                            <label class="font-weight-bold">Speciality--}}
                            {{--                                <span class="text-danger">*</span>--}}
                            {{--                            </label>--}}
                            {{--                            <input type="text" class="form-control form-control-sm" name="speciality" value="{{$provider_info->speciality}}" required>--}}


                            <label class="font-weight-bold">Speciality<span class="text-danger">*</span></label>
                            <select class="form-control form-control-sm" name="speciality">
                                <option value=""></option>
                                @foreach($spec as $spe)
                                    <option
                                        value="{{$spe->speciality_name}}" {{$spe->speciality_name == $provider_info->speciality ? 'selected' : ''}}>{{$spe->speciality_name}}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="col-md-4 col-xl-2 mb-2">
                            <label class="font-weight-bold">Taxonomy Code
                                <span class="text-danger"></span>
                            </label>
                            <input type="text" class="form-control form-control-sm" name="taxonomy_code"
                                   value="{{$provider_info->taxonomy_code}}">
                        </div>
                        <!-- Tax Id -->
                        <div class="col-md-4 col-xl-2 mb-2">
                            <label class="font-weight-bold">Tax Id
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control form-control-sm" name="tax_id"
                                   value="{{$provider_info->tax_id}}" data-mask="00-0000000" pattern=".{10}" required>
                        </div>

                        <div class="col-md-4 col-xl-2 mb-2">
                            <label class="font-weight-bold">SSN
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control form-control-sm" name="ssn"
                                   value="{{$provider_info->ssn}}" data-mask="000-000-000" pattern=".{11}" required>
                        </div>
                        <!-- NPI -->
                        <div class="col-md-4 col-xl-2 mb-2">
                            <label class="font-weight-bold">NPI
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control form-control-sm" name="npi"
                                   value="{{$provider_info->npi}}" data-mask="0000000000" pattern=".{10}" required>
                        </div>
                        <!-- UPIN -->
                        <div class="col-md-4 col-xl-2 mb-2">
                            <label class="font-weight-bold">UPIN
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control form-control-sm" name="upin"
                                   value="{{$provider_info->upin}}" required>
                        </div>
                        <!-- DEA -->
                        <div class="col-md-3 col-xl-3 mb-2">
                            <label class="font-weight-bold">DEA
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control form-control-sm" name="dea"
                                   value="{{$provider_info->dea}}" required>
                        </div>
                        <!-- State License -->
                        <div class="col-md-3 col-xl-3 mb-2">
                            <label class="font-weight-bold">State License
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control form-control-sm" name="state_licence"
                                   value="{{$provider_info->state_licence}}" required>
                        </div>
                        <!-- Number of Patient -->
                        <div class="col-md-3 col-xl-3 mb-2">
                            <label class="font-weight-bold">Provider's Degree</label>
                            <input type="text" class="form-control form-control-sm" name="provider_degree"
                                   value="{{$provider_info->provider_degree}}">
                        </div>
                        <div class="col-md-3 col-xl-3 mb-2">
                            <label class="font-weight-bold">Fax Number </label>
                            <input type="text" class="form-control form-control-sm" name="fax_number"
                                   value="{{$provider_info->fax_number}}">
                        </div>
                        <!-- Phone -->
                    @include('admin.provider.include.providerPhone')
                    <!-- Email -->
                    @include('admin.provider.include.providerEmail')
                    <!-- Address -->
                    @include('admin.provider.include.providerAddress')
                    <!-- Signature Date -->
                        <div class="col-md-4 col-xl-3 mb-2">
                            <label class="font-weight-bold">Signature Date
                                <span class="text-danger">*</span>
                            </label>
                            <input type="date" class="form-control form-control-sm" name="signature_date"
                                   value="{{$provider_info->signature_date}}" required>
                            <div class="form-check mt-2">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input" name="signature_on_file"
                                           value="1" {{$provider_info->signature_on_file == 1 ? 'checked' : ''}}>Signature
                                    on File
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4 col-xl-3 mb-2">
                            <label class="font-weight-bold">Start Date
                                <span class="text-danger">*</span>
                            </label>
                            <input type="date" class="form-control form-control-sm" name="start_date"
                                   value="{{$provider_info->start_date}}">

                        </div>
                        <!-- Upload Signature -->
                        <div class="col-md-4 col-xl-2 text-center align-self-center mb-2">
                            <input type="file" class="form-control-file d-none" name="sig_file" id="fileup">
                            <label for="fileup">
                                <svg viewBox="0 0 20 17" class="fileupsvg">
                                    <path
                                        d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/>
                                </svg>
                                <span>Upload Signature</span>
                            </label>
                        </div>
                        <div class="col-md-4 col-xl-3 align-self-center mb-2">
                            <div class="preview-sig">
                                <button type="button" class="close" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                @if (!empty($provider_info->sig_file) && file_exists($provider_info->sig_file))
                                    <img src="{{asset($provider_info->sig_file)}}" id="wizardPicturePreview"
                                         class="img-fluid" width="70" alt="aba+">
                                @else
                                    <img src="{{asset('assets/dashboard/')}}/images/client/contact.png"
                                         id="wizardPicturePreview" class="img-fluid" width="70" alt="aba+">
                                @endif
                            </div>
                        </div>
                        <!-- Checkbox -->
                        <div class="col-md-6 col-xl-4 mb-2">
                            <div class="row no-gutters">
                                <!-- Rendering Provider -->
                                <div class="col-md-7">
                                    <label>Rendering Provider</label>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-check-inline">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" name="rp"
                                                   value="1" {{$provider_info->rp == 1 ? 'checked' : ''}}>Yes
                                        </label>
                                    </div>
                                    <div class="form-check-inline">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" name="rp"
                                                   value="2" {{$provider_info->rp == 2 ? 'checked' : ''}}>No
                                        </label>
                                    </div>
                                </div>
                                <!-- Rendering Provider -->
                                <div class="col-md-7">
                                    <label>Override Company Profile</label>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-check-inline">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" name="ocp"
                                                   value="1" {{$provider_info->ocp == 1 ? 'checked' : ''}}>Yes
                                        </label>
                                    </div>
                                    <div class="form-check-inline">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" name="ocp"
                                                   value="2" {{$provider_info->ocp == 2 ? 'checked' : ''}}>No
                                        </label>
                                    </div>
                                </div>
                                <!-- Medicare Participating -->
                                <div class="col-md-7">
                                    <label>Medicare Participating</label>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-check-inline">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" name="mp"
                                                   value="1" {{$provider_info->mp == 1 ? 'checked' : ''}}>Yes
                                        </label>
                                    </div>
                                    <div class="form-check-inline">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" name="mp"
                                                   value="2" {{$provider_info->mp == 2 ? 'checked' : ''}}>No
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-4 mb-2">
                            <div class="row">
                                <div class="col-md-7">
                                    <label>Accepting new patient</label>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-check-inline">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" name="anp"
                                                   value="1" {{$provider_info->anp == 1 ? 'checked' : ''}}>Yes
                                        </label>
                                    </div>
                                    <div class="form-check-inline">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" name="anp"
                                                   value="2" {{$provider_info->anp == 2 ? 'checked' : ''}}>No
                                        </label>
                                    </div>
                                </div>
                                <!-- Print DEA on prescription -->
                                <div class="col-md-7">
                                    <label>Print DEA on prescription</label>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-check-inline">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" name="pdop"
                                                   value="1" {{$provider_info->rp == 1 ? 'checked' : ''}}>Yes
                                        </label>
                                    </div>
                                    <div class="form-check-inline">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" name="pdop"
                                                   value="2" {{$provider_info->pdop == 2 ? 'checked' : ''}}>No
                                        </label>
                                    </div>
                                </div>
                                <!-- All Payers Participating -->
                                <div class="col-md-7">
                                    <label>All Payers Participating</label>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-check-inline">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" name="app"
                                                   value="1" {{$provider_info->app == 1 ? 'checked' : ''}}>Yes
                                        </label>
                                    </div>
                                    <div class="form-check-inline">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" name="app"
                                                   value="2" {{$provider_info->app == 2 ? 'checked' : ''}}>No
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Submit -->
                        <div class="col-md-12">
                            <hr>
                            <button class="btn btn-primary mr-2">Save Provider</button>
                            <button type="button" class="btn btn-danger" onclick="window.location.reload();">Cancel
                            </button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{asset('assets/dashboard/custom/provider.js')}}"></script>
    <script>
        $(document).ready(function () {
            $("#fileup").change(function () {
                $('#wizardPicturePreview').attr('src', '');
                readURL(this);
            });
        });


        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#wizardPicturePreview').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
    <script>
        $(document).ready(function () {
            $('.existsphonedelete').click(function () {
                console.log('done')
                var phonid = $(this).data('id');
                $(this).closest('.removeexistphondiv').remove();
                $.ajax({
                    type: "POST",
                    url: "{{route('admin.delete.exist.provider.phone')}}",
                    data: {
                        '_token': "{{csrf_token()}}",
                        'phonid': phonid
                    },
                    success: function (data) {

                    }
                });
            });


            $('.deleteexistsemail').click(function () {
                var emailid = $(this).data('id');
                $(this).closest('.existsemailsection').remove();
                $.ajax({
                    type: "POST",
                    url: "{{route('admin.delete.exist.provider.email')}}",
                    data: {
                        '_token': "{{csrf_token()}}",
                        'emailid': emailid
                    },
                    success: function (data) {

                    }
                });
            });


            $('.deleteexistsaddress').click(function () {
                var addressid = $(this).data('id');
                $(this).closest('.existsaddresssection').remove();
                $.ajax({
                    type: "POST",
                    url: "{{route('admin.delete.exist.provider.address')}}",
                    data: {
                        '_token': "{{csrf_token()}}",
                        'addressid': addressid
                    },
                    success: function (data) {

                    }
                });
            })
        })
    </script>
@endsection
