/**
 * file: bsm-map3.js
 * defines functions for testmap3 on index3.php
 */

$(document).ready( function() {
	initmap();
});


var map3;
var markers = [];
var heat; //this is the heatmap layer

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
	
	
	
	initialMarkers.forEach(function (marker){
		markers.push(marker.latlng);
	});
	heat = L.heatLayer(
			markers,
			{
				radius: 25,
				minOpacity: .7
			}
			).addTo(map3);
	
	var nextPrevControl = L.Control.extend({
	    options: {
	        position: 'bottomleft'
	    },

	    onAdd: function (map) {
	        // create the control container with a particular class name
	        var container = L.DomUtil.create('div', 'next-prev-control');

	        $(container).html('<button class="btn btn-primary disabled" id="prev-button">&lt;Prev ' +
	        		'</button>' +
	        		'<button class="btn btn-primary" id="next-button"> Next &gt;' +
	        		'</button>');
	        
	        

	        return container;
	    }
	});
	
	newControl = new nextPrevControl();
	newControl.addTo(map3);
	//add listeners, etc.
    
    $("#prev-button").click(function (e){
    	markers = [];
    	initialMarkers.forEach(function (marker){
    		markers.push(marker.latlng);
    	});
    	heat.setLatLngs(markers);
    	$(".next-prev-control button").toggleClass("disabled");
    });
	
	/* I hate nested callback functions... */
	
    $("#next-button").click(function (e){
    	markers = [];
    	secondMarkers.forEach(function (marker){
    		markers.push(marker.latlng);
    	});
    	heat.setLatLngs(markers);
    	$(".next-prev-control button").toggleClass("disabled");
    });
    
	//console.log(MyControl);
}