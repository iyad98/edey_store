

function initMap() {
    var uluru = {lat: -25.344, lng: 131.036};

    vm.store.lat = uluru.lat;
    vm.store.lng = uluru.lng;

    map = new google.maps.Map(document.getElementById('map'), {
        center: uluru,
        zoom: 5
    });


    marker = new google.maps.Marker({
        position: uluru,
        map: map ,
        draggable:true,
        animation: google.maps.Animation.DROP,
    });
    get_current_location();
    google.maps.event.addListener(map, 'click', function(event) {
        marker.setPosition(event.latLng);
        vm.store.lat = event.latLng.lat();
        vm.store.lng = event.latLng.lng();
    });

    google.maps.event.addListener(marker, 'dragend', function (event) {
        vm.store.lat = event.latLng.lat();
        vm.store.lng = event.latLng.lng();
    });

    // search

    var searchBox = new google.maps.places.SearchBox(document.getElementById('pac-input'));
    map.controls[google.maps.ControlPosition.TOP_CENTER].push(document.getElementById('pac-input'));
    google.maps.event.addListener(searchBox, 'places_changed', function() {
        searchBox.set('map', null);


        var places = searchBox.getPlaces();

        var bounds = new google.maps.LatLngBounds();
        var i, place;
        for (i = 0; place = places[i]; i++) {
            (function(place) {

                marker.setPosition(place.geometry.location);
                // set
                vm.store.lat = place.geometry.location.lat();
                vm.store.lng = place.geometry.location.lng();

                marker.bindTo('map', searchBox, 'map');
                google.maps.event.addListener(marker, 'map_changed', function() {
                    if (!this.getMap()) {
                        this.unbindAll();
                    }
                });
                bounds.extend(place.geometry.location);


            }(place));

        }
        map.fitBounds(bounds);
        searchBox.set('map', map);
        map.setZoom(Math.min(map.getZoom(),12));

    });
}


function get_current_location() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };
            vm.store.lat = position.coords.latitude;
            vm.store.lng = position.coords.longitude;

            map.setCenter(pos);
            marker.setPosition(pos);
        }, function() {
        //    handleLocationError(true, infoWindow, map.getCenter());
        });
    } else {
        // Browser doesn't support Geolocation
      //  handleLocationError(false, infoWindow, map.getCenter());
    }

}