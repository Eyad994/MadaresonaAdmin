@if(!$note->isEmpty())
<table class="table table-striped">
    <thead>
    <tr>
        <th scope="col">#ID</th>
        <th scope="col">Text Note</th>
        <th scope="col">Added By</th>
        <th scope="col">Date</th>
    </tr>
    </thead>
    <tbody>
    <?php $i=1;?>
    @foreach($note as $item)
        <tr id="noteRow_{{ $item->id }}">
            <th scope="row">{{ $i }}</th>
            <td>{{ $item->note }}</td>
            <td>{{ $item->user->name }}</td>
            <td>{{ $item->created_at != null ? $item->created_at->format('d-m-Y  g:i A') : '' }}</td>
            <td style="text-align: center;">
                <a href="#" class="btn btn-sm btn-clean btn-icon note-remove-btn action-btn"
                   id="{{ $item->id }}" data-toggle="tooltip" data-placement="bottom" title="Remove"><i
                        class="far fa-trash-alt" style="color: #f64e60"></i></a>
            </td>
        </tr>
        <?php$i++;?>
    @endforeach
    </tbody>
</table>
<hr>
@endif
<div class="row">
                <form action="{{ route('noteStoreFinance') }}" method="POST" style="width: 100%" id="noteForm">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $User_id }}">
                    <div class="col-md-12 form-group">
                        <label>Note Text</label>
                        <input type="text" class="form-control" name="note_text" placeholder="Note" >
                    </div>
                    <div class="" style="float: right;">
                        <input type="submit" class="btn btn-success" value="Submit">
                    </div>
                </form>
</div>
