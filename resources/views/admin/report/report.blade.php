@extends('layouts.admin')
@section('headerselect')
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
                        <label>Facility</label>
                        <select class="form-control form-control-sm all_faciity" name="facility_id" required>
                            <option value=""></option>
                        </select>
                    </div>
                    <div class="mr-2 mb-2">
                        <label>Provider</label>
                        <select class="form-control form-control-sm all_provider" name="provider_id" required>
                            <option value=""></option>
                        </select>
                    </div>
                    <div class="mr-2 mb-2">
                        <label>Contracts</label>
                        <select class="form-control form-control-sm all_cotract" name="contact_id" required>
                            <option value=""></option>
                        </select>
                    </div>
                    <div class="mr-2 mb-2">
                        <label>Status</label>
                        <select class="form-control form-control-sm" name="status" required>
                            <option value=""></option>
                            <option value="In-Process">In-Process</option>
                            <option value="Pending">Pending</option>
                            <option value="In-Network">In-Network</option>
                            <option value="Closed">Closed</option>
                            <option value="Completed">Completed</option>
                        </select>
                    </div>
                    <div class="mr-2 mb-2">
                        <label>From Date</label>
                        <input type="date" class="form-control form-control-sm" name="form_date" required>
                    </div>
                    <div class="mr-2 mb-2">
                        <label>To Date</label>
                        <input type="date" class="form-control form-control-sm" name="to_date" required>
                    </div>
                    <div class="align-self-end mb-2">
                        <button type="submit" class="btn btn-sm btn-primary">Export</button>
                    </div>
                </div>
            </form>
            <!--/ Filter -->
            <h2 class="common-title">Download History</h2>
            <div class="table-responsive">
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
            </div>
        </div>
    </div>
@endsection
@include('admin.report.include.reportinc')
