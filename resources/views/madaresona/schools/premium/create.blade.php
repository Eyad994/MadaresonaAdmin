@if(isset($premium))
    <form action="{{ route('premiumUpdate') }}" method="POST" style="width: 100%" id="premiumForm">
        {{ method_field('PUT') }}
        @else
            <form action="{{ route('premiumStore') }}" method="POST" style="width: 100%"
                  id="premiumForm">
                @endif
                @csrf
                <input type="hidden" name="school_id" value="{{ $id }}">
                <div class="row">

                    <div class="col-md-4">
                        <label>Select Class</label>
                        <select name="school_class" class="form-control">
                            <option value="" selected disabled>Select Class</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" @if(isset($premium) && $class->id == $premium->class_id) selected @endif>{{ $class->class_en }}</option>
                            @endforeach
                        </select>

                    </div>

                    <div class="col-md-4">
                        <label>Select Curriculum</label>
                        <select name="curriculum" class="form-control">
                            <option value="" selected disabled>Select Curriculum</option>
                            <option value="0" @if(isset($premium) && $premium->curriculum == 0) selected @endif>International Program</option>
                            <option value="1" @if(isset($premium) && $premium->curriculum == 1) selected @endif>Local Program</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label>Price</label>
                        <input type="text" name="price" class="form-control" @if(isset($premium)) value="{{ $premium->price }}" @endif placeholder="Price">
                    </div>



                </div>
                <br>
                <div class="" style="float: right;">
                    <input type="submit" class="btn btn-success" value="Submit">
                </div>

            </form>