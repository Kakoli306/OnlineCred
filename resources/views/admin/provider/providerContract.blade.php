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
                <a href="{{route('admin.providers.list',$provider->practice_id)}}"
                   class="btn btn-sm btn-primary go_back">
                    <i class="ri-arrow-left-circle-line"></i>Back
                </a>
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
                                            <select class="form-control form-control-sm" name="status" required>
                                                <option value=""></option>
                                                @foreach($contact_status as $status)
                                                    <option
                                                        value="{{$status->id}}">{{$status->contact_status}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label>Document<span class="text-danger"></span></label>
                                            <input type="file" name="contact_document"
                                                   class="form-control form-control-sm">
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label>Document<span class="text-danger"></span></label>
                                            <input type="file" name="contact_document_one"
                                                   class="form-control form-control-sm">
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label>Document<span class="text-danger"></span></label>
                                            <input type="file" name="contact_document_two"
                                                   class="form-control form-control-sm">
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label>Document<span class="text-danger"></span></label>
                                            <input type="file" name="contact_document_three"
                                                   class="form-control form-control-sm">
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label>Document<span class="text-danger"></span></label>
                                            <input type="file" name="contact_document_four"
                                                   class="form-control form-control-sm">
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label>Document<span class="text-danger"></span></label>
                                            <input type="file" name="contact_document_five"
                                                   class="form-control form-control-sm">
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label>Document<span class="text-danger"></span></label>
                                            <input type="file" name="contact_document_six"
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
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($provider_contracts as $pcontract)
                            <?php
                            $con_status = \App\Models\contract_status::where('id', $pcontract->status)->first();
                            $con_name = \App\Models\contact_name::where('contact_name', $pcontract->contract_name)->where('admin_id', Auth::user()->id)->first();
                            ?>
                            <tr>
                                <td>
                                    @if ($con_name)
                                        {{$con_name->contact_name}}
                                    @endif

                                </td>
                                <td>{{\Carbon\Carbon::parse($pcontract->onset_date)->format('m/d/Y')}}</td>
                                <td>{{\Carbon\Carbon::parse($pcontract->end_date)->format('m/d/Y')}}</td>
                                <td>commercial</td>
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
                                                <form action="{{route('admin.provider.contract.add.note')}}"
                                                      method="post">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-4 mb-2">
                                                                <label>Status</label>
                                                            </div>
                                                            <div class="col-md-8 mb-2">
                                                                <select class="form-control form-control-sm"
                                                                        name="note_status">
                                                                    <option value=""></option>
                                                                    @foreach($contact_status as $constatus)
                                                                        <option
                                                                            value="{{$constatus->contact_status}}">{{$constatus->contact_status}}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-4 mb-2">
                                                                <label>Worked Date</label>
                                                            </div>
                                                            <div class="col-md-8 mb-2">
                                                                <input type="date" class="form-control form-control-sm"
                                                                       name="worked_date" required>
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
                                                                <label>Follow Up Date</label>
                                                            </div>
                                                            <div class="col-md-8 mb-2">
                                                                <input type="date" class="form-control form-control-sm"
                                                                       name="followup_date" required>
                                                            </div>
                                                            <div class="col-md-4 mb-2">
                                                                <label>Notes</label>
                                                            </div>
                                                            <div class="col-md-8 mb-2">
                                                                <textarea class="form-control form-control-sm"
                                                                          name="note"></textarea>
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
                                                                        name="status" required>
                                                                    <option value=""></option>
                                                                    @foreach($contact_status as $status)
                                                                        <option
                                                                            value="{{$status->id}}" {{$pcontract->status == $status->id ? 'selected':'' }}>{{$status->contact_status}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6 mb-2">
                                                                <label>Document<span class="text-danger"></span>
                                                                    @if (!empty($pcontract->contact_document) && file_exists($pcontract->contact_document))
                                                                        <a href="{{asset($pcontract->contact_document)}}"
                                                                           style="margin-left: 5px;">Download File</a>
                                                                    @else

                                                                    @endif

                                                                </label>
                                                                <input type="file" name="contact_document"
                                                                       class="form-control form-control-sm">
                                                            </div>


                                                            <div class="col-md-6 mb-2">
                                                                <label>Document<span class="text-danger"></span></label>
                                                                <input type="file" name="contact_document_one"
                                                                       class="form-control form-control-sm">
                                                            </div>
                                                            <div class="col-md-6 mb-2">
                                                                <label>Document<span class="text-danger"></span></label>
                                                                <input type="file" name="contact_document_two"
                                                                       class="form-control form-control-sm">
                                                            </div>
                                                            <div class="col-md-6 mb-2">
                                                                <label>Document<span class="text-danger"></span></label>
                                                                <input type="file" name="contact_document_three"
                                                                       class="form-control form-control-sm">
                                                            </div>
                                                            <div class="col-md-6 mb-2">
                                                                <label>Document<span class="text-danger"></span></label>
                                                                <input type="file" name="contact_document_four"
                                                                       class="form-control form-control-sm">
                                                            </div>
                                                            <div class="col-md-6 mb-2">
                                                                <label>Document<span class="text-danger"></span></label>
                                                                <input type="file" name="contact_document_five"
                                                                       class="form-control form-control-sm">
                                                            </div>
                                                            <div class="col-md-6 mb-2">
                                                                <label>Document<span class="text-danger"></span></label>
                                                                <input type="file" name="contact_document_six"
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
