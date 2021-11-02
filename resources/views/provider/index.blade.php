@extends('layouts.provider')
@section('headerselect')
    <div class="iq-search-bar">
        <?php
        $assign_prc = \App\Models\assign_practice::where('provider_id',Auth::user()->id)->first();
        if ($assign_prc) {
            $prc_name = \App\Models\practice::where('id',$assign_prc->practice_id)->first();
        }
        ?>
        @if ($assign_prc && $prc_name)
            <h5>{{$prc_name->business_name}}</h5>
        @endif

    </div>
@endsection
@section('proider')
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
                    @foreach($assign_prac as $prc)
                        <?php
                            $prac_name = \App\Models\practice::where('id',$prc->practice_id)->first();
                        ?>
                        <tr>
                            <td>{{$prac_name->business_name}}</td>
                            <td>{{$prac_name->dba_name}}</td>
                            <td>{{$prac_name->tax_id}}</td>
                            <td>{{$prac_name->npi}}</td>
                            <td>{{$prac_name->address}}</td>
                            <td>{{$prac_name->city}}</td>
                            <td>{{$prac_name->state}}</td>
                            <td>{{$prac_name->zip}}</td>
                            <td>{{$prac_name->phone_number}}</td>
                            <td>{{$prac_name->medicaid}}</td>
                        </tr>
                    @endforeach
                    <tbody>
                    </tbody>
                </table>
                {{$assign_prac->links()}}
            </div>
        </div>
    </div>
@endsection
