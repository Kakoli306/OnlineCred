@extends('layouts.admin')
@section('admin')
    <div class="iq-card">
        <div class="iq-card-body">
            <div class="d-lg-flex">
                <!-- menu -->
                <div class="setting_menu">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a href="{{route('admin.setting.contact.name')}}">contract name</a>
                            <a href="{{route('admin.setting.contact.type')}}">contract type</a>
                            <a href="{{route('admin.setting.speciality')}}">speciality</a>
                            <a href="{{route('admin.setting.insurance')}}">Insurance</a>
                            <a href="{{route('admin.setting.document.type')}}">Document Type</a>
                            <a href="{{route('admin.setting.contract.status')}}" class="active">Contract Status</a>
                        </li>
                    </ul>
                </div>
                <!-- content -->
                <div class="all_content flex-fill">
                    <div class="overflow-hidden">
                        <div class="float-left">
                            <h5 class="common-title">Contract Status</h5>
                        </div>
                        <div class="float-right">
                            <a href="#addDoc" class="btn btn-sm btn-primary" data-toggle="modal">+
                                Add
                                Contract Status</a>
                        </div>
                    </div>
                    <!-- Create Contract modal -->
                    <div class="modal fade" id="addDoc" data-backdrop="static">
                        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4>Create Contract Status</h4>
                                    <button type="button" class="close"
                                            data-dismiss="modal">&times;
                                    </button>
                                </div>
                                <form action="{{route('admin.setting.contract.status.save')}}" method="post">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-8 mb-2">
                                                <label>Contract Status Name
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" name="contact_status"
                                                       class="form-control form-control-sm"
                                                       required>
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <label>Is Show Reminder
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <select class="form-control form-control-sm" name="is_show_reminder">
                                                    <option value="0"></option>
                                                    <option value="1">Yes</option>
                                                    <option value="2">No</option>
                                                </select>
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
                    <!-- table -->
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered c_table auth_table">
                            <thead>
                            <tr>
                                <th>Contract Status Name</th>
                                <th>Show Reminder</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($all_contract_status as $status)
                                <tr>
                                    <td>{{$status->contact_status}}</td>
                                    <td>
                                        @if ($status->is_show_reminder == 1)
                                            Yes
                                        @elseif($status->is_show_reminder == 2)
                                            No
                                        @else
                                            Not Set
                                        @endif
                                    </td>
                                    <td>
                                        <a href="#editconstatus{{$status->id}}" title="Edit" data-toggle="modal">
                                            <i class="ri-pencil-line mr-2"></i>
                                        </a>
                                        <a href="{{route('admin.setting.contract.status.delete',$status->id)}}"
                                           title="Delete">
                                            <i class="ri-delete-bin-6-line text-danger"></i>
                                        </a>
                                    </td>
                                </tr>


                                <div class="modal fade" id="editconstatus{{$status->id}}" data-backdrop="static">
                                    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4>Update Contract Status</h4>
                                                <button type="button" class="close"
                                                        data-dismiss="modal">&times;
                                                </button>
                                            </div>
                                            <form action="{{route('admin.setting.contract.status.update')}}"
                                                  method="post">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-8 mb-2">
                                                            <label>Contract Status Name
                                                                <span class="text-danger">*</span>
                                                            </label>
                                                            <input type="text" name="contact_status"
                                                                   value="{{$status->contact_status}}"
                                                                   class="form-control form-control-sm"
                                                                   required>
                                                            <input type="hidden" name="contact_status_edit"
                                                                   value="{{$status->id}}"
                                                                   class="form-control form-control-sm"
                                                                   required>
                                                        </div>
                                                        <div class="col-md-4 mb-2">
                                                            <label>Is Show Reminder
                                                                <span class="text-danger">*</span>
                                                            </label>
                                                            <select class="form-control form-control-sm"
                                                                    name="is_show_reminder">
                                                                <option value="0"></option>
                                                                <option
                                                                    value="1" {{$status->is_show_reminder == 1 ? 'selected' : ''}}>
                                                                    Yes
                                                                </option>
                                                                <option
                                                                    value="2" {{$status->is_show_reminder == 2 ? 'selected' : ''}}>
                                                                    No
                                                                </option>
                                                            </select>
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

                            @endforeach
                            </tbody>
                        </table>
                        {{$all_contract_status->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
