@extends('layouts.main')

@section('content')

    <div class="container">

        <div class="card">
            <div class="card-header">
                <b>Registration</b>
                <div class="card-toolbar" style="float: right">

                    <a id="addRegistration" class="btn btn-primary font-weight-bolder">
	<span class="svg-icon svg-icon-md">
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
             viewBox="0 0 24 24" version="1.1">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"></rect>
        <circle fill="#000000" cx="9" cy="15" r="6"></circle>
        <path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z"
              fill="#000000" opacity="0.3"></path>
    </g>
</svg></span>New Registration</a>
                </div>

            </div>

            <div class="card-body">
                <table class="table" id="registrationTable"></table>
            </div>
        </div>

        @include('madaresona.schools.shcoolModal')
    </div>

@endsection

@section('script')

    <script type="text/javascript">

        var table = $('#registrationTable').DataTable({
            dom: 'Bfrtip',
            "columnDefs": [
             {"width": "100px", "targets": 7}
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
                url: "{{ route('registrationDatatable') }}",
                type: "get",
            },
            columns: [
                {data: 'DT_RowIndex', title: 'ID'},
                {
                    data: 'schools', title: 'Schools', "mRender": function (data, type, row) {
                    var arr = [];
                    row.schools.map(function (a) {
                        arr.push(a.name_ar + ' ');
                    });
                    return arr;
                }
                },
                {data: 'parent', title: 'Parent'},
                {data: 'number', title: 'Phone Number'},
                {data: 'child', title: 'Child'},
                {data: 'class_id', title: 'Class'},
                {data: 'by_admin', title: 'By Admin'},
                {
                    title: 'Actions', "mRender": function (data, type, row) {
                    var remove = '<a href="#" class="btn btn-sm btn-clean btn-icon action-btn remove-registration-btn" id="' + row.id + '"  title="View & Edit"><i class="far fa-trash-alt" style="color: #f64e60"></i></a>';
                    var edit = '<a href="#" class="btn btn-sm btn-clean btn-icon action-btn edit-registration-btn" id="' + row.id + '" title="Remove"><i class="fa fa-edit" style="color: #00aff0"></i></a>';
                    var notes = '<a href="#"  class="btn btn-sm btn-clean btn-icon action-btn note-registration-btn" title="Notes"  id="' + row.id + '"><i class="fa fa-sticky-note" style="color: #ffa800" ></i></a>'
                    return edit + remove + notes;
                }
                }
            ]
        });

        $('#addRegistration').on('click', function () {


            $.ajax({
                url: '{{ route('registration.create') }}',
                method: 'get',
                success: function (data) {
                    $('.modal-body').html(data);
                    $('.modal-title').text('Add Registration');
                    $('#schoolModal').modal('show');

                    $('#registrationForm').submit(function (e) {
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


        $(document).on('click', '.edit-registration-btn', function () {
            var id = $(this).attr('id');
            $.ajax({
                url: '/registration/' + id + '/edit',
                type: 'get',
                success: function (data) {
                    $('.modal-body').html(data);
                    $('.modal-title').text('Edit Registration');
                    $('#schoolModal').modal('show');

                    $('#registrationForm').submit(function (e) {
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

        $(document).on('click', '.remove-registration-btn', function () {
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
                        url: '/registration/' + id,
                        method: 'delete',
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


        $(document).on('click', '.note-registration-btn', function () {
            var id = $(this).attr('id');
            $.ajax({
                url: '/registration/note/'+ id,
                method: 'get',
                success: function (data) {
                    $('.modal-body').html(data);
                    $('.modal-title').text('Subscriptions');
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
    </script>

@endsection