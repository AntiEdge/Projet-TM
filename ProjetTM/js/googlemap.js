var map;
var geocoder;


// Fonction permettant de charger la Map de Google et on y insère les fonctions qu'elle aura lors de l'affichage
function loadMap() {

	// Indique la position de base de la map. et l'on met lat et lng de mons dans une variable mons
	var mons = {lat: 50.4459096, lng: 3.82962};

	var mapOptions = {
		zoom: 8,
		center: mons,
		mapTypeId: 'roadmap'
	};
	// Fait appel a la classe map de javascript et crée une nouvelle map stocké dans la variable map.
	// et l'on place la map dans la div 'map' en faisant document.getElementById('map')
   		map = new google.maps.Map(document.getElementById('map'), mapOptions);
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
		console.log(allData);
    showAllCitys(allData)



		var infoWindow = new google.maps.InfoWindow;
/* test position*/
		// Try HTML5 geolocation.
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(function(position) {
				var pos = {
					lat: position.coords.latitude,
					lng: position.coords.longitude
				};
				infoWindow.setPosition(pos);
				infoWindow.setContent('Location found.');
				infoWindow.open(map);
				map.setCenter(pos);
			}, function() {
				handleLocationError(true, infoWindow, map.getCenter());
			});
		} else {
			// Browser doesn't support Geolocation
			handleLocationError(false, infoWindow, map.getCenter());
		}
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
		url:"includes/action.php",
		method:"post",
		data: points,
		success: function(res) {
			console.log(res)
		}
	})

}


function direction(lat, lng){

	var contentString = "";

	var mapDirections = "https://www.google.com/maps/dir/Current+Location/"+ lat + "," + lng

	var directionsIcon = `<svg class="bi bi-arrow-90deg-right" width="1.3rem" height="1.3rem" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
	<path fill-rule="evenodd" d="M9.896 2.396a.5.5 0 000 .708l2.647 2.646-2.647 2.646a.5.5 0 10.708.708l3-3a.5.5 0 000-.708l-3-3a.5.5 0 00-.708 0z" clip-rule="evenodd"/>
	<path fill-rule="evenodd" d="M13.25 5.75a.5.5 0 00-.5-.5h-6.5a2.5 2.5 0 00-2.5 2.5v5.5a.5.5 0 001 0v-5.5a1.5 1.5 0 011.5-1.5h6.5a.5.5 0 00.5-.5z" clip-rule="evenodd"/>
	</svg>`

	console.log(mapDirections);
	console.log(directionsIcon);

	 contentString = contentString.concat("<span class='directionLink'> <a target='_blank' href=", mapDirections,">Get Directions", directionsIcon, "</a>", "</span>")

	return contentString;
}

	var recuperertest = document.getElementById("test");
	var testData = JSON.parse(document.getElementById("allData").innerHTML);

function renderHtml(testData){

	var htmlString = "";
	var lat;
	var lng;
	for (i=0; i < testData.length; i++){

		lat = testData[i].lat;
		lng = testData[i].lng;

			if(i==0){

				htmlString += '<a href="#" class="list-group-item list-group-item-action flex-column align-items-start active">';
			}else{

				htmlString += '<a href="#" class="list-group-item list-group-item-action flex-column align-items-start">';
			}

			htmlString += '<div class="d-flex w-100 justify-content-between">';
			htmlString += '<h5 class="mb-1">' + testData[i].name + "</h5>";
			htmlString += "<small>" + testData[i].type + "</small>";
			htmlString += "</div>";
			htmlString += '<p class="mb-1">' + testData[i].address + "</p>";
			htmlString += "<small>" + direction(lat,lng) + "</small>";
			htmlString += "</a>";

	}

	recuperertest.insertAdjacentHTML('afterbegin', htmlString);

}

window.onload = function(){
	renderHtml(testData);

}




/*                           test search from map                                   */
