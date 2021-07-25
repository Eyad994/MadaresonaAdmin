@extends('layouts.main')

@section('content')
    <div class="container">

        <div class="card">
            <div class="card-header">
                <b>Subscribes Email</b>


            </div>

            <div class="card-body">
                <form id="frm-example" action="{{ route('emailSender') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label>Title</label>
                            <input type="text" name="title" placeholder="Title" class="form-control">
                        </div>
                        <div class="col-md-12 form-group">
                            <label>Content</label>
                            <textarea name="email_content" id="email_content"
                                      style="display: block; width: 80%; height: 100px;"
                                      placeholder="Content ....................................."></textarea>
                        </div>
                        <div class="col-md-12 form-group">
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="1" name="example1" checked>
                                <label class="custom-control-label" for="1">Send All</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="2" name="example1">
                                <label class="custom-control-label" for="2">select</label>
                            </div>
                        </div>
                        <input type="hidden" id="emails" name="emails" value="">
                        <input type="hidden" id="option" name="option" value="">
                        <div class="col-md-12 form-group">
                            <input type="submit" class="btn btn-success" name="Submit" style="float: right">
                        </div>
                    </div>
                    <table class="table" id="subscribes-email"></table>

                </form>
            </div>
        </div>

        @include('madaresona.schools.shcoolModal')
    </div>
@endsection


@section('script')

    <script type="text/javascript">

        var table = $('#subscribes-email').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'selectAll',
                'selectNone'
            ],
            "order": [[0, 'desc']],
            'columnDefs': [
                {"width": "50px", "targets": 3},
                {
                    'targets': 0,
                    'checkboxes': {
                        'selectRow': true
                    }
                }
            ],
            'select': {
                'style': 'multi'
            },
            lengthMenu: [
                [10, 25, 50, 100, -1],
                ['10 rows', '25 rows', '50 rows', '100 rows', 'Show all']
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
                url: "{{ route('SubscribesEmailDatatable') }}",
                type: "get",
            },
            columns: [
                {data: 'DT_RowIndex', title: 'ID', orderable: false, searchable: false},
                {
                    title: 'Email', "mRender": function (data, type, row) {
                        return '<span class="font-weight-bold text-primary">' + row.email + '</span>';
                    }
                },
                {data: 'created_at', title: 'date'},
                {
                    title: 'Actions', "mRender": function (data, type, row) {
                        var remove = '<a href="#" class="btn btn-sm btn-clean btn-icon action-btn remove-subscribes-email-btn" id="' + row.id + '"  title="Remove"><i class="far fa-trash-alt" style="color: #f64e60"></i></a>';
                        return remove;
                    }
                }
            ]
        });
        $(document).on('click', '.remove-subscribes-email-btn', function () {
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
                        url: '/subscribes_email/destroy/' + id,
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


        $('#frm-example').submit(function (e) {
            var option = ($("input[name='example1']:checked")[0].id);
            $("#option").val(option);
            if (option == 2) {
                var rows_selected = table.column(0).checkboxes.selected();

                var emails = [];
                $.each(rows_selected, function () {
                    var datas = table.row(rows_selected).data()
                    emails.push(datas.email);
                });
                $("#emails").val(emails);
                    emails = emails.join(",");

            }

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
                    }else if (data.status === 4222) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            html: data.message,
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
    </script>

@endsection

