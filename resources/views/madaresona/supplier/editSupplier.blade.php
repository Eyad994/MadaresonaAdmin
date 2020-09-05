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
            margin-top: -333px;
            margin-left: 155px;

        }

        .imgUp {
            margin-bottom: 15px;
        }

        .controls {
            margin-top: 16px;
            border: 1px solid transparent;
            border-radius: 2px 0 0 2px;
            box-sizing: border-box;
            -moz-box-sizing: border-box;
            height: 32px;
            outline: none;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        }

        #pac-input {
            background-color: #fff;
            font-family: Roboto;
            font-size: 15px;
            font-weight: 300;
            margin-left: 12px;
            padding: 0 11px 0 13px;
            text-overflow: ellipsis;
            width: 300px;
            top: -6px !important;
            z-index: 100000 !important;
        }

        .modal {
            z-index: 550 !important;
        }

        .modal-backdrop {
            z-index: 10;
        }

        ​
        #pac-input:focus {
            border-color: #4d90fe;
        }

        #map-canvas {
            height: 350px;
            margin: 20px;
            width: 780px;
            padding: 0px;
        }

        .ck-editor__editable {
            max-height: 175px !important;
        }
    </style>

@section('content')
    <div class="container">
        @if(Session::has('success'))
            <div style="text-align: center; font-size: 15px" class="alert alert-success">
            {{ session('success') }}
            </div>
            @endif

        <div id="smartwizard">

            <ul class="nav">

                <li class="nav-item">
                    <a class="nav-link" href="#step-1">
                        <strong>Supplier Basic Information</strong>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#step-2">
                        <strong>Supplier Details</strong>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#step-3">
                        <strong>Supplier Address</strong>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#step-4">
                        <strong>Supplier Social Media Links</strong>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#step-7">
                        <strong>Supplier Account Information</strong>
                    </a>
                </li>
                @if(!isset($supplier))
                    <li class="nav-item">
                        <a class="nav-link" href="#step-8">
                            <strong>Supplier Financial Issues</strong>
                        </a>
                    </li>
                @endif
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
                                            <label>Supplier Type</label>
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
                                            <label>Supplier Order</label>
                                            <input type="number" class="form-control" placeholder="Supplier Order"
                                                   name="supplier_order"
                                                   id="supplier_order"
                                                   value="{{ isset($supplier) ? $supplier->supplier_order : '' }}">
                                            <small>Last Supplier Order:{{ $lastSupplierOrder }}</small>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label>Arabic Name</label>
                                            <input type="text" class="form-control" id="name_ar" name="name_ar"
                                                   style="direction: rtl"
                                                   placeholder="Arabic Name"
                                                   value="{{ isset($supplier) ? $supplier->name_ar : '' }}">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label>English Name</label>
                                            <input type="text" class="form-control" id="name_en" name="name_en"
                                                   placeholder="English Name"
                                                   value="{{ isset($supplier) ? $supplier->name_en : '' }}">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label>Email Address </label>
                                            <input type="email" class="form-control" id="email_supplier"
                                                   name="email_supplier"
                                                   placeholder="Email Supplier Address"
                                                   value="{{ isset($supplier) ? $supplier->email : '' }}">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label>Phone </label>
                                            <input type="text" class="form-control" id="phone" name="phone"
                                                   placeholder="Phone"
                                                   value="{{ isset($supplier) ? $supplier->phone : '' }}">
                                        </div>

                                        <div class="col-md-6 form-group">
                                            <label>Mobile</label>
                                            <input type="text" class="form-control" id="mobile" name="mobile"
                                                   placeholder="Mobile"
                                                   value="{{ isset($supplier) ? $supplier->mobile : '' }}">
                                        </div>

                                        <div class="col-md-6 form-group">
                                            <label> Fax</label>
                                            <input type="text" class="form-control" id="fax" name="fax" placeholder="Fax"
                                                   value="{{ isset($supplier) ? $supplier->fax : '' }}">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label> Website</label>
                                            <input type="text" class="form-control" id="website" name="website"
                                                   placeholder="Website"
                                                   value="{{ isset($supplier) ? $supplier->website : '' }}"
                                            >
                                        </div>

                                        <div class="col-md-6 form-group">
                                            <label>Location</label>
                                            <input type="text" class="form-control" id="location" name="location"
                                                   placeholder="Location"
                                                   value="{{ isset($supplier) ? $supplier->location : '' }}"
                                            >
                                        </div>

                                        <div class="col-sm-2 imgUp">
                                            <label>Supplier Logo </label>
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
                                            <label>Supplier details Arabic </label>
                                            <textarea name="supplier_details_ar" id="supplier_details_ar"
                                                      placeholder="Supplier details Arabic">@if(isset($supplier)) {!! $supplier->supplier_details_ar!!} @endif</textarea>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label>Supplier details English</label>
                                            <textarea name="supplier_details_en" id="supplier_details_en"
                                                      placeholder="Supplier details English">@if(isset($supplier)) {!! $supplier->supplier_details_en!!} @endif</textarea>
                                        </div>
                                    </div>
                                    <script>
                                        ClassicEditor.create(document.querySelector('#supplier_details_ar'));
                                        ClassicEditor.create(document.querySelector('#supplier_details_en'));
                                    </script>

                                </div>
                                <div id="step-3" class="tab-pane" role="tabpanel" aria-labelledby="step-3">
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label> Country</label>
                                            <select class="form-control" id="country" name="country" disabled>
                                                <option disabled selected value="1">Jordan</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label> City</label>
                                            <select class="form-control" id="city_id" name="city_id">
                                                @if(!isset($supplier))
                                                    <option value="" selected disabled>Select city</option>
                                                @endif

                                                @foreach($cities as $city)
                                                    <option @if(isset($supplier) && $city->id == $supplier->city->id) value="{{ $city->id }}"
                                                            selected
                                                            @else value="{{ $city->id }}" @endif>{{ $city->city_name_ar }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-6 form-group">
                                            <label> Region</label>
                                            <select class="form-control" id="region_id" name="region_id"
                                                    @if(isset($supplier)) @else disabled="" @endif>
                                                <option value="" selected>Select Region</option>
                                                @if(isset($supplier))
                                                    <script>
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
                                                    </script>
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                </div>

                                <div id="step-4" class="tab-pane" role="tabpanel" aria-labelledby="step-4">
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label>Facebook Link </label>
                                            <input type="text" class="form-control" id="facebook_link" name="facebook_link"
                                                   placeholder="Facebook Link"
                                                   value="{{isset($supplier) ? $supplier->facebook_link : ''}}">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label>Twitter Link </label>
                                            <input type="text" class="form-control" id="twitter_link" name="twitter_link"
                                                   placeholder="Instagram Link"
                                                   value="{{isset($supplier) ? $supplier->twitter_link : ''}}">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label> Instagram Link</label>
                                            <input type="text" class="form-control" id="instagram_link"
                                                   name="instagram_link"
                                                   placeholder="Instagram Link"
                                                   value="{{isset($supplier) ? $supplier->instagram_link : ''}}">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label> Linkedin Link</label>
                                            <input type="text" class="form-control" id="linkedin_link" name="linkedin_link"
                                                   placeholder="Linkedin Link"
                                                   value="{{isset($supplier) ? $supplier->linkedin_link : ''}}">
                                        </div>

                                        <div class="col-md-6 form-group">
                                            <label> Google Plus Link</label>
                                            <input type="text" class="form-control" id="googleplus_link"
                                                   name="googleplus_link"
                                                   placeholder="Google Plus Link"
                                                   value="{{isset($supplier) ? $supplier->googleplus_link : ''}}">
                                        </div>

                                        <div class="col-md-12 form-group">
                                            <label> Google Map</label>
                                            <input id="pac-input" class="controls" type="text" placeholder="Search Box">
                                            <div id="map-canvas"></div>
                                            <input type="hidden" name="lat" id="lat"
                                                   value="{{ isset($supplier) ? $supplier->lat : 0.0 }}"
                                                   readonly="yes">
                                            <input type="hidden" name="lng" id="lng"
                                                   value="{{ isset($supplier) ? $supplier->lng : 0.0 }}"
                                                   readonly="yes">
                                        </div>
                                    </div>
                                </div>
                                <div id="step-7" class="tab-pane" role="tabpanel" aria-labelledby="step-7">
                                    <div class="row">

                                        @if(!isset($supplier))
                                            <div class="col-md-6 form-group">
                                                <label> Email</label>
                                                <input type="email" class="form-control" id="email" name="email"
                                                       placeholder="Email">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label> User Name</label>
                                                <input type="text" class="form-control" id="user_name" name="user_name"
                                                       placeholder="User Name">
                                            </div>
                                        @endif
                                        <div class="col-md-6 form-group">
                                            <label>Active</label>
                                            <select class="form-control" id="active" name="active">
                                                @if(isset($supplier))
                                                    @foreach($trueFalseArray as $index => $value)
                                                        <option value="{{ $index }}"
                                                                @if($supplier->active == $index) selected @endif> {{ $value }}</option>
                                                    @endforeach
                                                @else
                                                    <option selected value="0"> False</option>
                                                    <option value="1"> True</option>
                                                @endif
                                            </select>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label>special</label>
                                            <select class="form-control" id="special" name="special">
                                                @if(isset($supplier))
                                                    @foreach($trueFalseArray as $index => $value)
                                                        <option value="{{ $index }}"
                                                                @if($supplier->special == $index) selected @endif> {{ $value }}</option>
                                                    @endforeach
                                                @else
                                                    <option selected value="0"> False</option>
                                                    <option value="1"> True</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                @if(!isset($supplier))
                                    <div id="step-8" class="tab-pane" role="tabpanel" aria-labelledby="step-8">
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label>Subscribe Price</label>
                                                <input type="text" name="subscribe_price" class="form-control"
                                                       placeholder="Subscribe Price">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label>Subscribe Type</label>
                                                <input type="text" name="subscribe_type" class="form-control"
                                                       placeholder="Subscribe Type">
                                            </div>

                                            <div class="col-md-12 form-group">

                                                <label>Date</label>
                                                <div class="input-daterange input-group" id="kt_datepicker_5">
                                                    <input type="text" class="form-control" name="start"
                                                           placeholder="From Date">
                                                    <div class="input-group-append">
                                                    <span class="input-group-text"><i
                                                                class="fa fa-ellipsis-h"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" name="end"
                                                           placeholder="To Date">
                                                </div>
                                            </div>

                                            <div class="col-md-6 form-group">
                                                <label>Tax</label>
                                                <select class="form-control" id="tax" name="tax">
                                                    <option selected value="0">False</option>
                                                    <option value="1"> True</option>
                                                </select>
                                            </div>

                                        </div>

                                    </div>
                                @endif
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


        // google maps
        var map;
        var marker = false;
        var lat;
        var lng;
        initialize();
        function initialize() {
            if ($("#map-canvas").length != 0) {
                @if(isset($supplier))
                    lat = parseFloat(document.getElementById('lat').value);
                lng = parseFloat(document.getElementById('lng').value);

                var myLocationEdit = {
                    lat: lat,
                    lng: lng
                };
                map = new google.maps.Map(document.getElementById('map-canvas'), {
                    center: myLocationEdit,
                    zoom: 16,
                    mapTypeId: 'roadmap'
                });
                marker = new google.maps.Marker({
                    position: myLocationEdit,
                    map: map,
                    draggable: true
                });
                        @else
                var markers = [];
                map = new google.maps.Map(document.getElementById('map-canvas'), {
                    center: {lat: 31.95411763246642, lng: 35.89202087546278},
                    zoom: 12
                });
                        @endif
                var input = /** @type {HTMLInputElement} */(
                        document.getElementById('pac-input'));
                new google.maps.places.Autocomplete(input);
                google.maps.event.addDomListener(window, 'load', initialize);

                map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
                var searchBox = new google.maps.places.SearchBox((input));

                google.maps.event.addListener(searchBox, 'places_changed', function () {
                    var places = searchBox.getPlaces();
                    if (places.length == 0) {
                        return;
                    }
                    markers = [];
                    var mLatLng;
                    var bounds = new google.maps.LatLngBounds();
                    for (var i = 0, place; place = places[i]; i++) {
                        if (marker === false) {
                            marker = new google.maps.Marker({
                                position: place.geometry.location,
                                map: map,
                            });
                            google.maps.event.addListener(marker, 'dragend', function () {
                                markerLocation();
                            });
                        } else {
                            marker.setPosition(place.geometry.location);
                        }
                        mLatLng = place.geometry.location;
                    }
                    document.getElementById('lat').value = mLatLng.lat(); //latitude
                    document.getElementById('lng').value = mLatLng.lng();
                    map.setCenter(mLatLng);
                    map.setZoom(18);
                });
                google.maps.event.addListener(map, 'click', function (event) {

                    var clickedLocation = event.latLng;
                    if (marker === false) {
                        marker = new google.maps.Marker({
                            position: clickedLocation,
                            map: map,
                        });
                        google.maps.event.addListener(marker, 'dragend', function () {
                            markerLocation();
                        });
                    } else {
                        marker.setPosition(clickedLocation);
                    }
                    markerLocation();
                });
            }
        }

        function markerLocation() {
            var currentLocation = marker.getPosition();
            document.getElementById('lat').value = currentLocation.lat(); //latitude
            document.getElementById('lng').value = currentLocation.lng(); //longitude
        }

    </script>
    @endsection
