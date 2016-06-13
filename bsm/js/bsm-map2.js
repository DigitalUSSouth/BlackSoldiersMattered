



$(function() {
    // Get start/end times
    var startTime = new Date(soldiers[0].properties.time[0]);
    var endTime = new Date(soldiers[0].properties.time[soldiers[0].properties.time.length - 1]);

    // Create a DataSet with data
    var timelineData = new vis.DataSet([{ start: startTime, end: endTime, content: 'Demo GPS Tracks' }]);

    // Set timeline options
    var timelineOptions = {
      "width":  "100%",
      "height": "80px",
      "type": "background",
      "align": "auto",
      "showCurrentTime":false
    };
    var container = document.getElementById('timeline');
    // Setup timeline
    var timeline = new vis.Timeline(container, timelineData, timelineOptions);
        
    // Set custom time marker (blue)
    timeline.addCustomTime(startTime);

    // Setup leaflet map
    var map = new L.Map('testmap2');

    var basemapLayer = new L.TileLayer('http://{s}.tiles.mapbox.com/v3/github.map-xgq2svrz/{z}/{x}/{y}.png');

    // start the map in United Sates
	map.setView(new L.LatLng(39.57182, -97.60254),4);

    // Adds the background layer to the map
    map.addLayer(basemapLayer);



    // =====================================================
    // =============== Playback ============================
    // =====================================================
    
    // Playback options
    var playbackOptions = {

        playControl: true,
        dateControl: true,
        
        // layer and marker options
        layer : {
            pointToLayer : function(featureData, latlng) {
                var result = {};
                
                if (featureData && featureData.properties && featureData.properties.path_options) {
                    result = featureData.properties.path_options;
                }
                
                if (!result.radius){
                    result.radius = 5;
                }
                
                return new L.CircleMarker(latlng, result);
            }
        },
        
        marker: { 
            getPopup: function(featureData) {
                var result = '';
                
                if (featureData && featureData.properties && featureData.properties.title) {
                    result = featureData.properties.title;
                }
                
                return result;
            }
        }
        
    };
        
    // Initialize playback
    var playback = new L.Playback(map, null, onPlaybackTimeChange, playbackOptions);
    
    playback.setData(soldiers);    
   // playback.addData(blueMountain);

    // Uncomment to test data reset;
    //playback.setData(blueMountain);    
    
    // Set timeline time change event, so cursor is set after moving custom time (blue)
    timeline.on('timechange', onCustomTimeChange);    

    // A callback so timeline is set after changing playback time
    function onPlaybackTimeChange (ms) {
        timeline.setCustomTime(new Date(ms));
    };
    
    // 
    function onCustomTimeChange(properties) {
        if (!playback.isPlaying()) {
            playback.setCursor(properties.time.getTime());
        }        
    }       
});
