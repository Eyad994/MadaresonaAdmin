@if(isset($faq))
    <form action="{{ route('faq.update', $faq) }}" method="POST" id="faqForm">
        {{ method_field('put') }}
        @else
            <form action="{{ route('faq.store') }}" method="POST" id="faqForm">
                @endif
                @csrf
<div class="row">
    <div class="col-md-6 form-group">
        <label>Arabic Question</label>
        <input type="text" class="form-control" name="question_ar" @if(isset($faq)) value="{{ $faq->question_ar }}" @endif placeholder="Arabic Question">
    </div>

    <div class="col-md-6 form-group">
        <label>English Question</label>
        <input type="text" class="form-control" name="question_en" @if(isset($faq)) value="{{ $faq->question_en }}" @endif placeholder="English Question">
    </div>

    <div class="col-md-6 form-group">
        <label>Arabic Answer</label>
        <textarea name="answer_ar" id="answer_ar"
                  placeholder="Arabic Answer">@if(isset($faq)) {!! $faq->answer_ar !!} @endif</textarea>
    </div>

    <div class="col-md-6 form-group">
        <label>English Answer</label>
        <textarea name="answer_en" id="answer_en"
                  placeholder="English Answer">@if(isset($faq)) {!! $faq->answer_en!!} @endif</textarea>
    </div>

    <div class="col-md-6 form-group">
        <label>Status</label>
        <select class="form-control" id="type_id" name="type_id">
            @if(!isset($faq))
                <option value="" selected disabled>Select Type</option>
            @endif
            @foreach($types as $type)
                <option value="{{ $type->id }}"
                        @if(isset($faq) && $faq->type_id == $type->id) selected @endif>{{ $type->name_en }}</option>
            @endforeach
        </select>
    </div>

    <script>
        ClassicEditor.create(document.querySelector('#answer_ar'));
        ClassicEditor.create(document.querySelector('#answer_en'));
    </script>
</div>

                <div class="row">
                    <div class="col-md-12 form-group">
                        <input type="submit" value="submit" id="submitBtn" class="btn btn-success" style="float: right">
                    </div>
                </div>
    </form>