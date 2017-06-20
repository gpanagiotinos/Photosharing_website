
this.geoLoc = function()
{
	
	//get current position
	navigator.geolocation.getCurrentPosition(handle_loc, handle_error);

};
function check_allready_pos()
{
	if($('#lat').val() != 0 && $('#lng').val() != 0)
	{
		return new google.maps.LatLng($('#lat').val(), $('#lng').val());
	}else{
		return false;
	}
}
function handle_loc(pos)
{
	var currentPos = check_allready_pos();
	if(!currentPos){
		currentPos = new google.maps.LatLng(pos.coords.latitude, pos.coords.longitude);
	}
	init_map(currentPos);
}
function handle_error()
{
	var currentPos = new google.maps.LatLng(38.245445,21.735046);
	init_map(currentPos);
}

function init_map(pos)
{
	$("#lat").val(pos.lat());
	$("#lng").val(pos.lng());
	//set map options
	var mapOptions = {
        zoom: 15,
        center: pos,
        mapTypeControl: false,
        panControl: false,
        streetViewControl: false,
        zoomControl: true,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        zoomControlOptions: {
            style: google.maps.ZoomControlStyle.LARGE,
            position: google.maps.ControlPosition.LEFT_CENTER
        }
    };
    //create map
	var map = new google.maps.Map(document.getElementById('photoMap'), mapOptions);

	marker = new google.maps.Marker({
      map:map,
      draggable:true,
      position: pos,
      visible: true
    });

    google.maps.event.addListener(marker, 'dragend', function(){
    	var pos = marker.getPosition();
    	formPos(pos);
    });
    google.maps.event.addListener(map, 'click', function(event){
    	var pos = event.latLng;
    	marker.setPosition(pos);
    	marker.setVisible(true);
    	formPos(pos);
    });
}
function formPos(pos)
{
	$("#lat").val(pos.lat());
	$("#lng").val(pos.lng());
    getAddress(pos);
}
function getAddress(pos)
{
    var geocoder = new google.maps.Geocoder();
    geocoder.geocode({
        'latLng': pos,
        'language': 'en, el'    
    },function(results, status){

        if(status == google.maps.GeocoderStatus.OK)
        {
            if(results[0]){
                var address = results[0].address_components[1].long_name + ' ' + results[0].address_components[0].long_name + ', ' + results[0].address_components[2].long_name + ', ' + results[0].address_components[6].long_name;
                $('#address').val(address);
                $('#currentAddress').text(address);
            }else{
                alert("No address");
            }
        }else{
            alert("Geocoder error : " + status);
        }
    });
}