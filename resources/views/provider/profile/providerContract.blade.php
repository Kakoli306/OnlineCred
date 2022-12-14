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
                    <a class="nav-link active" href="{{route('provider.contract')}}">Contracts</a>
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
                    <a class="nav-link" href="{{route('provider.tracking.user')}}">Tracking Muster</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('provider.activity')}}">Provider Activity</a>
                </li>
            </ul>
            <div class="all_content flex-fill">
                <div class="overflow-hidden">
                    <div class="float-left">
                        <h5 class="common-title">Contract List</h5>
                    </div>
                    <div class="float-right">
                        <a href="#createContract" class="btn btn-sm btn-primary" data-toggle="modal">+
                            Add
                            Contracts</a>
                    </div>
                </div>
                <!-- Create Contract modal -->
                <div class="modal fade" id="createContract" data-backdrop="static">
                    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4>Create Contract</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <form action="{{route('provider.contract.save')}}" method="post">
                                @csrf
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-2">
                                            <label>Contract Name
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control form-control-sm" name="contract_name" required>
                                            <input type="hidden" class="form-control form-control-sm" name="prvider_id" value="{{$provider->id}}" required>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label>Onset Date<span class="text-danger">*</span></label>
                                            <input type="date" name="onset_date" class="form-control form-control-sm">
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label>End Date<span class="text-danger">*</span></label>
                                            <input type="date" name="end_date" class="form-control form-control-sm" required>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label>Contract Type<span class="text-danger">*</span></label>
                                            <select name="contract_type" class="form-control form-control-sm">
                                                <option value="0"></option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label>Pin No.<span class="text-danger">*</span></label>
                                            <input type="text" name="pin_no" class="form-control form-control-sm" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Save<i class='bx bx-loader align-middle ml-2'></i></button>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered c_table auth_table">
                        <thead>
                        <tr>
                            <th>Contract Name</th>
                            <th>Onset Date</th>
                            <th>End Date</th>
                            <th>Contract Type</th>
                            <th>Pin No</th>
                            <th>Actions</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($provider_contracts as $pcontract)
                            <tr>
                                <td>{{$pcontract->contract_name}}</td>
                                <td>{{\Carbon\Carbon::parse($pcontract->onset_date)->format('m/d/Y')}}</td>
                                <td>{{\Carbon\Carbon::parse($pcontract->end_date)->format('m/d/Y')}}</td>
                                <td>commercial</td>
                                <td>{{$pcontract->pin_no}}</td>
                                <td>
                                    <a href="#addNote{{$pcontract->id}}" title="Add Notes" data-toggle="modal">
                                        <i class="ri-add-line mr-3"></i>
                                    </a>
                                    <a href="#chat" data-toggle="modal" class="show_chat" data-id="{{$pcontract->id}}">
                                        <i class="ri-message-2-line text-success mr-3"></i>
                                    </a>
                                    <a href="#editContract{{$pcontract->id}}" title="Edit" data-toggle="modal">
                                        <i class="ri-pencil-line mr-3"></i>
                                    </a>
                                    <a href="{{route('provider.contract.delete',$pcontract->id)}}" title="Delete">
                                        <i class="ri-delete-bin-6-line text-danger"></i>
                                    </a>
                                    <!-- Add Note -->
                                    <div class="modal fade" id="addNote{{$pcontract->id}}">
                                        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4>Add Note</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                <form action="{{route('provider.contract.add.note')}}" method="post">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-4 mb-2">
                                                                <label>Status</label>
                                                            </div>
                                                            <div class="col-md-8 mb-2">
                                                                <select class="form-control form-control-sm" name="status">
                                                                    <option></option>
                                                                    <option value="In-Process">In-Process
                                                                    </option>
                                                                    <option value="Pending">Pending</option>
                                                                    <option value="In-Network">In-Network</option>
                                                                    <option value="Closed">Closed</option>
                                                                    <option value="Completed">Completed</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-4 mb-2">
                                                                <label>Worked Date</label>
                                                            </div>
                                                            <div class="col-md-8 mb-2">
                                                                <input type="date" class="form-control form-control-sm" name="worked_date">
                                                                <input type="hidden" class="form-control form-control-sm" name="note_provider_id" value="{{$provider->id}}">
                                                                <input type="hidden" class="form-control form-control-sm" name="note_contract_id" value="{{$pcontract->id}}">
                                                            </div>
                                                            <div class="col-md-4 mb-2">
                                                                <label>Follow Up Date</label>
                                                            </div>
                                                            <div class="col-md-8 mb-2">
                                                                <input type="date" class="form-control form-control-sm" name="followup_date">
                                                            </div>
                                                            <div class="col-md-4 mb-2">
                                                                <label>Notes</label>
                                                            </div>
                                                            <div class="col-md-8 mb-2">
                                                                <textarea class="form-control form-control-sm" name="note"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">Save</button>
                                                        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- add chat -->
                                    <div class="modal fade" id="chat">
                                        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4>Follow Up</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                <div class="modal-body coms">

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- editContract  -->
                                    <div class="modal fade" id="editContract{{$pcontract->id}}" data-backdrop="static">
                                        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4>Edit Contract</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                <form action="{{route('provider.contract.update')}}" method="post">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-6 mb-2">
                                                                <label>Contract Name
                                                                    <span class="text-danger">*</span>
                                                                </label>
                                                                <input type="text" class="form-control form-control-sm" name="contract_name" value="{{$pcontract->contract_name}}" required>
                                                                <input type="hidden" class="form-control form-control-sm" name="contract_edit_id" value="{{$pcontract->id}}" required>
                                                            </div>
                                                            <div class="col-md-6 mb-2">
                                                                <label>Onset Date<span class="text-danger">*</span></label>
                                                                <input type="date" class="form-control form-control-sm" name="onset_date" value="{{$pcontract->onset_date}}">
                                                            </div>
                                                            <div class="col-md-6 mb-2">
                                                                <label>End Date<span class="text-danger">*</span></label>
                                                                <input type="date" class="form-control form-control-sm" name="end_date" value="{{$pcontract->end_date}}" required>
                                                            </div>
                                                            <div class="col-md-6 mb-2">
                                                                <label>Contract Type<span class="text-danger">*</span></label>
                                                                <select class="form-control form-control-sm" name="contract_type">
                                                                    <option></option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6 mb-2">
                                                                <label>Pin No.<span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control form-control-sm" name="pin_no" value="{{$pcontract->pin_no}}" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">Save<i class='bx bx-loader align-middle ml-2'></i></button>
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/ editContract  -->
                                </td>
                                <td>
                                    <i class="ri-checkbox-blank-circle-fill text-success" title="Active"></i>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>

                    {{$provider_contracts->links()}}
                </div>
            </div>
        </div>
    </div>
@endsection
@include('provider.profile.include.contractjs')
