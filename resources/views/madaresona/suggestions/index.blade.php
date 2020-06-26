@extends('layouts.main')

@section('content')
    <div class="container">

        <div class="card">
            <div class="card-header">
                <b>Suggestions</b>
            </div>

            <div class="card-body">
                <table class="table" id="suggestionsTable"></table>
            </div>
        </div>

        @include('madaresona.schools.shcoolModal')
    </div>
@endsection


@section('script')

    <script type="text/javascript">

        var table = $('#suggestionsTable').DataTable({
            dom: 'Bfrtip',
            "columnDefs": [
                {"width": "50px", "targets": 4}
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
                url: "{{ route('suggestionsDatatable') }}",
                type: "get",
            },
            columns: [
                {data: 'DT_RowIndex', title: 'ID'},
                {data: 'name', title: 'Name'},
                {data: 'email', title: 'Email'},
                {data: 'created_at', title: 'date'},
                {
                    title: 'Actions', "mRender": function (data, type, row) {
                        var edit = '<a href="#" class="btn btn-sm btn-clean btn-icon action-btn show-suggestions-btn" id="' + row.id + '" title="View"><i class="fa fa-eye" style="color: #00aff0"></i></a>';
                        var remove = '<a href="#" class="btn btn-sm btn-clean btn-icon action-btn remove-suggestions-btn" id="' + row.id + '"  title="Remove"><i class="far fa-trash-alt" style="color: #f64e60"></i></a>';
                        return edit + remove;
                    }
                }
            ]
        });


        $(document).on('click', '.show-suggestions-btn', function () {
            var id = $(this).attr('id');
            $.ajax({
                url: '/suggestions/' + id + '/edit',
                method: 'get',
                success: function (data) {
                    $('.modal-body').html(data);
                    $('.modal-title').text('suggestions');
                    $('#schoolModal').modal('show');

                }
            });
        });

        $(document).on('click', '.remove-suggestions-btn', function () {
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
                        url: '/suggestions/' + id,
                        method: 'delete',
                        success: function (data) {
                            Swal.fire({
                                icon: 'success',
                                title: 'suggestions has been removed',
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

