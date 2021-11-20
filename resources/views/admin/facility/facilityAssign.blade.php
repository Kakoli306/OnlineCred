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



        <br>
        <br>
        <br>
        <br>
        <div class="d-flex justify-content-between mb-3">
            <div class="mr-3 align-self-center">
                <h2 class="common-title mb-0">All Speciality</h2>
            </div>
            <div>
                <a class="btn btn-sm btn-primary" href="#createSpeciality" data-toggle="modal">
                    <i class="ri-add-line"></i>Add Speciality
                </a>
            </div>
        </div>


        <div class="modal fade" id="createSpeciality" data-backdrop="static">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4>Create Speciality</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <form action="{{route('admin.speciality.save')}}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12 mb-2">
                                    <label>Speciality<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm first_name" name="speciality_name" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" id="createProvider">Create & Continue</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>



        <div class="table-responsive pro_lists">
            <table class="table table-sm table-bordered c_table">
                <thead>
                <tr>
                    <th>Speciality</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody class="text-center">
                @foreach($all_scpec as $spec)
                <tr>
                    <td>{{$spec->speciality_name}}</td>
                    <td>
                        <a href="#editspec{{$spec->id}}" title="Edit" data-toggle="modal">
                            <i class="ri-pencil-line mr-2"></i>
                        </a>
                        <a href="{{route('admin.speciality.delete',$spec->id)}}" title="Delete">
                            <i class="ri-delete-bin-6-line text-danger"></i>
                        </a>


                        <div class="modal fade" id="editspec{{$spec->id}}" data-backdrop="static">
                            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4>Edit Speciality</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <form action="{{route('admin.speciality.update')}}" method="post">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-12 mb-2">
                                                    <label>Speciality<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control form-control-sm first_name" name="speciality_name" value="{{$spec->speciality_name}}" required>
                                                    <input type="hidden" class="form-control form-control-sm first_name" name="speciality_edit" value="{{$spec->id}}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary" id="createProvider">Update</button>
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>





                @endforeach


                </tbody>
            </table>
            <nav class="overflow-hidden">
                {{$all_scpec->links()}}
            </nav>


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

                let arr = [];
               $('.all_practice').each(function () {
                   arr.push($(this).val())
               })

                console.log(fac_id)

                if(pro_id == 0){
                    toastr["error"]("Please Select Provider ",'ALERT!');
                }else if(fac_id == null || fac_id == ""){
                    toastr["error"]("Please Select Practice ",'ALERT!');
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
                            if (data == 'more_prc'){
                                toastr["error"]("You Have Select Multiple Practice",'ALERT!');
                            }else if(data == 'already_have'){
                                toastr["error"]("Provider Already Have One Practice",'ALERT!');
                            }else {
                                toastr["success"]("Practice Successfully Assigned.",'SUCCESS!');
                            }
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
