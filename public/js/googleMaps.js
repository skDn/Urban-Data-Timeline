/**
 * Created by skDn on 22/11/2015.
 */
//        function initialize() {
//            var myLatlng = new google.maps.LatLng(-25.363882, 131.044922);
//            var mapOptions = {
//                zoom: 4,
//                center: myLatlng,
//                mapTypeId: google.maps.MapTypeId.ROADMAP,
//                animation: google.maps.Animation.DROP,
//            }
//            var map = new google.maps.Map(document.getElementById("googleMap"), mapOptions);
//
//            var marker = new google.maps.Marker({
//                position: myLatlng,
//                map: map,
//                draggable: true,
//                title: "Drag me!"
//            });
//
////get marker position and store in hidden input
//            google.maps.event.addListener(marker, 'dragend', function (evt) {
//                document.getElementById("latInput").value = evt.latLng.lat().toFixed(4);
//            });
//        }

// function loadScript()
// {
// var script = document.createElement("script");
// script.type = "text/javascript";
// script.src = "http://maps.googleapis.com/maps/api/js?key=&sensor=false&callback=initialize";
// document.body.appendChild(script);
// }

var geocoder;
var map;
var infowindow;
var marker;
var markers = [];
var mapDiv = 'googleMap';
var latInput = 'latInput';
var lngInput = 'lonInput'
function start() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(success, success);

        // geolocation is not supported by this browser
    } else {
        alert('here');
        success(false);
    }
}

function success(position) {
    //$('#'+mapDiv).height(($( document ).height()*30)/100);
    var coords;
    var zoom;
    var lat = document.getElementById(latInput);
    var lng = document.getElementById(lngInput);
    if (position != false && position.code == undefined) {
        if (lat.value == '' && lng.value == '') {
            coords = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
        }
        else {
            coords = new google.maps.LatLng($('#'+latInput).val(), $('#'+lngInput).val());
        }
        zoom = 14;
    }
    else {
        if (lat.value == '' && lng.value == '') {
            coords = new google.maps.LatLng(55.8580, -4.2590);
        }
        else {
            coords = new google.maps.LatLng($('#'+latInput).val(), $('#'+lngInput).val());
        }
        zoom = 11;
    }
    //console.log(options);
    lat.value = coords.lat().toFixed(4);
    lng.value = coords.lng().toFixed(4);

    geocoder = new google.maps.Geocoder();
    var options = {
        zoom: zoom,
        center: coords,
        mapTypeControl: false,
        navigationControlOptions: {
            style: google.maps.NavigationControlStyle.SMALL
        },
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById(mapDiv), options);

    marker = new google.maps.Marker({
        position: coords,
        map: map,
        draggable: true,
        title: "Drag me!",
        icon: 'http://s12.postimg.org/4dq9xmsix/AB5bb.png', // null = default icon
    });

    google.maps.event.addListener(marker, 'dragend', function (evt) {
        map.setCenter(evt.latLng);
        lat.value = evt.latLng.lat().toFixed(4);
        lng.value = evt.latLng.lng().toFixed(4);
    });

    map.addListener('click', function(evt) {
        marker.setPosition(evt.latLng);
        map.setCenter(evt.latLng);
		lat.value = evt.latLng.lat().toFixed(4);
        lng.value = evt.latLng.lng().toFixed(4);
    });
    // uncomment if doesn't like the appearing of the input box
    //var $newInput = $('<input id="pac-input" class="controls" type="text" placeholder="Input a location">');
    //$( "body" ).append($newInput);

    var input = document.getElementById('pac-input');
    var searchBox = new google.maps.places.SearchBox(input);
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

    searchBox.addListener('places_changed', function () {
        codeAddress(input.value);
    });
}

function callback(results, status) {
    // Clear out the old markers.
    markers.forEach(function (marker) {
        marker.setMap(null);
    });
    markers = [];
    if (status == google.maps.places.PlacesServiceStatus.OK) {
        for (var i = 0; i < results.length; i++) {
            createMarker(results[i]);
        }
    }
}

function createMarker(place) {
    var placeLoc = place.geometry.location;

    var icon = {
        url: place.icon,
        scaledSize: new google.maps.Size(25, 25)
    };


    var marker1 = new google.maps.Marker({
        map: map,
        position: place.geometry.location,
        // either pick place's icon or custom icon
        icon: icon,
        //icon: 'http://s12.postimg.org/3mxjruq5l/AB5bb.png', // null = default icon
    });
    markers.push(marker1);
    google.maps.event.addListener(marker1, 'mouseover', function () {
        infowindow.setContent(place.name);
        infowindow.open(map, this);
    });
}

function codeAddress(address) {
    //var address = document.getElementById("address").value;
    geocoder.geocode({
        'address': address
    }, function (results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            map.setCenter(results[0].geometry.location);
            map.setZoom(15);
            marker.setPosition(results[0].geometry.location);
            document.getElementById(latInput).value = results[0].geometry.location.lat().toFixed(4);
            document.getElementById(lngInput).value = results[0].geometry.location.lng().toFixed(4);

            var request = {
                location: results[0].geometry.location,
                radius: 500,
                query: 'venue',
            };
            infowindow = new google.maps.InfoWindow();
            var service = new google.maps.places.PlacesService(map);
            service.nearbySearch(request, callback);
        } else {
            alert("Geocode was not successful for the following reason: " + status);
        }
    });
}
window.onload = start;