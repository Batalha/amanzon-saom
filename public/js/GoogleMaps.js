
var googlemaps;

// inicializa google maps para #dadosInstal
function initialize() {

	var latitude = $('#googlemaps').attr('lat');
	var longitude = $('#googlemaps').attr('long');
	var location = new google.maps.LatLng(latitude,longitude);
	// console.log(latitude+" "+longitude);

    var mapOptions = {
        center: location,
        zoom: 8,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    googlemaps = new google.maps.Map(document.getElementById("googlemaps"),
        mapOptions);

    var marker = new google.maps.Marker({
    	position: location,
    	map: googlemaps
  	});
}

