
function initialize() {
  var mapOptions = {
    zoom: 13,
    center: new google.maps.LatLng(-25.363882,131.044922)
  };
  var map = new google.maps.Map(document.getElementById('map-canvas'),
      mapOptions);

if(navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var pos = new google.maps.LatLng(position.coords.latitude,
                                       position.coords.longitude);


      map.setCenter(pos);
    }, function() {
      handleNoGeolocation(true);
    });
  } else {
    // Browser doesn't support Geolocation
    handleNoGeolocation(false);
  }
  var transitLayer = new google.maps.TransitLayer();
  transitLayer.setMap(map);


  google.maps.event.addListener(map, 'click', function(e) {
    placeMarker(e.latLng, map);
  });
}
function handleNoGeolocation(errorFlag) {
  if (errorFlag) {
    var content = 'Le service est indisponible.';
  } else {
    var content = 'Votre navigateur ne permet pas de vous localiser.';
  }

  var options = {
    map: map,
    position: new google.maps.LatLng(60, 105),
    content: content
  };

  //var infowindow = new google.maps.InfoWindow(options);
  map.setCenter(options.position);
}

function placeMarker(position, map) {
  var marker = new google.maps.Marker({
    position: position,
    map: map
  });
  map.panTo(position);
  document.getElementById('issue_custom_field_values_36').value=position;
}

google.maps.event.addDomListener(window, 'load', initialize);
