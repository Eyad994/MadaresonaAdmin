@extends('layouts.main')

@section('content')

    <div class="container">

        <div class="card">
            <div class="card-header">
                <b>User's</b>
                <div class="card-toolbar" style="float: right">

                    <a id="addUser" class="btn btn-primary font-weight-bolder">
	<span class="svg-icon svg-icon-md">
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
             viewBox="0 0 24 24" version="1.1">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"></rect>
        <circle fill="#000000" cx="9" cy="15" r="6"></circle>
        <path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z"
              fill="#000000" opacity="0.3"></path>
    </g>
</svg></span>New User</a>
                </div>

            </div>

            <div class="card-body">
                <table class="table" id="userTable"></table>
            </div>
        </div>

        @include('madaresona.schools.shcoolModal')
    </div>
@endsection

@section('script')

    <script>
        var table = $('#userTable').DataTable({
            dom: 'Bfrtip',
            "columnDefs": [

                {"width": "60px", "targets": 5},
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
                url: "{{ route('userDatatable') }}",
                type: "get"
            },
            columns: [
                {data: 'DT_RowIndex', title: 'ID'},
                {data: 'name', title: 'Name'},

                {
                    title: 'Type', "mRender": function (data, type, row) {
                        if (row.type == 'Admin') {
                            return '<span class="label label-info label-dot mr-2"></span>' +
                                '<span class="font-weight-bold text-info">' + row.type + '</span>'
                        } else if (row.type == 'Editor') {
                            return '<span class="label label-warning label-dot mr-2"></span>' +
                                '<span class="font-weight-bold text-warning">' + row.type + '</span>'
                        } else if (row.type == 'School') {
                            return '<span class="label label-success label-dot mr-2"></span>' +
                                '<span class="font-weight-bold text-success">' + row.type + '</span>'
                        } else if (row.type == 'Supplier') {
                            return '<span class="label label-primary label-dot mr-2"></span>' +
                                '<span class="font-weight-bold text-primary">' + row.type + '</span>'
                        }
                    }
                },
                {data: 'email', title: 'Email'},
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
                        var edit = '<a href="#" class="btn btn-sm btn-clean btn-icon action-btn edit-user-btn" id="' + row.id + '" title="View & Edit"><i class="fa fa-edit" style="color: #00aff0"></i></i></a>';
                        var remove = '<a href="#" class="btn btn-sm btn-clean btn-icon action-btn generate-password-btn" id="' + row.id + '"  title="Generate Password "><i class="fas fa-unlock-alt" style="color: #f64e60"></i></i></a>';
                        return edit + remove;
                    }
                }
            ]
        });


        $('#addUser').on('click', function () {

            $.ajax({
                url: '{{ route('user.create') }}',
                method: 'get',
                success: function (data) {
                    $('.modal-body').html(data);
                    $('.modal-title').text('Add User');
                    $('#schoolModal').modal('show');

                    $('#userForm').submit(function (e) {
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
        $(document).on('click', '.generate-password-btn', function () {

            var id = $(this).attr('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Generate it!'
            }).then(function (result) {
                if (result.value) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        url: '/generate/' + id ,
                        method: 'post',
                        success: function (data) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Your user has Generate Password Successfully' ,
                                showConfirmButton: false,
                                timer: 1500
                            });
                            table.ajax.reload();
                        }
                    });
                }
            });

        });

        $(document).on('click', '.edit-user-btn', function () {
            var id = $(this).attr('id');
            $.ajax({
                url: '/user/' + id + '/edit',
                type: 'get',
                success: function (data) {
                    $('.modal-body').html(data);
                    $('.modal-title').text('Edit User');
                    $('#schoolModal').modal('show');

                    $('#userForm').submit(function (e) {
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

        $(document).on('click', '.remove-user-btn', function () {
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
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        url: '/user/' + id,
                        method: 'delete',
                        success: function (data) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Your question has been removed',
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
