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
		url:"action.php",
		method:"post",
		data: points,
		success: function(res) {
			console.log(res)
		}
	})

}
