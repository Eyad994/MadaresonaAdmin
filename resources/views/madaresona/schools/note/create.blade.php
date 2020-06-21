<div class="row">
    @if(isset($note))
        <form action="{{ route('noteUpdate') }}" method="POST" style="width: 100%" id="noteForm">
            {{ method_field('PUT') }}
            @else
                <form action="{{ route('noteStore') }}" method="POST" style="width: 100%"
                      id="noteForm">
                    @endif

                    @csrf
                    <input type="hidden" name="school_id" value="{{ $id }}">
                    <div class="col-md-12 form-group">
                        <label>Note Text</label>
                        <input type="text" class="form-control" name="note_text" placeholder="Note"
                               @if(isset($note))  value="{{ $note->note}}" @endif required>
                    </div>
                    <script>
                        ClassicEditor.create(document.querySelector('#note_text'));
                    </script>
                    <div class="" style="float: right;">
                        <input type="submit" class="btn btn-success" value="Submit">
                    </div>
                </form>
</div>
