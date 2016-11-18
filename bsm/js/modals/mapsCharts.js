$('#mapsChartsModal').on('shown.bs.modal', function()
  {
    if (soldierStatsModalDisplayed) return; //if the modal has been opened before we don't want to redraw everything
    soldierStatsModalDisplayed = true;
    var pie = new d3pie("birthPlacePie", {
	"header": {
		"title": {
			"text": "Born in NC vs Other States",
			"fontSize": 24,
			"font": "open sans"
		},
		"subtitle": {
			"color": "#999999",
			"fontSize": 12,
			"font": "open sans"
		},
		"titleSubtitlePadding": 9
	},
	"footer": {
		"color": "#999999",
		"fontSize": 10,
		"font": "open sans",
		"location": "bottom-left"
	},
	"size": {
		canvasHeight: 500,
		canvasWidth: 750,
		pieInnerRadius: 0,
		pieOuterRadius: null
	},
	"data": {
		"sortOrder": "value-desc",
		"content": birthPlaceRatio
	},
	"labels": {
		"outer": {
			"pieDistance": 32
		},
		"inner": {
			"hideWhenLessThanPercentage": 3
		},
		"mainLabel": {
			"fontSize": 11
		},
		"percentage": {
			"color": "#ffffff",
			"decimalPlaces": 0
		},
		"value": {
			"color": "#adadad",
			"fontSize": 11
		},
		"lines": {
			"enabled": true
		},
		"truncation": {
			"enabled": true
		}
	},
	"effects": {
		"pullOutSegmentOnClick": {
			"effect": "linear",
			"speed": 400,
			"size": 8
		}
	},
	"tooltips": {
		"enabled" : true,
		"type": "placeholder",
		"string": "{label}, {value}"
	},
	"misc": {
		"gradient": {
			"enabled": true,
			"percentage": 100
		}
	}
    });

//induction place pie
var pie = new d3pie("inductionPlacePie", {
	"header": {
		"title": {
			"text": "Inducted in NC vs Other States",
			"fontSize": 24,
			"font": "open sans"
		},
		"subtitle": {
			"color": "#999999",
			"fontSize": 12,
			"font": "open sans"
		},
		"titleSubtitlePadding": 9
	},
	"footer": {
		"color": "#999999",
		"fontSize": 10,
		"font": "open sans",
		"location": "bottom-left"
	},
	"size": {
		canvasHeight: 500,
		canvasWidth: 750,
		pieInnerRadius: 0,
		pieOuterRadius: null
	},
	"data": {
		"sortOrder": "value-desc",
		"content": inductionPlaceRatio
	},
	"labels": {
		"outer": {
			"pieDistance": 32
		},
		"inner": {
			"hideWhenLessThanPercentage": 3
		},
		"mainLabel": {
			"fontSize": 11
		},
		"percentage": {
			"color": "#ffffff",
			"decimalPlaces": 0
		},
		"value": {
			"color": "#adadad",
			"fontSize": 11
		},
		"lines": {
			"enabled": true
		},
		"truncation": {
			"enabled": true
		}
	},
	"effects": {
		"pullOutSegmentOnClick": {
			"effect": "linear",
			"speed": 400,
			"size": 8
		}
	},
	"tooltips": {
		"enabled" : true,
		"type": "placeholder",
		"string": "{label}, {value}"
	},
	"misc": {
		"gradient": {
			"enabled": true,
			"percentage": 100
		}
	}
    });

    // set up the map 
	birthPlaceMap = new L.Map('birthPlaceMap');

	// create the tile layer with correct attribution
	var osmUrl='http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
	var osmAttrib='Map data © <a href="http://openstreetmap.org">OpenStreetMap</a> contributors';
	var osm = new L.TileLayer(osmUrl, {minZoom: 2, maxZoom: 12, attribution: osmAttrib});
	var basemapLayer = new L.TileLayer('http://{s}.tiles.mapbox.com/v3/github.map-xgq2svrz/{z}/{x}/{y}.png');

	// start the map in United Sates 
	birthPlaceMap.setView(new L.LatLng(39.57182, -97.60254),4);
	birthPlaceMap.addLayer(osm);
	
	var birthMarkers = L.markerClusterGroup();
console.log('created layers')
	$.each(birthPlaces,function (key,mkr){
		
		if (key=="" || mkr[0]==null || mkr[1]==null) return; //if key is blank then it's an invalid marker so we just return
		//console.log(key+' '+mkr);
		var marker = L.marker(mkr,{title:key}).bindPopup(key);//.addTo(birthPlaceMap);
		birthMarkers.addLayer(marker);
	});

	birthPlaceMap.addLayer(birthMarkers);


    // set up the map 
	inductionPlaceMap = new L.Map('inductionPlaceMap');

	// create the tile layer with correct attribution
	var osmUrl='http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
	var osmAttrib='Map data © <a href="http://openstreetmap.org">OpenStreetMap</a> contributors';
	var osm = new L.TileLayer(osmUrl, {minZoom: 2, maxZoom: 12, attribution: osmAttrib});
	var basemapLayer = new L.TileLayer('http://{s}.tiles.mapbox.com/v3/github.map-xgq2svrz/{z}/{x}/{y}.png');

	// start the map in United Sates
	inductionPlaceMap.setView(new L.LatLng(39.57182, -97.60254),4);
	inductionPlaceMap.addLayer(osm);
	
	var inductionMarkers = L.markerClusterGroup();
console.log('created layers')
	$.each(inductionPlaces,function (key,mkr){
		
		if (key=="" || mkr[0]==null || mkr[1]==null) return; //if key is blank then it's an invalid marker so we just return
		//console.log(key+' '+mkr);
		var marker = L.marker(mkr,{title:key}).bindPopup(key);//.addTo(birthPlaceMap);
		inductionMarkers.addLayer(marker);
	});

	inductionPlaceMap.addLayer(inductionMarkers);
    
    
    
    // set up the map 
	residencePlaceMap = new L.Map('residencePlaceMap');

	// create the tile layer with correct attribution
	var osmUrl='http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
	var osmAttrib='Map data © <a href="http://openstreetmap.org">OpenStreetMap</a> contributors';
	var osm = new L.TileLayer(osmUrl, {minZoom: 2, maxZoom: 12, attribution: osmAttrib});
	var basemapLayer = new L.TileLayer('http://{s}.tiles.mapbox.com/v3/github.map-xgq2svrz/{z}/{x}/{y}.png');

	// start the map in United Sates
	residencePlaceMap.setView(new L.LatLng(35.131547,-79.4294789),7);
	residencePlaceMap.addLayer(osm);
	
	var residenceMarkers = L.markerClusterGroup();
console.log('created layers')
	$.each(residencePlaces,function (key,mkr){
		
		if (key=="" || mkr[0]==null || mkr[1]==null) return; //if key is blank then it's an invalid marker so we just return
		//console.log(key+' '+mkr);
		var marker = L.marker(mkr,{title:key}).bindPopup(key);//.addTo(birthPlaceMap);
		residenceMarkers.addLayer(marker);
	});

	residencePlaceMap.addLayer(residenceMarkers);


// set up camps map 
	campsMap = new L.Map('campsMap');

	// create the tile layer with correct attribution
	var osmUrl='http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
	var osmAttrib='Map data © <a href="http://openstreetmap.org">OpenStreetMap</a> contributors';
	var osm = new L.TileLayer(osmUrl, {minZoom: 2, maxZoom: 12, attribution: osmAttrib});
	var basemapLayer = new L.TileLayer('http://{s}.tiles.mapbox.com/v3/github.map-xgq2svrz/{z}/{x}/{y}.png');

	// start the map in United Sates
	campsMap.setView(new L.LatLng(35.131547,-63.4294789),3);
	campsMap.addLayer(osm);

var markerTypes = {
	"National Army" : L.AwesomeMarkers.icon({
        icon: 'map-pin',
        markerColor: 'red'
      }),
	"Regular Army (National Guard)" : L.AwesomeMarkers.icon({
        icon: 'map-pin',
        markerColor: 'blue'
      }),
	"Port of Embarkation" : L.AwesomeMarkers.icon({
        icon: 'map-pin',
        markerColor: 'orange'
      }),
	"Embarkation Camp" : L.AwesomeMarkers.icon({
        icon: 'map-pin',
        markerColor: 'grey'
      }),
	"Students' Army Training Corps School" : L.AwesomeMarkers.icon({
        icon: 'map-pin',
        markerColor: 'purple'
      }),
	"Regular Army Camps" : L.AwesomeMarkers.icon({
        icon: 'map-pin',
        markerColor: 'green'
      }),
	"French Ports" : L.AwesomeMarkers.icon({
        icon: 'map-pin',
        markerColor: 'black'
      }),
	"Miscellaneous" : L.AwesomeMarkers.icon({
        icon: 'map-pin',
        markerColor: 'lightblue'
      })
  };

var redMarker = L.AwesomeMarkers.icon({
    icon: 'map-pin',
    markerColor: 'red'
  });

  var blueMarker = L.AwesomeMarkers.icon({
    icon: 'map-pin',
    markerColor: 'blue'
  });

  //L.marker([34.941196,-87.512291], {icon: redMarker}).addTo(campsMap);	
	var campsMarkers = L.markerClusterGroup();
//console.log('created layers')
	$.each(campsPlaces,function (key,mkr){
		console.log(mkr);
	    if (key=="" || mkr.id==null || mkr.type==null) return; //if key is blank then it's an invalid marker so we just return
		//console.log(key+' '+mkr);
		var cat = mkr.type;
		console.log(cat);
		var markerType = markerTypes[cat];
		console.log(markerType);
		var marker = L.marker(mkr.latlng,{title:key, icon:markerType}).bindPopup(key);//.addTo(campsMap);
		campsMarkers.addLayer(marker);
	});

	campsMap.addLayer(campsMarkers);




});//$('#mapsChartsModal').on('shown.bs.modal', function()