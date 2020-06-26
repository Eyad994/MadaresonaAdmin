@extends('layouts.main')

@section('content')
    <div class="container">

        <div class="card">
            <div class="card-header">
                <b>Request's</b>


            </div>

            <div class="card-body">
                <table class="table" id="requests"></table>
            </div>
        </div>

        @include('madaresona.schools.shcoolModal')
    </div>
@endsection


@section('script')

    <script type="text/javascript">

        var table = $('#requests').DataTable({
            dom: 'Bfrtip',
            "columnDefs": [
                {"width": "60px", "targets": 7}
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
                url: "{{ route('requestsDatatable') }}",
                type: "get",
            },
            columns: [
                {data: 'DT_RowIndex', title: 'ID'},
                {data: 'name', title: 'Name'},
                {data: 'contact_name', title: 'Contact Name'},
                {data: 'phone', title: 'Phone'},
                {data: 'type', title: 'Type'},
                {data: 'email', title: 'Email'},
                {data: 'created_at', title: 'date'},
                {
                    title: 'Actions', "mRender": function (data, type, row) {
                        var remove = '<a href="#" class="btn btn-sm btn-clean btn-icon action-btn remove-requests-btn" id="' + row.id + '"  title="Remove"><i class="far fa-trash-alt" style="color: #f64e60"></i></a>';
                        return remove;
                    }
                }
            ]
        });





        $(document).on('click', '.remove-requests-btn', function () {
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
                        url: '/requests/destroy/' + id,
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

