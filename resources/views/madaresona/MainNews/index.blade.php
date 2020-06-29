@extends('layouts.main')

@section('content')
    <div class="container">

        <div class="card">
            <div class="card-header">
                <b>News</b>
                <div class="card-toolbar" style="float: right">

                    <a id="addNews" class="btn btn-primary font-weight-bolder">
	<span class="svg-icon svg-icon-md">
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
             viewBox="0 0 24 24" version="1.1">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"></rect>
        <circle fill="#000000" cx="9" cy="15" r="6"></circle>
        <path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z"
              fill="#000000" opacity="0.3"></path>
    </g>
</svg></span>New News</a>
                </div>

            </div>

            <div class="card-body">
                <table class="table" id="newsTable"></table>
            </div>
        </div>

        @include('madaresona.schools.shcoolModal')
    </div>
@endsection


@section('script')

    <script type="text/javascript">

        var table = $('#newsTable').DataTable({
            dom: 'Bfrtip',
            "columnDefs": [
                {"width": "50px", "targets": 6}
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
            ajax: {
                url: "{{ route('newsMainDatatable') }}",
                type: "get",
            },
            columns: [
                {data: 'DT_RowIndex', title: 'ID'},
                {data: 'title_ar', title: 'Arabic Title'},
                {data: 'title_en', title: 'English Title'},
                {data: 'order', title: 'Order'},
                {
                    data: 'img', title: 'Image', "mRender": function (data, type, row) {
                        var imgeUrl = '{{ asset('images/Main News') }}';
                        if (row.img != '') {
                            return '<img src="' + imgeUrl + '/'  + row.img + '" class="avatar" width="50" height="50"/>';
                        }
                        else
                            return "Not Found Logo";
                    }
                },
                {
                    data: 'active', title: 'Status', "mRender": function (data, type, row) {
                        if (row.active == 'InActive') {
                            return "<span class='label font-weight-bold label-lg  label-light-danger label-inline'>InActive</span>";
                        } else if (row.active == 'Active') {
                            return "<span class='label font-weight-bold label-lg  label-light-success label-inline'>Active</span>";

                        }

                    }
                },

                {
                    title: 'Actions', "mRender": function (data, type, row) {
                        var remove = '<a href="#" class="btn btn-sm btn-clean btn-icon action-btn remove-news-btn" id="' + row.id + '"  title="Remove"><i class="far fa-trash-alt" style="color: #f64e60"></i></a>';
                        var edit = '<a href="#" class="btn btn-sm btn-clean btn-icon action-btn edit-news-btn" id="' + row.id + '" d title="View & Edit"><i class="fa fa-edit" style="color: #00aff0"></i></a>';
                        return edit + remove;
                    }
                }
            ]
        });

        $('#addNews').on('click', function () {


            $.ajax({
                url: '{{ route('createMainNews') }}',
                method: 'get',
                success: function (data) {
                    $('.modal-body').html(data);
                    $('.modal-title').text('Add News');
                    $('#schoolModal').modal('show');

                    $('#newsForm').submit(function (e) {
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


        $(document).on('click', '.edit-news-btn', function () {
            var id = $(this).attr('id');
            $.ajax({
                url: '/news/' + id + '/edit',
                method: 'get',
                success: function (data) {
                    $('.modal-body').html(data);
                    $('.modal-title').text('Edit News');
                    $('#schoolModal').modal('show');

                    $('#newsForm').submit(function (e) {
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

        $(document).on('click', '.remove-news-btn', function () {
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
                        url: 'main/remove/'+id,
                        method: 'get',
                        success: function (data) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Your image has been removed',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            table.ajax.reload();
                        }
                    });
                }
            });

        });


    </script>

@endsection
