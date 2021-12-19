<div class="table-responsive provider_table">
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
        @foreach($providers as $data)
            <?php
            $provider_info = \App\Models\Provider_info::where('provider_id', $data->id)->first();
            ?>
            <tr>
                <td><a href="{{route('account.manager.provider.info',$data->id)}}" class="mr-2">{{$data->full_name}}</a>
                </td>
                <td>
                    <p>{{$data->phone}}</p>
                </td>
                <td>{{\Carbon\Carbon::parse($data->dob)->format('m/d/Y')}}</td>
                <td>{{$data->gender}}</td>
                <td>
                    @if ($provider_info)
                        {{$provider_info->speciality}}
                    @endif
                </td>
                <td>
                    <a href="#mycontract{{$data->id}}" data-toggle="modal"><i class="fa fa-id-card-o"
                                                                              aria-hidden="true"></i></a>
                    <!-- Contract Modal -->
                    <div class="modal fade" id="mycontract{{$data->id}}" data-backdrop="static">
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
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $provider_cons = \App\Models\provider_contract::where('provider_id', $data->id)->get();
                                        ?>
                                        @foreach($provider_cons as $conts)
                                            <?php
                                            $status_name = \App\Models\contract_status::where('id', $conts->status)->first();
                                            $con_type = \App\Models\contact_type::where('id', $conts->contract_type)->first();
                                            ?>
                                            <tr>
                                                <td>{{$conts->contract_name}}</td>
                                                <td>{{\Carbon\Carbon::parse($conts->onset_date)->format('m/d/Y')}}</td>
                                                <td>{{\Carbon\Carbon::parse($conts->end_date)->format('m/d/Y')}}</td>
                                                <td>
                                                    @if ($con_type)
                                                        {{$con_type->contact_type}}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($status_name)
                                                        {{$status_name->contact_status}}
                                                    @endif
                                                </td>

                                                <td><a href="{{route('admin.provider.contract',$conts->provider_id)}}">Go
                                                        To
                                                        Contract</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <a href="{{route('admin.provider.contract',$data->id)}}"
                                       class="btn btn-primary border-white">Add Contract</a>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
                <td>
                    @if ($data->is_active == 1)
                        <i class="ri-checkbox-blank-circle-fill text-success" title="Active"></i>
                    @else
                        <i class="ri-checkbox-blank-circle-fill text-danger" title="In-Active"></i>
                    @endif

                </td>
                <td>
                    <div class="dropdown">
                        <a class="btn btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                            Manage
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="{{route('account.manager.provider.info',$data->id)}}">Edit
                                provider
                                info</a>
                            <a class="dropdown-item text-danger" href="#">Make inactive</a>
                            <a class="dropdown-item text-danger" href="{{route('admin.provider.delete',$data->id)}}">Delete
                                Provider</a>
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
</div>
<nav class="overflow-hidden">
    {{$providers->links()}}
</nav>
<?php
