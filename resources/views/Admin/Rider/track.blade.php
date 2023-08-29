@extends('Admin.Layouts.master')
@section('content')

    <div class="page-title d-flex align-items-center justify-content-between flex-wrap">
        <h2>Track Rider</h2>
    </div>
    <br>
    <div class="cover-inner-content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title d-flex align-itesms-center justify-content-between">Track Rider <i
                                class="bi bi-info-circle"></i></h4>
                    <div class="row g-4">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <div id="map" style='height:400px'></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>


 @include('Admin.Partials.script')
 <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
      function initializeMap() {
                var locations = {{ Js::from($userslatlong) }};
                const map = new google.maps.Map(document.getElementById("map"), {
                    zoom: 0
                });
                var infowindow = new google.maps.InfoWindow();
                var bounds = new google.maps.LatLngBounds();
                for (var location of locations) {
                    var marker = new google.maps.Marker({
                        position: new google.maps.LatLng(location.latitude, location.longitude),
                        map: map
                    });
                    bounds.extend(marker.position);
                    google.maps.event.addListener(marker, 'click', (function(marker, location) {
                        return function() {
                            infowindow.setContent(location.name);
                            infowindow.open(map, marker);
                        }
                    })(marker, location));
                }
                map.fitBounds(bounds);
            }
        </script>
        <script type="text/javascript"
            src="https://maps.google.com/maps/api/js?key=AIzaSyCaEtV35BVEawpt7AJUQM3v5gm10O9RCJo&callback=initializeMap">
        </script>
       
    </script>
@endsection
