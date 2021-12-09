@extends('layouts.admin')
@section('headerselect')
    <div class="iq-search-bar">
        <h5>ABC Behavioral Therapy Center</h5>
    </div>
@endsection
@section('admin')
    <div class="iq-card">
        <div class="iq-card-body">
            <h2 class="common-title">All Practice</h2>
            <div class="table-responsive">
                <table class="table table-sm table-bordered c_table">
                    <thead>
                    <tr>
                        <th>Business Name</th>
                        <th>DBA Name</th>
                        <th>Tax Id No.</th>
                        <th>NPI</th>
                        <th>Address</th>
                        <th>City</th>
                        <th>State</th>
                        <th>Zip</th>
                        <th>Phone Number</th>
                        <th>Medicaid</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    @foreach($all_practices as $prc)
                        <tr>
                            <td>{{$prc->business_name}}</td>
                            <td>{{$prc->dba_name}}</td>
                            <td>{{$prc->tax_id}}</td>
                            <td>{{$prc->npi}}</td>
                            <td>{{$prc->address}}</td>
                            <td>{{$prc->city}}</td>
                            <td>{{$prc->state}}</td>
                            <td>{{$prc->zip}}</td>
                            <td>{{$prc->phone_number}}</td>
                            <td>{{$prc->medicaid}}</td>
                            <td>
                                <a href="#editPractice{{$prc->id}}" data-toggle="modal"><i
                                        class="ri-edit-box-line mr-2"></i></a>
                                <a href="{{route('admin.practice.delete',$prc->id)}}"><i
                                        class="ri-delete-bin-6-line text-danger"></i></a>
                                <!-- Edit Practice modal -->
                                <div class="modal fade" id="editPractice{{$prc->id}}" data-backdrop="static">
                                    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4>Edit Practice</h4>
                                                <button type="button" class="close"
                                                        data-dismiss="modal">&times;
                                                </button>
                                            </div>
                                            <form action="{{route('admin.practice.update')}}" method="post"
                                                  enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-6 mb-2">
                                                            <label>Business Name<span
                                                                    class="text-danger">*</span></label>
                                                            <input type="text"
                                                                   class="form-control form-control-sm"
                                                                   name="business_name" value="{{$prc->business_name}}"
                                                                   required>
                                                            <input type="hidden" class="form-control form-control-sm"
                                                                   name="prc_edit_id" value="{{$prc->id}}" required>
                                                        </div>
                                                        <div class="col-md-6 mb-2">
                                                            <label>DBA Name<span
                                                                    class="text-danger">*</span></label>
                                                            <input type="text"
                                                                   class="form-control form-control-sm" name="dba_name"
                                                                   value="{{$prc->dba_name}}" required>
                                                        </div>
                                                        <div class="col-md-6 mb-2">
                                                            <label>Tax Id No.<span
                                                                    class="text-danger">*</span></label>
                                                            <input type="text"
                                                                   class="form-control form-control-sm" name="tax_id"
                                                                   value="{{$prc->tax_id}}"
                                                                   data-mask="00-0000000" pattern=".{10}" required>
                                                        </div>
                                                        <div class="col-md-6 mb-2">
                                                            <label>NPI<span class="text-danger">*</span></label>
                                                            <input type="text"
                                                                   class="form-control form-control-sm" name="npi"
                                                                   value="{{$prc->npi}}"
                                                                   data-mask="0000000000" pattern=".{10}" required>
                                                        </div>
                                                        <div class="col-md-6 mb-2">
                                                            <label>Address<span
                                                                    class="text-danger">*</span></label>
                                                            <input type="text" name="address" value="{{$prc->address}}"
                                                                   class="form-control form-control-sm" required>
                                                        </div>
                                                        <div class="col-md-6 mb-2">
                                                            <div class="row">
                                                                <div class="col-md">
                                                                    <label>City<span
                                                                            class="text-danger">*</span></label>
                                                                    <input type="text" name="city"
                                                                           value="{{$prc->city}}"
                                                                           class="form-control form-control-sm"
                                                                           required>
                                                                </div>
                                                                <div class="col-md">
                                                                    <label>State<span
                                                                            class="text-danger">*</span></label>
                                                                    <input type="text" name="state"
                                                                           value="{{$prc->state}}"
                                                                           class="form-control form-control-sm"
                                                                           required>
                                                                </div>
                                                                <div class="col-md">
                                                                    <label>Zip<span
                                                                            class="text-danger">*</span></label>
                                                                    <input type="text" name="zip" value="{{$prc->zip}}"
                                                                           class="form-control form-control-sm"
                                                                           required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 mb-2">
                                                            <label>Phone Number<span
                                                                    class="text-danger">*</span></label>
                                                            <input type="text" name="phone_number"
                                                                   value="{{$prc->phone_number}}"
                                                                   class="form-control form-control-sm"
                                                                   data-mask="(000)-000-0000" pattern=".{14,}"
                                                                   required="" autocomplete="off" maxlength="14">
                                                        </div>
                                                        <div class="col-md-6 mb-2">
                                                            <label>Medicaid</label>
                                                            <input type="text" name="medicaid"
                                                                   value="{{$prc->medicaid}}"
                                                                   class="form-control form-control-sm">
                                                        </div>
                                                        <div class="col-md-6 mb-2">
                                                            <label>Document<span
                                                                    class="text-danger">*</span></label>
                                                            <input type="file" name="doc_file"
                                                                   class="form-control form-control-sm">
                                                        </div>
                                                        <div class="col-md-6 mb-2" style="margin-top: 30px;">
                                                            @if (!empty($prc->doc_file) && file_exists($prc->doc_file))
                                                                <a href="{{asset($prc->doc_file)}}" target="_blank">View
                                                                    Document</a>
                                                            @else
                                                                <a target="_blank">View Document</a>
                                                            @endif

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">Save<i
                                                            class='bx bx-loader align-middle ml-2'></i></button>
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
                    <tbody>
                    </tbody>
                </table>
                {{$all_practices->links()}}
            </div>
        </div>
    </div>
@endsection
