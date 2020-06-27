<script type="text/javascript">

    $(function () {

        // show all products
        var table = $('.data-table').DataTable({
            dom: 'Bfrtip',
            "columnDefs": [

                {"width": "160px", "targets": 8},
                {"width": "50px", "targets": 9},
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

                {
                    title: 'SN', "mRender": function (data, type, row) {
                    return '<label style="font-weight: 600 !important; color: #0d8ddc;">' + row.sn + ' </label>'

                }
                },
                {data: 'name_ar', title: 'Name'},
                {data: 'school_order', title: 'Order'},

                {
                    data: 'active', title: 'Case', "mRender": function (data, type, row) {
                    if (row.active == 'InActive') {
                        return "<span class='label font-weight-bold label-lg  label-light-danger label-inline'>InActive</span>";
                    } else if (row.active == 'Active') {
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
                    data: 'status_name', title: 'Status', "mRender": function (data, type, row) {
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
                    data: 'special', title: 'Special', "mRender": function (data, type, row) {
                    if (row.special == 'General') {
                        return "<span class='label font-weight-bold label-lg  label-light-primary label-inline'>General</span>";
                    } else if (row.special == 'Special') {
                        return "<span class='label font-weight-bold label-lg  label-light-warning label-inline'>Special</span>";

                    }

                }
                },

                {
                    title: 'Services', "mRender": function (data, type, row) {
                    var gallery = '<a href="#" class="btn btn-sm btn-clean btn-icon action-btn gallerySchool" id="' + row.id + '"><i class="fa fa-file-image"  title="School gallery"></i></i></a>';
                    var transportation = '<a href="/schools/transportation/' + row.id + '" target="_blank" class="btn btn-sm btn-clean btn-icon action-btn" id="' + row.id + '"><i class="fa fa-bus"  title="Transportation" ></i></a>';
                    var premiums = '<a href="/schools/premium/' + row.id + '" target="_blank" class="btn btn-sm btn-clean btn-icon action-btn" id="' + row.id + '" ><i class="fa fa-credit-card"  title="Premiums"></i></a>';
                    var news = '<a href="/schools/news/' + row.id + '" target="_blank" class="btn btn-sm btn-clean btn-icon action-btn"><i class="fa fa-newspaper" title="News"></i></i></a>';
                    var notes = '<a href="/schools/note/' + row.id + '" target="_blank" class="btn btn-sm btn-clean btn-icon action-btn"><i class="fa fa-sticky-note" title="Notes"></i></i></a>';
                    return gallery + transportation + premiums + news + notes;
                    /*var show = '<button data-toggle="modal" data-target="#productModal" class="btn btn-success  showM" id="' + row.id + '"><i class="fa fa-eye"></i></button >';
                     return show;*/
                }

                },
                {
                    title: 'Actions', "mRender": function (data, type, row) {
                    var edit = '<a href="#" class="btn btn-sm btn-clean btn-icon editSchool action-btn" id="' + row.id + '"  data-toggle="tooltip" data-placement="bottom" title="View & Edit"><i class="fas fa-edit" style="color: #3699ff"></i></a>';
                    var remove = '<a href="#" class="btn btn-sm btn-clean btn-icon action-btn remove-School-btn"  id="' + row.id + '" data-toggle="tooltip" data-placement="bottom" title="Remove"><i class="far fa-trash-alt" style="color: #f64e60"></i></i></a>';
                    return edit + remove;
                    /*var show = '<button data-toggle="modal" data-target="#productModal" class="btn btn-success  showM" id="' + row.id + '"><i class="fa fa-eye"></i></button >';
                     return show;*/
                }
                }
            ]
        });


        $('.filter-select').change(function () {
            var filterStatus = document.getElementById("filter-select");
            var filterText = filterStatus.options[filterStatus.selectedIndex].text;

            table.column($(this).data('column'))
                .search(filterText)
                //.search($(this).val())
                .draw();
        });

        $(document).on('click', '.gallerySchool', function () {

            var id = $(this).attr('id');

            $.ajax({
                url: '/schools/gallery/' + id,
                method: 'get',
                success: function (data) {
                    $('.modal-body').html(data);
                    $('.modal-title').text('School Gallery');
                    $('#schoolModal').modal('show');

                    $("#galleryForm").submit(function (e) {

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

                                    $('#schoolModal').modal('hide');
                                }
                            }
                        });

                    });
                }
            });
        });


        $(document).on('click', '.galleryDelete', function () {
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
                        url: 'removeGallery/' + id,
                        method: 'get',
                        success: function (data) {
                            $('.galleryDeleteDiv_' + id).fadeOut('slow', function () {
                                $('.galleryDeleteDiv_' + id).remove();
                            });
                            Swal.fire({
                                icon: 'success',
                                title: 'Your image has been removed',
                                showConfirmButton: false,
                                timer: 1500
                            })
                        }
                    });
                }
            });

        });

        $(document).on('click', '.editSchool', function () {
            var id = $(this).attr('id');
            $.ajax({
                url: '/schools/edit' + '/' + id,
                method: 'get',
                success: function (data) {
                    $('.modal-body').html(data);
                    $('.modal-title').text('Edit School');
                    $('#schoolModal').modal('show');
                    $("#updateSchoolForm").submit(function (e) {

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
                                        title: data.message,
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                    //$('.data-table').DataTable.ajax().reload();

                                    $('#schoolModal').modal('hide');
                                    table.ajax.reload();
                                }

                            }
                        });

                    });
                }
            })
        });


        $('#addSchool').on('click', function () {

            $.ajax({
                url: '{{ route('addSchool') }}',
                method: 'get',
                success: function (data) {
                    $('.modal-body').html(data);
                    $('.modal-title').text('Add School');
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
                                        title: data.message,
                                        showConfirmButton: false,
                                        timer: 1500
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

        $(document).on('click', '.remove-School-btn', function () {
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
                        url: '/schools/' + id + '/destroy',
                        method: 'get',
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

    });

</script>
