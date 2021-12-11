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
                            <a href="{{route('admin.setting.document.type')}}" class="active">Document Type</a>
                            <a href="{{route('admin.setting.contract.status')}}">Contract Status</a>
                        </li>
                    </ul>
                </div>
                <!-- content -->
                <div class="all_content flex-fill">
                    <div class="overflow-hidden">
                        <div class="float-left">
                            <h5 class="common-title">Document Type</h5>
                        </div>
                        <div class="float-right">
                            <a href="#addDocType" class="btn btn-sm btn-primary" data-toggle="modal">+
                                Add
                                Document Type</a>
                        </div>
                    </div>
                    <!-- Create Contract modal -->
                    <div class="modal fade" id="addDocType" data-backdrop="static">
                        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4>Create Document Type</h4>
                                    <button type="button" class="close"
                                            data-dismiss="modal">&times;
                                    </button>
                                </div>
                                <form action="{{route('admin.setting.document.type.save')}}" method="post">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12 mb-2">
                                                <label>Document Type Name
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" name="description"
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
                                <th>Document Type Name</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($all_documents as $document)
                                <tr>
                                    <td>{{$document->doc_type_name}}</td>
                                    <td>
                                        <a href="#editdoctype{{$document->id}}" title="Edit" data-toggle="modal">
                                            <i class="ri-pencil-line mr-2"></i>
                                        </a>
                                        <a href="{{route('admin.setting.document.type.delete',$document->id)}}"
                                           title="Delete">
                                            <i class="ri-delete-bin-6-line text-danger"></i>
                                        </a>
                                    </td>
                                </tr>


                                <div class="modal fade" id="editdoctype{{$document->id}}" data-backdrop="static">
                                    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4>Update Document Type</h4>
                                                <button type="button" class="close"
                                                        data-dismiss="modal">&times;
                                                </button>
                                            </div>
                                            <form action="{{route('admin.setting.document.type.update')}}"
                                                  method="post">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-12 mb-2">
                                                            <label>Document Type Name
                                                                <span class="text-danger">*</span>
                                                            </label>
                                                            <input type="text" name="description"
                                                                   value="{{$document->description}}"
                                                                   class="form-control form-control-sm"
                                                                   required>
                                                            <input type="hidden" name="document_type_edit"
                                                                   value="{{$document->id}}"
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
                        {{$all_documents->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
