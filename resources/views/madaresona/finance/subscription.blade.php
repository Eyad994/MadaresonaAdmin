<table class="table table-striped">
    <thead>
    <tr>
        <th scope="col">#ID</th>
        <th scope="col">Balance</th>
        <th scope="col">Details</th>
        <th scope="col">Start Date</th>
        <th scope="col">End Date</th>
    </tr>
    </thead>
    <tbody>
    @foreach($finance as $item)
        <tr id="subscriptionRow_{{ $item->id }}">
            <th scope="row">{{ $item->id }}</th>
            <td>{{ $item->balance }}</td>
            <td>{{ $item->type }}</td>
            <td>{{ $item->start_date }}</td>
            <td>{{ $item->end_date }}</td>
            <td>
                <a href="#" class="btn btn-sm btn-clean btn-icon subscription-remove-btn action-btn"
                   id="{{ $item->id }}" data-toggle="tooltip" data-placement="bottom" title="Remove"><i
                            class="far fa-trash-alt" style="color: #f64e60"></i></a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<hr>
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
            <input type="text" name="balance" placeholder="Balance" class="form-control">
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


<script src="{{ asset('assets/js/pages/crud/forms/widgets/bootstrap-datepicker7a4a.js') }}"></script>
