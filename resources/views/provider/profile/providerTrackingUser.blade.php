@extends('layouts.provider')
@section('headerselect')
    <div class="iq-search-bar">
        <?php
        $assign_prc = \App\Models\assign_practice::where('provider_id',Auth::user()->id)->first();
        if ($assign_prc) {
            $prc_name = \App\Models\practice::where('id',$assign_prc->practice_id)->first();
        }
        ?>
        @if ($assign_prc && $prc_name)
            <h5>{{$prc_name->business_name}}</h5>
        @endif

    </div>
@endsection
@section('proider')
    <div class="iq-card-body">
        <div class="d-flex justify-content-between mb-3">
            <div class="align-self-center">
                <h5><a href="#" class="cmn_a">{{$provider->first_name}} {{$provider->middle_name}} {{$provider->last_name}}</a> |
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

            </div>
        </div>
        <div class="d-lg-flex">
            <ul class="nav flex-column setting_menu">
                <!-- Profile Picture -->
                <li class="nav-item border-0 text-center">
                    <div class="profile-pic-div">
                        <img src="{{asset('assets/dashboard/')}}/images/man.jpg" class="img-fluid" id="photo" alt="aba+">
                        <input type="file" id="file" class="d-none">
                        <label for="file" id="uploadBtn">Upload Photo</label>
                    </div>
                </li>
                <!--/ Profile Picture -->
                <li class="nav-item">
                    <a class="nav-link" href="{{route('providers.info')}}">Provider Info</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('provider.contract')}}">Contracts</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('provider.document')}}">Documents</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('provider.portal')}}">Provider Portal</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('provider.online.access')}}">Online Access</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{route('provider.tracking.user')}}">Tracking Muster</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('provider.activity')}}">Provider Activity</a>
                </li>
            </ul>
            <div class="all_content flex-fill">
                <h2 class="common-title">Tracking Muster</h2>
                <!-- table -->
                <div class="table-responsive">
                    <table class="table table-sm table-bordered c_table">
                        <thead>
                        <tr>
                            <th colspan="4">Details</th>
                            <th colspan="2">Follow up # 1</th>
                        </tr>
                        <tr>
                            <th>Payer Name</th>
                            <th>Task</th>
                            <th>Initial Application Date</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Remarks</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Medicare</td>
                            <td>Credentialing</td>
                            <td>9/7/2021</td>
                            <td>In-Network</td>
                            <td>9/8/2021</td>
                            <td>Medicare application has been approved</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

