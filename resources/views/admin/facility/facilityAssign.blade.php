@extends('layouts.admin')
@section('headerselect')
    <div class="iq-search-bar">
        <div class="row">
            <div class="col-md-6">
                <select class="form-control form-control-sm account_type_user">
                    <option value="0">Account Type</option>
                    <option value="2">Account Manager</option>
                    <option value="3">Base Sraff</option>
                </select>
            </div>
            <div class="col-md-6">
                <select class="form-control form-control-sm user_id">
                    <option value="0">Select User</option>
                </select>
            </div>
        </div>
    </div>
@endsection
@section('admin')
    <div class="loading2">
        <div class="table-loading"></div>
    </div>
    <div class="iq-card-body">
        <h2 class="common-title">Assign Practice</h2>
        <div class="row">
            <div class="col-md-4">
                <label>All Practice</label>
                <select class="form-control form-control-sm all_practice" multiple>

                </select>
                <button type="button" class="btn btn-sm btn-primary mt-2">Add All</button>
            </div>
            <div class="col-md-4 text-center mt-5">
                <div class="mb-2">
                    <button type="button" class="btn btn-sm btn-primary" id="addbtn">Add</button>
                </div>
                <div>
                    <button type="button" class="btn btn-sm btn-danger" id="removebtn">Remove</button>
                </div>
            </div>
            <div class="col-md-4">
                <label>Assign Practice</label>
                <select class="form-control form-control-sm assign_prac" multiple>
                </select>
                <button type="button" class="btn btn-sm btn-danger mt-2">Remove All</button>
            </div>
        </div>


    </div>



@endsection
@section('js')
    <script>

        $(document).ready(function () {
            //get all provider
            getAllShow();


            $('.account_type_user').change(function () {
                let type_id = $(this).val();
                if (type_id == 0) {
                    toastr["error"]("Please Select User Type ", 'ALERT!');
                } else {
                    $.ajax({
                        type: "POST",
                        url: "{{route('admin.get.all.user')}}",
                        data: {
                            '_token': "{{csrf_token()}}",
                            'type_id': type_id
                        },
                        success: function (data) {
                            $('.user_id').empty();
                            $('.user_id').append(
                                `<option value="0">select user</option>`
                            )
                            $.each(data, function (index, value) {
                                $('.user_id').append(
                                    `<option value="${value.id}">${value.name}</option>`
                                )
                            });

                        }
                    });
                }
            })


            //add facility
            $('#addbtn').click(function () {
                let account_type_user = $('.account_type_user').val();
                let user_id = $('.user_id').val();
                let fac_id = $('.all_practice').val();

                let arr = [];
                $('.all_practice').each(function () {
                    arr.push($(this).val())
                })


                if (account_type_user == 0) {
                    toastr["error"]("Please Select User Type ", 'ALERT!');
                } else if (user_id == 0) {
                    toastr["error"]("Please Select User ", 'ALERT!');
                } else if (fac_id == null || fac_id == "") {
                    toastr["error"]("Please Select Practice ", 'ALERT!');
                } else {
                    $.ajax({
                        type: "POST",
                        url: "{{route('admin.add.facility.user')}}",
                        data: {
                            '_token': "{{csrf_token()}}",
                            'account_type_user': account_type_user,
                            'user_id': user_id,
                            'fac_id': fac_id,
                        },
                        success: function (data) {
                            getAllShow();
                            $('.loading2').hide();
                        }
                    });
                }
            });

            //remove practice
            $('#removebtn').click(function () {
                let account_type_user = $('.account_type_user').val();
                let user_id = $('.user_id').val();
                let assign_prac = $('.assign_prac').val();
                if (account_type_user == 0) {
                    toastr["error"]("Please Select User Type ", 'ALERT!');
                } else if (user_id == 0) {
                    toastr["error"]("Please Select User ", 'ALERT!');
                } else {
                    $.ajax({
                        type: "POST",
                        url: "{{route('admin.remove.facility.for.user')}}",
                        data: {
                            '_token': "{{csrf_token()}}",
                            'account_type_user': account_type_user,
                            'user_id': user_id,
                            'assign_prac': assign_prac,
                        },
                        success: function (data) {
                            getAllShow();
                            $('.loading2').hide();
                        }
                    });
                }
            })


            //show all facility


            $('.user_id').change(function () {
                getAllShow();
            });


            function getAllShow() {
                $('.loading2').show();
                let account_type_user = $('.account_type_user').val();
                let user_id = $('.user_id').val();

                if (user_id != 0) {
                    //all practice
                    $.ajax({
                        type: "POST",
                        url: "{{route('admin.practice.assign.show.all.prc')}}",
                        data: {
                            '_token': "{{csrf_token()}}",
                            'account_type_user': account_type_user,
                            'user_id': user_id
                        },
                        success: function (data) {
                            console.log(data)
                            $('.all_practice').empty();
                            $.each(data, function (index, value) {
                                $('.all_practice').append(
                                    `<option value="${value.id}">${value.business_name}</option>`
                                )
                            });
                            $('.loading2').hide();

                        }
                    });

                    //assign practice

                    $('.loading2').show();
                    $.ajax({
                        type: "POST",
                        url: "{{route('admin.practice.assign.get.by.user')}}",
                        data: {
                            '_token': "{{csrf_token()}}",
                            'account_type_user': account_type_user,
                            'user_id': user_id
                        },
                        success: function (data) {
                            console.log(data)
                            $('.assign_prac').empty();
                            $.each(data, function (index, value) {
                                $('.assign_prac').append(
                                    `<option value="${value.id}">${value.business_name}</option>`
                                )
                            });
                            $('.loading2').hide();

                        }
                    });


                } else {
                    $('.loading2').hide();
                }


            }

        })
    </script>
@endsection
