@if(!$finance->isEmpty())
<table class="table table-striped">
    <thead>
    <tr>
        <th scope="col">#ID</th>
        <th scope="col">#Subscription</th>
        <th scope="col">Balance</th>
        <th scope="col">Details</th>
        <th scope="col">Start Date</th>
        <th scope="col">End Date</th>
    </tr>
    </thead>
    <tbody>
    <section class="campaign">
    <?php $i=1;?>
    @foreach($finance as $item)
        <tr id="subscriptionRow_{{ $item->id }}">
            <th scope="row">{{ $i }}</th>
            <td>@if($item->uuid != null){{ $item->uuid }} @else {{ $item->uuids }} @endif</td>
            <td>{{ $item->balance }}</td>
            <td>{{ $item->type }}</td>
            <td>{{ $item->start_date }}</td>
            <td>{{ $item->end_date }}</td>
            <td style="text-align: center;">
                <a href="#" class="btn btn-sm btn-clean btn-icon subscription-remove-btn action-btn"
                   id="{{ $item->id }}" data-toggle="tooltip" data-placement="bottom" title="Remove"><i
                            class="far fa-trash-alt" style="color: #f64e60"></i></a>
            </td>
        </tr>
        <?php $i++;?>
    @endforeach
    </section>
    </tbody>
</table>
{!! $finance->links() !!}
<hr>
@endif
<div class="row">
    <div class="col-md-3">
        <b>Add New Subscription Form</b>
    </div>
</div>

<div style="height: 20px"></div>

<form action="{{ route('subscriptionStore') }}" method="POST" id="subscriptionForm">
    <div class="row">

        @csrf
        <input type="hidden" name="user_id" value="{{ $item->user_id }}">

        <div class="col-md-6 form-group">
            <label>Balance</label>
            <input type="number" name="balance" placeholder="Balance" class="form-control">
        </div>
        <div class="col-md-6 form-group">
            <label>Details</label>
            <input type="text" name="type" placeholder="Details" class="form-control">
        </div>

        <div class="col-md-12 form-group">
            <label>Date</label>
            <div class="input-daterange input-group" id="kt_datepicker_5">
                <input type="text" class="form-control" name="start"
                       placeholder="From Date">
                <div class="input-group-append">
                    <span class="input-group-text"><i class="fa fa-ellipsis-h"></i></span>
                </div>
                <input type="text" class="form-control" name="end"
                       placeholder="To Date">
            </div>
        </div>

        <div class="col-md-6">
            <label>Is Tax</label>
            <select name="tax" class="form-control">
                <option value="0">False</option>
                <option value="1">True</option>
            </select>
        </div>

    </div>

    <input type="submit" value="submit" class="btn btn-success" style="float: right">
</form>

<script type="text/javascript">

    $("#subscriptionForm").submit(function (e) {

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

                    $('#schoolModal').modal('hide');
                }
            }
        });

    });

    $('.subscription-remove-btn').on('click', function () {
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
                    url: 'removeSubscription/' + id,
                    method: 'get',
                    success: function (data) {
                        $('#subscriptionRow_' + id).remove();
                        Swal.fire({
                            icon: 'success',
                            title: 'Your subscription has been removed',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                });
            }
        });
    })
</script>
<script src="{{ asset('assets/js/pages/crud/forms/widgets/bootstrap-datepicker7a4a.js') }}"></script>
