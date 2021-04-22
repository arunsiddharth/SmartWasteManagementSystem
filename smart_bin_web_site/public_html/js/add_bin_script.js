var tmpMarker = null;
var map;
function initMap(){
    var mnit_center = {lat : 26.8630, lng : 75.8106};
    var mapProps = {
      zoom : 12,
      center : mnit_center
    };
    map = new google.maps.Map(document.getElementById('map'),mapProps);
    google.maps.event.addListener(map, 'click', function(event){
        addMarker({coords:event.latLng});
    });
}
function addMarker(props){
          if(tmpMarker){
            tmpMarker.setMap(null);
          }
          var marker = new google.maps.Marker({
             position : props.coords,
             map : map
          });
        tmpMarker = marker;
        document.getElementById('af_lat').value =props.coords.lat();
        document.getElementById('af_lng').value =props.coords.lng();
}
