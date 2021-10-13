@extends('layouts.admin')
@section('headerselect')
    <div class="iq-search-bar">
        <?php
            $all_facility = \App\Models\practice::where('admin_id',Auth::user()->id)->get();
        ?>
        <select class="form-control form-control-sm fac_id">
            <option value="0">----- Select Facility -----</option>
            @foreach($all_facility as $fac)
            <option value="{{$fac->id}}">{{$fac->business_name}}</option>
            @endforeach
        </select>
    </div>
@endsection
@section('admin')
    <div class="iq-card-body">
        <div class="d-flex justify-content-between mb-3">
            <div class="mr-3 align-self-center">
                <h2 class="common-title mb-0">All Provider</h2>
            </div>
            <div>
                <a class="btn btn-sm btn-primary" href="#createProviderNew" data-toggle="modal">
                    <i class="ri-add-line"></i>Add Provider
                </a>
            </div>
        </div>


        <div class="modal fade" id="createProviderNew" data-backdrop="static">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4>Create Provider</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <form action="#">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label>First Name<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm first_name" required>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label>Last Name<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm last_name" required>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label>Contact Info<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm phone_num" data-mask="(000)-000-0000" pattern=".{14,}" required="" autocomplete="off" maxlength="14">
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label>DOB<span class="text-danger">*</span></label>
                                    <input type="date" class="form-control form-control-sm dob" required>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label>Gender<span class="text-danger">*</span></label>
                                    <select class="form-control form-control-sm gender">
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" id="createProvider">Create & Continue<i class='bx bx-loader align-middle ml-2'></i></button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>



        <div class="table-responsive">
            <table class="table table-sm table-bordered c_table">
                <thead>
                <tr>
                    <th style="width: 150px;">name</th>
                    <th style="width: 150px;">contact info</th>
                    <th style="width: 150px;">DOB</th>
                    <th style="width: 150px;">gender</th>
                    <th style="width: 150px;">Credential</th>
                    <th>Speciality</th>
                    <th>Contract</th>
                    <th>Status</th>
                    <th>manage</th>
                </tr>
                </thead>
                <tbody class="text-center">
                @foreach($providers as $provider)
                <tr>
                    <td><a href="{{route('admin.provider.info',$provider->id)}}" class="mr-2">{{$provider->first_name}}</a></td>
                    <td>
                        <p>{{$provider->phone}}</p>
                    </td>
                    <td>{{\Carbon\Carbon::parse($provider->dob)->format('m/d/Y')}}</td>
                    <td>{{$provider->gender}}</td>
                    <td>Loren</td>
                    <td>Miami</td>
                    <td>
                        <a href="#mycontract{{$provider->id}}" data-toggle="modal"><i class="fa fa-id-card-o" aria-hidden="true"></i></a>
                        <!-- Contract Modal -->
                        <div class="modal fade" id="mycontract{{$provider->id}}" data-backdrop="static">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4>All Contracts</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <h5 class="common-title">Contract List</h5>
                                        <table class="table table-sm c_table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>Contract Name</th>
                                                <th>Onset Date</th>
                                                <th>End Date</th>
                                                <th>Contract Type</th>
                                                <th>Pin No</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                                $provider_cons = \App\Models\provider_contract::where('provider_id',$provider->id)->get();
                                            ?>
                                            @foreach($provider_cons as $conts)
                                            <tr>
                                                <td>{{$conts->contract_name}}</td>
                                                <td>{{\Carbon\Carbon::parse($conts->onset_date)->format('m/d/Y')}}</td>
                                                <td>{{\Carbon\Carbon::parse($conts->end_date)->format('m/d/Y')}}</td>
                                                <td>commercial</td>
                                                <td>{{$conts->pin_no}}</td>
                                                <td>
                                                    <i class="ri-checkbox-blank-circle-fill text-success" title="Active"></i>
                                                </td>
                                                <td><a href="{{route('admin.provider.contract',$conts->provider_id)}}">Go To Contract</a>
                                                </td>
                                            </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="modal-footer">
                                        <a href="{{route('admin.provider.contract',$provider->id)}}" class="btn btn-primary border-white">Add Contract</a>
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td><i class="ri-checkbox-blank-circle-fill text-success" title="Active"></i>
                    </td>
                    <td>
                        <div class="dropdown">
                            <a class="btn btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                                Manage
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="{{route('admin.provider.info',$provider->id)}}">Edit provider
                                    info</a>
                                <a class="dropdown-item text-danger" href="#">Make inactive</a>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach

                </tbody>
            </table>
            <!-- pagination -->
            <nav class="overflow-hidden">
                {{$providers->links()}}
            </nav>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function () {


            $('#createProvider').click(function () {
                let fac_id = $('.fac_id').val();
                let first_name = $('.first_name').val();
                let last_name = $('.last_name').val();
                let phone_num = $('.phone_num').val();
                let dob = $('.dob').val();
                let gender = $('.gender').val();

                $.ajax({
                    type : "POST",
                    url: "{{route('admin.provider.save')}}",
                    data : {
                        '_token' : "{{csrf_token()}}",
                        'fac_id' : fac_id,
                        'first_name' : first_name,
                        'last_name' : last_name,
                        'phone_num' : phone_num,
                        'dob' : dob,
                        'gender' : gender,
                    },
                    success:function(data){
                        console.log(data);
                        location.reload();
                    }
                });
            })



        })
    </script>
@endsection
