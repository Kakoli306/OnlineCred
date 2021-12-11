@section('js')
    <script>
        $(document).ready(function () {


            $('.show_chat').click(function () {
                var id = $(this).data('id');
                $.ajax({
                    type: "POST",
                    url: "{{route('admin.get.contract.note')}}",
                    data: {
                        '_token': "{{csrf_token()}}",
                        'id': id,
                    },
                    success: function (data) {
                        let url = "{{asset('assets/dashboard/')}}/images/user/01.jpg"
                        $('.coms').empty();
                        $.each(data, function (index, value) {

                            $('.coms').append(
                                `
                                <div class="row mb-3">
                                                    <div class="col-md-2 mb-3">
                                                        <img src="${url}" class="img-fluid" alt="user">
                                                    </div>
                                                    <div class="col-md-10 mb-3">
                                                        <div class="talkbubble">
                                                            <h6 class="overflow-hidden">Albert <span class="badge badge-secondary">${value.status}</span> <small class="text-muted float-right">(${value.followup_date})</small></h6>
                                                            <hr>
                                                            <p>${value.note}</p>
                                                        </div>
                                                    </div>
                                                </div>
                             `
                            )
                        })
                    }
                });
            })
        })
    </script>
@endsection
