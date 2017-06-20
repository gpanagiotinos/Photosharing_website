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
        zoom: 15,
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

    setMarkers(homeMap_pos, map);  
}


function setMarkers(homeMap_pos, map)
{
    //ajax response
    alert("sds");
    var dataStr = 'lat=' + homeMap_pos.lat() + '&lng=' + homeMap_pos.lng();
    $.ajax({
            url: 'ajax/map.php',
            dataType: 'json',
            success: function(data){
                        var myOptions = {
                             content: 's'
                            ,disableAutoPan: false
                            ,maxWidth: 0
                            ,pixelOffset: new google.maps.Size(-140, 0)
                            ,zIndex: null
                            ,boxStyle: { 
                               opacity: 0.95
                              ,width: "180px"
                             }
                            ,closeBoxMargin: "10px 2px 2px 2px"
                            ,closeBoxURL: "http://www.google.com/intl/en_us/mapfiles/close.gif"
                            ,infoBoxClearance: new google.maps.Size(1, 1)
                            ,isHidden: false
                            ,pane: "floatPane"
                            ,enableEventPropagation: false
                        };

                        var ib = new InfoBox(myOptions);

                        for(var i = 0; i < data.length; i++)
                        {
                            //alert(data[i].title);
                            var image = new google.maps.MarkerImage(data[i].thumb_path,
                            new google.maps.Size(32, 32),
                            new google.maps.Point(0,0),
                            new google.maps.Point(0, 32));
                            var myLatLng = new google.maps.LatLng(data[i].lat, data[i].lng);
                            var marker = new google.maps.Marker({
                                position: myLatLng,
                                map: map,
                                icon: image,
                                title: data[i].title
                            });

                            var boxText = document.createElement("div");
                            boxText.style.cssText = "border: 5px solid #e7e1d0; background: #e7e1d4; padding: 5px;";
                            boxText.innerHTML = '<table><tr><td><img src="'+data[i].thumb_path+'" class="fleft"/><br/><q>'+data[i].username+'</q><br/><i>'+data[i].views+'</i></td><td><em>' + data[i].title + '</em><br/><a href="photo.php?pid='+data[i].id+'">Προβολη</a></td></tr></table>';
                            
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


}
function bindInfoW(map, marker,  ib, boxText)
{                
        

        google.maps.event.addListener(marker, 'click', function() {
            ib.setContent(boxText);
            ib.open(map, marker);
        });
}