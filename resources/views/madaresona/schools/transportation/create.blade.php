<div class="row">
    @if(isset($transportation))
        <form action="{{ route('transportationUpdate') }}" method="POST" style="width: 100%" id="transportationForm">
            {{ method_field('PUT') }}
            @else
                <form action="{{ route('transportationStore') }}" method="POST" style="width: 100%"
                      id="transportationForm">
                    @endif

                    @csrf
                    <input type="hidden" name="school_id" value="{{ $id }}">
                    <div class="col-md-12 form-group">
                        <label>Region Arabic</label>
                        <input type="text" class="form-control" name="region_ar" placeholder="Region Arabic"
                               @if(isset($transportation))  value="{{ $transportation->region_ar }}" @endif required>
                    </div>
                    <div class="col-md-12 form-group">
                        <label>Region English</label>
                        <input type="text" class="form-control" name="region_en" placeholder="Region English"
                               @if(isset($transportation))  value="{{ $transportation->region_en }}" @endif required>
                    </div>
                    <div class="col-md-12 form-group">
                        <label>One Way Price</label>
                        <input type="text" class="form-control" name="one_way" placeholder="One Way Price "
                               @if(isset($transportation))  value="{{ $transportation->one_way }}" @endif>
                    </div>
                    <div class="col-md-12 form-group">
                        <label>Two Way Price</label>
                        <input type="text" class="form-control" name="two_way" placeholder="Two Way Price"
                               @if(isset($transportation))  value="{{ $transportation->two_way }}" @endif>
                    </div>
                    <div class="" style="float: right;">
                        <input type="submit" class="btn btn-success" value="Submit">
                    </div>
                </form>
</div>
