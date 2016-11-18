//soldierPage.js

var unitMarkers = [];

$(document).ready(function (){
    //
    soldierMap = new L.Map('soldierMap');

	// create the tile layer with correct attribution
	var osmUrl='http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
	var osmAttrib='Map data © <a href="http://openstreetmap.org">OpenStreetMap</a> contributors';
	var osm = new L.TileLayer(osmUrl, {minZoom: 2, maxZoom: 12, attribution: osmAttrib});
	var basemapLayer = new L.TileLayer('http://{s}.tiles.mapbox.com/v3/github.map-xgq2svrz/{z}/{x}/{y}.png');

	// start the map in United Sates/France
	soldierMap.setView(new L.LatLng(39.57182, -97.60254),5);
	soldierMap.addLayer(osm);
	
	var popup = L.popup();

	function onMapClick(e) {
	    popup
	        .setLatLng(e.latlng)
	        .setContent("You clicked the map at " + e.latlng.toString())
	        .openOn(soldierMap);
	}

    //var soldierUnits = soldier.unit_progression;
    

    var markerCluster = L.markerClusterGroup();
    var counter = 0;
    var firstLatlng;
    $.each(unit.location, function(id, loc){
        //var unitName = unit[0];
        //console.log(unitName);
        //var companyName = unit[1];
        var toDate = loc.date;
        if (loc.id== undefined) return true;
        var camp = loc.id;
        //console.log(camp);
        var latlng = camps[camp].latlng;
        var place = camps[camp].place;
        if(counter++==0) firstLatlng=latlng;
        //console.log(latlng);
        var marker = L.marker(latlng,{title:camp}).bindPopup(
            "<h3>Camp: "+camp+"</h3>"
            +"<p><strong>Place: </strong>"+place+"</p>"
            +"<p><strong>Date: </strong>"+toDate+"</p>"
        ).addTo(soldierMap);
        unitMarkers.push(marker);
        //console.log(unitMarkers);
        //markerCluster.addLayer(marker);
    });

    soldierMap.panTo(firstLatlng);
    unitMarkers[0].openPopup();
    
//    soldierMap.addLayer(markerCluster);
	
	//alert ('map init done')
	//soldierMap.on('click', onMapClick);
  
});