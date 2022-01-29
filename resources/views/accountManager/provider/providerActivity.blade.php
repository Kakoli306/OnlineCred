@extends('layouts.accountManager')
@section('managerheaderselect')
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
@section('accountmanager')
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
                    <a href="{{route('account.manager.providers.list',$provider->practice_id)}}"
                       class="btn btn-sm btn-primary go_back">
                        <i class="ri-arrow-left-circle-line"></i>Back
                    </a>
                @else
                    <a href="{{route('account.manager.providers.list',0)}}"
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
                    <a class="nav-link "
                       href="{{route('account.manager.provider.contract',$provider->id)}}">Contracts</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"
                       href="{{route('account.manager.provider.document',$provider->id)}}">Documents</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"
                       href="{{route('account.manager.provider.insurance.document',$provider->id)}}">Insurnace
                        Documents</a>
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
                {{--                    <a class="nav-link" href="{{route('admin.provider.tracking.user',$provider->id)}}">Tracking Muster</a>--}}
                {{--                </li>--}}
                <li class="nav-item">
                    <a class="nav-link active" href="{{route('account.manager.provider.activity',$provider->id)}}">Provider
                        Activity</a>
                </li>
            </ul>
            <div class="all_content flex-fill">
                <h5 class="common-title">Provider Activity</h5>
                <!-- single activity-->
                @foreach($activity as $act)
                    <div class="d-flex">
                        <div class="mr-4 datetime">
                            <p class="today mb-0">{{\Carbon\Carbon::parse($act->created_at)->format('m/d/Y')}}</p>
                            <p class="time">{{\Carbon\Carbon::parse($act->created_at)->format('g:i a')}}</p>
                        </div>
                        <div class="flex-fill timeline">
                            <div class="history">
                                <h6>Provider</h6>
                                <p>{!! $act->message !!}<a href="#">View Details</a></p>
                            </div>
                            <div class="timeline-dots"></div>
                        </div>
                    </div>
            @endforeach
            <!-- single activity-->
            {{$activity->links()}}
            <!--/ single activity -->
            </div>
        </div>
    </div>
@endsection


