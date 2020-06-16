<script type="text/javascript">

    $(function () {

        // show all products
        var table = $('.data-table').DataTable({
            dom: 'Bfrtip',
            "columnDefs": [
                {"width": "120px", "targets": 8},
                {"width": "100px", "targets": 9},
                {"className": "text-center", "targets": 1}
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
            ajax: "{{ route('schoolsDatable') }}",
            columns: [
                {data: 'DT_RowIndex', title: 'ID'},
                {data: 'name_ar', title: 'SN'},
                {data: 'name_ar', title: 'Name'},
                {data: 'school_order', title: 'Order'},

                {
                   title: 'Case', "mRender": function (data, type, row) {
                    if (row.active == 0) {
                        return "<span class='label font-weight-bold label-lg  label-light-danger label-inline'>Not Active</span>";
                    } else if (row.active == 1) {
                        return "<span class='label font-weight-bold label-lg  label-light-success label-inline'>Active</span>";

                    }

                }
                },
                {
                    title: 'logo', "mRender": function (data, type, row) {
                    var imgeUrl = '{{ asset('images/') }}';
                    if (row.school_logo != '') {
                        return '<img src="' + imgeUrl + '/' + row.name_en + '/' + row.school_logo + '" class="avatar" width="50" height="50"/>';
                    }
                    else
                        return "Not Found Logo";

                }
                },
                {
                   data:'status_name', title: 'Status', "mRender": function (data, type, row) {
                    if (row.status == 1) {
                        return '<span class="label font-weight-bold label-lg  label-light-danger label-inline">' + row.status_name + '</span>'
                    } else if (row.status == 2) {
                        return '<span class="label font-weight-bold label-lg  label-light-info label-inline">' + row.status_name + '</span>'
                    } else if (row.status == 3) {
                        return '<span class="label font-weight-bold label-lg  label-light-success label-inline">' + row.status_name + '</span>'
                    }
                }
                },

                {
                    title: 'Special', "mRender": function (data, type, row) {
                    if (row.special == 0) {
                        return "<span class='label font-weight-bold label-lg  label-light-primary label-inline'> Not Special</span>";
                    } else if (row.special == 1) {
                        return "<span class='label font-weight-bold label-lg  label-light-warning label-inline'>Special</span>";

                    }

                }
                },

                {
                    title: 'Services', "mRender": function (data, type, row) {
                    var view = '<a href="#" class="btn btn-sm btn-clean btn-icon action-btn" id="' + row.id + '"><i class="fa fa fa-bus" data-toggle="tooltip" data-placement="bottom" title="Tooltip on bottom" style="color: orange"></i></a>';
                    var edit = '<a href="#" class="btn btn-sm btn-clean btn-icon action-btn" toolbar="asd"><i class="fa fa-credit-card" style="color: #ffa800"></i></a>';
                    var remove = '<a href="#" class="btn btn-sm btn-clean btn-icon action-btn"><i class="fa fa-newspaper" style="color: #f64e60"></i></i></a>';
                    var news = '<a href="#" class="btn btn-sm btn-clean btn-icon action-btn"><i class="fa fa-sticky-note" style="color: #f64e60"></i></i></a>';
                    return view + edit + remove + news;
                    /*var show = '<button data-toggle="modal" data-target="#productModal" class="btn btn-success  showM" id="' + row.id + '"><i class="fa fa-eye"></i></button >';
                     return show;*/
                }

                },
                {
                    title: 'Actions', "mRender": function (data, type, row) {
                    var edit = '<a href="#" class="btn btn-sm btn-clean btn-icon editSchool action-btn" id="' + row.id + '" data-toggle="modal" data-target="#schoolModal"><i class="fas fa-edit" style="color: #3699ff"></i></a>';
                    var remove = '<a href="#" class="btn btn-sm btn-clean btn-icon action-btn"><i class="far fa-trash-alt" style="color: #f64e60"></i></i></a>';
                    return  edit + remove;
                    /*var show = '<button data-toggle="modal" data-target="#productModal" class="btn btn-success  showM" id="' + row.id + '"><i class="fa fa-eye"></i></button >';
                     return show;*/
                }
                },
            ],
        });


        $('.filter-select').change(function () {
            var filterStatus = document.getElementById("filter-select");
            var filterText = filterStatus.options[filterStatus.selectedIndex].text;

            table.column($(this).data('column'))
                .search(filterText)
                //.search($(this).val())
                .draw();
        });


        $(document).on('click', '.editSchool', function () {
            var id = $(this).attr('id');
            $.ajax({
                url: '/schools/edit' + '/' + id,
                method: 'get',
                success: function (data) {
                    $('.modal-body').html(data);
                }
            })
        });

        $('#addSchool').on('click', function () {

            $.ajax({
                url: '{{ route('addSchool') }}',
                method: 'get',
                success: function (data) {
                    $('.modal-body').html(data);
                    $('#schoolModal').modal('show');

                    $("#addSchoolForm").submit(function (e) {

                        e.preventDefault(); // avoid to execute the actual submit of the form.

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
                            //data: form.serialize(), // serializes the form's elements.
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
                                    //$('.data-table').DataTable.ajax().reload();

                                    $('#schoolModal').modal('hide');
                                    table.ajax.reload();
                                }

                            }
                        });

                    });
                }
            });
        });

    });

</script>
