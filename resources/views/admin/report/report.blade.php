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
        <div class="d-flex">
            <div class="mr-2 mb-2">
                <label>Facility</label>
                <select class="form-control form-control-sm all_faciity">

                </select>
            </div>
            <div class="mr-2 mb-2">
                <label>Provider</label>
                <select class="form-control form-control-sm all_provider">
                    <option></option>
                    <option>Lorem ipsum dolor sit.</option>
                </select>
            </div>
            <div class="mr-2 mb-2">
                <label>Contracts</label>
                <select class="form-control form-control-sm all_cotract">
                    <option></option>
                    <option>Lorem ipsum dolor sit.</option>
                </select>
            </div>
            <div class="mr-2 mb-2">
                <label>Status</label>
                <select class="form-control form-control-sm">
                    <option></option>
                    <option>Lorem ipsum dolor sit.</option>
                </select>
            </div>
            <div class="mr-2 mb-2">
                <label>From Date</label>
                <input type="date" class="form-control form-control-sm">
            </div>
            <div class="mr-2 mb-2">
                <label>To Date</label>
                <input type="date" class="form-control form-control-sm">
            </div>
            <div class="align-self-end mb-2">
                <button type="button" class="btn btn-sm btn-primary">Export</button>
            </div>
        </div>
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
                    <tr>
                        <td>Lorem ipsum dolor sit</td>
                        <td>4/9/2021 at 12.01pm</td>
                        <td>extra@example.com</td>
                        <td class="text-primary">Completed</td>
                        <td>
                            <button type="button" class="btn text-primary p-0">Export</button>
                        </td>
                    </tr>
                    <tr>
                        <td>Lorem ipsum dolor sit</td>
                        <td>4/9/2021 at 12.01pm</td>
                        <td>extra@example.com</td>
                        <td class="text-danger">Pending</td>
                        <td>
                            <button type="button" class="btn text-primary p-0">Export</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
    $(document).ready(function() {
        let getAllFacility = function() {
            $.ajax({
                type: "POST",
                url: "{{route('admin.report.get.all.facility')}}",
                data: {
                    '_token': "{{csrf_token()}}",
                },
                success: function(data) {
                    console.log(data);
                    $('.all_faciity').empty();
                    $('.all_faciity').append(
                        `<option value="0"></option>`
                    );
                    $.each(data, function(index, value) {
                        $('.all_faciity').append(
                            `<option value="${value.id}">${value.business_name}</option>`
                        );
                    });

                }
            });
        };

        getAllFacility();


        $('.all_faciity').change(function() {
            let fac_id = $(this).val();
            $.ajax({
                type: "POST",
                url: "{{route('admin.report.provider.by.facility')}}",
                data: {
                    '_token': "{{csrf_token()}}",
                    'fac_id': fac_id
                },
                success: function(data) {
                    console.log(data);
                    $('.all_provider').empty();
                    $('.all_provider').append(
                        `<option value="0"></option>`
                    );
                    $.each(data, function(index, value) {
                        $('.all_provider').append(
                            `<option value="${value.id}">${value.full_name}</option>`
                        );
                    });

                }
            });
        });


        $('.all_provider').change(function() {
            let prov_id = $(this).val();
            $.ajax({
                type: "POST",
                url: "{{route('admin.report.contract.by.provider')}}",
                data: {
                    '_token': "{{csrf_token()}}",
                    'prov_id': prov_id
                },
                success: function(data) {
                    console.log(data);
                    $('.all_cotract').empty();
                    $('.all_cotract').append(
                        `<option value="0"></option>`
                    );
                    $.each(data, function(index, value) {
                        $('.all_cotract').append(
                            `<option value="${value.id}">${value.full_name}</option>`
                        );
                    });

                }
            });
        })



    })
</script>
@endsection