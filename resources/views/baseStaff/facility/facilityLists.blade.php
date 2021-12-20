@extends('layouts.baseStaff')
@section('basestaffheaderselect')
    <div class="iq-search-bar">
        <h5>ABC Behavioral Therapy Center</h5>
    </div>
@endsection
@section('basestaff')
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
