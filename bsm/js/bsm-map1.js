/**
 * file: bsm-map1.js
 * defines functions for testmap1 on index.php
 */

$(document).ready( function() {
	initmap();
});


var map1;

/**
 * function initmap() 
 * initializes test map on index.php
 */
function initmap() {
	// set up the map
	map1 = new L.Map('testmap1');

	// create the tile layer with correct attribution
	var osmUrl='http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
	var osmAttrib='Map data © <a href="http://openstreetmap.org">OpenStreetMap</a> contributors';
	var osm = new L.TileLayer(osmUrl, {minZoom: 2, maxZoom: 12, attribution: osmAttrib});
	var basemapLayer = new L.TileLayer('http://{s}.tiles.mapbox.com/v3/github.map-xgq2svrz/{z}/{x}/{y}.png');

	// start the map in United Sates
	map1.setView(new L.LatLng(39.57182, -97.60254),4);
	map1.addLayer(osm);
	
	var popup = L.popup();

	function onMapClick(e) {
	    popup
	        .setLatLng(e.latlng)
	        .setContent("You clicked the map at " + e.latlng.toString())
	        .openOn(map1);
	}
	
	//alert ('map init done')
	map1.on('click', onMapClick);

	//test marker
	//var marker = L.marker([40.38003, -75.71777]).addTo(map);


 // =====================================================
    // =============== Playback ============================
    // =====================================================
    
   // Playback options
    var playbackOptions = {
    	tickLen : 1000,
        playControl: true,
        dateControl: true,
        sliderControl: true
    };

    // Initialize playback
    var playback = new L.Playback(map1, soldiers, null, playbackOptions);
    
    //debug:
    console.log(playback);
	
}
