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
                    <a href="{{route('basestaff.providers.list',$provider->practice_id)}}"
                       class="btn btn-sm btn-primary go_back">
                        <i class="ri-arrow-left-circle-line"></i>Back
                    </a>
                @else
                    <a href="{{route('basestaff.providers.list',0)}}"
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
                    <a class="nav-link" href="{{route('account.manager.provider.info',$provider->id)}}">Provider
                        Info</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"
                       href="{{route('account.manager.provider.contract',$provider->id)}}">Contracts</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"
                       href="{{route('account.manager.provider.document',$provider->id)}}">Documents</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('account.manager.provider.portal',$provider->id)}}">Provider
                        Portal</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('account.manager.provider.online.access',$provider->id)}}">Online
                        Access</a>
                </li>
                {{--                <li class="nav-item">--}}
                {{--                    <a class="nav-link active" href="{{route('admin.provider.tracking.user',$provider->id)}}">Tracking Muster</a>--}}
                {{--                </li>--}}
                <li class="nav-item">
                    <a class="nav-link" href="{{route('account.manager.provider.activity',$provider->id)}}">Provider
                        Activity</a>
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



