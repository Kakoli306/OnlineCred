@extends('layouts.baseStaff')
@section('basestaffheaderselect')
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
@section('basestaff')
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
                    <a class="nav-link" href="{{route('basestaff.provider.info',$provider->id)}}">Provider
                        Info</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"
                       href="{{route('basestaff.provider.contract',$provider->id)}}">Contracts</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"
                       href="{{route('basestaff.provider.document',$provider->id)}}">Documents</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('basestaff.provider.portal',$provider->id)}}">Provider
                        Portal</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{route('basestaff.provider.online.access',$provider->id)}}">Online
                        Access</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('basestaff.provider.activity',$provider->id)}}">Provider
                        Activity</a>
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
                            <form action="{{route('basestaff.provider.online.access.save')}}" method="post">
                                @csrf
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-4 mb-2">
                                            <label>Access Name</label>
                                        </div>
                                        <div class="col-md-8 mb-2">
                                            <input type="text" class="form-control form-control-sm" name="name"
                                                   required>
                                            <input type="hidden" class="form-control form-control-sm" name="provider_id"
                                                   value="{{$provider->id}}" required>
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
                                            <input type="text" class="form-control form-control-sm" name="user_name"
                                                   required>
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <label>Password</label>
                                        </div>
                                        <div class="col-md-8 mb-2">
                                            <input type="password" class="form-control form-control-sm" name="password"
                                                   required>
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
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($provider_online_access as $access)
                            <tr>
                                <td>{{$access->name}}</td>
                                <td>{{$access->url}}</td>
                                <td>{{$access->user_name}}</td>
                                <td>{{$access->password}}</td>
                                <td>
                                    <a href="#editonlibeaccess{{$access->id}}" title="Edit" data-toggle="modal">
                                        <i class="ri-pencil-line mr-2"></i>
                                    </a>
                                    <a href="{{route('basestaff.online.access.delete',$access->id)}}"
                                       title="Delete">
                                        <i class="ri-delete-bin-6-line text-danger"></i>
                                    </a>
                                </td>
                            </tr>


                            <div class="modal fade" id="editonlibeaccess{{$access->id}}" data-backdrop="static">
                                <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4>Edit Access</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <form action="{{route('basestaff.provider.online.access.update')}}"
                                              method="post">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-4 mb-2">
                                                        <label>Access Name</label>
                                                    </div>
                                                    <div class="col-md-8 mb-2">
                                                        <input type="text" class="form-control form-control-sm"
                                                               name="name" value="{{$access->name}}" required>
                                                        <input type="hidden" class="form-control form-control-sm"
                                                               name="access_edit_id" value="{{$access->id}}" required>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label>URL</label>
                                                    </div>
                                                    <div class="col-md-8 mb-2">
                                                        <input type="text" class="form-control form-control-sm"
                                                               name="url" value="{{$access->url}}" required>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label>User Name</label>
                                                    </div>
                                                    <div class="col-md-8 mb-2">
                                                        <input type="text" class="form-control form-control-sm"
                                                               name="user_name" value="{{$access->user_name}}" required>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label>Password</label>
                                                    </div>
                                                    <div class="col-md-8 mb-2">
                                                        <input type="text" class="form-control form-control-sm"
                                                               name="password" value="{{$access->password}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Save</button>
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">
                                                    Close
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        @endforeach
                        </tbody>
                    </table>
                    {{$provider_online_access->links()}}
                </div>
            </div>
        </div>
    </div>
@endsection


