@extends('layouts.main')

@section('css')
    <style>
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
        }

        #pac-input:focus {
            border-color: #4d90fe;
        }

        #map-canvas {
            height: 350px;
            margin: 20px;
            width: 780px;
            padding: 0px;
        }
    </style>
    @endsection
@section('content')
    <div class="col-md-12 form-group">

        <label> Google Map</label>
        <input id="pac-input" class="controls" type="text" placeholder="Search Box">
        <div id="map-canvas"></div>
        <input type="hidden" name="lat" id="lat" readonly="yes">
        <input type="hidden" name="lng" id="lng" readonly="yes">
    </div>
@endsection
@section('script')

    <script>

        // google maps
        var map;
        var marker = false;
        initialize();
        function initialize() {
            if ($("#map-canvas").length != 0) {
                var markers = [];
                map = new google.maps.Map(document.getElementById('map-canvas'), {
                    center: {lat: 31.95411763246642, lng: 35.89202087546278},
                    zoom: 12
                });
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