<script type="text/javascript">

    $(function () {

        // show all products
        var table = $('.data-table').DataTable({
            dom: 'Bfrtip',
            "columnDefs": [

                {"width": "100px", "targets": 7},
            ],
            processing: true,
            serverSide: true,
            buttons: [
                {'extend': 'pageLength'},
                {
                    text: 'Reload',
                    action: function (e, dt, node, config) {
                        dt.ajax.reload();
                    }
                },
                {'extend': 'excel'},
                {'extend': 'print'},
                {'extend': 'pdf'}
            ],
            ajax: "{{ route('FinanceDatable') }}",
            columns: [
                {data: 'DT_RowIndex', title: 'ID'},
                 {
                   data: 'uuid', title: 'SN', "mRender": function (data, type, row) {
                    return '<label style="font-weight: 600 !important; color: #0d8ddc;">' + row.uuid + ' </label>'

                }
                },
                {data: 'user_id', title: 'Name'},

                {data: 'type', title: 'Type'},
                {data: 'is_tax', title: 'Is Tax'},
                {data: 'end_date', title: 'Subscription Expired', "mRender": function (data, type, row) {

                if (row.diff_days > 30)
                    return '<span class="label font-weight-bold label-lg  label-light-success label-inline">'+ row.end_date +'</span>';
                else
                    return '<span class="label font-weight-bold label-lg  label-light-danger label-inline">'+ row.end_date +'</span>';
                }},
                {data: 'school_supplier', title: 'Finance Type'},
                {
                    title: 'Actions', "mRender": function (data, type, row) {


                    var subscription = '<a href="#" class="btn btn-sm btn-clean btn-icon action-btn subscription-btn" data-toggle="tooltip"  user_id="' + row.user_finance_id + '" data-placement="bottom" title="Subscriptions"><i class="fa fa-bars" style="color: #00aff0"></i></a>';
                    var payment = '<a href="#" class="btn btn-sm btn-clean btn-icon action-btn payment-btn" data-toggle="tooltip" finance_id="'+ row.id +'" user_id="' + row.user_finance_id + '"  data-placement="bottom" title="Payment"><i class="fa fa-credit-card" style="color: green"></i></i></a>'
                         var notes = '<a href="#" target="_blank" class="btn btn-sm btn-clean btn-icon action-btn" title="Notes"  user_id="' + row.user_finance_id + '"><i class="fa fa-sticky-note" style="color: #ffa800" ></i></a>'
                    return subscription + payment+notes;
                }
                }

            ]
        });

        $(document).on('click', '.subscription-btn', function () {
            var user_id = $(this).attr('user_id');
            $.ajax({
                url: '/finance/subscription/'+user_id,
                method: 'get',
                success: function (data) {
                    $('.modal-body').html(data);
                    $('.modal-title').text('Subscriptions');
                    $('#schoolModal').modal('show');

                    $("#subscriptionForm").submit(function (e) {

                        e.preventDefault();
                        var form = $(this);
                        var url = form.attr('action');

                        $.ajax({
                            type: "POST",
                            url: url,
                            data: new FormData(this),
                            dataType: "json",
                            contentType: false,
                            cache: false,
                            processData: false,
                            success: function (data) {

                                if (data.status === 422) {
                                    var error_html = '';

                                    for (let value of Object.values(data.errors)) {
                                        error_html += '<div class="alert alert-danger">' + value + '</div>';
                                    }
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        html: error_html,
                                    })
                                } else {
                                    Swal.fire({
                                        icon: 'success',
                                        title: data.message,
                                        showConfirmButton: false,
                                        timer: 1500
                                    });

                                    table.ajax.reload();
                                    $('#schoolModal').modal('hide');
                                }
                            }
                        });

                    });

                    $('.subscription-remove-btn').on('click', function () {
                        var id = $(this).attr('id');

                        Swal.fire({
                            title: 'Are you sure?',
                            text: "You won't be able to revert this!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, delete it!'
                        }).then(function (result) {
                            if (result.value) {
                                $.ajax({
                                    url: 'removeSubscription/' + id,
                                    method: 'get',
                                    success: function (data) {
                                        $('#subscriptionRow_' + id).remove();
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Your subscription has been removed',
                                            showConfirmButton: false,
                                            timer: 1500
                                        })
                                    }
                                });
                            }
                        });
                    })
                }
            })
        });


        $(document).on('click', '.payment-btn', function () {
            var user_id = $(this).attr('user_id');
            $.ajax({
                url: '/finance/payment/'+user_id,
                method: 'get',
                success: function (data) {
                    $('.modal-body').html(data);
                    $('.modal-title').text('Payments');
                    $('#schoolModal').modal('show');

                    $("#paymentForm").submit(function (e) {

                        e.preventDefault();
                        var form = $(this);
                        var url = form.attr('action');

                        $.ajax({
                            type: "POST",
                            url: url,
                            data: new FormData(this),
                            dataType: "json",
                            contentType: false,
                            cache: false,
                            processData: false,
                            success: function (data) {

                                if (data.status === 422) {
                                    var error_html = '';

                                    for (let value of Object.values(data.errors)) {
                                        error_html += '<div class="alert alert-danger">' + value + '</div>';
                                    }
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        html: error_html,
                                    })
                                } else {
                                    Swal.fire({
                                        icon: 'success',
                                        title: data.message,
                                        showConfirmButton: false,
                                        timer: 1500
                                    });

                                    table.ajax.reload();
                                    $('#schoolModal').modal('hide');
                                }
                            }
                        });

                    });

                    $('.payment-remove-btn').on('click', function () {
                        var id = $(this).attr('id');

                        Swal.fire({
                            title: 'Are you sure?',
                            text: "You won't be able to revert this!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, delete it!'
                        }).then(function (result) {
                            if (result.value) {
                                $.ajax({
                                    url: 'removePayment/' + id,
                                    method: 'get',
                                    success: function (data) {
                                        $('#paymentRow_' + id).remove();
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Your subscription has been removed',
                                            showConfirmButton: false,
                                            timer: 1500
                                        })
                                    }
                                });
                            }
                        });
                    })
                }
            })
        })
    });

</script>
