@if(!$saleFinances->isEmpty())
<table class="table table-striped">
    <thead>
    <tr>
        <th scope="col">#ID</th>
        <th scope="col">User Name</th>
        <th scope="col">Number</th>
        <th scope="col">Amount</th>
        <th scope="col">Add By</th>
        <th scope="col">Date</th>
    </tr>
    </thead>
    <tbody>


    <section class="campaign">
        <?php $i=1;?>
        @foreach($saleFinances as $item)
            <tr id="salesFinanceRow_{{ $item->id }}">
                <th scope="row">{{$i}}</th>
                <td>{{ $item->user->name }}</td>
                <td>{{ $item->number }}</td>
                <td>{{ $item->amount }}</td>
                <td>{{ $item->user->name }}</td>
                <td>{{ $item->date != null ? $item->date->format('d-m-Y') : '' }}</td>
                <td style="text-align: center;">
                    <a href="#" class="btn btn-sm btn-clean btn-icon salesFinance-remove-btn action-btn"
                       id="{{ $item->id }}" data-toggle="tooltip" data-placement="bottom" title="Remove"><i
                                class="far fa-trash-alt" style="color: #f64e60"></i></a>
                </td>
            </tr>
            <?php $i++;?>
        @endforeach
    </section>

    </tbody>
</table>
<div class="row">
    <div class="col-md-12" style="float: right">
        {!! $saleFinances->render() !!}
    </div>
</div>
<hr>
@endif
<script type="text/javascript">

    $(function () {
        

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

