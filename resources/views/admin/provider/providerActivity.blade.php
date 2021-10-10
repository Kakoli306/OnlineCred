@extends('layouts.admin')
@section('headerselect')
    <div class="iq-search-bar">
        <h5>ABC Behavioral Therapy Center</h5>
    </div>
@endsection
@section('admin')
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
                <a href="{{route('admin.providers')}}" class="btn btn-sm btn-primary">
                    <i class="ri-arrow-left-circle-line"></i>Back
                </a>
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
                    <a class="nav-link" href="{{route('admin.provider.info',$provider->id)}}">Provider Info</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="{{route('admin.provider.contract',$provider->id)}}">Contracts</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.provider.document',$provider->id)}}">Documents</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.provider.portal',$provider->id)}}">Provider Portal</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.provider.online.access',$provider->id)}}">Online Access</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.provider.tracking.user',$provider->id)}}">Tracking Muster</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{route('admin.provider.activity',$provider->id)}}">Provider Activity</a>
                </li>
            </ul>
            <div class="all_content flex-fill">
                <h5 class="common-title">Provider Activity</h5>
                <!-- single activity-->
                <div class="d-flex">
                    <div class="mr-4 datetime">
                        <p class="today mb-0">19 November 2019</p>
                        <p class="time">2:59 PM</p>
                    </div>
                    <div class="flex-fill timeline">
                        <div class="history">
                            <h6>Provider Meeting</h6>
                            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Suscipit,
                                voluptate!- <a href="#">View Details</a></p>
                        </div>
                        <div class="timeline-dots"></div>
                    </div>
                </div>
                <!-- single activity-->
                <div class="d-flex">
                    <div class="mr-4 datetime">
                        <p class="today mb-0">19 November 2019</p>
                        <p class="time">2:59 PM</p>
                    </div>
                    <div class="flex-fill timeline">
                        <div class="history">
                            <h6>Provider Meeting</h6>
                            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Suscipit,
                                voluptate!- <a href="#">View Details</a></p>
                        </div>
                        <div class="timeline-dots"></div>
                    </div>
                </div>
                <!--/ single activity -->
            </div>
        </div>
    </div>
@endsection

