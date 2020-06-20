@extends('layouts.main')

@section('content')
    <div class="container">

        <div class="card">
            <div class="card-header">
                <b>Transportation's</b>
                <div class="card-toolbar" style="float: right">

                    <a id="addTransportation" class="btn btn-primary font-weight-bolder">
	<span class="svg-icon svg-icon-md">
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"viewBox="0 0 24 24" version="1.1">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"></rect>
        <circle fill="#000000" cx="9" cy="15" r="6"></circle>
        <path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z"
              fill="#000000" opacity="0.3"></path>
    </g>
</svg></span>New Transportation</a>
                </div>

            </div>

            <input type="hidden" id="school_id" name="school_id" value="{{ $id }}">
            <div class="card-body">
                <table class="table" id="transportationTable"></table>
            </div>
        </div>

        @include('madaresona.schools.shcoolModal')
    </div>
@endsection


@section('script')

    <script type="text/javascript">
            var table = $('#transportationTable').DataTable({
                dom: 'Bfrtip',
                "columnDefs": [
                    {"width": "50px", "targets": 5}
                ],
                processing: true,
                serverSide: true,
                data: {
                    "school_id": $('#school_id').val()
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
                    url: "{{ route('transportationDatatble') }}",
                    type: "get",
                    data: {
                        "school_id": $('#school_id').val()
                    }},
                columns: [
                    {data: 'DT_RowIndex', title: 'ID'},
                    {data: 'region_ar', title: 'Region Arabic'},
                    {data: 'region_en', title: 'Region English'},
                    {data: 'one_way', title: 'One Way'},
                    {data: 'two_way', title: 'Two Way'},
                    {
                        title: 'Actions', "mRender": function (data, type, row) {
                        var remove = '<a href="#" class="btn btn-sm btn-clean btn-icon action-btn remove-trans-btn" id="' + row.id + '" data-toggle="tooltip" data-placement="bottom" title="Remove"><i class="far fa-trash-alt" style="color: #f64e60"></i></i></a>';
                        var edit = '<a href="#" class="btn btn-sm btn-clean btn-icon action-btn edit-trans-btn" id="' + row.id + '" data-toggle="tooltip" data-placement="bottom" title="Remove"><i class="fa fa-edit" style="color: #00aff0"></i></i></a>';
                        return edit + remove;
                    }
                    }
                ]
            });

            $('#addTransportation').on('click', function () {

                var id = '{{ $id }}';
                $.ajax({
                    url: '/schools/transportation/'+id+'/create',
                    method: 'get',
                    success: function (data) {
                       $('.modal-body').html(data);
                        $('.modal-title').text('Add Transportation');
                       $('#schoolModal').modal('show');

                        $('#transportationForm').submit(function (e) {
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
                                            title: data.message
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


            $(document).on('click', '.edit-trans-btn', function () {
                var id = $(this).attr('id');

                $.ajax({
                    url: '/schools/transportation/'+id+'/edit',
                    method: 'get',
                    success: function (data) {
                        $('.modal-body').html(data);
                        $('.modal-title').text(' Edit Transportation');
                        $('#schoolModal').modal('show');

                        $('#transportationForm').submit(function (e) {
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
                                            title: data.message
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

            $(document).on('click', '.remove-trans-btn', function () {
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
                            url: 'removeTransportation/' + id,
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
