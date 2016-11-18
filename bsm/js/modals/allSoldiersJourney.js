$('#allSoldiersJourneyModal').on('shown.bs.modal', function() {

	if (allSoldiersJourneyModalDisplayed) return; //if the modal has been opened before we don't want to redraw everything
    allSoldiersJourneyModalDisplayed = true;



    // set up the map
	map3 = new L.Map('allSoldiersJourneyMap');

	// create the tile layer with correct attribution
	var osmUrl='http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
	var osmAttrib='Map data © <a href="http://openstreetmap.org">OpenStreetMap</a> contributors';
	var osm = new L.TileLayer(osmUrl, {minZoom: 2, maxZoom: 12, attribution: osmAttrib});
	var basemapLayer = new L.TileLayer('http://{s}.tiles.mapbox.com/v3/github.map-xgq2svrz/{z}/{x}/{y}.png');

	// start the map in United Sates/France
	map3.setView(new L.LatLng(35.131547,-63.4294789),3);
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
	
	 
	
	soldierLocations['1913-8'].forEach(function (marker){
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
		$( "#slider1" ).slider({
      	  value:1,
          min: 1,
	      max: 92,
	      step: 1,
	      slide: function( event, ui ) {
	        //console.log(getDateIndex(ui.value));
			markers = [];
            var dateIndex = getDateIndex(ui.value);
    		soldierLocations[dateIndex].forEach(function (marker){
    		  markers.push(marker);
    		});
    		heat.setLatLngs(markers);
            //TODO: display full month name instead of number
            $("#dateDisplay").text(dateIndex);
	      }
	    });
	});
});
 

//function to get date index from slider value
function getDateIndex(val){
	switch (val){
		//case 0: 
		  //return "1913-9";
case 1:
  return "1913-8";
case 2:
  return "1913-9";
case 3:
  return "1913-10";
case 4:
  return "1913-11";
case 5:
  return "1913-12";
case 6:
  return "1914-1";
case 7:
  return "1914-2";
case 8:
  return "1914-3";
case 9:
  return "1914-4";
case 10:
  return "1914-5";
case 11:
  return "1914-6";
case 12:
  return "1914-7";
case 13:
  return "1914-8";
case 14:
  return "1914-9";
case 15:
  return "1914-10";
case 16:
  return "1914-11";
case 17:
  return "1914-12";
case 18:
  return "1915-1";
case 19:
  return "1915-2";
case 20:
  return "1915-3";
case 21:
  return "1915-4";
case 22:
  return "1915-5";
case 23:
  return "1915-6";
case 24:
  return "1915-7";
case 25:
  return "1915-8";
case 26:
  return "1915-9";
case 27:
  return "1915-10";
case 28:
  return "1915-11";
case 29:
  return "1915-12";
case 30:
  return "1916-1";
case 31:
  return "1916-2";
case 32:
  return "1916-3";
case 33:
  return "1916-4";
case 34:
  return "1916-5";
case 35:
  return "1916-6";
case 36:
  return "1916-7";
case 37:
  return "1916-8";
case 38:
  return "1916-9";
case 39:
  return "1916-10";
case 40:
  return "1916-11";
case 41:
  return "1916-12";
case 42:
  return "1917-1";
case 43:
  return "1917-2";
case 44:
  return "1917-3";
case 45:
  return "1917-4";
case 46:
  return "1917-5";
case 47:
  return "1917-6";
case 48:
  return "1917-7";
case 49:
  return "1917-8";
case 50:
  return "1917-9";
case 51:
  return "1917-10";
case 52:
  return "1917-11";
case 53:
  return "1917-12";
case 54:
  return "1918-1";
case 55:
  return "1918-2";
case 56:
  return "1918-3";
case 57:
  return "1918-4";
case 58:
  return "1918-5";
case 59:
  return "1918-6";
case 60:
  return "1918-7";
case 61:
  return "1918-8";
case 62:
  return "1918-9";
case 63:
  return "1918-10";
case 64:
  return "1918-11";
case 65:
  return "1918-12";
case 66:
  return "1919-1";
case 67:
  return "1919-2";
case 68:
  return "1919-3";
case 69:
  return "1919-4";
case 70:
  return "1919-5";
case 71:
  return "1919-6";
case 72:
  return "1919-7";
case 73:
  return "1919-8";
case 74:
  return "1919-9";
case 75:
  return "1919-10";
case 76:
  return "1919-11";
case 77:
  return "1919-12";
case 78:
  return "1920-1";
case 79:
  return "1920-2";
case 80:
  return "1920-3";
case 81:
  return "1920-4";
case 82:
  return "1920-5";
case 83:
  return "1920-6";
case 84:
  return "1920-7";
case 85:
  return "1920-8";
case 86:
  return "1920-9";
case 87:
  return "1920-10";
case 88:
  return "1920-11";
case 89:
  return "1920-12";
case 90:
  return "1921-1";
case 91:
  return "1921-2";
case 92:
  return "1921-3";
//case 93:
  //return "1921-4";
		  
	}
}