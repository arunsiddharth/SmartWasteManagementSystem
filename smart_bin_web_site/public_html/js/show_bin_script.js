var map;
function initMap(){
    var mnit_center = {lat : 26.8630, lng : 75.8106};
    var mapProps = {
       zoom : 12,
       center : mnit_center
    };
    map = new google.maps.Map(document.getElementById('map'),mapProps);
    for(var i=0;i<Markers_props.length;i++){
        addMarker(Markers_props[i]);
    }
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