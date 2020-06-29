<style>
    .imagePreview {
        width: 292px;
        height: 200px;
        background-position: center center;
        background: url('{{asset('/images/default/add_picture.png')}}');
        background-color: #fff;
        background-size: 100% 200px;
        background-repeat: no-repeat;
        border-radius: 10px;
        display: inline-block;
        webkit-box-shadow: 0 0.5rem 1.5rem 0.5rem rgba(0, 0, 0, .075);
        box-shadow: 0 0.5rem 1.5rem 0.5rem rgba(0, 0, 0, .075);
        border: 3px solid #fff;
    }

    .btn_edit_img {
        margin-top: -429px;
        margin-left: 275px

    }

    .imgUp {
        margin-bottom: 15px;
    }
</style>

@if(isset($advertisement))
    <form action="{{ route('UpdateAdvertisement') }}" method="POST" style="width: 100%" id="advertisementForm"
          enctype="multipart/form-data">
        {{ method_field('PUT') }}
        @else
            <form action="{{ route('storeAdvertisement') }}" method="POST" style="width: 100%"
                  id="advertisementForm" enctype="multipart/form-data">
                @endif

                @csrf
                @if(isset($advertisement))
                    <input type="hidden" name="advertisement_id" value="{{ $advertisement->id }}">
                @endif
                <div class="row">

                    <div class="col-md-12 form-group">
                        <label>URL</label>
                        <input type="text" class="form-control" name="url" placeholder="URL"
                               @if(isset($advertisement))  value="{{ $advertisement->url }}" @endif >
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Order</label>
                        <input type="number" placeholder="Order"
                               @if(isset($advertisement)) value="{{ $advertisement->order }}" @endif name="order"
                               class="form-control">
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Type</label>
                        <select class="form-control" id="type" name="type">
                            @if(!isset($advertisement))
                                <option selected disabled value=""> Select Advertisement Type</option>
                            @endif
                            @foreach($typeArray as $index => $value)
                                <option value="{{ $index }}"
                                        @if(isset($advertisement)) @if($advertisement->type == $index) selected @endif @endif > {{ $value }}</option>
                            @endforeach

                        </select>
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Status</label>
                        <select class="form-control" id="active" name="active">
                            @if(isset($advertisement))
                                @foreach($trueFalseArray as $index => $value)
                                    <option value="{{ $index }}"
                                            @if($advertisement->active == $index) selected @endif> {{ $value }}</option>
                                @endforeach
                            @else
                                <option selected value="0"> False</option>
                                <option value="1"> True</option>
                            @endif
                        </select>
                    </div>
                </div>
                <div class="col-sm-2 imgUp">
                    <label>Image</label>
                    <div class="imagePreview" style="@if(isset($advertisement))
                            background:url('{{asset('/images/Advertisement/'.$advertisement->img.'')}}');
                            background-position: center center;
                            background-color: #fff;
                            background-size: 100% 200px;
                            background-repeat: no-repeat;
                    @endif"></div>
                    <label class="btn_edit_img btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                           style="color: #262673 !important;">
                        <i class="fa fa-pen icon-sm text-muted"></i>
                        <input type="file" name="img" id="img" class="uploadFile img"
                               value="{{ isset($advertisement) ? $advertisement->img: '' }}"
                               style="width: 0px;height: 0px;overflow: hidden;">
                    </label>
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

