//get the current pos
function initHomeMap()
{	
	//get current position
	navigator.geolocation.getCurrentPosition(homeMap_handler_loc, homeMap_handler_error);

};

function homeMap_handler_loc(pos)
{
	initialize(new google.maps.LatLng(pos.coords.latitude, pos.coords.longitude));
}
function homeMap_handler_error()
{
	initialize(new google.maps.LatLng(38.245445,21.735046));
}
function initialize(homeMap_pos)
{
  var map;

  var mapOptions = {
        zoom: 16,
        center: homeMap_pos,
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
	var map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);


	   //ajax response
    var dataStr = 'lat=' + homeMap_pos.lat() + '&lng=' + homeMap_pos.lng();
    $.ajax({
            url: 'ajax/map.php',
            dataType: 'json',
            success: function(data){
                        var myOptions = {
                             content: 's'
                            ,disableAutoPan: false
                            ,maxWidth: 0
                            ,pixelOffset: new google.maps.Size(-105, 0)
                            ,zIndex: null
                            ,boxStyle: { 
                               opacity: 0.95
                              ,width: "204px"
                             }
                            
                            ,closeBoxURL: "themes/Default/images/close.png"
                            ,infoBoxClearance: new google.maps.Size(1, 1)
                            ,isHidden: false
                            ,pane: "floatPane"
                            ,enableEventPropagation: false
                        };

                        var ib = new InfoBox(myOptions);
                        var image = new google.maps.MarkerImage(
	                            'themes/Default/images/marker.png',
	                            new google.maps.Size(100,50),
								new google.maps.Point(0,0),
								new google.maps.Point(50,50)
							);
							var shadow = new google.maps.MarkerImage(
								'themes/Default/images/shadow.png',
								new google.maps.Size(130,50),
								new google.maps.Point(0,0),
								new google.maps.Point(65, 50)
							);
                        for(var i = 0; i < data.length; i++)
                        {
                            //alert(data[i].title);
                            
                            var myLatLng = new google.maps.LatLng(data[i].lat, data[i].lng);
                            var marker = new google.maps.Marker({
                                position: myLatLng,
                                map: map,
                                icon: image,
                                shadow: shadow,
                                title: data[i].title
                            });

                            var boxText = document.createElement("div");
                            boxText.style.cssText = "border: 2px solid #1e2629; background: #3d4c53;";
                            boxText.innerHTML = '<a href="photo.php?pid='+data[i].id+'" alt="'+data[i].title+'"><img src="thumbs.php?id='+data[i].id+'" alt="'+data[i].title+'"/></a>';
                            
                            bindInfoW(map, marker, ib, boxText);
                            
                        } 
                        
                    },
            data: dataStr,
            method: 'get',
            statusCode: {
                404:function() {
                        alert("404:Page not found!");
                    }
                }
    });

	
    //setMarkers(homeMap_pos, map);  
}


function setMarkers(homeMap_pos, map)
{
 

}
function bindInfoW(map, marker,  ib, boxText)
{                
        

        google.maps.event.addListener(marker, 'click', function() {
            ib.setContent(boxText);
            ib.open(map, marker);
        });
}