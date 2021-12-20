@extends('layouts.accountManager')
@section('accountmanager')
    <div class="iq-card">
        <div class="iq-card-body">

            <h2 class="common-title">Reminder</h2>
            <div class="table-responsive">
                <table class="table table-sm table-bordered">
                    <thead>
                    <tr>
                        <th>Facility Name</th>
                        <th>Provider Name</th>
                        <th>Contract Name</th>
                        <th>Followup Date</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($reminders as $notes)
                        <?php
                        $fac_name = \App\Models\practice::select('id', 'business_name')->where('id', $notes->facility_id)->first();
                        $prov_name = \App\Models\Provider::select('id', 'full_name')->where('id', $notes->provider_id)->first();
                        $con_name = \App\Models\provider_contract::select('id', 'contract_name')->where('id', $notes->contract_id)->first();
                        $status_name = \App\Models\contract_status::where('id', $notes->status)->first();
                        ?>
                        <tr>
                            <td>
                                @if ($fac_name)
                                    {{$fac_name->business_name}}
                                @endif
                            </td>
                            <td>
                                @if ($prov_name)
                                    <a href="{{route('admin.provider.contract',$notes->provider_id)}}" target="_blank">
                                        {{$prov_name->full_name}}
                                    </a>
                                @endif
                            </td>
                            <td>
                                @if ($con_name)
                                    {{$con_name->contract_name}}
                                @endif
                            </td>
                            <td>{{\Carbon\Carbon::parse($notes->followup_date)->format('m/d/Y')}}</td>
                            <td>
                                @if ($status_name)
                                    {{$status_name->contact_status}}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{$reminders->links()}}
            </div>
        </div>
    </div>
@endsection
