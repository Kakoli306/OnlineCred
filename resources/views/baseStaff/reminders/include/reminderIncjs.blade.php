@section('js')
    <script>
        $(document).ready(function () {
            $('.loading2').show();
            $.ajax({
                type: "POST",
                url: "{{route('basestaff.reminder.get.all.prc')}}",
                data: {
                    '_token': "{{csrf_token()}}",
                },
                success: function (data) {
                    $('.all_prc_data').empty();
                    $('.all_prc_data').append(
                        `<option value="">select facility</option>`
                    );
                    $.each(data, function (index, value) {
                        $('.all_prc_data').append(
                            `<option value="${value.id}">${value.business_name}</option>`
                        );
                    });

                    $('.loading2').hide();

                }


            });


            $('.all_prc_data').change(function () {
                $('.loading2').show();
                let prc_id = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "{{route('basestaff.reminder.prov.by.fac')}}",
                    data: {
                        '_token': "{{csrf_token()}}",
                        'prc_id': prc_id

                    },
                    success: function (data) {
                        $('.all_prov_name').empty();
                        $('.all_prov_name').append(
                            `<option value="">select facility</option>`
                        );
                        $.each(data, function (index, value) {
                            $('.all_prov_name').append(
                                `<option value="${value.id}">${value.full_name}</option>`
                            );
                        })
                        $('.loading2').hide();
                    }


                });
            });


            $('.all_prov_name').change(function () {
                $('.loading2').show();
                let prov_id = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "{{route('basestaff.reminder.con.by.prov')}}",
                    data: {
                        '_token': "{{csrf_token()}}",
                        'prov_id': prov_id

                    },
                    success: function (data) {
                        $('.all_con_data').empty();
                        $('.all_con_data').append(
                            `<option value="">select facility</option>`
                        );
                        $.each(data, function (index, value) {
                            $('.all_con_data').append(
                                `<option value="${value.id}">${value.contract_name}</option>`
                            );
                        })
                        $('.loading2').hide();
                    }
                });
            });

        })
    </script>

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


            function showAllReminder() {
                $('.loading2').show();
                $.ajax({
                    type: "POST",
                    url: "{{route('basestaff.reminder.show.all')}}",
                    data: {
                        '_token': "{{csrf_token()}}",

                    },
                    success: function (data) {
                        console.log(data)
                        $('.reminderTable').empty().html(data.view)
                        $('.loading2').hide();
                    }
                });
            };

            showAllReminder();


            $('#goBtn').click(function () {
                let all_prc_data = $('.all_prc_data').val();
                let all_prov_name = $('.all_prov_name').val();
                let all_con_data = $('.all_con_data').val();
                let fowllowup_filter = $('.fowllowup_filter').val();
                let status_filter = $('.status_filter').val();

                $('.loading2').show();
                $.ajax({
                    type: "POST",
                    url: "{{route('basestaff.reminder.show.all')}}",
                    data: {
                        '_token': "{{csrf_token()}}",
                        'all_prc_data': all_prc_data,
                        'all_prov_name': all_prov_name,
                        'all_con_data': all_con_data,
                        'fowllowup_filter': fowllowup_filter,
                        'status_filter': status_filter,

                    },
                    success: function (data) {
                        console.log(data)
                        $('.reminderTable').empty().html(data.view)
                        $('.loading2').hide();
                    }
                });

            })


        });


        function getData(myurl) {
            $('.loading2').show();

            let all_prc_data = $('.all_prc_data').val();
            let all_prov_name = $('.all_prov_name').val();
            let all_con_data = $('.all_con_data').val();
            let fowllowup_filter = $('.fowllowup_filter').val();
            let status_filter = $('.status_filter').val();
            $.ajax(
                {
                    url: myurl,
                    type: "get",
                    data: {
                        '_token': "{{csrf_token()}}",
                        'all_prc_data': all_prc_data,
                        'all_prov_name': all_prov_name,
                        'all_con_data': all_con_data,
                        'fowllowup_filter': fowllowup_filter,
                        'status_filter': status_filter,
                    },
                    datatype: "html"
                }).done(function (data) {
                // console.log(data)
                $('.reminderTable').empty().html(data.view)
                $('.loading2').hide();
                // location.hash = myurl;

            }).fail(function (jqXHR, ajaxOptions, thrownError) {
                alert('No response from server');
                $('.loading2').hide();
            });
        }
    </script>


@endsection
