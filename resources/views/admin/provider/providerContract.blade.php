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
                    <a class="nav-link active" href="{{route('admin.provider.contract',$provider->id)}}">Contracts</a>
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
                {{--                <li class="nav-item">--}}
                {{--                    <a class="nav-link" href="{{route('admin.provider.tracking.user',$provider->id)}}">Tracking--}}
                {{--                        Muster</a>--}}
                {{--                </li>--}}
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.provider.activity',$provider->id)}}">Provider Activity</a>
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
                            <form action="{{route('admin.provider.contract.save')}}" method="post"
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-2">
                                            <label>Contract Name
                                                <span class="text-danger">*</span>
                                            </label>

                                            <select name="contract_name" class="form-control form-control-sm" required>
                                                <option value=""></option>
                                                @foreach($contact_name as $conname)
                                                    <option
                                                        value="{{$conname->contact_name}}">{{$conname->contact_name}}</option>
                                                @endforeach
                                            </select>
                                            <input type="hidden" class="form-control form-control-sm" name="prvider_id"
                                                   value="{{$provider->id}}" required>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label>Onset Date<span class="text-danger">*</span></label>
                                            <input type="date" name="onset_date" class="form-control form-control-sm">
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label>End Date<span class="text-danger">*</span></label>
                                            <input type="date" name="end_date" class="form-control form-control-sm">
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label>Followup Date<span class="text-danger">*</span></label>
                                            <input type="date" name="contract_followup_date"
                                                   class="form-control form-control-sm">
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label>Contract Type<span class="text-danger">*</span></label>
                                            <select name="contract_type" class="form-control form-control-sm">
                                                <option value=""></option>
                                                @foreach($contact_type as $contype)
                                                    <option value="{{$contype->id}}">{{$contype->contact_type}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label>Contract Status<span class="text-danger">*</span></label>
                                            <select class="form-control form-control-sm" name="con_status" required>
                                                <option value=""></option>
                                                @foreach($contact_status as $status)
                                                    <option
                                                        value="{{$status->id}}">{{$status->contact_status}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label>Assigned to<span class="text-danger">*</span></label>
                                            <?php
                                            $assign_users = \App\Models\assign_practice_user::where('practice_id', $provider->practice_id)->get();

                                            ?>
                                            <select class="form-control form-control-sm" name="assign_to_name">
                                                <option value=""></option>
                                                @foreach($assign_users as $assuser)
                                                    @if ($assuser->user_type == 2)
                                                        <?php
                                                        $manager_user = \App\Models\AccountManager::select('id', 'name')->where('id', $assuser->user_id)
                                                            ->where('account_type', $assuser->user_type)
                                                            ->first();
                                                        ?>
                                                        @if ($manager_user)
                                                            <option
                                                                value="{{$manager_user->name}}">{{$manager_user->name}}</option>
                                                        @endif
                                                    @elseif($assuser->user_type == 3)
                                                        <?php
                                                        $staff_user = \App\Models\BaseStaff::select('id', 'name')->where('id', $assuser->user_id)
                                                            ->where('account_type', $assuser->user_type)
                                                            ->first();
                                                        ?>
                                                        @if ($staff_user)
                                                            <option
                                                                value="{{$staff_user->name}}">{{$staff_user->name}}</option>
                                                        @endif
                                                    @elseif($assuser->user_type == 1)
                                                        <?php
                                                        $admin_user = \App\Models\Admin::select('id', 'name')->where('id', $assuser->user_id)
                                                            ->where('account_type', $assuser->user_type)
                                                            ->first();
                                                        ?>
                                                        @if ($admin_user)
                                                            <option
                                                                value="{{$admin_user->name}}">{{$admin_user->name}}</option>
                                                        @endif
                                                    @else
                                                    @endif

                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label>Document 1<span class="text-danger"></span></label>
                                            <input type="file" name="contact_document"
                                                   class="form-control form-control-sm">
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label>Document 2<span class="text-danger"></span></label>
                                            <input type="file" name="contact_document_one"
                                                   class="form-control form-control-sm">
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label>Document 3<span class="text-danger"></span></label>
                                            <input type="file" name="contact_document_two"
                                                   class="form-control form-control-sm">
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label>Document 4<span class="text-danger"></span></label>
                                            <input type="file" name="contact_document_three"
                                                   class="form-control form-control-sm">
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label>Document 5<span class="text-danger"></span></label>
                                            <input type="file" name="contact_document_four"
                                                   class="form-control form-control-sm">
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label>Document 6<span class="text-danger"></span></label>
                                            <input type="file" name="contact_document_five"
                                                   class="form-control form-control-sm">
                                        </div>

                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Save<i
                                            class='bx bx-loader align-middle ml-2'></i></button>
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
                            <th>Actions</th>
                            <th>Assigned To</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($provider_contracts as $pcontract)
                            <?php
                            $con_status = \App\Models\contract_status::where('id', $pcontract->status)->first();
                            $con_name = \App\Models\contact_name::where('contact_name', $pcontract->contract_name)->first();
                            $type_name = \App\Models\contact_type::where('id', $pcontract->contract_type)->first();
                            ?>
                            <tr>
                                <td>
                                    @if ($con_name)
                                        {{$con_name->contact_name}}
                                    @endif

                                </td>
                                <td>
                                    @if ($pcontract->onset_date != null || $pcontract->onset_date != "")
                                        {{\Carbon\Carbon::parse($pcontract->onset_date)->format('m/d/Y')}}
                                    @endif

                                </td>
                                <td>
                                    @if ($pcontract->end_date != null || $pcontract->end_date != "")
                                        {{\Carbon\Carbon::parse($pcontract->end_date)->format('m/d/Y')}}
                                    @endif

                                </td>
                                <td>
                                    @if ($type_name)
                                        {{$type_name->contact_type}}
                                    @endif
                                </td>
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
                                    <a href="{{route('admin.provider.contract.delete',$pcontract->id)}}" title="Delete">
                                        <i class="ri-delete-bin-6-line text-danger"></i>
                                    </a>
                                    <!-- Add Note -->
                                    <div class="modal fade" id="addNote{{$pcontract->id}}">
                                        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4>Add Note</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;
                                                    </button>
                                                </div>
                                                <?php
                                                $exits_note = \App\Models\provider_contract_note::where('contract_id', $pcontract->id)
                                                    ->orderBy('id', 'desc')
                                                    ->first();
                                                ?>
                                                <form action="{{route('admin.provider.contract.add.note')}}"
                                                      method="post">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-4 mb-2">
                                                                <label>Status <span class="text-danger">*</span></label>
                                                            </div>
                                                            <div class="col-md-8 mb-2">
                                                                <select class="form-control form-control-sm"
                                                                        name="note_status" required>
                                                                    <option value=""></option>
                                                                    @foreach($contact_status as $constatus)
                                                                        <option
                                                                            value="{{$constatus->id}}" {{$pcontract->status == $constatus->id ? 'selected' :''}}>{{$constatus->contact_status}}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-4 mb-2">
                                                                <label>Assigned to <span
                                                                        class="text-danger"></span></label>
                                                            </div>
                                                            <div class="col-md-8 mb-2">
                                                                <select class="form-control form-control-sm"
                                                                        name="note_assign_to_name">
                                                                    <option value=""></option>
                                                                    @foreach($assign_users as $assuser)
                                                                        @if ($assuser->user_type == 2)
                                                                            <?php
                                                                            $manager_user = \App\Models\AccountManager::select('id', 'name')->where('id', $assuser->user_id)
                                                                                ->where('account_type', $assuser->user_type)
                                                                                ->first();
                                                                            ?>
                                                                            @if ($manager_user)
                                                                                <option
                                                                                    value="{{$manager_user->name}}" {{$pcontract->assign_to_type == 2 && $pcontract->assign_to_id == $manager_user->id ? 'selected' :''}}>{{$manager_user->name}}</option>
                                                                            @endif
                                                                        @elseif($assuser->user_type == 3)
                                                                            <?php
                                                                            $staff_user = \App\Models\BaseStaff::select('id', 'name')->where('id', $assuser->user_id)
                                                                                ->where('account_type', $assuser->user_type)
                                                                                ->first();
                                                                            ?>
                                                                            @if ($staff_user)
                                                                                <option
                                                                                    value="{{$staff_user->name}}" {{$pcontract->assign_to_type == 3 && $pcontract->assign_to_id == $staff_user->id ? 'selected' :''}}>{{$staff_user->name}}</option>
                                                                            @endif
                                                                        @elseif($assuser->user_type == 1)
                                                                            <?php
                                                                            $admin_user = \App\Models\Admin::select('id', 'name')->where('id', $assuser->user_id)
                                                                                ->where('account_type', $assuser->user_type)
                                                                                ->first();
                                                                            ?>
                                                                            @if ($admin_user)
                                                                                <option
                                                                                    value="{{$admin_user->name}}" {{$pcontract->assign_to_type == 1 && $pcontract->assign_to_id == $admin_user->id ? 'selected' :''}}>{{$admin_user->name}}</option>
                                                                            @endif
                                                                        @else
                                                                        @endif

                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-4 mb-2">
                                                                <label>Worked Date <span
                                                                        class="text-danger">*</span></label>
                                                            </div>
                                                            <div class="col-md-8 mb-2">
                                                                <input type="date"
                                                                       class="form-control form-control-sm"
                                                                       name="note_worked_date"
                                                                       value="{{isset($exits_note) ? $exits_note->worked_date : ''}}"
                                                                       required>

                                                                <input type="hidden"
                                                                       class="form-control form-control-sm"
                                                                       name="note_provider_id"
                                                                       value="{{$provider->id}}">
                                                                <input type="hidden"
                                                                       class="form-control form-control-sm"
                                                                       name="note_contract_id"
                                                                       value="{{$pcontract->id}}">
                                                            </div>
                                                            <div class="col-md-4 mb-2">
                                                                <label>Follow Up Date <span class="text-danger">*</span></label>
                                                            </div>
                                                            <div class="col-md-8 mb-2">
                                                                <input type="date" class="form-control form-control-sm"
                                                                       name="note_followup_date"
                                                                       value="{{$pcontract->contract_followup_date}}"
                                                                       required>
                                                            </div>
                                                            <div class="col-md-4 mb-2">
                                                                <label>Notes <span class="text-danger">*</span></label>
                                                            </div>
                                                            <div class="col-md-8 mb-2">
                                                                @if ($exits_note)
                                                                    <textarea class="form-control form-control-sm"
                                                                              name="note"
                                                                              required>{{isset($exits_note) ? $exits_note->note : ''}}</textarea>
                                                                @else
                                                                    <textarea class="form-control form-control-sm"
                                                                              name="note"
                                                                              required></textarea>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">Save</button>
                                                        <button type="button" class="btn btn-primary"
                                                                data-dismiss="modal">Close
                                                        </button>
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
                                                    <button type="button" class="close" data-dismiss="modal">&times;
                                                    </button>
                                                </div>
                                                <div class="modal-body coms">

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary" data-dismiss="modal">
                                                        Close
                                                    </button>
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
                                                    <button type="button" class="close" data-dismiss="modal">&times;
                                                    </button>
                                                </div>
                                                <form action="{{route('admin.provider.contract.update')}}"
                                                      method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-6 mb-2">
                                                                <label>Contract Name
                                                                    <span class="text-danger">*</span>
                                                                </label>
                                                                <select name="contract_name"
                                                                        class="form-control form-control-sm" required>
                                                                    <option value=""></option>
                                                                    @foreach($contact_name as $conname)
                                                                        <option
                                                                            value="{{$conname->contact_name}}" {{$pcontract->contract_name == $conname->contact_name ? 'selected' : ''}}>{{$conname->contact_name}}</option>
                                                                    @endforeach
                                                                </select>
                                                                <input type="hidden"
                                                                       class="form-control form-control-sm"
                                                                       name="contract_edit_id"
                                                                       value="{{$pcontract->id}}" required>
                                                            </div>
                                                            <div class="col-md-6 mb-2">
                                                                <label>Onset Date<span
                                                                        class="text-danger">*</span></label>
                                                                <input type="date" class="form-control form-control-sm"
                                                                       name="onset_date"
                                                                       value="{{$pcontract->onset_date}}">
                                                            </div>

                                                            <div class="col-md-6 mb-2">
                                                                <label>End Date<span
                                                                        class="text-danger">*</span></label>
                                                                <input type="date" class="form-control form-control-sm"
                                                                       name="end_date" value="{{$pcontract->end_date}}">
                                                            </div>
                                                            <div class="col-md-6 mb-2">
                                                                <label>Followup Date<span
                                                                        class="text-danger">*</span></label>
                                                                <input type="date" name="contract_followup_date"
                                                                       value="{{$pcontract->contract_followup_date}}"
                                                                       class="form-control form-control-sm">
                                                            </div>
                                                            <div class="col-md-6 mb-2">
                                                                <label>Contract Type<span
                                                                        class="text-danger">*</span></label>
                                                                <select class="form-control form-control-sm"
                                                                        name="contract_type">
                                                                    <option value=""></option>
                                                                    @foreach($contact_type as $contype)
                                                                        <option
                                                                            value="{{$contype->id}}" {{$pcontract->contract_type == $contype->id ? 'selected' : ''}}>{{$contype->contact_type}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6 mb-2">
                                                                <label>Contract Status<span class="text-danger"></span></label>
                                                                <select class="form-control form-control-sm"
                                                                        name="con_status" required>
                                                                    <option value=""></option>
                                                                    @foreach($contact_status as $status)
                                                                        <option
                                                                            value="{{$status->id}}" {{$pcontract->status == $status->id ? 'selected':'' }}>{{$status->contact_status}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6 mb-2">
                                                                <label>Assigned to<span
                                                                        class="text-danger">*</span></label>
                                                                <select class="form-control form-control-sm"
                                                                        name="assign_to_name">
                                                                    <option value=""></option>
                                                                    @foreach($assign_users as $assuser)
                                                                        @if ($assuser->user_type == 2)
                                                                            <?php
                                                                            $manager_user = \App\Models\AccountManager::select('id', 'name')->where('id', $assuser->user_id)
                                                                                ->where('account_type', $assuser->user_type)
                                                                                ->first();
                                                                            ?>
                                                                            @if ($manager_user)
                                                                                <option
                                                                                    value="{{$manager_user->name}}" {{$manager_user->name == $pcontract->assign_to_name ? 'selected' : ''}}>{{$manager_user->name}}</option>
                                                                            @endif
                                                                        @elseif($assuser->user_type == 3)
                                                                            <?php
                                                                            $staff_user = \App\Models\BaseStaff::select('id', 'name')->where('id', $assuser->user_id)
                                                                                ->where('account_type', $assuser->user_type)
                                                                                ->first();
                                                                            ?>
                                                                            @if ($staff_user)
                                                                                <option
                                                                                    value="{{$staff_user->name}}" {{$staff_user->name == $pcontract->assign_to_name ? 'selected' : ''}}>{{$staff_user->name}}</option>
                                                                            @endif
                                                                        @elseif($assuser->user_type == 1)
                                                                            <?php
                                                                            $admin_user = \App\Models\Admin::select('id', 'name')->where('id', $assuser->user_id)
                                                                                ->where('account_type', $assuser->user_type)
                                                                                ->first();
                                                                            ?>
                                                                            @if ($admin_user)
                                                                                <option
                                                                                    value="{{$admin_user->name}}" {{$admin_user->name == $pcontract->assign_to_name ? 'selected' : ''}}>{{$admin_user->name}}</option>
                                                                            @endif
                                                                        @else
                                                                        @endif

                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6 mb-2">
                                                                <label>Document 1<span class="text-danger"></span>
                                                                    @if (!empty($pcontract->contact_document) && file_exists($pcontract->contact_document))
                                                                        <a href="{{asset($pcontract->contact_document)}}"
                                                                           style="margin-left: 5px;">Download File</a>
                                                                    @endif

                                                                </label>
                                                                <input type="file" name="contact_document"
                                                                       class="form-control form-control-sm">
                                                            </div>


                                                            <div class="col-md-6 mb-2">
                                                                <label>Document 2<span
                                                                        class="text-danger"></span>
                                                                    @if (!empty($pcontract->contact_document_one) && file_exists($pcontract->contact_document_one))
                                                                        <a href="{{asset($pcontract->contact_document_one)}}"
                                                                           style="margin-left: 5px;">Download File</a>
                                                                    @endif
                                                                </label>
                                                                <input type="file" name="contact_document_one"
                                                                       class="form-control form-control-sm">
                                                            </div>
                                                            <div class="col-md-6 mb-2">
                                                                <label>Document 3<span
                                                                        class="text-danger"></span>
                                                                    @if (!empty($pcontract->contact_document_two) && file_exists($pcontract->contact_document_two))
                                                                        <a href="{{asset($pcontract->contact_document_two)}}"
                                                                           style="margin-left: 5px;">Download File</a>
                                                                    @endif
                                                                </label>
                                                                <input type="file" name="contact_document_two"
                                                                       class="form-control form-control-sm">
                                                            </div>
                                                            <div class="col-md-6 mb-2">
                                                                <label>Document 4<span
                                                                        class="text-danger"></span>
                                                                    @if (!empty($pcontract->contact_document_three) && file_exists($pcontract->contact_document_three))
                                                                        <a href="{{asset($pcontract->contact_document_three)}}"
                                                                           style="margin-left: 5px;">Download File</a>
                                                                    @endif
                                                                </label>
                                                                <input type="file" name="contact_document_three"
                                                                       class="form-control form-control-sm">
                                                            </div>
                                                            <div class="col-md-6 mb-2">
                                                                <label>Document 5<span
                                                                        class="text-danger"></span>
                                                                    @if (!empty($pcontract->contact_document_four) && file_exists($pcontract->contact_document_four))
                                                                        <a href="{{asset($pcontract->contact_document_four)}}"
                                                                           style="margin-left: 5px;">Download File</a>
                                                                    @endif
                                                                </label>
                                                                <input type="file" name="contact_document_four"
                                                                       class="form-control form-control-sm">
                                                            </div>
                                                            <div class="col-md-6 mb-2">
                                                                <label>Document 6<span
                                                                        class="text-danger"></span>
                                                                    @if (!empty($pcontract->contact_document_five) && file_exists($pcontract->contact_document_five))
                                                                        <a href="{{asset($pcontract->contact_document_five)}}"
                                                                           style="margin-left: 5px;">Download File</a>
                                                                    @endif
                                                                </label>
                                                                <input type="file" name="contact_document_five"
                                                                       class="form-control form-control-sm">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">Save</button>
                                                        <button type="button" class="btn btn-danger"
                                                                data-dismiss="modal">Close
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/ editContract  -->
                                </td>
                                <td>
                                    @if ($pcontract->is_assign == 1)
                                        <?php
                                        if ($pcontract->assign_to_type == 1) {
                                            $assignto_admin = \App\Models\Admin::where('id', $pcontract->assign_to_id)->first();
                                        } elseif ($pcontract->assign_to_type == 2) {
                                            $assignto_manager = \App\Models\AccountManager::where('id', $pcontract->assign_to_id)->first();
                                        } elseif ($pcontract->assign_to_type == 3) {
                                            $assignto_staff = \App\Models\BaseStaff::where('id', $pcontract->assign_to_id)->first();
                                        }

                                        ?>

                                        @if ($pcontract->assign_to_type == 1)
                                            @if ($assignto_admin)
                                                {{$assignto_admin->name}}
                                            @endif

                                        @elseif($pcontract->assign_to_type == 2)
                                            @if ($assignto_manager)
                                                {{$assignto_manager->name}}
                                            @endif

                                        @elseif($pcontract->assign_to_type == 3)
                                            @if ($assignto_staff)
                                                {{$assignto_staff->name}}
                                            @endif

                                        @else

                                        @endif


                                    @endif
                                </td>
                                <td>
                                    @if ($con_status)
                                        {{$con_status->contact_status}}
                                    @endif

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
@include('admin.provider.include.contractjs')
