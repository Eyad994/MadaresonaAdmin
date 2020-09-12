@extends('layouts.main')

@section('content')
    <style>
        .imagePreview {
            width: 700px;
            height: 700px;

            background-position: center center;
            background: url('{{asset('/images/default/add_picture.png')}}');
            background-color: #fff;
            background-size: 100% 700px;
            background-repeat: no-repeat;
            display: inline-block;
            webkit-box-shadow: 0 0.5rem 1.5rem 0.5rem rgba(0, 0, 0, .075);
            box-shadow: 0 0.5rem 1.5rem 0.5rem rgba(0, 0, 0, .075);
            border: 3px solid #fff;
            border-radius: 10px;
        }

        .btn_edit_img {
            margin-top: -1427px;
            margin-left: 685px;
        }

        .imgUp {
            margin-bottom: 15px;
        }
    </style>
    <div class="container">

        <form action="/storeMainAdvertisement" enctype="multipart/form-data" method="POST">
            @csrf

            <div class="form-group card">
                <div class="card-header">
                    <b>Main Advertisement</b>
                </div>

                <div class="card-body">
                    <div class="col-sm-2 imgUp">
                        <label> Image </label>
                        <div class="imagePreview" style="@if(isset($news))
                                background:url('{{asset('/images/Main News/'.$news->img.'')}}');
                                background-position: center center;
                                background-color: #fff;
                                background-size: 100% 700px;
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
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-success" value="Upload">
            </div>
        </form>

    </div>

@endsection
@section('script')
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
@endsection
