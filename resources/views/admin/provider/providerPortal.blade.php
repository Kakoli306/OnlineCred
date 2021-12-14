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
                @if ($provider->practice_id != null)
                    <a href="{{route('admin.providers.list',$provider->practice_id)}}"
                       class="btn btn-sm btn-primary go_back">
                        <i class="ri-arrow-left-circle-line"></i>Back
                    </a>
                @else
                    <a href="{{route('admin.providers.list',0)}}"
                       class="btn btn-sm btn-primary go_back">
                        <i class="ri-arrow-left-circle-line"></i>Back
                    </a>
                @endif

            </div>
        </div>
        <div class="d-lg-flex">
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
                    <a class="nav-link" href="{{route('admin.provider.info',$provider->id)}}">Provider Info</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.provider.contract',$provider->id)}}">Contracts</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.provider.document',$provider->id)}}">Documents</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{route('admin.provider.portal',$provider->id)}}">Provider
                        Portal</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.provider.online.access',$provider->id)}}">Online Access</a>
                </li>
                {{--                <li class="nav-item">--}}
                {{--                    <a class="nav-link" href="{{route('admin.provider.tracking.user',$provider->id)}}">Tracking Muster</a>--}}
                {{--                </li>--}}
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.provider.activity',$provider->id)}}">Provider Activity</a>
                </li>
            </ul>
            <div class="all_content flex-fill">

                <div class="row">
                    <div class="col-md-6 mb-2">
                        <form action="{{route('admin.provider.portal.save')}}" method="post">
                            @csrf
                            <h4 class="common-title">Provider Portal Features</h4>
                            <label class="d-block text-muted">Select which features are available for
                                this Provider Portal.</label>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input" name="sec_msg"
                                           value="1" {{$portal->sec_msg == 1? 'checked':''}}>Use secure messaging
                                </label>
                                <input type="hidden" name="portal_edit_id" value="{{$portal->id}}">
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input" name="acc_bill"
                                           value="1" {{$portal->acc_bill == 1? 'checked':''}}>Access billing
                                    documents
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input" name="pay_bal"
                                           value="1" {{$portal->pay_bal == 1? 'checked':''}}>Pay a balance with
                                    credit card using Stripe
                                </label>
                            </div>
                            <button type="submit" class="btn btn-sm btn-primary mt-2">Save
                                Features
                            </button>
                        </form>
                    </div>

                    <div class="col-md-6 mb-2">
                        <form action="{{route('admin.provider.send.access')}}" method="post">
                            @csrf
                            <h4 class="common-title">Provider Portal Access</h4>
                            <label class="d-block mb-2 text-muted">Provider will create their own
                                accounts to access your Provider Portal.</label>
                            <label>Email: </label>
                            <div class="d-inline-block">
                                <select class="form-control form-control-sm" name="access_email">
                                    <option value="{{$provider->email}}">
                                        {{$provider->email}}
                                    </option>
                                    @foreach($provider_all_email as $proemail)
                                        <option value="{{$proemail->email}}">
                                            {{$proemail->email}}
                                        </option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="portal_acess_id" value="{{$provider->id}}">
                            </div>
                            <div class="alert alert-danger alert-dismissible mt-2 mb-2" role="alert">
                                Invitation sent — provider has not signed in yet.
                                <button type="button" class="close text-danger" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <button type="submit" class="btn btn-sm btn-secondary">Send
                                Invitation
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection



