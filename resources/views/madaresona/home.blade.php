@extends('layouts.main')

@section('content')

    <div class="container">
        <div class="row">

            <div class="col-lg-6 col-xxl-6">
                <!--begin::Mixed Widget 1-->
                <div class="card card-custom bg-gray-100 card-stretch gutter-b">
                    <!--begin::Header-->
                    <div class="card-header border-0 bg-danger py-5">
                        <h3 class="card-title font-weight-bolder text-white">Schools</h3>
                    </div>
                    <!--end::Header-->

                    <!--begin::Body-->
                    <div class="card-body p-0 position-relative overflow-hidden">
                        <!--begin::Chart-->
                        <div class="card-rounded-bottom bg-danger"
                             style="height: 200px; min-height: 200px;">
                        </div>
                        <!--end::Chart-->

                        <!--begin::Stats-->
                        <div class="card-spacer mt-n25">
                            <!--begin::Row-->
                            <div class="row m-0">
                                <div class="col bg-light-warning px-6 py-8 rounded-xl mr-7 mb-7">
                                    <span class="svg-icon svg-icon-3x svg-icon-warning d-block my-2"><span class="fa-count-chart">{{ $activeSchools }}</span><i class="fa fa-check fa-chart" style="color: #ffa800 "></i></span> <a href="#" class="text-warning font-weight-bold font-size-h6">
                                        Active
                                    </a>
                                </div>
                                <div class="col bg-light-primary px-6 py-8 rounded-xl mb-7">
                                    <span class="svg-icon svg-icon-3x svg-icon-primary d-block my-2"><span class="fa-count-chart">{{ $onHoldSchools }}</span><i class="fa fa-pause fa-chart" style="color: #3699ff "></i></span> <a href="#" class="text-primary font-weight-bold font-size-h6 mt-2">
                                        On Hold
                                    </a>
                                </div>
                            </div>
                            <!--end::Row-->
                            <!--begin::Row-->
                            <div class="row m-0">
                                <div class="col bg-light-danger px-6 py-8 rounded-xl mr-7">
                                    <span class="svg-icon svg-icon-3x svg-icon-danger d-block my-2"><span class="fa-count-chart">{{ $inCallingSchools }}</span><i class="fa fa-phone fa-chart" style="color: #ec0c24 "></i></span> <a href="#" class="text-danger font-weight-bold font-size-h6 mt-2">
                                        In Calling
                                    </a>
                                </div>
                                <div class="col bg-light-success px-6 py-8 rounded-xl">
                                    <span class="svg-icon svg-icon-3x svg-icon-success d-block my-2"><span class="fa-count-chart">{{ $completedSchools }}</span><i class="fa fa-check fa-chart" style="color: #1bc5bd "></i></span> <a href="#" class="text-success font-weight-bold font-size-h6 mt-2">
                                        Completed
                                    </a>
                                </div>
                            </div>
                            <!--end::Row-->
                        </div>
                        <!--end::Stats-->
                        <div class="resize-triggers">
                            <div class="expand-trigger">
                                <div style="width: 414px; height: 461px;"></div>
                            </div>
                            <div class="contract-trigger"></div>
                        </div>
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Mixed Widget 1-->
            </div>

            <div class="col-lg-6 col-xxl-6">
                <!--begin::Mixed Widget 1-->
                <div class="card card-custom bg-gray-100 card-stretch gutter-b">
                    <!--begin::Header-->
                    <div class="card-header border-0 bg-success py-5">
                        <h3 class="card-title font-weight-bolder text-white">Suppliers</h3>
                    </div>
                    <!--end::Header-->

                    <!--begin::Body-->
                    <div class="card-body p-0 position-relative overflow-hidden">
                        <!--begin::Chart-->
                        <div class="card-rounded-bottom bg-success"
                             style="height: 200px; min-height: 200px;">
                        </div>
                        <!--end::Chart-->

                        <!--begin::Stats-->
                        <div class="card-spacer mt-n25">
                            <!--begin::Row-->
                            <div class="row m-0">
                                <div class="col bg-light-warning px-6 py-8 rounded-xl mr-7 mb-7">
                                    <span class="svg-icon svg-icon-3x svg-icon-warning d-block my-2"><span class="fa-count-chart">{{ $activeSupplier }}</span><i class="fa fa-check fa-chart" style="color: #ffa800 "></i></span> <a href="#" class="text-warning font-weight-bold font-size-h6">
                                        Active
                                    </a>
                                </div>
                                <div class="col bg-light-primary px-6 py-8 rounded-xl mb-7">
                                    <span class="svg-icon svg-icon-3x svg-icon-primary d-block my-2"><span class="fa-count-chart">{{ $inActiveSupplier }}</span><i class="fa fa-pause fa-chart" style="color: #3699ff "></i></span> <a href="#" class="text-primary font-weight-bold font-size-h6 mt-2">
                                        InActive
                                    </a>
                                </div>
                            </div>
                            <!--end::Row-->
                            <!--begin::Row-->
                            <div class="row m-0">
                                <div class="col bg-light-danger px-6 py-8 rounded-xl mr-7">
                                    <span class="svg-icon svg-icon-3x svg-icon-danger d-block my-2"><span class="fa-count-chart">100</span><i class="fa fa-phone fa-chart" style="color: #ec0c24 "></i></span> <a href="#" class="text-danger font-weight-bold font-size-h6 mt-2">
                                        In Calling
                                    </a>
                                </div>
                                <div class="col bg-light-success px-6 py-8 rounded-xl">
                                    <span class="svg-icon svg-icon-3x svg-icon-success d-block my-2"><span class="fa-count-chart">100</span><i class="fa fa-check fa-chart" style="color: #1bc5bd "></i></span> <a href="#" class="text-success font-weight-bold font-size-h6 mt-2">
                                        Completed
                                    </a>
                                </div>
                            </div>
                            <!--end::Row-->
                        </div>
                        <!--end::Stats-->
                        <div class="resize-triggers">
                            <div class="expand-trigger">
                                <div style="width: 414px; height: 461px;"></div>
                            </div>
                            <div class="contract-trigger"></div>
                        </div>
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Mixed Widget 1-->
            </div>
        </div>
    </div>

@endsection