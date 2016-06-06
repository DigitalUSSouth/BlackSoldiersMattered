/**
 * 
 */


var map;


function initmap() {
	// set up the map
	map = new L.Map('testmap');

	// create the tile layer with correct attribution
	var osmUrl='http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
	var osmAttrib='Map data © <a href="http://openstreetmap.org">OpenStreetMap</a> contributors';
	var osm = new L.TileLayer(osmUrl, {minZoom: 2, maxZoom: 12, attribution: osmAttrib});		

	// start the map in South-East England
	map.setView(new L.LatLng(39.57182, -97.60254),4);
	map.addLayer(osm);
	
	var popup = L.popup();

	function onMapClick(e) {
	    popup
	        .setLatLng(e.latlng)
	        .setContent("You clicked the map at " + e.latlng.toString())
	        .openOn(map);
	}

	map.on('click', onMapClick);
	
	
}

$(document).ready( function() {
	initmap();
});