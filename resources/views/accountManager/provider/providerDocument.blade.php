@extends('layouts.accountManager')
@section('managerheaderselect')
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
@section('accountmanager')
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
                    <a href="{{route('account.manager.providers.list',$provider->practice_id)}}"
                       class="btn btn-sm btn-primary go_back">
                        <i class="ri-arrow-left-circle-line"></i>Back
                    </a>
                @else
                    <a href="{{route('account.manager.providers.list',0)}}"
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
                    <a class="nav-link" href="{{route('account.manager.provider.info',$provider->id)}}">Provider
                        Info</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"
                       href="{{route('account.manager.provider.contract',$provider->id)}}">Contracts</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{route('account.manager.provider.document',$provider->id)}}">Documents</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"
                       href="{{route('account.manager.provider.insurance.document',$provider->id)}}">Insurnace
                        Documents</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('account.manager.provider.portal',$provider->id)}}">Provider
                        Portal</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('account.manager.provider.online.access',$provider->id)}}">Online
                        Access</a>
                </li>
                {{--                <li class="nav-item">--}}
                {{--                    <a class="nav-link" href="{{route('admin.provider.tracking.user',$provider->id)}}">Tracking Muster</a>--}}
                {{--                </li>--}}
                <li class="nav-item">
                    <a class="nav-link" href="{{route('account.manager.provider.activity',$provider->id)}}">Provider
                        Activity</a>
                </li>
            </ul>
            <div class="all_content flex-fill">
                <div class="overflow-hidden">
                    <div class="float-left">
                        <h2 class="common-title">Provider Documents</h2>
                    </div>
                    {{--                    <div class="float-right" style="margin-left: 5px;"><a href="#addocType" data-toggle="modal"--}}
                    {{--                                                                          class="btn btn-sm btn-primary">+ Create--}}
                    {{--                            Document Type</a></div>--}}
                    <div class="float-right"><a href="#addoc" data-toggle="modal" class="btn btn-sm btn-primary">+ Add
                            Document</a></div>
                </div>
                <!-- Add Document -->
                <div class="modal fade" id="addoc" data-backdrop="static">
                    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4>Add Document</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <form action="{{route('account.manager.provider.document.save')}}" method="post"
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="row no-gutters">
                                        <div class="col-md-3 pr-2">
                                            <label>Document Type</label>
                                            <select class="form-control form-control-sm all_doc_type"
                                                    name="doc_type_id">
                                                <option value="Information Form">Information Form</option>
                                                <option value="License Copy">License Copy</option>
                                                <option value="Resume">Resume</option>
                                                <option value="Certificate">Certificate</option>
                                                <option value="CPR/First Aid">CPR/First Aid</option>
                                                <option value="Signature">Signature</option>
                                                <option value="PLI">PLI</option>
                                                <option value="W9 Form">W9 Form</option>
                                                <option value="Other">Other</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 pr-2">
                                            <label>Description</label>
                                            <input type="text" class="form-control form-control-sm" name="description">
                                            <input type="hidden" class="form-control form-control-sm" name="provider_id"
                                                   value="{{$provider->id}}">
                                        </div>
                                        <div class="col-md-3 pr-2">
                                            <label>Expiry Date</label>
                                            <input type="date" class="form-control form-control-sm" name="exp_date">
                                        </div>
                                        <div class="col-md-3">
                                            <label>Upload File</label>
                                            <input type="file" class="form-control-file" name="doc_file">
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
                            <th>Document Type</th>
                            <th>Description</th>
                            <th>Uploaded On</th>
                            <th>Created By</th>
                            <th>Expiry Date</th>
                            <th>Actions</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($provider_documents as $doc)
                            <tr>
                                <td>{{$doc->doc_type}}</td>
                                <td>{{$doc->description}}</td>
                                <td>
                                    {{\Carbon\Carbon::parse($doc->created_at)->format('m/d/Y')}}
                                </td>
                                <td>
                                    {{$doc->created_by}}
                                </td>
                                <td>
                                    @if ($doc->exp_date != null || $doc->exp_date != "")
                                        {{\Carbon\Carbon::parse($doc->exp_date)->format('m/d/Y')}}
                                    @endif


                                </td>

                                <td>
                                    @if (!empty($doc->file) && file_exists($doc->file))
                                        <a href="{{asset($doc->file)}}" target="_blank" title="View">
                                            <i class="ri-eye-line text-success mr-2"></i>
                                        </a>
                                    @else
                                        <a href="#" title="View">
                                            <i class="ri-eye-line text-success mr-2"></i>
                                        </a>
                                    @endif

                                    <a href="#editdoc{{$doc->id}}" title="Edit" data-toggle="modal">
                                        <i class="ri-pencil-line mr-2"></i>
                                    </a>
                                    <a href="{{route('account.manager.provider.document.delete',$doc->id)}}"
                                       title="Delete">
                                        <i class="ri-delete-bin-6-line text-danger"></i>
                                    </a>
                                    <!-- Edit Document -->
                                    <div class="modal fade" id="editdoc{{$doc->id}}" data-backdrop="static">
                                        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4>Edit Document</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;
                                                    </button>
                                                </div>
                                                <form action="{{route('account.manager.provider.document.update')}}"
                                                      method="post"
                                                      enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="row no-gutters">
                                                            <div class="col-md-3 pr-2">
                                                                <label>Document Type</label>
                                                                <select class="form-control form-control-sm"
                                                                        name="doc_type_id">
                                                                    @foreach($providers_doc_type as $doc_type)
                                                                        <option
                                                                            value="{{$doc_type->id}}" {{$doc->doc_type == $doc_type->doc_type_name ? 'selected' : ''}}>
                                                                            {{$doc_type->doc_type_name}}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-3 pr-2">
                                                                <label>Description</label>
                                                                <input type="text" class="form-control form-control-sm"
                                                                       name="description" value="{{$doc->description}}">
                                                                <input type="hidden"
                                                                       class="form-control form-control-sm"
                                                                       name="doc_edit_id" value="{{$doc->id}}">
                                                            </div>
                                                            <div class="col-md-3 pr-2">
                                                                <label>Expiry Date</label>
                                                                <input type="date" class="form-control form-control-sm"
                                                                       name="exp_date" value="{{$doc->exp_date}}">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label>Upload File</label>
                                                                <input type="file" class="form-control-file"
                                                                       name="doc_file">
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
                                <td><i class="ri-checkbox-blank-circle-fill text-success" title="Active"></i></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function () {


            const getAllType = () => {
                $.ajax({
                    type: "POST",
                    url: "{{route('account.manager.provider.get.all.doc.type')}}",
                    data: {
                        '_token': "{{csrf_token()}}",
                    },
                    success: function (data) {
                        $('.all_doc_type').empty();
                        $.each(data, function (index, value) {
                            $('.all_doc_type').append(
                                `<option value="${value.id}">${value.doc_type_name}</option>`
                            )
                        })


                    }
                });
            };


            getAllType();


        })
    </script>
@endsection

