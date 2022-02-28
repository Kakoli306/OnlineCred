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
                    <a class="nav-link" href="{{route('admin.provider.contract',$provider->id)}}">Contracts</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.provider.document',$provider->id)}}">Documents</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{route('admin.provider.insurance.document',$provider->id)}}">Insurance
                        Documents</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="{{route('admin.provider.portal',$provider->id)}}">Provider Portal</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.provider.online.access',$provider->id)}}">Online Access</a>
                </li>
                {{--                <li class="nav-item">--}}
                {{--                    <a class="nav-link" href="{{route('admin.provider.tracking.user',$provider->id)}}">Tracking Muster</a>--}}
                {{--                </li>--}}
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.provider.activity',$provider->id)}}">Provider Activity</a>
                </li>
            </ul>
            <div class="all_content flex-fill">
                <div class="overflow-hidden">
                    <div class="float-left">
                        <h2 class="common-title">Provider Insurance Documents</h2>
                    </div>
                    {{--                    <div class="float-right" style="margin-left: 5px;"><a href="#addocType" data-toggle="modal"--}}
                    {{--                                                                          class="btn btn-sm btn-primary">+ Create--}}
                    {{--                            Document Type</a></div>--}}
                    <div class="float-right"><a href="#adInsdoc" data-toggle="modal" class="btn btn-sm btn-primary">+
                            Add Insurance
                            Document</a></div>
                </div>
                <!-- Add Document -->
                <div class="modal fade" id="adInsdoc" data-backdrop="static">
                    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4>Add Insurance Document</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <form action="{{route('admin.provider.insurance.document.save')}}" method="post"
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="row no-gutters">
                                        <div class="col-md-4 pr-2">
                                            <label>Contract Name</label>
                                            <select class="form-control form-control-sm contract_name_id"
                                                    name="contract_name_id" required>
                                                <option value=""></option>
                                                @foreach($contract_name as $con_name)
                                                    <option
                                                        value="{{$con_name->id}}">{{$con_name->contact_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4 pr-2">
                                            <label>Document Type</label>
                                            <select class="form-control form-control-sm document_type"
                                                    name="document_type_id">
                                                <option value=""></option>
                                                @foreach($document_types as $doc_types)
                                                    <option
                                                        value="{{$doc_types->id}}">{{$doc_types->doc_type_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4 pr-2">
                                            <label>Description</label>
                                            <input type="text" class="form-control form-control-sm" name="description">
                                            <input type="hidden" class="form-control form-control-sm" name="provider_id"
                                                   value="{{$provider->id}}">
                                        </div>
                                        <div class="col-md-4 pr-2">
                                            <label>File</label>
                                            <input type="file" class="form-control form-control-sm" name="prov_ins_file" >
                                           
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


                <div class="table-responsive">
                    <table class="table table-sm table-bordered c_table">
                        <thead>
                        <tr>
                            <th>Contract Name</th>
                            <th>Document Type</th>
                            <th>Description</th>
                            <th>Uploaded On</th>
                            <th>Created By</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($all_ins_dcouments as $ins_doc)
                            <?php
                            $con_name = \App\Models\contact_name::where('id', $ins_doc->contract_name_id)->first();
                            $doc_name = \App\Models\provider_document_type::where('id', $ins_doc->document_type_id)->first();
                            ?>
                            <tr>
                                <td>
                                    @if($con_name)
                                        {{$con_name->contact_name}}
                                    @endif
                                </td>
                                <td>
                                    @if($doc_name)
                                        {{$doc_name->doc_type_name}}
                                    @endif
                                </td>
                                <td>
                                    {!! $ins_doc->description !!}
                                </td>
                                <td>
                                    @if ($ins_doc->created_on != null || $ins_doc->created_on != "")
                                        {{\Carbon\Carbon::parse($ins_doc->created_on)->format('m/d/Y')}}
                                    @endif

                                </td>
                                <td>
                                    {{$ins_doc->created_by}}
                                </td>

                                <td>
                                @if (!empty($ins_doc->prov_ins_file) && file_exists($ins_doc->prov_ins_file))
                                        <a href="{{asset($ins_doc->prov_ins_file)}}" target="_blank" title="View">
                                            <i class="ri-eye-line text-success mr-2"></i>
                                        </a>
                                    @else
                                        <a href="#" title="View">
                                            <i class="ri-eye-line text-success mr-2"></i>
                                        </a>
                                    @endif

                                    <a href="#editinsdoc{{$ins_doc->id}}" title="Edit" data-toggle="modal">
                                        <i class="ri-pencil-line mr-2"></i>
                                    </a>
                                    <a href="{{route('admin.provider.insurance.document.delete',$ins_doc->id)}}"
                                       title="Delete">
                                        <i class="ri-delete-bin-6-line text-danger"></i>
                                    </a>
                                    <!-- Edit Document -->
                                    <div class="modal fade" id="editinsdoc{{$ins_doc->id}}" data-backdrop="static">
                                        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4>Edit Insurance Document</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;
                                                    </button>
                                                </div>
                                                <form action="{{route('admin.provider.insurance.document.update')}}"
                                                      method="post"
                                                      enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="row no-gutters">
                                                            <div class="col-md-4 pr-2">
                                                                <label>Contract Name</label>
                                                                <select
                                                                    class="form-control form-control-sm contract_name_id"
                                                                    name="contract_name_id" required>
                                                                    <option value=""></option>
                                                                    @foreach($contract_name as $con_name)
                                                                        <option
                                                                            value="{{$con_name->id}}" {{$ins_doc->contract_name_id == $con_name->id ? 'selected':''}}>{{$con_name->contact_name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-4 pr-2">
                                                                <label>Document Type</label>
                                                                <select
                                                                    class="form-control form-control-sm document_type"
                                                                    name="document_type_id">
                                                                    <option value=""></option>
                                                                    @foreach($document_types as $doc_types)
                                                                        <option
                                                                            value="{{$doc_types->id}}" {{$ins_doc->document_type_id == $doc_types->id ? 'selected' :''}}>{{$doc_types->doc_type_name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-4 pr-2">
                                                                <label>Description</label>
                                                                <input type="text" class="form-control form-control-sm"
                                                                       name="description"
                                                                       value="{{$ins_doc->description}}">
                                                                <input type="hidden"
                                                                       class="form-control form-control-sm"
                                                                       name="provider_id"
                                                                       value="{{$provider->id}}">
                                                                <input type="hidden"
                                                                       class="form-control form-control-sm"
                                                                       name="edit_ins_doc"
                                                                       value="{{$ins_doc->id}}">
                                                            </div>
                                                            <div class="col-md-4 pr-2">
                                                                <label>File</label>
                                                                <input type="file" class="form-control form-control-sm"
                                                                       name="prov_ins_file" id="prov_ins_file"
                                                                       value="{{$ins_doc->prov_ins_file}}">
                                                                
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
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{$all_ins_dcouments->links()}}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')

@endsection

