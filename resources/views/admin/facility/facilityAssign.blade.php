@extends('layouts.admin')
@section('headerselect')
    <div class="iq-search-bar">
        <select class="form-control form-control-sm all_provider_id">
            <option value="0">Select User</option>
            <option>test</option>
            <option>test</option>
        </select>
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
                <div class="mb-2"><button type="button" class="btn btn-sm btn-primary" id="addbtn">Add</button>
                </div>
                <div><button type="button" class="btn btn-sm btn-danger" id="removebtn">Remove</button></div>
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
            $.ajax({
                type : "POST",
                url: "{{route('admin.get.all.provider')}}",
                data : {
                    '_token' : "{{csrf_token()}}",
                },
                success:function(data){
                    $('.all_provider_id').empty();
                    $('.all_provider_id').append(
                        `<option value="0">select provider</option>`
                    )
                    $.each(data,function (index,value) {
                        $('.all_provider_id').append(
                            `<option value="${value.id}">${value.full_name}</option>`
                        )
                    });

                }
            });




            //add facility
            $('#addbtn').click(function () {
                let pro_id = $('.all_provider_id').val();
                let fac_id = $('.all_practice').val();
                if(pro_id == 0){
                    toastr["error"]("Please Select Provider ",'ALERT!');
                }else {
                    $.ajax({
                        type : "POST",
                        url: "{{route('admin.add.facility.provider')}}",
                        data : {
                            '_token' : "{{csrf_token()}}",
                            'pro_id' : pro_id,
                            'fac_id' : fac_id,
                        },
                        success:function(data){
                            getAllShow();
                            $('.loading2').hide();
                        }
                    });
                }
            });

            //remove practice
            $('#removebtn').click(function () {
                let pro_id = $('.all_provider_id').val();
                let assign_prac = $('.assign_prac').val();
                if(pro_id == 0){
                    toastr["error"]("Please Select Provider ",'ALERT!');
                }else {
                    $.ajax({
                        type : "POST",
                        url: "{{route('admin.remove.facility.provider')}}",
                        data : {
                            '_token' : "{{csrf_token()}}",
                            'pro_id' : pro_id,
                            'assign_prac' : assign_prac,
                        },
                        success:function(data){
                            getAllShow();
                            $('.loading2').hide();
                        }
                    });
                }
            })



            //show all facility


            $('.all_provider_id').change(function () {
                getAllShow();
            })


            function getAllShow(){
                $('.loading2').show();
                let pro_id = $('.all_provider_id').val();

                if(pro_id != 0){
                    $.ajax({
                        type : "POST",
                        url: "{{route('admin.get.all.practice')}}",
                        data : {
                            '_token' : "{{csrf_token()}}",
                            'pro_id':pro_id
                        },
                        success:function(data){
                            $('.all_practice').empty();
                            $.each(data,function (index,value) {
                                $('.all_practice').append(
                                    `<option value="${value.id}">${value.business_name}</option>`
                                )
                            });
                            $('.loading2').hide();

                        }
                    });
                }else {
                    $('.loading2').hide();
                }


                $('.loading2').show();
                if (pro_id != 0){
                    $.ajax({
                        type : "POST",
                        url: "{{route('admin.get.assin.practice')}}",
                        data : {
                            '_token' : "{{csrf_token()}}",
                            'pro_id':pro_id
                        },
                        success:function(data){

                            $('.assign_prac').empty();
                            $.each(data,function (index,value) {
                                $('.assign_prac').append(
                                    `<option value="${value.id}">${value.business_name}</option>`
                                )
                            })
                            $('.loading2').hide();
                        }
                    });
                }else {
                    $('.loading2').hide();
                }

            }

        })
    </script>
@endsection
