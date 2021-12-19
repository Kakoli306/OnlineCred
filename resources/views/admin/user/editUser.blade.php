@extends('layouts.admin')
@section('admin')
    <div class="iq-card">
        <div class="iq-card-body">
            <h2 class="common-title">Create/Edit User</h2>
            <form action="{{route('admin.create.user.update')}}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="row">
                            <div class="col-lg-3 col-md-4">
                                <label>User Name</label>
                            </div>
                            <div class="col-lg-7 col-md-8">
                                <input type="text" name="name" value="{{$user->name}}"
                                       class="form-control form-control-sm" required="">
                                <input type="hidden" name="user_id" value="{{$user->id}}"
                                       class="form-control form-control-sm" required="">
                                <input type="hidden" name="user_type" value="{{$type_id}}"
                                       class="form-control form-control-sm" required="">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="row">
                            <div class="col-lg-3 col-md-4">
                                <label>Actual Name</label>
                            </div>
                            <div class="col-lg-7 col-md-8">
                                <input type="text" name="actual_name" value="{{$user->actual_name}}"
                                       class="form-control form-control-sm" required="">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="row">
                            <div class="col-lg-3 col-md-4">
                                <label>Email ID</label>
                            </div>
                            <div class="col-lg-7 col-md-8">
                                <input type="email" name="email" value="{{$user->email}}"
                                       class="form-control form-control-sm" required="">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="row">
                            <div class="col-lg-3 col-md-4">
                                <label>Phone Number</label>
                            </div>
                            <div class="col-lg-7 col-md-8">
                                <input type="tel" name="phone_number" value="{{$user->phone_number}}"
                                       class="form-control form-control-sm" required="">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="row">
                            <div class="col-lg-3 col-md-4">
                                <label>A/C Password</label>
                            </div>
                            <div class="col-lg-7 col-md-8">
                                <input type="password" name="password" class="form-control form-control-sm">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="row">
                            <div class="col-lg-3 col-md-4">
                                <label>A/C Status</label>
                            </div>
                            <div class="col-lg-7 col-md-8">
                                <select class="form-control form-control-sm" name="account_status" required="">
                                    <option value="">Select Any</option>
                                    <option value="1" {{$user->account_status == 1? 'selected' : ''}}>Active</option>
                                    <option value="2" {{$user->account_status == 2? 'selected' : ''}}>De-Active</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="row">
                            <div class="col-lg-3 col-md-4">
                                <label>A/C Type</label>
                            </div>
                            <div class="col-lg-7 col-md-8">
                                <select class="form-control form-control-sm" name="account_type" required="">
                                    <option value="0">Select Any</option>
                                    <option value="1" {{$user->account_type == 1? 'selected' : ''}}>Admin</option>
                                    <option value="2" {{$user->account_type == 2? 'selected' : ''}}>Account Manager
                                    </option>
                                    <option value="3" {{$user->account_type == 3? 'selected' : ''}}>Base Staff</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <hr>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
