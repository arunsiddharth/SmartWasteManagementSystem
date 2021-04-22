      var map;
      function initMap() {
        var directionsService = new google.maps.DirectionsService;
        var directionsDisplay = new google.maps.DirectionsRenderer;
        var mnit_center = {lat: 26.8630, lng: 75.8106};
        var mapProps = {
          zoom: 12,
          center: mnit_center
        };
        map = new google.maps.Map(document.getElementById('map'),mapProps);        directionsDisplay.setMap(map);
        calculateAndDisplayRoute(directionsService, directionsDisplay);
      }
      function addMarker(props){
          var marker = new google.maps.Marker({
             position : props.coords,
             map : map
          });
          if(props.content){
              var infoWindow = new google.maps.InfoWindow({
                  content : props.content
              });
              marker.addListener('click',function(){
                infoWindow.open(map,marker);
              });
          }
          if(props.iconImage){
              marker.setIcon(props.iconImage);
          }
      }
      function calculateAndDisplayRoute(directionsService, directionsDisplay) {
        var waypts = [];
        for (var i = 1; i < Markers.length; i++) {
            waypts.push({
              location: new google.maps.LatLng(Markers[i][0], Markers[i][1]),
              stopover: true
            });
        }
        directionsService.route({
          origin: new google.maps.LatLng(Markers[0][0], Markers[0][1]),
          destination: new google.maps.LatLng(Markers[0][0], Markers[0][1]),
          waypoints: waypts,
          optimizeWaypoints: true,
          travelMode: 'DRIVING'
        }, function(response, status) {
          if (status === 'OK') {
            directionsDisplay.setDirections(response);
            var route = response.routes[0];
            var summaryPanel = document.getElementById('directions-panel');
            summaryPanel.innerHTML = '';
            // For each route, display summary information.
            for (var i = 0; i < route.legs.length; i++) {
              var routeSegment = i + 1;
              summaryPanel.innerHTML += '<b>Route Segment: ' + routeSegment + '</b><br>';
              summaryPanel.innerHTML += route.legs[i].start_address + ' to ';
              summaryPanel.innerHTML += route.legs[i].end_address + '<br>';
              summaryPanel.innerHTML += route.legs[i].distance.text + '<br><br>';
            }
          } else {
            window.alert('Directions request failed due to ' + status);
          }
        });
      }
