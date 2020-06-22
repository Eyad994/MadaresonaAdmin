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
    @foreach($payment as $item)
        <tr id="paymentRow_{{ $item->id }}">
            <th scope="row">{{ $item->id }}</th>
            <td>{{ $item->payed }}</td>
            <td>{{ $item->user->name }}</td>
            <td>{{ $item->created_at != null ? $item->created_at->format('d-m-Y  g:i A') : '' }}</td>
            <td>
                <a href="#" class="btn btn-sm btn-clean btn-icon payment-remove-btn action-btn"
                   id="{{ $item->id }}" data-toggle="tooltip" data-placement="bottom" title="Remove"><i
                            class="far fa-trash-alt" style="color: #f64e60"></i></i></a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<hr>
<div class="row">
    <div class="col-md-3">
        <b>Add New Payment Form</b>
    </div>
</div>

<div style="height: 20px"></div>

<form action="{{ route('paymentStore') }}" method="POST" id="paymentForm">
    <div class="row">
        @csrf

        <input type="hidden" name="finance_id" value="{{ $financeId }}">
        <div class="col-md-12 form-group">
            <label>Pay</label>
            <input type="text" name="payed" placeholder="Pay" class="form-control">
        </div>

    </div>

    <input type="submit" value="submit" class="btn btn-success" style="float: right">
</form>
