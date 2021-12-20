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
                            <option value="{{$prc->id}}">{{$prc->business_name}}</option>
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

            // get data by fac id
            $('.fac_id').change(function () {
                getProFacId()
            });


            //search provider
            $('.search_provider').keyup(function () {
                getProFacId()

            });


        });

        // get data by pagination
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
                        'search_name': search_name,
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
