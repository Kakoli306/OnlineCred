@extends('layouts.baseStaff')
@section('basestaff')
    <div class="iq-card">
        <div class="iq-card-body">

            <h2 class="common-title">Reminder</h2>

            <div class="d-flex mb-3">
                <div class="mr-2">
                    <label>Facility Name</label>
                    <select class="form-control form-control-sm all_prc_data">

                    </select>
                </div>
                <div class="mr-2">
                    <label>Provider Name</label>
                    <select class="form-control form-control-sm all_prov_name">

                    </select>
                </div>
                <div class="mr-2">
                    <label>Contract Name</label>
                    <select class="form-control form-control-sm all_con_data">

                    </select>
                </div>
                <div class="mr-2">
                    <label>Followup Date</label>
                    <input type="date" class="form-control form-control-sm fowllowup_filter">
                </div>
                <div class="mr-2">
                    <label>Status</label>
                    <select class="form-control form-control-sm status_filter">
                        <option value=""></option>
                        @foreach($status as $sta)
                            <option value="{{$sta->id}}">{{$sta->contact_status}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="align-self-end">
                    <button type="button" class="btn btn-sm btn-primary" id="goBtn">Go</button>
                </div>
            </div>

            <div class="table-responsive reminderTable">

            </div>
        </div>
    </div>
@endsection
@include('baseStaff.reminders.include.reminderIncjs')
