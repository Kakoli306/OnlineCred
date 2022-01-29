@extends('layouts.admin')
@section('css')
    <link rel="stylesheet"
          href="{{asset('assets/multisel/bootstrap-multiselect.css')}}">

@endsection
@section('admin')
    <div class="loading2">
        <div class="table-loading"></div>
    </div>
    <div class="iq-card">
        <div class="iq-card-body">

            <h2 class="common-title">Reminder</h2>

            <form action="{{route('admin.reminder.export')}}" method="post">
                @csrf
                <div class="d-flex mb-3">
                    <div class="mr-2">
                        <label>Facility Name</label>
                        <select class="form-control form-control-sm all_prc_data" name="all_prc_data">

                        </select>
                    </div>
                    <div class="mr-2">
                        <label>Select Provider</label>
                        <br>
                        <select id="all_prov_name" name="all_prov_name[]"
                                class="all_prov_name form-control form-control-sm"
                                multiple="multiple">

                        </select>

                    </div>
                    <div class="mr-2">
                        <label>Contract Name</label>
                        <br>
                        <select id="all_con_data" name="all_con_data[]"
                                class="form-control form-control-sm all_con_data" multiple="multiple">

                        </select>
                    </div>
                    <div class="mr-2">
                        <label>Followup Date</label>
                        <input type="date" class="form-control form-control-sm fowllowup_filter">
                    </div>
                    <div class="mr-2">
                        <label>Status</label>
                        <br>

                        <select id="all_status_data" name="all_status_data[]"
                                class="form-control form-control-sm all_status_data"
                                multiple="multiple">

                        </select>
                    </div>
                    <div class="align-self-end">
                        <button type="button" class="btn btn-sm btn-primary" id="goBtn">Go</button>
                    </div>
                    <div class="align-self-end" style="margin-left: 10px;">
                        <button type="submit" class="btn btn-sm btn-primary" id="goBtn">Export Excel</button>
                    </div>
                </div>
            </form>

            <div class="table-responsive reminderTable">
                <table class="table table-sm table-bordered" id="all_rem_table">
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
@include('admin.reminder.include.reminderIncjs')
