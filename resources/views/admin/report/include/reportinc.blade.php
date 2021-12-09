@section('js')
    <script>
        $(document).ready(function () {
            let getAllFacility = function () {
                $.ajax({
                    type: "POST",
                    url: "{{route('admin.report.get.all.facility')}}",
                    data: {
                        '_token': "{{csrf_token()}}",
                    },
                    success: function (data) {
                        console.log(data);
                        $('.all_faciity').empty();
                        $('.all_faciity').append(
                            `<option value=""></option>`
                        );
                        $.each(data, function (index, value) {
                            $('.all_faciity').append(
                                `<option value="${value.id}">${value.business_name}</option>`
                            );
                        });

                    }
                });
            };

            getAllFacility();


            $('.all_faciity').change(function () {
                let fac_id = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "{{route('admin.report.provider.by.facility')}}",
                    data: {
                        '_token': "{{csrf_token()}}",
                        'fac_id': fac_id
                    },
                    success: function (data) {
                        console.log(data);
                        $('.all_provider').empty();
                        $('.all_provider').append(
                            `<option value=""></option>`
                        );
                        $.each(data, function (index, value) {
                            $('.all_provider').append(
                                `<option value="${value.id}">${value.full_name}</option>`
                            );
                        });

                    }
                });
            });


            $('.all_provider').change(function () {
                let prov_id = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "{{route('admin.report.contract.by.provider')}}",
                    data: {
                        '_token': "{{csrf_token()}}",
                        'prov_id': prov_id
                    },
                    success: function (data) {
                        console.log(data);
                        $('.all_cotract').empty();
                        $('.all_cotract').append(
                            `<option value=""></option>`
                        );
                        $.each(data, function (index, value) {
                            $('.all_cotract').append(
                                `<option value="${value.id}">${value.contract_name}</option>`
                            );
                        });

                    }
                });
            })


        })
    </script>
@endsection
