@extends('layouts.main')

@section('content')
<style>

</style>
    <div class="container">

        <div class="card">
            <div class="card-header">
                <b>Finance</b>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-2" style="top: 78px; right: 20px;">
                        {{--
                        <select data-column="6" class="form-control filter-select" id="filter-select">
                            <option value="">All status</option>
                            @foreach($schoolsStatus as $school)
                                <option value="{{ $school->id }}">{{ $school->name_en }}</option>
                            @endforeach
                        </select>
                        --}}
                    </div>
                </div>
                <table class="table data-table" id="data-table"></table>
            </div>
        </div>



</div>
@endsection

@section('script')
 @include('madaresona.finance.financeJs')
@endsection
