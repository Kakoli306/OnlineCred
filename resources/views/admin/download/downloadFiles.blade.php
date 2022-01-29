@extends('layouts.admin')

@section('admin')

    <div class="iq-card">
        <div class="iq-card-body">

            <h2 class="common-title">Download Files</h2>


            <div class="table-responsive reminderTable">
                <table class="table table-sm table-bordered" id="all_rem_table">
                    <thead style="background-color: #375EB7 !important;color: white">
                    <tr>
                        <th>File Type</th>
                        <th>File Name</th>
                        <th>Created Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($reports as $report)
                        <tr>
                            <td>
                                @if($report->report_type == 1)
                                    Reminder
                                @elseif($report->report_type == 2)
                                    Report
                                @else
                                    Not Set
                                @endif
                            </td>
                            <td>{{$report->report_name}}</td>
                            <td>{{\Carbon\Carbon::parse($report->created_at)->format('m/d/Y')}}</td>
                            <td>
                                @if($report->is_completed == 1)
                                    Pending
                                @elseif($report->is_completed == 2)
                                    Complete
                                @else
                                    Not Set
                                @endif
                            </td>
                            <td>
                                @if ($report->is_completed == 1)
                                    <button type="button" class="btn text-primary p-0">Export</button>
                                @else
                                    @if( $report->report_type == 1)
                                        <a href="{{route('admin.reminder.download.file',$report->id)}}" target="_blank">
                                            <button type="button" class="btn text-primary p-0">Export</button>
                                        </a>
                                    @else
                                        <a href="{{route('admin.report.export',$report->id)}}" target="_blank">
                                            <button type="button" class="btn text-primary p-0">Export</button>
                                        </a>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
@endsection

