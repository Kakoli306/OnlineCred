<table class="table table-sm table-bordered">
    <thead>
    <tr>
        <th>Facility Name</th>
        <th>Provider Name</th>
        <th>Contract Name</th>
        <th>Worked Date</th>
        <th>Followup Date</th>
        <th>Status</th>
        <th>CreatedBy/AssignedTo</th>
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

        @if ($status_name && $status_name->is_show_reminder == 1)
            <tr>
                <td>
                    @if ($fac_name)
                        {{$fac_name->business_name}}
                    @endif
                </td>
                <td>
                    @if ($prov_name)
                        <a href="{{route('admin.provider.contract',$notes->provider_id)}}"
                           target="_blank">
                            {{$prov_name->full_name}}
                        </a>
                    @endif
                </td>
                <td>
                    @if ($con_name)
                        {{$con_name->contract_name}}
                    @endif
                </td>
                <td>
                    @if ($notes->worked_date != null || $notes->worked_date != "")
                        {{\Carbon\Carbon::parse($notes->worked_date)->format('m/d/Y')}}
                    @endif
                </td>
                <td>
                    @if ($notes->followup_date != null || $notes->followup_date != "")
                        {{\Carbon\Carbon::parse($notes->followup_date)->format('m/d/Y')}}
                    @endif
                </td>
                <td>
                    @if ($status_name)
                        {{$status_name->contact_status}}
                    @endif
                </td>
                <td>
                    <?php
                    $create_by_admin = \App\Models\Admin::where('id', $notes->user_id)->where('account_type', $notes->user_type)->first();
                    $create_by_manager = \App\Models\AccountManager::where('id', $notes->user_id)->where('account_type', $notes->user_type)->first();
                    $create_by_staff = \App\Models\BaseStaff::where('id', $notes->user_id)->where('account_type', $notes->user_type)->first();

                    ?>
                    @if ($create_by_admin)
                        CreatedBy- {{$create_by_admin->name}}
                    @elseif($create_by_manager)
                        CreatedBy- {{$create_by_manager->name}}
                    @elseif($create_by_staff)
                        CreatedBy- {{$create_by_staff->name}}
                    @else
                    @endif

                    @if ($notes->is_assign == 1)
                        <?php
                        if ($notes->assignedto_user_type == 1) {
                            $assignto_admin = \App\Models\Admin::where('id', $notes->assignedto_user_id)->first();
                        } elseif ($notes->assignedto_user_type == 2) {
                            $assignto_manager = \App\Models\AccountManager::where('id', $notes->assignedto_user_id)->first();
                        } elseif ($notes->assignedto_user_type == 3) {
                            $assignto_staff = \App\Models\BaseStaff::where('id', $notes->assignedto_user_id)->first();
                        }

                        ?>
                        @if ($notes->assignedto_user_type == 1)
                            @if ($assignto_admin)
                                / AssignedTo-{{$assignto_admin->name}}
                            @endif

                        @elseif($notes->assignedto_user_type == 2)
                            @if ($assignto_manager)
                                / AssignedTo-{{$assignto_manager->name}}
                            @endif

                        @elseif($notes->assignedto_user_type == 3)
                            @if ($assignto_staff)
                                / AssignedTo-{{$assignto_staff->name}}
                            @endif

                        @else

                        @endif


                    @endif
                </td>
            </tr>
        @endif


    @endforeach
    </tbody>
</table>
{{$reminders->links()}}
