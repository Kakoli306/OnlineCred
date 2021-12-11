@extends('layouts.admin')
@section('admin')
    <div class="iq-card">
        <div class="iq-card-body">
            <div class="d-lg-flex">
                <!-- menu -->
                <div class="setting_menu">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a href="{{route('admin.setting.contact.name')}}" class="active">contract name</a>
                            <a href="{{route('admin.setting.contact.type')}}">contract type</a>
                            <a href="{{route('admin.setting.speciality')}}">speciality</a>
                            <a href="{{route('admin.setting.insurance')}}">Insurance</a>
                            <a href="{{route('admin.setting.document.type')}}">Document Type</a>
                            <a href="{{route('admin.setting.contract.status')}}">Contract Status</a>
                        </li>
                    </ul>
                </div>
                <!-- content -->
                <div class="all_content flex-fill">
                    <div class="overflow-hidden">
                        <div class="float-left">
                            <h5 class="common-title">Contract Name</h5>
                        </div>
                        <div class="float-right">
                            <a href="#addDoc" class="btn btn-sm btn-primary" data-toggle="modal">+
                                Add
                                Contract Name</a>
                        </div>
                    </div>
                    <!-- Create Contract modal -->
                    <div class="modal fade" id="addDoc" data-backdrop="static">
                        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4>Create Contract Name</h4>
                                    <button type="button" class="close"
                                            data-dismiss="modal">&times;
                                    </button>
                                </div>
                                <form action="{{route('admin.setting.contact.name.save')}}" method="post">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-2">
                                                <label>Contract Name
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" name="contact_name"
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
                                <th>Contract Name</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($all_contact_name as $con_name)
                                <tr>
                                    <td>{{$con_name->contact_name}}</td>
                                    <td>
                                        <a href="#editcon{{$con_name->id}}" title="Edit" data-toggle="modal">
                                            <i class="ri-pencil-line mr-2"></i>
                                        </a>
                                        <a href="{{route('admin.setting.contact.name.delete',$con_name->id)}}"
                                           title="Delete">
                                            <i class="ri-delete-bin-6-line text-danger"></i>
                                        </a>
                                    </td>
                                </tr>


                                <div class="modal fade" id="editcon{{$con_name->id}}" data-backdrop="static">
                                    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4>Update Contract Name</h4>
                                                <button type="button" class="close"
                                                        data-dismiss="modal">&times;
                                                </button>
                                            </div>
                                            <form action="{{route('admin.setting.contact.name.update')}}" method="post">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-6 mb-2">
                                                            <label>Contract Name
                                                                <span class="text-danger">*</span>
                                                            </label>
                                                            <input type="text" name="contact_name"
                                                                   value="{{$con_name->contact_name}}"
                                                                   class="form-control form-control-sm"
                                                                   required>
                                                            <input type="hidden" name="contact_name_edit"
                                                                   value="{{$con_name->id}}"
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
                        {{$all_contact_name->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
