@extends('layouts.accountManager')
@section('managerheaderselect')
    <div class="iq-search-bar">
        <div class="row">
            <div class="col-md-3">
                <?php
                $assn_prc_datats = \App\Models\assign_practice_user::where('user_id', Auth::user()->id)->where('user_type', Auth::user()->account_type)->get();
                $array = [];
                foreach ($assn_prc_datats as $prc_data) {
                    array_push($array, $prc_data->practice_id);
                }
                $assn_prc = \App\Models\practice::whereIn('id', $array)->orderBy('business_name', 'asc')->get();
                ?>
                <select class="form-control form-control-sm fac_id">
                    <option value="0">----- Select Facility -----</option>
                    @foreach($assn_prc as $assprc)
                        @if ($assprc)
                            <option value="{{$assprc->id}}">{{$assprc->business_name}}</option>
                        @endif

                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control form-control-sm search_provider" placeholder="Search Provider">
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control form-control-sm search_tax" placeholder="Search TAX ID">
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control form-control-sm search_npi" placeholder="Search NPI">
            </div>
        </div>

    </div>
@endsection
@section('accountmanager')
    <div class="loading2">
        <div class="table-loading"></div>
    </div>
    <div class="iq-card-body">
        <div class="d-flex justify-content-between mb-3">
            <div class="mr-3 align-self-center">
                <h2 class="common-title mb-0">All Provider</h2>
            </div>
            <div>
                <a class="btn btn-sm btn-primary" href="#createProviderNew" data-toggle="modal">
                    <i class="ri-add-line"></i>Add Provider
                </a>
            </div>
        </div>


        <div class="modal fade" id="createProviderNew" data-backdrop="static">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4>Create Provider</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <form action="{{route('account.manager.provider.save')}}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label>First Name<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm first_name" name="first_name"
                                           required>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label>Last Name<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm last_name" name="last_name"
                                           required>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label>Contact Info<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm phone_num" name="phone"
                                           data-mask="(000)-000-0000" pattern=".{14,}" required="" autocomplete="off"
                                           maxlength="14">
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label>DOB<span class="text-danger">*</span></label>
                                    <input type="date" class="form-control form-control-sm dob" name="dob" required>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label>Gender<span class="text-danger">*</span></label>
                                    <select class="form-control form-control-sm gender" name="gender">
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label>Age Restrictions</label>
                                    <input type="text" class="form-control form-control-sm dob" name="age_restriction"
                                           required>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label>Working Hours</label>
                                    <input type="text" class="form-control form-control-sm dob" name="working_hours"
                                           required>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label>County Name</label>
                                    <input type="text" class="form-control form-control-sm dob" name="country_name"
                                           required>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label>Contact Manager</label>
                                    <input type="text" class="form-control form-control-sm dob" name="contract_manager"
                                           required>
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


        <div class="pro_lists"></div>


    </div>
@endsection
@section('js')
    <script>

        $(window).on('hashchange', function () {
            if (window.location.hash) {
                var page = window.location.hash.replace('#', '');
                if (page == Number.NaN || page <= 0) {
                    return false;
                } else {
                    getData(page);
                }
            }
        });
        $(document).ready(function () {
            $('.loading2').hide();
            $(document).on('click', '.pagination a', function (event) {
                event.preventDefault();


                $('li').removeClass('active');
                $(this).parent('li').addClass('active');

                var myurl = $(this).attr('href');
                // console.log(myurl);
                var newurl = myurl.substr(0, myurl.length - 1);

                var page = $(this).attr('href').split('page=')[1];
                var newurldata = (newurl + page);
                // console.log(newurldata);
                getData(myurl);
            });


            $('#createProvider').click(function (e) {
                e.preventDefault();
                let fac_id = $('.fac_id').val();
                let first_name = $('.first_name').val();
                let last_name = $('.last_name').val();
                let phone_num = $('.phone_num').val();
                let dob = $('.dob').val();
                let gender = $('.gender').val();

                if (fac_id == 0) {
                    toastr["error"]("Please Select Facility", 'ALERT!');
                } else if (first_name == "") {
                    toastr["error"]("Please Enter First Name", 'ALERT!');
                } else if (last_name == "") {
                    toastr["error"]("Please Enter Last Name", 'ALERT!');
                } else if (phone_num == "") {
                    toastr["error"]("Please Enter Phone Number", 'ALERT!');
                } else if (dob == "") {
                    toastr["error"]("Please Enter DOB", 'ALERT!');
                } else {
                    $.ajax({
                        type: "POST",
                        url: "{{route('account.manager.provider.save')}}",
                        data: {
                            '_token': "{{csrf_token()}}",
                            'fac_id': fac_id,
                            'first_name': first_name,
                            'last_name': last_name,
                            'phone_num': phone_num,
                            'dob': dob,
                            'gender': gender,
                        },
                        success: function (data) {
                            console.log(data);
                            getProFacId();
                            $('#createProviderNew').modal('hide');
                            toastr["success"]("Provider Successfully Created", 'SUCCESS!');
                            $('.first_name').val('');
                            $('.last_name').val('');
                            $('.phone_num').val('');
                            $('.dob').val('');
                            $('.gender').val('');

                        }
                    });
                }
            });


            function getProFacId() {
                $('.loading2').show();
                let f_id = $('.fac_id').val();
                let search_name = $('.search_provider').val();
                let search_tax = $('.search_tax').val();
                let search_npi = $('.search_npi').val();

                $.ajax({
                    type: "POST",
                    url: "{{route('account.manager.provider.list.all.get.fid')}}",
                    data: {
                        '_token': "{{csrf_token()}}",
                        'f_id': f_id,
                        'search_name': search_name,
                        'search_tax': search_tax,
                        'search_npi': search_npi,
                    },
                    success: function (data) {
                        console.log(data);
                        $('.pro_lists').empty().append(data.view)
                        $('.pro_lists').show();
                        $('.loading2').hide();


                    }
                });
            }

            // get data by fac id
            $('.fac_id').change(function () {
                getProFacId()
            });


            //search provider
            $('.search_provider').keyup(function () {
                getProFacId()

            });

            //search tax
            $('.search_tax').keyup(function () {
                getProFacId()
            });

            //search npi
            $('.search_npi').keyup(function () {
                getProFacId()
            });


        });

        // get data by pagination
        function getData(myurl) {
            $('.loading2').show();
            let f_id = $('.fac_id').val();
            let search_name = $('.search_provider').val();
            let search_tax = $('.search_tax').val();
            let search_npi = $('.search_npi').val();
            $.ajax(
                {
                    url: myurl,
                    type: "get",
                    data: {
                        '_token': "{{csrf_token()}}",
                        'f_id': f_id,
                        'search_name': search_name,
                        'search_tax': search_tax,
                        'search_npi': search_npi,
                    },
                    datatype: "html"
                }).done(function (data) {
                // console.log(data)
                $('.pro_lists').empty().append(data.view)
                $('.pro_lists').show();
                // location.hash = myurl;
                $('.loading2').hide();
            }).fail(function (jqXHR, ajaxOptions, thrownError) {
                alert('No response from server');
                $('.loading2').hide();
            });
        }

    </script>
@endsection
