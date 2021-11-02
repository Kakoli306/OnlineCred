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
                    <a class="nav-link active" href="{{route('provider.online.access')}}">Online Access</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('provider.tracking.user')}}">Tracking Muster</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('provider.activity')}}">Provider Activity</a>
                </li>
            </ul>
            <div class="all_content flex-fill">
                <div class="overflow-hidden">
                    <div class="float-left">
                        <h2 class="common-title">Online Access</h2>
                    </div>
                    <div class="float-right">
                        <a href="#addAccess" class="btn btn-sm btn-primary" data-toggle="modal">+ Add Access</a>
                    </div>
                </div>
                <!-- Add Access Modal -->
                <div class="modal fade" id="addAccess" data-backdrop="static">
                    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4>Add Access</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <form action="{{route('provider.online.access.save')}}" method="post">
                                @csrf
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-4 mb-2">
                                            <label>Access Name</label>
                                        </div>
                                        <div class="col-md-8 mb-2">
                                            <input type="text" class="form-control form-control-sm" name="name" required>
                                            <input type="hidden" class="form-control form-control-sm" name="provider_id" value="{{$provider->id}}" required>
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <label>URL</label>
                                        </div>
                                        <div class="col-md-8 mb-2">
                                            <input type="text" class="form-control form-control-sm" name="url" required>
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <label>User Name</label>
                                        </div>
                                        <div class="col-md-8 mb-2">
                                            <input type="text" class="form-control form-control-sm" name="user_name" required>
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <label>Password</label>
                                        </div>
                                        <div class="col-md-8 mb-2">
                                            <input type="password" class="form-control form-control-sm" name="password" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- table -->
                <div class="table-responsive">
                    <table class="table table-sm table-bordered c_table">
                        <thead>
                        <tr>
                            <th>Access Name</th>
                            <th>Url</th>
                            <th>User Name</th>
                            <th>Password</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($provider_online_access as $access)
                            <tr>
                                <td>{{$access->name}}</td>
                                <td>{{$access->url}}</td>
                                <td>{{$access->user_name}}</td>
                                <td>{{$access->password}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{$provider_online_access->links()}}
                </div>
            </div>
        </div>
    </div>
@endsection

