@extends('layouts.baseStaff')
@section('basestaffheaderselect')


    <div class="iq-search-bar">
        <div class="row">
            <div class="col-md-6">
                <?php
                $assn_prc = \App\Models\assign_practice_user::where('user_id', Auth::user()->id)->where('user_type', Auth::user()->account_type)->get();
                ?>
                <select class="form-control form-control-sm fac_id">
                    <option value="0">----- Select Facility -----</option>
                    @foreach($assn_prc as $assprc)
                        <?php
                        $prc = \App\Models\practice::where('id', $assprc->practice_id)->first();
                        ?>
                        @if ($prc)
                            <option
                                value="{{$prc->id}}" {{$facility_id == $prc->id ? 'selected' : ''}}>{{$prc->business_name}}</option>
                        @endif

                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <input type="text" class="form-control form-control-sm search_provider" placeholder="Search Provider">
            </div>
        </div>

    </div>

@endsection
@section('basestaff')
    <div class="loading2">
        <div class="table-loading"></div>
    </div>
    <div class="iq-card-body">
        <div class="d-flex justify-content-between mb-3">
            <div class="mr-3 align-self-center">
                <h2 class="common-title mb-0">All Provider</h2>
            </div>
            <div>

            </div>
        </div>


        <div class="table-responsive pro_lists">

        </div>
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
                        url: "{{route('basestaff.provider.save')}}",
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


            let f_id = $('.fac_id').val();
            if (f_id != 0) {
                $('.loading2').show();
                $.ajax({
                    type: "POST",
                    url: "{{route('basestaff.provider.list.all.get.fid')}}",
                    data: {
                        '_token': "{{csrf_token()}}",
                        'f_id': f_id
                    },
                    success: function (data) {
                        console.log(data);
                        $('.pro_lists').empty().append(data.view)
                        $('.pro_lists').show();
                        $('.loading2').hide();


                    }
                });
            }

            function getProFacId() {
                $('.loading2').show();
                let f_id = $('.fac_id').val();
                let search_name = $('.search_provider').val();
                $.ajax({
                    type: "POST",
                    url: "{{route('basestaff.provider.list.all.get.fid')}}",
                    data: {
                        '_token': "{{csrf_token()}}",
                        'f_id': f_id,
                        'search_name': search_name,
                    },
                    success: function (data) {
                        console.log(data);
                        $('.pro_lists').empty().append(data.view)
                        $('.pro_lists').show();
                        $('.loading2').hide();
                    }
                });
            }


            $('.fac_id').change(function () {
                getProFacId();
            });

            //search provider
            $('.search_provider').keyup(function () {
                getProFacId()
            });


        });


        function getData(myurl) {
            $('.loading2').show();
            let f_id = $('.fac_id').val();
            let search_name = $('.search_provider').val();
            $.ajax(
                {
                    url: myurl,
                    type: "get",
                    data: {
                        '_token': "{{csrf_token()}}",
                        'f_id': f_id,
                        'search_name': search_name
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
