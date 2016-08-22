$(document).ready(function(){
    var pie = new d3pie("myPie", {
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
	
	var markers = L.markerClusterGroup();
console.log('created layers')
	$.each(birthPlaces,function (key,mkr){
		
		if (key=="" || mkr[0]==null || mkr[1]==null) return; //if key is blank then it's an invalid marker so we just return
		console.log(key+' '+mkr);
		var marker = L.marker(mkr,{title:key}).bindPopup(key);//.addTo(birthPlaceMap);
		markers.addLayer(marker);
	});

	birthPlaceMap.addLayer(markers);

});