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

<div class="row">

    @foreach($gallery as $item)
    <div class="col-md-3 galleryDeleteDiv_{{ $item->id }} form-group">
        <label class="btn_close btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow galleryDelete" id="{{ $item->id }}" style="color: #262673 !important;">
            <i class="fa fa-times text-muted" style="color: red !important;"></i>
        </label>
        <img class="img-gallery" src="{{ asset('/images/'.$schoolName.'/gallery/'.$item->img) }}" width="200px" height="150px" alt="">
    </div>
        @endforeach
</div>
<br>
<div class="row">
    <form id="galleryForm" action="{{ route('submitGallery') }}" method="POST" enctype="multipart/form-data" style="width: 100%" onsubmit="false">
        @csrf

        <input type="hidden" name="school_id" value="{{ $id }}">
        <div class="col-md-3">
            <div class="form-group">
                <input id="galleries" name="galleries[]" type="file" class="file" multiple>
            </div>
        </div>
        <input type="submit" class="btn btn-success" value="Submit" style="float: right">
    </form>
</div>
