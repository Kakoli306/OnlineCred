@extends('layouts.admin')
@section('admin')
    <div class="iq-card">
        <div class="iq-card-body">
            <h2 class="common-title">Admin</h2>
            <div class="table-responsive">
                <table class="table table-sm table-bordered c_table">
                    <thead>
                    <tr>
                        <th>User Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($all_admins as $admin)
                        <tr>
                            <td>{{$admin->name}}</td>
                            <td>{{$admin->email}}</td>
                            <td>{{$admin->phone_number}}</td>
                            <td>
                                <i class="ri-checkbox-blank-circle-fill text-success"></i>
                            </td>
                            <td>
                                <a href="{{route('admin.user.edit',['id'=>$admin->id,'type'=>1])}}" title="Edit"
                                   class="text-primary mr-2"><i
                                        class="ri-edit-box-line"></i></a>
                                <a href="#" title="Delete" class="text-danger mr-2"><i
                                        class="ri-delete-bin-line"></i></a>
                                <a href="#changeType{{$admin->id}}" data-toggle="modal" title="Change"
                                   class="text-primary mr-2"><i class="ri-user-shared-line"></i></a>
                                <!-- modal -->
                                <div class="modal fade" id="changeType{{$admin->id}}" data-backdrop="static">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4>Change User Account</h4>
                                                <button type="button" class="close"
                                                        data-dismiss="modal">&times;
                                                </button>
                                            </div>
                                            <form action="#">
                                                <div class="modal-body">
                                                    <div class="d-flex">
                                                        <div class="mr-2 align-self-center"><label>Select
                                                                Type</label></div>
                                                        <div class="align-self-center">
                                                            <select class="form-control form-control-sm">
                                                                <option value="0">Select Any</option>
                                                                <option value="2">Account Manager</option>
                                                                <option value="3">Base Staff</option>
                                                                <option value="4">Mis</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button"
                                                            class="btn btn-secondary">Save
                                                    </button>
                                                    <button type="button" class="btn btn-danger"
                                                            data-dismiss="modal">Close
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
