var map;
var geocoder;

// Fonction permettant de charger la Map de Google et on y insère les fonctions qu'elle aura lors de l'affichage
function loadMap() {
	// Indique la position de base de la map. et l'on met lat et lng de mons dans une variable mons
	var mons = {lat: 50.4459096, lng: 3.82962};
	// Fait appel a la classe map de javascript et crée une nouvelle map stocké dans la variable map.
	// et l'on place la map dans la div 'map' en faisant document.getElementById('map')
   		map = new google.maps.Map(document.getElementById('map'), {
      zoom: 10,
      center: mons
    });
// Place un point sur la Map et le considère comme le centre de la map lors de l'affichage.
// Ici il s'agit de Mons
    var marker = new google.maps.Marker({
      position: mons,
      map: map
    });

//On récupère les données qu'on a envoyé au format json depuis echo dans index.php et on parse pour qu'ils
//soient compréhensible par javascript.
//On renvois ces éléments a travers la fonction geocoder de google pour transformer une adresse en lat et lng
    var vdata = JSON.parse(document.getElementById('data').innerHTML);
    geocoder = new google.maps.Geocoder();
    codeAddress(vdata);

    var allData = JSON.parse(document.getElementById('allData').innerHTML);
    showAllCitys(allData)
}

function showAllCitys(allData) {
	var infoWind = new google.maps.InfoWindow;
	Array.prototype.forEach.call(allData, function(data){
		var content = document.createElement('div');
		var strong = document.createElement('strong');

		strong.textContent = data.name;
		content.appendChild(strong);

		var img = document.createElement('img');
		img.src = 'img/Leopard.jpg';
		img.style.width = '30px';
		content.appendChild(img);

		var marker = new google.maps.Marker({
	      position: new google.maps.LatLng(data.lat, data.lng),
	      map: map
	    });

	    marker.addListener('mouseover', function(){
	    	infoWind.setContent(content);
	    	infoWind.open(map, marker);
	    })
	})
}

// Fonction google permettant de transformer une adresse en coordonnées lng et lat pour pouvoir afficher
// les éléments sur la map.
function codeAddress(vdata) {
   Array.prototype.forEach.call(vdata, function(data){
		// On place dans une variable l'adresse qu'on a récupéré dans le fichier json converti
    	var address = data.name + ' ' + data.address;
	// On geocode l'adresse grâce à l'API de google
	    geocoder.geocode( { 'address': address}, function(results, status) {
	      if (status == 'OK') {
	        map.setCenter(results[0].geometry.location);
	        var points = {};
	        points.id = data.id;
	        points.lat = map.getCenter().lat();
	        points.lng = map.getCenter().lng();
		//On met à jour dans la base de donnée la lat et lng des nouveaux éléments correspondant à l'adresse
	        updateCityWithLatLng(points);
	      } else {
	        alert('Geocode was not successful for the following reason: ' + status);
	      }
	    });
	});
}
//fonction ajax permettant de mettre à jour les coordonnées dans la base de donnée en faisant appel
// a la fonction action.php qui inscrit les éléments dans la base
function updateCityWithLatLng(points) {
	$.ajax({
		url:"../includes/action.php",
		method:"post",
		data: points,
		success: function(res) {
			console.log(res)
		}
	})

}







/*

//Trouve un ensemble de résultat en fonction de la position actuelle.
function findResults(lat, lng, numberHits=20){

    index.search('', {

        aroundLatLng: lat + ", " + lng,
        // aroundRadius: 5000,
        hitsPerPage: numberHits
      }).then(({ hits }) => {
        searchList.clear()
        clearMarkers()
        hits.map(createMarker)
        setBounds()
        $( ".list li:first-of-type" ).trigger("click") //open infowindow for closest element
      });
}

function runWithGeolocation(position) {
    mapCenter = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);

    // map.setCenter(mapCenter);
    // map.setZoom(10);
    findResults(position.coords.latitude, position.coords.longitude);

    geocoder.geocode({'location': mapCenter}, function (results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            $('#zipCode').val(results[0].formatted_address).parent().addClass('is-dirty');
        } else {
            console.log("Geocode was not successful for the following reason: ")
        }
    });
}

function init() {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(runWithGeolocation);
    } else {
      console.log("Geolocation is not supported by this browser.")
    }
}

$( document ).ready(function() {
    //codeAddress('Mons');
    init()
});


//                                           Test Search




//ALGOLIA SETUP
const client = algoliasearch('JWHPBFC4T1', '6eb371014c3bff23b98dde01a8ef1763');
const index = client.initIndex('prod_schools');

var listTemplate = `<li>
    <a href="#" class="shadow-sm list-group-item list-group-item-action flex-column align-items-start">
        <div class="d-flex w-100 justify-content-between">
            <h5 class="mb-1 siteName"></h5>
            <small class="distance"></small>
        </div>
        <p class="mb-1 collapsed"></p>
    <small></small>
</a></li>
`


var directionsIcon = `<svg class="bi bi-arrow-90deg-right" width="1.3rem" height="1.3rem" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" d="M9.896 2.396a.5.5 0 000 .708l2.647 2.646-2.647 2.646a.5.5 0 10.708.708l3-3a.5.5 0 000-.708l-3-3a.5.5 0 00-.708 0z" clip-rule="evenodd"/>
<path fill-rule="evenodd" d="M13.25 5.75a.5.5 0 00-.5-.5h-6.5a2.5 2.5 0 00-2.5 2.5v5.5a.5.5 0 001 0v-5.5a1.5 1.5 0 011.5-1.5h6.5a.5.5 0 00.5-.5z" clip-rule="evenodd"/>
</svg>`

var searchOptions = {
    valueNames: [ 'siteName', 'siteAddress', 'distance'],
    item: listTemplate
};

var searchList = new List('searchList', searchOptions);



function findResults(lat, lng, numberHits=20){

    index.search('', {

        aroundLatLng: lat + ", " + lng,
        // aroundRadius: 5000,
        hitsPerPage: numberHits
      }).then(({ hits }) => {
        searchList.clear()
        clearMarkers()
        hits.map(createMarker)
        setBounds()
        $( ".list li:first-of-type" ).trigger("click") //open infowindow for closest element
      });
}

function distance(mk1, mk2) {
    var R = 3958.8; // Radius of the Earth in miles
    var rlat1 = mk1.lat() * (Math.PI/180); // Convert degrees to radians
    var rlat2 = mk2.lat() * (Math.PI/180); // Convert degrees to radians
    var difflat = rlat2-rlat1; // Radian difference (latitudes)
    var difflon = (mk2.lng()-mk1.lng()) * (Math.PI/180); // Radian difference (longitudes)

    var d = 2 * R * Math.asin(Math.sqrt(Math.sin(difflat/2)*Math.sin(difflat/2)+Math.cos(rlat1)*Math.cos(rlat2)*Math.sin(difflon/2)*Math.sin(difflon/2)));
    var roundedDistance = (Math.round(d * 10) / 10).toFixed(1);
    var string = roundedDistance.toString() + ' miles away';
    return string;
}

function setBounds(){
    var bounds = new google.maps.LatLngBounds();
    for (var i = 0; i < markerArray.length; i++) {
        bounds.extend(markerArray[i].getPosition());
    }
    map.fitBounds(bounds);
}
*/
