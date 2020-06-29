
<div class="row">
    <div class="col-md-3">
        <b>Add New Target Form</b>
    </div>
</div>

<div style="height: 20px"></div>

<form action="{{ route('saleFinance.store') }}" method="POST" id="saleFinanceForm" >
    <div class="row">
        @csrf

        <input type="hidden" name="user_id" value="{{ $userId }}">
        <div class="col-md-6 form-group">
            <label>Number</label>
            <input type="text" name="number" placeholder="Number" class="form-control">
        </div>

        <div class="col-md-6 form-group">
            <label>Amount</label>
            <input type="text" name="amount" placeholder="Amount" class="form-control">
        </div>

        <div class="col-md-6 form-group">
            <label for="date">Date :</label>
            <input name="date" id="datepicker" class="date-picker form-control"/>
        </div>

        <script type="text/javascript">

            $(function () {
                $("#datepicker").datepicker({
                    format: "yyyy-mm-dd",
                });

                $('#saleFinanceForm').submit(function (e) {
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


                $('.salesFinance-remove-btn').on('click', function () {
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
                                url: '/salesFinances/destroy/' + id,
                                method: 'get',
                                success: function (data) {
                                    $('#salesFinanceRow_' + id).remove();
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Your sales has been removed',
                                        showConfirmButton: false,
                                        timer: 1500
                                    })
                                }
                            });
                        }
                    });
                })

            });

        </script>

    </div>

    <input type="submit" value="submit" class="btn btn-success" style="float: right">
</form>
