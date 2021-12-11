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
                            <a href="{{route('admin.setting.insurance')}}" class="active">Insurance</a>
                            <a href="{{route('admin.setting.document.type')}}">Document Type</a>
                            <a href="{{route('admin.setting.contract.status')}}">Contract Status</a>
                        </li>
                    </ul>
                </div>
                <!-- content -->
                <div class="all_content flex-fill">
                    <div class="overflow-hidden">
                        <div class="float-left">
                            <h5 class="common-title">Insurance</h5>
                        </div>
                        <div class="float-right">
                            <a href="#addDoc" class="btn btn-sm btn-primary" data-toggle="modal">+
                                Add
                                Insurance</a>
                        </div>
                    </div>
                    <!-- Create Contract modal -->
                    <div class="modal fade" id="addDoc" data-backdrop="static">
                        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4>Create Insurance</h4>
                                    <button type="button" class="close"
                                            data-dismiss="modal">&times;
                                    </button>
                                </div>
                                <form action="{{route('admin.setting.insurance.save')}}" method="post">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-2">
                                                <label>Insurance Name
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" name="insurnace_name"
                                                       class="form-control form-control-sm"
                                                       required>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <label>Insurance type
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" name="insurnace_type"
                                                       class="form-control form-control-sm"
                                                       required>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <label>Practice Name
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" name="insurnace_practice_name"
                                                       class="form-control form-control-sm"
                                                       required>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <label>Country
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" name="insurnace_country"
                                                       class="form-control form-control-sm"
                                                       required>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <label>City
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" name="insurnace_city"
                                                       class="form-control form-control-sm"
                                                       required>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <label>State
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" name="insurnace_state"
                                                       class="form-control form-control-sm"
                                                       required>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <label>Contract /Network Manager
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" name="insurnace_contract"
                                                       class="form-control form-control-sm"
                                                       required>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <label>Phone
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" name="insurnace_phone"
                                                       class="form-control form-control-sm"
                                                       required>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <label>Email
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" name="insurnace_email"
                                                       class="form-control form-control-sm"
                                                       required>
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
                                <th>Insurance Name</th>
                                <th>Insurance type</th>
                                <th>Practice Name</th>
                                <th>Country</th>
                                <th>City</th>
                                <th>State</th>
                                <th>Contract</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($all_insurnace as $ins)
                                <tr>
                                    <td>{{$ins->insurnace_name}}</td>
                                    <td>{{$ins->insurnace_type}}</td>
                                    <td>{{$ins->insurnace_practice_name}}</td>
                                    <td>{{$ins->insurnace_country}}</td>
                                    <td>{{$ins->insurnace_city}}</td>
                                    <td>{{$ins->insurnace_state}}</td>
                                    <td>{{$ins->insurnace_contract}}</td>
                                    <td>{{$ins->insurnace_phone}}</td>
                                    <td>{{$ins->insurnace_email}}</td>
                                    <td>
                                        <a href="#editins{{$ins->id}}" title="Edit" data-toggle="modal">
                                            <i class="ri-pencil-line mr-2"></i>
                                        </a>
                                        <a href="{{route('admin.setting.insurance.delete',$ins->id)}}"
                                           title="Delete">
                                            <i class="ri-delete-bin-6-line text-danger"></i>
                                        </a>
                                    </td>
                                </tr>


                                <div class="modal fade" id="editins{{$ins->id}}" data-backdrop="static">
                                    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4>Create Insurance</h4>
                                                <button type="button" class="close"
                                                        data-dismiss="modal">&times;
                                                </button>
                                            </div>
                                            <form action="{{route('admin.setting.insurance.update')}}" method="post">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-6 mb-2">
                                                            <label>Insurance Name
                                                                <span class="text-danger">*</span>
                                                            </label>
                                                            <input type="text" name="insurnace_name"
                                                                   value="{{$ins->insurnace_name}}"
                                                                   class="form-control form-control-sm"
                                                                   required>
                                                            <input type="hidden" name="insurnace_edit"
                                                                   value="{{$ins->id}}"
                                                                   class="form-control form-control-sm"
                                                                   required>
                                                        </div>
                                                        <div class="col-md-6 mb-2">
                                                            <label>Insurance type
                                                                <span class="text-danger">*</span>
                                                            </label>
                                                            <input type="text" name="insurnace_type"
                                                                   value="{{$ins->insurnace_type}}"
                                                                   class="form-control form-control-sm"
                                                                   required>
                                                        </div>
                                                        <div class="col-md-6 mb-2">
                                                            <label>Practice Name
                                                                <span class="text-danger">*</span>
                                                            </label>
                                                            <input type="text" name="insurnace_practice_name"
                                                                   value="{{$ins->insurnace_practice_name}}"
                                                                   class="form-control form-control-sm"
                                                                   required>
                                                        </div>
                                                        <div class="col-md-6 mb-2">
                                                            <label>Country
                                                                <span class="text-danger">*</span>
                                                            </label>
                                                            <input type="text" name="insurnace_country"
                                                                   value="{{$ins->insurnace_country}}"
                                                                   class="form-control form-control-sm"
                                                                   required>
                                                        </div>
                                                        <div class="col-md-6 mb-2">
                                                            <label>City
                                                                <span class="text-danger">*</span>
                                                            </label>
                                                            <input type="text" name="insurnace_city"
                                                                   value="{{$ins->insurnace_city}}"
                                                                   class="form-control form-control-sm"
                                                                   required>
                                                        </div>
                                                        <div class="col-md-6 mb-2">
                                                            <label>State
                                                                <span class="text-danger">*</span>
                                                            </label>
                                                            <input type="text" name="insurnace_state"
                                                                   value="{{$ins->insurnace_state}}"
                                                                   class="form-control form-control-sm"
                                                                   required>
                                                        </div>
                                                        <div class="col-md-6 mb-2">
                                                            <label>Contract /Network Manager
                                                                <span class="text-danger">*</span>
                                                            </label>
                                                            <input type="text" name="insurnace_contract"
                                                                   value="{{$ins->insurnace_contract}}"
                                                                   class="form-control form-control-sm"
                                                                   required>
                                                        </div>
                                                        <div class="col-md-6 mb-2">
                                                            <label>Phone
                                                                <span class="text-danger">*</span>
                                                            </label>
                                                            <input type="text" name="insurnace_phone"
                                                                   value="{{$ins->insurnace_phone}}"
                                                                   class="form-control form-control-sm"
                                                                   required>
                                                        </div>
                                                        <div class="col-md-6 mb-2">
                                                            <label>Email
                                                                <span class="text-danger">*</span>
                                                            </label>
                                                            <input type="text" name="insurnace_email"
                                                                   value="{{$ins->insurnace_email}}"
                                                                   class="form-control form-control-sm"
                                                                   required>
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
                        {{$all_insurnace->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
