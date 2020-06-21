<script type="text/javascript">

    $(function () {

        // show all products
        var table = $('.data-table').DataTable({
            dom: 'Bfrtip',
            "columnDefs": [

                {"width": "160px", "targets": 8},
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
            ajax: "{{ route('FinanceDatable') }}",
            columns: [
                {data: 'DT_RowIndex', title: 'ID'},

                {{-- {
                    title: 'SN', "mRender": function (data, type, row) {
                    return '<label style="font-weight: 600 !important; color: #0d8ddc;">' + row.sn + ' </label>'

                }
                },
                {data: '', title: 'Name'},

                {data: '', title: 'Type'},
                {data: '', title: 'Is Tax'},
                {data: '', title: 'Subscription expired'},
                {data: '', title: 'School OR Supplier'},
                {
                    title: 'Actions', "mRender": function (data, type, row) {
                    var show = '<button data-toggle="modal" data-target="#productModal" class="btn btn-success  showM" id="' + row.id + '"><i class="fa fa-eye"></i></button >';
                    return show;
                }
                }
                --}}
            ]
        });

    });

</script>
