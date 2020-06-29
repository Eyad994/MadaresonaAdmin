@extends('layouts.main')

@section('content')
    <div class="container">

        <div class="card">
            <div class="card-header">
                <b>Sales <b style="color:#ffa800;">{{$user_name}}</b></b>
                <div class="card-toolbar" style="float: right">

                    <a id="addSalesFinance" class="btn btn-primary font-weight-bolder">
	<span class="svg-icon svg-icon-md">
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
             viewBox="0 0 24 24" version="1.1">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"></rect>
        <circle fill="#000000" cx="9" cy="15" r="6"></circle>
        <path
                d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z"
                fill="#000000" opacity="0.3"></path>
    </g>
</svg></span>New Sales</a>
                </div>

            </div>
            <input type="hidden" id="user_id" name="user_id" value="{{ $id }}">

            <div class="card-body">
                <table class="table" id="salesFinances"></table>
            </div>
        </div>

        @include('madaresona.schools.shcoolModal')
    </div>
@endsection



@section('script')

    <script type="text/javascript">

        $('#addSalesFinance').on('click', function () {
            var userId = $('#user_id').val();
            $.ajax({
                url: '/salesFinances/create/' + userId,
                method: 'get',
                success: function (data) {
                    $('.modal-body').html(data);
                    $('.modal-title').text('Add Sales Finance');
                    $('#schoolModal').modal('show');

                }
            });
        });

        $('body').on('click', '.pagination a', function (e) {
            e.preventDefault();
            var url = $(this).attr('href');
            var outer_html = $('.campaign')[0].outerHTML;
            $.get(url, function (outer_html) {
                $('.modal-body').html(outer_html);
                //$('#test').replaceWith(outer_html);
            });
        });

        var table = $('#salesFinances').DataTable({
            dom: 'Bfrtip',
            "columnDefs": [
                {"width": "50px", "targets": 4}
            ],
            processing: true,
            serverSide: true,
            data: {
                "user_id": $('#user_id').val()
            },
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
            ajax: {
                url: "{{ route('salesFinancesDatatable') }}",
                type: "get",
                data: {
                    "user_id": $('#user_id').val()
                }
            },
            columns: [
                {data: 'DT_RowIndex', title: 'ID'},
                {data: 'date', title: 'Data'},
                {
                    title: 'Total Amount', "mRender": function (data, type, row) {
                        return  '<span class="font-weight-bold text-success" style="color: orange !important;">' + row.sum_amount + '</span>';
                    }
                },
                {
                    title: 'Target', "mRender": function (data, type, row) {
                        return  '<span class="font-weight-bold text-success">' + row.target + '</span>';
                    }
                },

                {
                    title: 'Actions', "mRender": function (data, type, row) {
                    var view = '<a href="#" class="btn btn-sm btn-clean btn-icon action-btn view-trans-btn" month="' + row.month + '"  year="' + row.year + '" data-toggle="tooltip" data-placement="bottom" title="View"><i class="fa fa-eye" style="color: #00aff0"></i></a>';
                    return view;
                }
                },

            ]
        });


        $(document).on('click', '.view-trans-btn', function () {
            var month = $(this).attr('month');
            var year = $(this).attr('year');
            var userId = $('#user_id').val();
            $.ajax({
                url: '/salesFinances/edit/' + userId + '/' + month + '/' + year,
                method: 'get',
                success: function (data) {
                    $('.modal-body').html(data);
                    $('.modal-title').text('Edit Sales');
                    $('#schoolModal').modal('show');

                    $('#saleForm').submit(function (e) {
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
                                    console.log(data);
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
                }
            });
        });
    </script>

@endsection