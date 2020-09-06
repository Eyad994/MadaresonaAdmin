@extends('layouts.main')
<link rel="stylesheet" href="{{ asset('assets/smartwizard/css/smart_wizard_all.css') }}">
<style>


    .imagePreview {
        width: 170px;
        height: 150px;
        background-position: center center;
        background: url('{{asset('/images/default/supplier.png')}}');
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
        margin-top: -161px;
        margin-right: 155px;

    }

    .imgUp {
        margin-bottom: 15px;
    }


    .select2-container--default .select2-selection--multiple .select2-selection__rendered .select2-selection__choice {
        float: right !important;
    }
</style>

@section('content')
    <div class="container" style="text-align: right; direction:rtl;">
        @if(Session::has('success'))
            <div style="text-align: center; font-size: 15px" class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div id="smartwizard">

            <ul class="nav">

                <li class="nav-item">
                    <a class="nav-link" href="#step-1">
                        <strong>المعلومات الاساسية </strong>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#step-2">
                        <strong> كلمة عن المورد</strong>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#step-3">
                        <strong>العنوان</strong>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#step-4">
                        <strong>روابط وسائل التواصل الاجتماعي </strong>
                    </a>
                </li>
            </ul>
            <hr>
            @if(isset($supplier))
                <form action="{{ route('supplier.update', $supplier) }}" method="POST" id="updateSchoolForm"
                      enctype="multipart/form-data">
                    {{ method_field('put') }}
                    @else
                        <form action="{{ route('supplier.store') }}" method="POST" id="addSupplierForm"
                              enctype="multipart/form-data">
                            @endif
                            @csrf
                            <div class="tab-content">
                                @if(isset($supplier))
                                    <input type="hidden" id="id" name="id" value="{{ $supplier->id }}">
                                @endif
                                <div id="step-1" class="tab-pane" role="tabpanel" aria-labelledby="step-1">

                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label> القسم</label>
                                            <select class="multiple-select" name="type[]" multiple="multiple">
                                                @if(!isset($supplier))
                                                    <option value="" disabled>Select Supplier Type</option>
                                                @endif
                                                @foreach($supplierTypes as $type)
                                                    <option value="{{ $type->id }}" {{ isset($supplier) ? (in_array($type->id, $supplierTypesExploded)) ? 'selected' : '' : ''}}>{{ $type->name_ar }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label>الاسم بالعربي</label>
                                            <input type="text" class="form-control" id="name_ar" name="name_ar"
                                                   style="direction: rtl"
                                                   placeholder="الاسم بالعربي"
                                                   value="{{ isset($supplier) ? $supplier->name_ar : '' }}">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label>الاسم بالانجليزي</label>
                                            <input type="text" class="form-control" id="name_en" name="name_en"
                                                   placeholder="الاسم بالانجليزي"
                                                   value="{{ isset($supplier) ? $supplier->name_en : '' }}"
                                                   style="text-align: left;direction: ltr;">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label>البريد الالكتروني </label>
                                            <input type="email" class="form-control" id="email_supplier"
                                                   name="email_supplier"
                                                   placeholder="البريد الالكتروني"
                                                   value="{{ isset($supplier) ? $supplier->email : '' }}">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label>الهاتف </label>
                                            <input type="text" class="form-control" id="phone" name="phone"
                                                   placeholder="الهاتف"
                                                   value="{{ isset($supplier) ? $supplier->phone : '' }}">
                                        </div>

                                        <div class="col-md-6 form-group">
                                            <label>هاتف اخر</label>
                                            <input type="text" class="form-control" id="mobile" name="mobile"
                                                   placeholder="هاتف اخر"
                                                   value="{{ isset($supplier) ? $supplier->mobile : '' }}">
                                        </div>

                                        <div class="col-md-6 form-group">
                                            <label> فاكس</label>
                                            <input type="text" class="form-control" id="fax" name="fax"
                                                   placeholder="فاكس"
                                                   value="{{ isset($supplier) ? $supplier->fax : '' }}">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label> موقع الكتروني</label>
                                            <input type="text" class="form-control" id="website" name="website"
                                                   placeholder="موقع الكتروني"
                                                   value="{{ isset($supplier) ? $supplier->website : '' }}"
                                            >
                                        </div>

                                        <div class="col-md-6 form-group">
                                            <label>الموقع</label>
                                            <input type="text" class="form-control" id="location" name="location"
                                                   placeholder="الموقع"
                                                   value="{{ isset($supplier) ? $supplier->location : '' }}"
                                            >
                                        </div>

                                        <div class="col-sm-2 imgUp">
                                            <label>شعار </label>
                                            <div class="imagePreview" style="@if(isset($supplier))
                                                    background:url('{{asset('/images/'.$supplier->name_en.'/'.$supplier->supplier_logo.'')}}');
                                                    background-position: center center;
                                                    background-color: #fff;
                                                    background-size: cover;
                                                    background-repeat: no-repeat;
                                            @endif"></div>
                                            <label class="btn_edit_img btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                   style="color: #262673 !important;">
                                                <i class="fa fa-pen icon-sm text-muted"></i>
                                                <input type="file" name="logo" id="logo" class="uploadFile img"
                                                       value="{{ isset($supplier) ? $supplier->supplier_logo: '' }}"
                                                       style="width: 0px;height: 0px;overflow: hidden;">
                                            </label>
                                        </div>
                                    </div>

                                </div>

                                <div id="step-2" class="tab-pane" role="tabpanel" aria-labelledby="step-2">
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label>كلمة بالعربي </label>
                                            <textarea name="supplier_details_ar" id="supplier_details_ar"
                                                      placeholder="كلمة بالعربي">@if(isset($supplier)) {!! $supplier->supplier_details_ar!!} @endif</textarea>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label>كلمة بالانجليزي</label>
                                            <textarea name="supplier_details_en" id="supplier_details_en"
                                                      placeholder="كلمة بالانجليزي">@if(isset($supplier)) {!! $supplier->supplier_details_en!!} @endif</textarea>
                                        </div>
                                    </div>
                                    <script>

                                    </script>
                                </div>

                                <div id="step-3" class="tab-pane" role="tabpanel" aria-labelledby="step-3">
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label> البلد</label>
                                            <select class="form-control" id="country" name="country" disabled>
                                                <option disabled selected value="1">Jordan</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label> المدنية</label>
                                            <select class="form-control" id="city_id" name="city_id">
                                                @if(!isset($supplier))
                                                    <option value="" selected disabled>اختار المدنية</option>
                                                @endif
                                                @foreach($cities as $city)
                                                    <option @if(isset($supplier) && $city->id == $supplier->city->id) value="{{ $city->id }}"
                                                            selected
                                                            @else value="{{ $city->id }}" @endif>{{ $city->city_name_ar }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-6 form-group">
                                            <label> المنطقة</label>
                                            <select class="form-control" id="region_id" name="region_id"
                                                    @if(isset($supplier)) @else disabled="" @endif>
                                                @if(!isset($supplier))
                                                    <option value="" selected>اختار المنطقة</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                </div>

                                <div id="step-4" class="tab-pane" role="tabpanel" aria-labelledby="step-4">
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label>رابط الفيس بوك </label>
                                            <input type="text" class="form-control" id="facebook_link"
                                                   name="facebook_link"
                                                   placeholder="رابط الفيس بوك"
                                                   value="{{isset($supplier) ? $supplier->facebook_link : ''}}">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label>رابط التويتر </label>
                                            <input type="text" class="form-control" id="twitter_link"
                                                   name="twitter_link"
                                                   placeholder="رابط التويتر"
                                                   value="{{isset($supplier) ? $supplier->twitter_link : ''}}">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label> رابط انستقرام </label>
                                            <input type="text" class="form-control" id="instagram_link"
                                                   name="instagram_link"
                                                   placeholder="رابط انستقرام "
                                                   value="{{isset($supplier) ? $supplier->instagram_link : ''}}">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label> رابط لينك ايند</label>
                                            <input type="text" class="form-control" id="linkedin_link"
                                                   name="linkedin_link"
                                                   placeholder="رابط لينك ايند"
                                                   value="{{isset($supplier) ? $supplier->linkedin_link : ''}}">
                                        </div>

                                        <div class="col-md-6 form-group">
                                            <label> رابط جوجل بلس</label>
                                            <input type="text" class="form-control" id="googleplus_link"
                                                   name="googleplus_link"
                                                   placeholder="رابط جوجل بلس"
                                                   value="{{isset($supplier) ? $supplier->googleplus_link : ''}}">
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </form>
        </div>
        @foreach($errors->all() as $error)
            <li style="color: red;">{{$error}}</li>
        @endforeach
    </div>

@endsection


@section('script')
    <script src="{{ asset('assets/plugins/global/plugins.bundle7a4a.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/smartwizard/js/jquery.smartWizard.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/pages/crud/forms/widgets/select27a4a.js') }}"></script>
    <script src="{{ asset('assets/js/pages/crud/forms/widgets/bootstrap-datepicker7a4a.js') }}"></script>
    <script type="text/javascript">
        f();
        function f() {
            var value = {{ $supplier->city_id }}
            $.ajax({
                url: '/getRegions/' + value,
                method: 'get',
                success: function (result) {
                    var supplierId = {{ $supplier->region_id }}
                    $('#region_id option:not(:first)').remove();
                    $.each(result, function (index, value) {
                        if (supplierId == value.id)
                            $('#region_id').append("<option value='" + value.id + "' selected>" + value.area_name_ar + "");
                        else
                            $('#region_id').append("<option value='" + value.id + "'>" + value.area_name_ar + "");
                    });

                    $('#region_id').removeAttr('disabled');
                }
            });
        }


        ClassicEditor.create(document.querySelector('#supplier_details_ar'));
        ClassicEditor.create(document.querySelector('#supplier_details_en'));
        $(document).ready(function () {

            $(document).on("click", "i.del", function () {
                $(this).parent().remove();
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

            // $('#smartwizard').smartWizard();
            $('#datepicker').datepicker({
                format: 'mm/dd/yyyy',
                multidate: true,
                daysOfWeekDisabled: [0, 6],
                clearBtn: true,
                todayHighlight: true,
                daysOfWeekHighlighted: [1, 2, 3, 4, 5]
            });

            $('#datepicker').on('changeDate', function (evt) {
                console.log(evt.date);
            });

            $('#smartwizard').smartWizard({
                selected: 0, // Initial selected step, 0 = first step
                theme: 'dots', // theme for the wizard, related css need to include for other than default theme
                justified: true, // Nav menu justification. true/false
                autoAdjustHeight: true, // Automatically adjust content height
                cycleSteps: false, // Allows to cycle the navigation of steps
                backButtonSupport: true, // Enable the back button support
                @if(isset($supplier))
                enableURLhash: false, // Enable selection of the step based on url hash
                @else
                enableURLhash: true,
                @endif
                transition: {
                    animation: 'slide-swing', // Effect on navigation, none/fade/slide-horizontal/slide-vertical/slide-swing
                    speed: '400', // Transion animation speed
                    easing: '' // Transition animation easing. Not supported without a jQuery easing plugin
                }, toolbarSettings: {
                    toolbarPosition: 'bottom', // none, top, bottom, both
                    toolbarButtonPosition: 'right', // left, right, center

                    showNextButton: true, // show/hide a Next button
                    showPreviousButton: true, // show/hide a Previous button
                    toolbarExtraButtons: [
                        $('<button></button>').text('Finish')
                            .addClass('btn btn-success sw-btn-group-extra')
                            .attr('style', 'color: #fff;background-color: #5cb85c;border: 1px solid #5cb85c;')
                            .attr('id', 'submitBtn')
                            .attr('type', 'submit')
                    ] // Extra buttons to show on toolbar, array of jQuery input/buttons elements
                },
                anchorSettings: {
                    anchorClickable: true, // Enable/Disable anchor navigation
                    @if(isset($supplier))
                    enableAllAnchors: true, // Activates all anchors clickable all times
                    @else
                    enableAllAnchors: false, // Activates all anchors clickable all times
                    @endif
                    markDoneStep: true, // Add done css
                    markAllPreviousStepsAsDone: true, // When a step selected by url hash, all previous steps are marked done
                    removeDoneStepOnNavigateBack: true, // While navigate back done step after active step will be cleared
                    enableAnchorOnDoneStep: true // Enable/Disable the done steps navigation
                },
            });

            $("#smartwizard").on("showStep", function (e, anchorObject, stepNumber, stepDirection) {
                if ($('button.sw-btn-next').hasClass('disabled')) {
                    $('button.sw-btn-next').hide();
                    $('.sw-btn-group-extra').show(); // show the button extra only in the last page
                } else {
                    $('.sw-btn-group-extra').hide();
                    $('button.sw-btn-next').show();
                }

            });

            $('.multiple-select').select2();

        });


        $('#city_id').on('change', function () {
            var value = $(this).val();
            $.ajax({
                url: '/getRegions/' + value,
                method: 'get',
                success: function (result) {
                    $('#region_id option:not(:first)').remove();
                    $.each(result, function (index, value) {
                        $('#region_id').append("<option value='" + value.id + "'>" + value.area_name_ar + "");
                    });

                    $('#region_id').removeAttr('disabled');
                }
            });
        });



    </script>
@endsection
