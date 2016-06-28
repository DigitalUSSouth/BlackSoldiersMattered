/**
 * file: bsm-map3.js
 * defines functions for testmap3 on index3.php
 */

$(document).ready( function() {
	initmap();
});


var map3;

/**
 * function initmap() 
 * initializes test map on index.php
 */
function initmap() {
	// set up the map
	map3 = new L.Map('testmap3');

	// create the tile layer with correct attribution
	var osmUrl='http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
	var osmAttrib='Map data © <a href="http://openstreetmap.org">OpenStreetMap</a> contributors';
	var osm = new L.TileLayer(osmUrl, {minZoom: 2, maxZoom: 12, attribution: osmAttrib});
	var basemapLayer = new L.TileLayer('http://{s}.tiles.mapbox.com/v3/github.map-xgq2svrz/{z}/{x}/{y}.png');

	// start the map in United Sates
	map3.setView(new L.LatLng(39.57182, -97.60254),4);
	map3.addLayer(osm);
	
	var popup = L.popup();

	function onMapClick(e) {
	    popup
	        .setLatLng(e.latlng)
	        .setContent("You clicked the map at " + e.latlng.toString())
	        .openOn(map3);
	}
	
	//alert ('map init done')
	//map3.on('click', onMapClick);
	
	var markers = [];
	
	initialMarkers.forEach(function (marker){
		markers.push(marker.latlng);
	});
	var heat = L.heatLayer(
			markers,
			{
				radius: 25,
				minOpacity: .7
			}
			).addTo(map3);
	
	//console.log(markers);
}