@extends('layouts.main')

@section('content')
    <div class="container">

        <div class="card">
            <div class="card-header">
                <b>Suggestions</b>
            </div>
            <div class="col-md-12">
                <label class="" style="padding: 10px 0px 0px 19px;"> Supplier Name : <b style="color:#ffa800;">{{$supplier_name}}</b> </label>
            </div>
            <div class="card-body">
                <table class="table" id="messageTable"></table>
            </div>
        </div>

        <input type="hidden" name="user_id" id="user_id" value="{{ $id }}">
        @include('madaresona.schools.shcoolModal')
    </div>
@endsection


@section('script')

    <script type="text/javascript">

        var table = $('#messageTable').DataTable({
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
                url: "{{ route('messageDatatable') }}",
                type: "get",
                data: {
                    "user_id": $('#user_id').val()
                }
            },
            columns: [
                {data: 'DT_RowIndex', title: 'ID'},
                {data: 'name', title: 'Name'},
                {data: 'subject', title: 'Subject'},
                {
                    title: 'Email', "mRender": function (data, type, row) {
                        return'<span class="font-weight-bold text-primary">' + row.email + '</span>';
                    }
                },
                {data: 'created_at', title: 'date'},
                {
                    data: 'seen', title: 'Seen', "mRender": function (data, type, row) {
                        if (row.seen == 'NO') {
                            return "<span class='label font-weight-bold label-lg  label-light-danger label-inline'>NO</span>";
                        } else if (row.seen == 'Yes') {
                            return "<span class='label font-weight-bold label-lg  label-light-success label-inline'>Yes</span>";

                        }

                    }
                },
                {
                    title: 'Actions', "mRender": function (data, type, row) {
                        var edit = '<a href="#" class="btn btn-sm btn-clean btn-icon action-btn show-message-btn" id="' + row.id + '" title="View"><i class="fa fa-eye" style="color: #00aff0"></i></a>';
                        var remove = '<a href="#" class="btn btn-sm btn-clean btn-icon action-btn remove-message-btn" id="' + row.id + '"  title="Remove"><i class="far fa-trash-alt" style="color: #f64e60"></i></a>';
                        return edit + remove;
                    }
                }
            ]
        });


        $(document).on('click', '.show-message-btn', function () {
            var id = $(this).attr('id');
            $.ajax({
                url: '/supplier/message/' + id + '/edit',
                method: 'get',
                success: function (data) {
                    $('.modal-body').html(data);
                    $('.modal-title').text('message');
                    $('#schoolModal').modal('show');

                }
            });
        });

        $(document).on('click', '.remove-message-btn', function () {
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
                        url: '/supplier/message/' + id + '/destroy',
                        method: 'get',
                        success: function (data) {
                            Swal.fire({
                                icon: 'success',
                                title: 'message has been removed',
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

