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
	
	
	
	soldierLocations['1918-4'].forEach(function (marker){
		markers.push(marker);
	});
	heat = L.heatLayer(
			markers,
			{
				radius: 25,
				minOpacity: .5
			}
			).addTo(map3);
	
	$( function() {
		$( "#slider" ).slider({
      	  value:0,
          min: 0,
	      max: 340,
	      step: 10,
	      slide: function( event, ui ) {
	        //console.log(getDateIndex(ui.value));
			markers = [];
    		soldierLocations[getDateIndex(ui.value)].forEach(function (marker){
    		  markers.push(marker);
    		});
    		heat.setLatLngs(markers);
	      }
	    });
	});
	
   



	/*var nextPrevControl = L.Control.extend({
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
	
	
    $("#next-button").click(function (e){
    	markers = [];
    	secondMarkers.forEach(function (marker){
    		markers.push(marker.latlng);
    	});
    	heat.setLatLngs(markers);
    	$(".next-prev-control button").toggleClass("disabled");
    });*/
    
	//console.log(MyControl);
}


//function to get date index from slider value
function getDateIndex(val){
	switch (val){
		case 0: 
		  return "1917-2";
		case 10: 
		  return "1917-3";
		case 20: 
		  return "1917-4";
		case 30: 
		  return "1917-5";
		case 40: 
		  return "1917-6";
		case 50: 
		  return "1917-7";
		case 60: 
		  return "1917-8";
		case 70: 
		  return "1917-9";
		case 80: 
		  return "1917-10";
		case 90: 
		  return "1917-11";
		case 100: 
		  return "1917-12";
		case 110: 
		  return "1918-1";
		case 120: 
		  return "1918-2";
		case 130: 
		  return "1918-3";
		case 140: 
		  return "1918-4";
		case 150: 
		  return "1918-5";
		case 160: 
		  return "1918-6";
		case 170: 
		  return "1918-7";
		case 180: 
		  return "1918-8";
		case 190: 
		  return "1918-9";
		case 200: 
		  return "1918-10";
		case 210: 
		  return "1918-11";
		case 220: 
		  return "1918-12";
		case 230: 
		  return "1919-1";
		case 240: 
		  return "1919-2";
		case 250: 
		  return "1919-3";
		case 260: 
		  return "1919-4";
		case 270: 
		  return "1919-5";
		case 280: 
		  return "1919-6";
		case 290: 
		  return "1919-7";
		case 300: 
		  return "1919-8";
		case 310: 
		  return "1919-9";
		case 320: 
		  return "1919-10";
		case 330: 
		  return "1919-11";
		case 340: 
		  return "1919-12";
		  
	}
}