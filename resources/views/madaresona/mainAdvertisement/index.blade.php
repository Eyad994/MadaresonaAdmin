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

        <form action="{{ route('storeMainAdvertisement') }}" method="POST" id="Form">
            @csrf

            <div class="form-group card" style="padding: 10px 20px;">
                <div class="card-header">
                    <b>Main Advertisement</b>
                </div>

                <row class="card-body">

                    <div class="col-md-6 form-group">
                        <label>Link </label>
                        <input type="text" class="form-control" name="link" placeholder="Link" value="@if(isset($advertisement)){{$advertisement->url}}@endif">
                    </div>

                    <div class="col-md-6 form-group">
                        <label>Status</label>
                        <select class="form-control" id="status" name="status">
                            <option value="0" @if(!isset($advertisement)) selected @elseif($advertisement->active== 0) selected @endif > False</option>
                            <option value="1" @if(isset($advertisement))@if($advertisement->active== 1) selected @endif @endif> True </option>
                        </select>
                    </div>

                    <div class="col-sm-2 imgUp">
                        <label> Image </label>
                        <div class="imagePreview" style="@if($advertisement != null)
                                background:url('{{asset('/images/'.$advertisement->img.'')}}');
                                background-position: center center;
                                background-color: #fff;
                                background-size: 100% 700px;
                                background-repeat: no-repeat;
                        @endif"></div>
                        <label class="btn_edit_img btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                               style="color: #262673 !important;">
                            <i class="fa fa-pen icon-sm text-muted"></i>
                            <input type="file" name="img" id="img" class="uploadFile img"
                                   value="@if($advertisement != null){{$advertisement->img}}@endif"
                                   style="width: 0px;height: 0px;overflow: hidden;">
                        </label>
                    </div>
                <div class="row">
                    <div class="col-md-12 form-group">
                        <input type="submit" value="submit" id="submitBtn" class="btn btn-success" style="float: right">
                    </div>
                </div>

        </form>
           </div>
    </div>

@endsection
@section('script')
    <script>
        $('#Form').submit(function (e) {
            e.preventDefault();
            var form = $(this);
            var url = form.attr('action');
            $.ajax({
                type: "POST",
                url: url,
                data: new FormData(this),
                dataType: "json",
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    if (data.status === 422) {
                        var error_html = '';

                        for (let value of Object.values(data.errors)) {
                            error_html += '<div class="alert alert-danger">' + value + '</div>';
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            html: error_html,
                        })
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: data.message,
                            showConfirmButton: false,
                            timer: 1500
                        });

                        table.ajax.reload();
                        $('#schoolModal').modal('hide');
                    }
                }
            });

        });
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
