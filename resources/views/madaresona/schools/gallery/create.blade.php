<style>
    .img-gallery{
        border-radius: 10px;
        display: inline-block;
        webkit-box-shadow: 0 0.5rem 1.5rem 0.5rem rgba(0, 0, 0, .075);
        box-shadow: 0 0.5rem 1.5rem 0.5rem rgba(0, 0, 0, .075);
        border: 3px solid #fff;
    }
</style>

<div class="row">

    @foreach($gallery as $item)
    <div class="col-md-3 galleryDeleteDiv_{{ $item->id }}">
        <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow galleryDelete" id="{{ $item->id }}" style="color: #262673 !important;">
            <i class="fa fa-pen icon-sm text-muted"></i>
        </label>
        <img class="img-gallery" src="{{ asset('/images/'.$schoolName.'/gallery/'.$item->img) }}" width="100px" height="100px" alt="">
    </div>
        @endforeach
</div>
<br>
<div class="row">
    <form action="{{ route('submitGallery') }}" method="POST" enctype="multipart/form-data" style="width: 100%">
        @csrf
        <input type="hidden" name="school_id" value="{{ $id }}">
        <div class="col-md-3">
            <div class="form-group">
                <input id="galleries" name="galleries[]" type="file" class="file" data-show-upload="true"
                       data-show-caption="true" multiple>
            </div>
        </div>
        <input type="submit" class="btn btn-success" value="Submit" style="float: right">
    </form>
</div>