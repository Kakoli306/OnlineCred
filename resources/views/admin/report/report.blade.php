@extends('layouts.admin')
@section('headerselect')
<link rel="stylesheet"
      href="{{asset('assets/multisel/bootstrap-multiselect.css')}}">
    <div class="iq-search-bar">
        <h5>ABC Behavioral Therapy Center</h5>
    </div>
@endsection
@section('admin')
    <div class="iq-card">
        <div class="iq-card-body">
            <!-- Filter -->
            <form action="{{route('admin.report.save')}}" method="post">
                @csrf
                <div class="d-flex">
                    <div class="mr-2 mb-2">
                        <label>Facility Name</label>
                        <!-- <select class="form-control form-control-sm all_faciity" name="facility_id" required>
                            <option value=""></option> -->
                            <select class="form-control form-control-sm all_prc_data" name="all_prc_data">

                        </select>
                    </div>
                    <div class="mr-2 mb-2">
                        <label>Select Provider</label>
                        <!-- <select class="form-control form-control-sm all_provider" name="provider_id" required>
                            <option value=""></option> -->
                            <br>
                            <select id="all_prov_name" name="all_prov_name[]"
                                    class="all_prov_name form-control form-control-sm"
                                    multiple="multiple">
                        </select>
                    </div>
                    <div class="mr-2 mb-2">
                        <label>Contract Name</label>
                        <br>
                        <!-- <select class="form-control form-control-sm all_cotract" name="contact_id" required>
                            <option value=""></option> -->
                            <select id="all_con_data" name="all_con_data[]"
                                    class="form-control form-control-sm all_con_data" multiple="multiple">
                        </select>
                    </div>
                    <div class="mr-2 mb-2">
                        <label>Worked Date</label>
                        <br>
                        <input type="date" class="form-control form-control-sm worked_filter">

                    </div>
                    <div class="mr-2">
                        <label>Followup Date</label>
                        <input type="date" class="form-control form-control-sm fowllowup_filter">
                    </div>
                    <div class="mr-2 mb-2">
                        <label>Status</label>
                        <br>
                        <!-- <select class="form-control form-control-sm custom-select" name="report_status[]" multiple>
                            @foreach($all_status as $status)
                                <option value="{{$status->id}}">{{$status->contact_status}}</option>
                            @endforeach -->
                            <select id="all_status_data" name="all_status_data[]"
                                    class="form-control form-control-sm all_status_data"
                                    multiple="multiple">
                        </select>

                    </div>

                    <div class="mr-2 mb-2">
            <label>Account Type</label>
            <br>
                <select class="form-control form-control-sm account_type_user user_type">
                    <option value="0">Account Type</option>
                    <option value="1">Admin</option>
                    <option value="2">Account Manager</option>
                    <option value="3">Base Staff</option>
                </select>
            </div>
            <div class="mr-2">
            <label>Select User</label>
                <select class="form-control form-control-sm user_id">
                    <option value="0">Select User</option>
                </select>
            </div>
                    <!-- <div class="mr-2 mb-2">
                        <label>From Date</label>
                        <input type="date" class="form-control form-control-sm" name="form_date" required>
                    </div>
                    <div class="mr-2 mb-2">
                        <label>To Date</label>
                        <input type="date" class="form-control form-control-sm" name="to_date" required>
                    </div> -->

                    <div class="align-self-end">
                        <button type="button" class="btn btn-sm btn-primary" id="goBtn">Go</button>
                    </div>
                    <div class="align-self-end" style="margin-left: 10px;">
                        <button type="submit" class="btn btn-sm btn-primary" id="goBtn">Export Excel</button>
                    </div>
                </div>
            </form>
            <!--/ Filter -->
            <!-- <h2 class="common-title">Download History</h2> -->
            <!-- <div class="table-responsive">
                <table class="table table-sm table-bordered">
                    <thead>
                    <tr>
                        <th>File Name</th>
                        <th>Download Time</th>
                        <th>Downloaded By</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($all_reports as $report)
                        <tr>
                            <td>{{$report->report_name}}</td>
                            <td>{{\Carbon\Carbon::parse($report->report_time)->format('m/d/Y g:i:a')}}</td>
                            <td>{{Auth::user()->name}}</td>
                            <td class="text-primary">
                                @if ($report->is_completed == 1)
                                    Pending
                                @else
                                    Completed
                                @endif

                            </td>
                            <td>
                                @if ($report->is_completed == 1)
                                    <button type="button" class="btn text-primary p-0">Export</button>
                                @else
                                    <a href="{{route('admin.report.export',$report->id)}}" target="_blank">
                                        <button type="button" class="btn text-primary p-0">Export</button>
                                    </a>

                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{$all_reports->links()}}
            </div> -->
            <div class="table-responsive reminderTable">
                <table class="table table-sm table-bordered" >
                    <thead style="background-color: #375EB7 !important;color: white">
                    <tr>
                        <th>Facility Name</th>
                        <th>Provider Name</th>
                        <th>Contract Name</th>
                        <th>Followup Date</th>
                        <th>Status</th>
                        <th>CreatedBy/AssignedTo</th>
                      
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
@endsection
@include('admin.report.include.reportIncjs')
