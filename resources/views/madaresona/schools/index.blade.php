@extends('layouts.main')

@section('content')
<style>
    .bs-tooltip-auto[x-placement^=bottom] .arrow::before,
    .bs-tooltip-bottom .arrow::before {
        border-bottom-color: #f00; /* Red */
    }
</style>
    <div class="container">

        <div class="card">
            <div class="card-header">
                <b>Schools</b>
                <div class="card-toolbar" style="float: right">

                    <a id="addSchool" class="btn btn-primary font-weight-bolder">
	<span class="svg-icon svg-icon-md">
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"viewBox="0 0 24 24" version="1.1">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"></rect>
        <circle fill="#000000" cx="9" cy="15" r="6"></circle>
        <path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z"
              fill="#000000" opacity="0.3"></path>
    </g>
</svg></span>New School</a>
                </div>

            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-2" style="top: 78px; right: 20px;">
                        <select data-column="6" class="form-control filter-select" id="filter-select">
                            <option value="">All status</option>
                            @foreach($schoolsStatus as $school)
                                <option value="{{ $school->id }}">{{ $school->name_en }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <table class="table data-table" id="data-table"></table>
            </div>
        </div>

        @include('madaresona.schools.shcoolModal')

    </div>
@endsection

@section('script')
    @include('madaresona.schools.schoolsJs')
@endsection
