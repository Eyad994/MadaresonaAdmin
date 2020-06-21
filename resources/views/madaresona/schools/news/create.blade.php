<style>
    .imagePreview {
        width: 170px;
        height: 150px;
        background-position: center center;
        background: url('{{asset('/images/default/news.png')}}');
        background-color: #fff;
        background-size: cover;
        background-repeat: no-repeat;
        border-radius: 10px;
        display: inline-block;
        webkit-box-shadow: 0 0.5rem 1.5rem 0.5rem rgba(0, 0, 0, .075);
        box-shadow: 0 0.5rem 1.5rem 0.5rem rgba(0, 0, 0, .075);
        border: 3px solid #fff;
    }

    .btn_edit_img {
        margin-top: -333px;
        margin-left: 155px;

    }

    .imgUp {
        margin-bottom: 15px;
    }
</style>

    @if(isset($news))
        <form action="{{ route('newsUpdate') }}" method="POST" style="width: 100%" id="newsForm">
            {{ method_field('PUT') }}
            @else
                <form action="{{ route('newsStore') }}" method="POST" style="width: 100%"
                      id="newsForm">
                    @endif

                    @csrf
                    <input type="hidden" name="school_id" value="{{ $id }}">
                    <div class="row">

                    <div class="col-md-6 form-group">
                        <label>Arabic Title</label>
                        <input type="text" class="form-control" name="title_ar" placeholder="Arabic Title"
                               @if(isset($news))  value="{{ $news->title_ar }}" @endif required>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>English Title</label>
                        <input type="text" class="form-control" name="title_en" placeholder="English Title"
                               @if(isset($news))  value="{{ $news->title_en }}" @endif required>
                    </div>

                        <div class="col-md-6 form-group">
                            <label>Arabic Text</label>
                            <textarea name="text_ar" id="text_ar"
                                      placeholder="Arabic Text">@if(isset($news)) {!! $news->text_ar!!} @endif</textarea>
                        </div>

                        <div class="col-md-6 form-group">
                            <label>English Text</label>
                            <textarea name="text_en" id="text_en"
                                      placeholder="English Text">@if(isset($news)) {!! $news->text_en!!} @endif</textarea>
                        </div>

                        <script>
                            ClassicEditor.create(document.querySelector('#text_en'));
                            ClassicEditor.create(document.querySelector('#text_ar'));
                        </script>

                        <div class="col-md-6 form-group">
                            <label>Status</label>
                            <select class="form-control" id="active" name="active">
                                @if(isset($news))
                                    @foreach($trueFalseArray as $index => $value)
                                        <option value="{{ $index }}"
                                                @if($news->active == $index) selected @endif> {{ $value }}</option>
                                    @endforeach
                                @else
                                    <option selected value="0"> False</option>
                                    <option value="1"> True</option>
                                @endif
                            </select>
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Active Days</label>
                            <input type="text" placeholder="Active Days" @if(isset($news)) value="{{ $news->active_days }}" @endif name="active_days" class="form-control">
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Order</label>
                            <input type="text" placeholder="Order" @if(isset($news)) value="{{ $news->order }}" @endif name="order" class="form-control">
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Youtube Link</label>
                            <input type="text" placeholder="Youtube Link" @if(isset($news)) value="{{ $news->youtube }}" @endif name="youtube" class="form-control">
                        </div>

                        <div class="col-sm-2 imgUp">
                            <label>School Logo </label>
                            <div class="imagePreview" style="@if(isset($news))
                                    background:url('{{asset('/images/'.$schoolName.'/news/'.$news->img.'')}}');
                                    background-position: center center;
                                    background-color: #fff;
                                    background-size: cover;
                                    background-repeat: no-repeat;
                            @endif"></div>
                            <label class="btn_edit_img btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                   style="color: #262673 !important;">
                                <i class="fa fa-pen icon-sm text-muted"></i>
                                <input type="file" name="img" id="img" class="uploadFile img"
                                       value="{{ isset($news) ? $news->img: '' }}"
                                       style="width: 0px;height: 0px;overflow: hidden;">
                            </label>
                        </div>

                    </div>
                    <div class="" style="float: right;">
                        <input type="submit" class="btn btn-success" value="Submit">
                    </div>
                </form>


                <script>

                    $(function () {
                        $(document).on("change", ".uploadFile", function () {
                            var uploadFile = $(this);
                            var files = !!this.files ? this.files : [];
                            if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support

                            if (/^image/.test(files[0].type)) { // only image file
                                var reader = new FileReader(); // instance of the FileReader
                                reader.readAsDataURL(files[0]); // read the local file

                                reader.onloadend = function () { // set image data as background of div
                                    //alert(uploadFile.closest(".upimage").find('.imagePreview').length);
                                    uploadFile.closest(".imgUp").find('.imagePreview').css("background-image", "url(" + this.result + ")");
                                }
                            }

                        });
                    });
                </script>

