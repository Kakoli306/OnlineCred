<table class="table table-sm table-bordered c_table">
    <thead>
    <tr>
        <th style="width: 150px;">name</th>
        <th style="width: 150px;">contact info</th>
        <th style="width: 150px;">DOB</th>
        <th style="width: 150px;">gender</th>
        <th>Speciality</th>
        <th>Contract</th>
        <th>Status</th>
        <th>manage</th>
    </tr>
    </thead>
    <tbody class="text-center">
    @foreach($providers as $provider)
        <tr>
            <td><a href="{{route('admin.provider.info',$provider->id)}}" class="mr-2">{{$provider->full_name}}</a></td>
            <td>
                <p>{{$provider->phone}}</p>
            </td>
            <td>{{\Carbon\Carbon::parse($provider->dob)->format('m/d/Y')}}</td>
            <td>{{$provider->gender}}</td>
            <td>{{$provider->speciality}}</td>
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
