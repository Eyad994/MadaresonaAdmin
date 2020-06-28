@extends('layouts.main')

@section('content')
    <div class="container">

        <div class="card">
            <div class="card-header">
                <b>Sales <b style="color:#ffa800;">{{$user_name}}</b></b>
                <div class="card-toolbar" style="float: right">

                    <a id="addSales" class="btn btn-primary font-weight-bolder">
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

        var table = $('#salesFinances').DataTable({
            dom: 'Bfrtip',
            "columnDefs": [
                {"width": "50px", "targets": 2}
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
                }},
            columns: [
                {data: 'DT_RowIndex', title: 'ID'},
                {data: 'date', title: 'Data'},
                {
                    title: 'Actions', "mRender": function (data, type, row) {
                        //var remove = '<a href="#" class="btn btn-sm btn-clean btn-icon action-btn remove-trans-btn" id="' + row.id + '" title="Remove"><i class="far fa-trash-alt" style="color: #f64e60"></i></i></a>';
                        var edit = '<a href="#" class="btn btn-sm btn-clean btn-icon action-btn edit-trans-btn" id="' + row.id + '"  title="View & Edit"><i class="fa fa-edit" style="color: #00aff0"></i></i></a>';
                        return edit;
                    }
                }
            ]
        });
    </script>

@endsection