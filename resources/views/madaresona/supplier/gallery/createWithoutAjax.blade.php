@extends('layouts.main')
<style>
    .img-gallery{
        border-radius: 10px;
        display: inline-block;
        webkit-box-shadow: 0 0.5rem 1.5rem 0.5rem rgba(0, 0, 0, .075);
        box-shadow: 0 0.5rem 1.5rem 0.5rem rgba(0, 0, 0, .075);
        border: 3px solid #fff;
    }
    .btn_close
    {
        position: absolute;
        right: 50px;
        top: -8px;
    }
</style>
@section('content')

    <div class="container">
        @if(Session::has('success'))
            <div style="text-align: center; font-size: 15px" class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="row">

            @foreach($gallery as $item)
                <div class="col-md-3 galleryDeleteDiv_{{ $item->id }} form-group">
                    <label class="btn_close btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow galleryDelete" id="{{ $item->id }}" style="color: #262673 !important;">
                        <i class="fa fa-times text-muted" style="color: red !important;"></i>
                    </label>
                    <img class="img-gallery" src="{{ asset('/images/'.$supplierName.'/gallery/'.$item->img) }}" width="200px" height="150px" alt="">
                </div>
            @endforeach
        </div>
        <br>
        <div class="row">
            <form id="galleryForm" action="{{ route('submitGallerySupplier') }}" method="POST" enctype="multipart/form-data" style="width: 100%" onsubmit="false">
                @csrf

                <input type="hidden" name="supplier_id" value="{{ $id }}">
                <div class="col-md-3">
                    <div class="form-group">
                        <input id="galleries" name="galleries[]" type="file" class="file" multiple>
                    </div>
                </div>
                <input type="submit" class="btn btn-success" value="Submit" style="float: right">
            </form>
        </div>
            @foreach($errors->all() as $error)
                <li style="color: red;">{{$error}}</li>
            @endforeach
    </div>

    @endsection
@section('script')
    <script>
        $(document).on('click', '.galleryDelete', function () {
            var id = $(this).attr('id');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then(function (result) {
                if (result.value) {
                    $.ajax({
                        url: 'removeGallerySupplier/' + id,
                        method: 'get',
                        success: function (data) {
                            $('.galleryDeleteDiv_' + id).fadeOut('slow', function () {
                                $('.galleryDeleteDiv_' + id).remove();
                            });
                            Swal.fire({
                                icon: 'success',
                                title: 'Your image has been removed',
                                showConfirmButton: false,
                                timer: 1500
                            })
                        }
                    });
                }
            });

        });
    </script>
    @endsection
