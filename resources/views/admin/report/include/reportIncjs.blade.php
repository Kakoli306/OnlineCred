@section('js')
    <script
        src="{{asset('assets/multisel/bootstrap-multiselect.js')}}"></script>

    <script>

        $(document).ready(function () {
            $('#all_prov_name').multiselect();
            $('#all_con_data').multiselect();
            $('#all_status_data').multiselect();
        });
    </script>
    <script>
        $(document).ready(function () {
            $('.loading2').show();
            $.ajax({
                type: "POST",
                url: "{{route('admin.reminder.get.all.prc')}}",
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

            $('.account_type_user').change(function () {
                $('.loading2').show();
                let type_id = $(this).val();
                if (type_id == 0) {
                    toastr["error"]("Please Select User Type ", 'ALERT!');
                    $('.loading2').hide();
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

                            $('.loading2').hide();

                        }
                    });
                }
            })


            $('.all_prc_data').change(function () {
                $('.loading2').show();
                let prc_id = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "{{route('admin.reminder.prov.by.fac')}}",
                    data: {
                        '_token': "{{csrf_token()}}",
                        'prc_id': prc_id

                    },
                    success: function (data) {
                        console.log(data)
                        $('.all_prov_name').empty();
                        if (data.length > 0) {
                            $.each(data, function (index, value) {
                                $('.all_prov_name').append(
                                    `<option value="${value.id}">${value.full_name}</option>`
                                );
                            });
                        }
                        $('#all_prov_name').multiselect({includeSelectAllOption: true});
                        $("#all_prov_name").multiselect('rebuild');
                        $('.loading2').hide();
                    }


                });
            });


            $('.all_prov_name').change(function () {
                $('.loading2').show();
                let prov_id = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "{{route('admin.reminder.con.by.prov')}}",
                    data: {
                        '_token': "{{csrf_token()}}",
                        'prov_id': prov_id

                    },
                    success: function (data) {
                        $('.all_con_data').empty();

                        $.each(data, function (index, value) {
                            $('.all_con_data').append(
                                `<option value="${value.id}">${value.contract_name}</option>`
                            );
                        })
                        $('#all_con_data').multiselect({includeSelectAllOption: true});
                        $("#all_con_data").multiselect('rebuild');
                        $('.loading2').hide();
                    }
                });
            });


            //all status
            $.ajax({
                type: "POST",
                url: "{{route('admin.reminder.get.all.status')}}",
                data: {
                    '_token': "{{csrf_token()}}",

                },
                success: function (data) {
                    $('.all_status_data').empty();

                    $.each(data, function (index, value) {
                        $('.all_status_data').append(
                            `<option value="${value.id}">${value.contact_status}</option>`
                        );
                    })
                    $('#all_status_data').multiselect({includeSelectAllOption: true});
                    $("#all_status_data").multiselect('rebuild');
                    $('.loading2').hide();
                }
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
                 console.log(myurl);
                var newurl = myurl.substr(0, myurl.length - 1);
                var page = $(this).attr('href').split('page=')[1];
                var newurldata = (newurl + page);
                 console.log(newurldata);
                getData(myurl);
            });

            function showAllReminder() {
                $('.loading2').show();
                $.ajax({
                    type: "POST",
                    url: "{{route('admin.report.show.all')}}",
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
                let status_filter = $('.all_status_data').val();
                let user_type = $('.user_type').val();
                let user_id = $('.user_id').val();
                
                $('.loading2').show();
                $.ajax({
                    type: "POST",
                    url: "{{route('admin.report.show.all')}}",
                    data: {
                        '_token': "{{csrf_token()}}",
                        'all_prc_data': all_prc_data,
                        'all_prov_name': all_prov_name,
                        'all_con_data': all_con_data,
                        'fowllowup_filter': fowllowup_filter,
                        'status_filter': status_filter,
                        'user_type': user_type,
                        'user_id' : user_id
                       
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
            let status_filter = $('.all_status_data').val();
            let user_type = $('.user_type').val();
                let user_id = $('.user_id').val();
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
                        'user_type': user_type,
                        'user_id' : user_id
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
