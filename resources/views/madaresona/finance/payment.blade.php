@if(!$payment->isEmpty())
<table class="table table-striped">
    <thead>
    <tr>
        <th scope="col">#ID</th>
        <th scope="col">Pay</th>
        <th scope="col">Added By</th>
        <th scope="col">Date</th>
    </tr>
    </thead>
    <tbody>

    <?php $i=1;
    ?>
    @foreach($payment as $item)
        <tr id="paymentRow_{{ $item->id }}">
            <th scope="row">{{ $i}}</th>
            <td>{{ $item->payed }}</td>
            <td>{{ $item->user->name }}</td>
            <td>{{ $item->date != null ? $item->date : '' }}</td>
            <td style="text-align: center;">
                <a href="#" class="btn btn-sm btn-clean btn-icon payment-remove-btn action-btn"
                   id="{{ $item->id }}" data-toggle="tooltip" data-placement="bottom" title="Remove"><i
                        class="far fa-trash-alt" style="color: #f64e60"></i></a>
            </td>
        </tr>
        <?php $i++;?>
    @endforeach

    </tbody>
</table>
<hr>
@endif
<div class="row">
    <div class="col-md-3">
        <b>Add New Payment Form</b>
    </div>
</div>

<div style="height: 20px"></div>

<form action="{{ route('paymentStore') }}" method="POST" id="paymentForm">
    <div class="row">
        @csrf

        <input type="hidden" name="user_id" value="{{ $userId }}">
        <div class="col-md-6 form-group">
            <label>Pay</label>
            <input type="number" name="payed" placeholder="Pay" class="form-control">
        </div>
        <div class="col-md-6 form-group">
            <label for="date">Date</label>
            <input name="date" id="datepicker" class="date-picker form-control"/>
        </div>

    </div>

    <input type="submit" value="submit" class="btn btn-success" style="float: right">
</form>
<script type="text/javascript">

    $(function () {

        $("#datepicker").datepicker({
            format: "dd-mm-yyyy",
        });
    });
</script>