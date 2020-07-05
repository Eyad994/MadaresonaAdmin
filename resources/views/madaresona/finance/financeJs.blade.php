<script type="text/javascript">

    $(function () {

        // show all products
        var table = $('.data-table').DataTable({
            dom: 'Bfrtip',
            "columnDefs": [

                {"width": "100px", "targets": 8},
                {"width": "120px", "targets": 1},
            ],
            processing: true,
            serverSide: true,
            lengthMenu: [
                [ 10, 25, 50,100, -1 ],
                [ '10 rows', '25 rows', '50 rows','100 rows', 'Show all' ]
            ],
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
                {
                    title: 'Is Tax', "mRender": function (data, type, row) {
                        if (row.is_tax == 'True') {
                            return '<span class="label label-success label-dot mr-2"></span>' +
                                '<span class="font-weight-bold text-success">' + row.is_tax + '</span>'
                        } else if (row.is_tax == 'false') {
                            return '<span class="label label-danger label-dot mr-2"></span>' +
                                '<span class="font-weight-bold text-danger">' + row.is_tax + '</span>'
                        }
                    }
                },
                {
                    data: 'end_date', title: 'Subscription Expired', "mRender": function (data, type, row) {

                        if (row.diff_days > 30)
                            return '<span class="label font-weight-bold label-lg  label-light-success label-inline">' + row.end_date + '</span>';
                        else
                            return '<span class="label font-weight-bold label-lg  label-light-danger label-inline">' + row.end_date + '</span>';
                    }
                },
                {
                    title: 'Finance Type', "mRender": function (data, type, row) {
                        if (row.school_supplier == 'School') {
                            return '<span class="label label-success label-dot mr-2"></span>' +
                                '<span class="font-weight-bold text-success">' + row.school_supplier + '</span>'
                        } else if (row.school_supplier == 'Supplier') {
                            return '<span class="label label-primary label-dot mr-2"></span>' +
                                '<span class="font-weight-bold text-primary">' + row.school_supplier + '</span>'
                        }
                    }
                },
                {
                    title: 'Total Amount', "mRender": function (data, type, row) {
                        if (row.total_amount > 0) {
                            return '<span class="font-weight-bold text-danger">' + row.total_amount + '</span>'
                        } else if (row.total_amount < 0) {
                            return '<span class="font-weight-bold text-success">' + row.total_amount + '</span>'
                        }else if (row.total_amount = 0) {
                            return '<span class="font-weight-bold">' + row.total_amount + '</span>'
                        }
                    }
                },
                {
                    title: 'Actions', "mRender": function (data, type, row) {

                        var subscription = '<a href="#" class="btn btn-sm btn-clean btn-icon action-btn subscription-btn" data-toggle="tooltip"  user_id="' + row.user_finance_id + '" data-placement="bottom" title="Subscriptions"><i class="fa fa-bars" style="color: #00aff0"></i></a>';
                        var payment = '<a href="#" class="btn btn-sm btn-clean btn-icon action-btn payment-btn" data-toggle="tooltip" finance_id="' + row.id + '" user_id="' + row.user_finance_id + '"  data-placement="bottom" title="Payment"><i class="fa fa-credit-card" style="color: green"></i></i></a>'
                        var notes = '<a href="#"  class="btn btn-sm btn-clean btn-icon note-btn" title="Notes"  user_id="' + row.user_finance_id + '"><i class="fa fa-sticky-note" style="color: #ffa800" ></i></a>'
                        return subscription + payment + notes;
                    }
                }

            ]
        });

        $(document).on('click', '.subscription-btn', function () {
            var user_id = $(this).attr('user_id');
            $.ajax({
                url: '/finance/subscription/' + user_id,
                method: 'get',
                success: function (data) {
                    $('.modal-body').html(data);
                    $('.modal-title').text('Subscriptions');
                    $('#schoolModal').modal('show');

                    $('body').on('click', '.pagination a', function (e) {
                        e.preventDefault();
                        var url = $(this).attr('href');
                        var outer_html = $('.campaign')[0].outerHTML;
                        $.get(url, function (outer_html) {
                            $('.modal-body').html(outer_html);
                            //$('#test').replaceWith(outer_html);

                        });
                    });

                }
            })
        });


        $(document).on('click', '.payment-btn', function () {
            var user_id = $(this).attr('user_id');
            $.ajax({
                url: '/finance/payment/' + user_id,
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
        $(document).on('click', '.note-btn', function () {
            var user_id = $(this).attr('user_id');
            $.ajax({
                url: '/finance/note/' + user_id,
                method: 'get',
                success: function (data) {
                    $('.modal-body').html(data);
                    $('.modal-title').text('Finance Note');
                    $('#schoolModal').modal('show');

                    $("#noteForm").submit(function (e) {

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

                    $('.note-remove-btn').on('click', function () {
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
                                    url: '/finance/note/removeNote/' + id,
                                    method: 'get',
                                    success: function (data) {
                                        $('#noteRow_' + id).remove();
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
    });

</script>
