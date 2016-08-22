<html>
<head>

<script src="js/jquery.min.js"></script>
<script src="leaflet/leaflet.js"></script>
<!--<link href="css/bootstrap.min.css" rel="stylesheet">-->
<link rel="stylesheet" href="leaflet/leaflet.css" />


<style>
* {
	margin: 0;
	padding: 0;
}

html, body {
	height: 100%;
}

.maindiv {
	text-align: center;
	margin-left: 50%;
	background: #fafafa;
}

.horizontal1 {
	position: fixed;
	top: 5%;
	left: 0;
	margin-left: -100%;
}


#mapDiv {
    position: fixed;
    top: 0%;
    height: 400px;
    width: 50%;
}

.maindiv h2 {
	padding-bottom: 400px;
}
.horizontal1 p {
	font-size: 200px;
	color: grey;
}

#map-control {
	color:red;
}

</style>

</head>
<body>
<div class="maindiv">
<h2 id="section1">
this is the main div
</h2>
<h2 id="section2">
this is the main div section2
</h2>
<h2 id="section3">
this is the main div section3
</h2>
<h2 id="section4">
this is the main div section4
</h2>
</div>

<div class="horizontal1">
	<p>Horizontal</p>
</div>

<div id="mapDiv">
this is the map div
</div>


<script>

var individualSoldierMap;

$(document).ready(function(){
		$(window).bind('scroll', function(e){
			parallaxScroll();
		});
		function parallaxScroll(){
            //alert('aahhh');
			var scrolledY = $(window).scrollTop();
			//$('.vertical').css('top','+' + ((scrolledY*1.3)) + 'px');
			$('.horizontal1').css('left','+' + ((scrolledY*0.2)) + '%');
			//$('.opacity').css('opacity','0' + (scrolledY*0.001));
		}


     $("#mapDiv").height($(window).height());
     $(window).resize(function(){
         $("#mapDiv").height($(window).height());
     });
     individualSoldierMap = new L.Map('mapDiv');

	// create the tile layer with correct attribution
	var osmUrl='http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
	var osmAttrib='Map data © <a href="http://openstreetmap.org">OpenStreetMap</a> contributors';
	var osm = new L.TileLayer(osmUrl, {minZoom: 2, maxZoom: 12, attribution: osmAttrib});
	//var basemapLayer = new L.TileLayer('http://{s}.tiles.mapbox.com/v3/github.map-xgq2svrz/{z}/{x}/{y}.png');

	// start the map in United Sates
	individualSoldierMap.setView(new L.LatLng(39.57182, -97.60254),4);
	individualSoldierMap.addLayer(osm);

	//map control stuff

var mapUpdateControl = L.Control.extend({
	    options: {
	        position: 'topright'
	    },

	    onAdd: function (map) {
	        // create the control container with a particular class name
	        var container = L.DomUtil.create('div', 'map-update-control');

	        $(container).html('<h1 id="map-control">section 1</h1>');
	        return container;
	    }
	});
	
	newControl = new mapUpdateControl();
	newControl.addTo(individualSoldierMap);




	});

var section1Offset = $("#section1").offset().top;
var section2Offset = $("#section2").offset().top;
var section3Offset = $("#section3").offset().top;
var section4Offset = $("#section4").offset().top;

$(window).on('scroll',function (){
	//alert('yup');
	var y_scroll_pos = window.pageYOffset;
	if (y_scroll_pos >= section1Offset && y_scroll_pos < section2Offset){
		console.log('1');
		$("#map-control").text("section 1");
		return;
	}
	if (y_scroll_pos >= section2Offset && y_scroll_pos < section3Offset){
		console.log('2');
		$("#map-control").text("section 2");
		return;
	}
	if (y_scroll_pos >= section3Offset && y_scroll_pos < section4Offset){
		console.log('3');
		$("#map-control").text("section 3");
		return;
	}
	//TODO: fix this last one so it updates
	if (y_scroll_pos >= section4Offset){
		console.log('4');
		$("#map-control").text("section 4");
		return;
	}
	
});




</script>
<!--<script src="js/bootstrap.min.js"></script>-->
</body>
</html>