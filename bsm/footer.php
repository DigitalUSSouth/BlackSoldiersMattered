    </div>

    
    <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/bootstrap.min.js"></script>

    <!--Slick --
    <?php //do we realy need slick??
	//I don't think so. ?>
    <script type="text/javascript" src="slick/slick.min.js"></script> -->
    
   <!-- Vis Timeline -->
   <script src="vis/vis.js"></script>
   <link href="vis/vis.css" rel="stylesheet"       type="text/css" />

    <?php /*
    TODO: make loading of leaflet stuff conditional only for pages that use map
    */?>
    <!-- leaflet test data -->
    <script src="testdata/demo-tracks.js"></script>
    <script src="testdata/test.js"></script>
    <!-- leaflet playback module -->
    <?php //TODO: update to minified js when debugging is done?>
    <script src="leaflet/LeafletPlayback/LeafletPlayback.js"></script>
    

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
