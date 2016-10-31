  <?php 
  /* These are the modals for individual visualizations
   * Add here and link from the appropriate place to display
   */
  ?>
  <!-- Modals -->
<div id="timelinesModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Entrance status</h4>
      </div>
      <div class="modal-body">
        <iframe src="bubbles/index.html" style="width:100%;height:800px;"></iframe>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<div id="dischargeDateModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Discharge Date</h4>
      </div>
      <div class="modal-body">
        <h3 class="text-danger">We can customize/refine the look/feel of these charts</h3>
        <h2>Discharge date for all soldiers</h2>
        <div id="graphDischargeDateAll" style="width:100%; height:300px;"></div>
        <h2>Compare domestic vs. overseas soldiers' discharge dates</h2>
        <div id="graphDischargeDateCompare" style="width:100%; height:300px;"></div>
        <script src="js/modals/dischargeDateModal.js"></script>
        <h2 class="text-danger">TODO: add comparison for labor vs combat for overseas soldiers</h2>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<div id="overseasStatsModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Unit Statistics</h4>
      </div>
      <div class="modal-body">
        <script src="js/modals/overseasStats.js"></script>
        <script>
          var unitStatsModalDisplayed = false;
          var overseasVsDomesticPieData = <?php print getUnitsOverseasDomesticPieData(); ?>;
          var domesticUnitsPieData = <?php print getUnitsPieData('Domestic'); ?>;
          var overseasUnitsPieData = <?php print getUnitsPieData('France'); ?>;
        </script> 
        <div id="overseasDomesticUnitsPie">
        </div>
        <div id="domesticUnitsPie">
        </div>
        <div id="overseasUnitsPie">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<div id="mapsChartsModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Soldier Locations</h4>
      </div>
      <div class="modal-body">
        <script src="js/modals/mapsCharts.js"></script>
        <!-- TODO: Insert map here -->
        <script>
          var soldierStatsModalDisplayed = false;
          var birthPlaceRatio = <?php print getBirthPlaceRatio();?>;
          var birthPlaces = <?php print file_get_contents('data/birthPlaces.json'); ?>;

          var inductionPlaceRatio = <?php print getInductionPlaceRatio();?>;
          var inductionPlaces = <?php print file_get_contents('data/inductionPlaces.json'); ?>;

          var residencePlaces = <?php print file_get_contents('data/residencePlaces.json'); ?>;

          var campsPlaces = <?php print file_get_contents('data/campsPlaces.json'); ?>;

        </script>
        <h1 class="text-primary">Birth</h1>
        <div id="birthPlaceMap" style="height: 400px;"></div>
        <div id="birthPlacePie">
        </div>
        <!--
        <iframe src="visualizations/slide-5" style="width:100%;height:1000px;"></iframe> -->
        <h1 class="text-primary">Induction</h1>
        <div id="inductionPlaceMap" style="height: 400px;"></div>
        <div id="inductionPlacePie">
        </div>

        <h1 class="text-primary">Residence</h1>
        <div id="residencePlaceMap" style="height: 400px;"></div>

        <h1 class="text-primary">Camps</h1>
        <div id="campsMap" style="height: 400px;"></div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<div id="allSoldiersJourneyModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Collective Journey</h4>
      </div>
      <div class="modal-body">
        <script src="js/modals/allSoldiersJourney.js"></script>
        <script>
        var allSoldiersJourneyModalDisplayed = false;
        </script>
<?php
        $fullSoldierLocations = readJson('data/soldierLocations.json');
$soldierLocations = array();
foreach ($fullSoldierLocations as $key => $fullSoldierLocationsItem){
    $soldierLocationsItem = array();
    foreach ($fullSoldierLocationsItem as $latlng){
        //var_dump( $latlng);
        if (!preg_match('/[0-9]{1,3}\.[0-9]{1,5}/',$latlng[0]) || !preg_match('/[0-9]{1,3}\.[0-9]{1,5}/',$latlng[1])) continue; //TODO: add error reporting
        $soldierLocationsItem[] = $latlng;
    }
    $soldierLocations[$key] = $soldierLocationsItem;
}


?>
<script>
var soldierLocations = <?php print json_encode($soldierLocations,JSON_PRETTY_PRINT);?>;

</script>
        <script>
          var map3;
          var markers = [];
          var heat;
        </script>
        <div id="allSoldiersJourneyMap"></div>
        <div id="slider1"></div>
        <div id="dateDisplay">1913-8</div>
        <?php 
        //print sizeof($soldierLocations['1918-4']);
        ?>
        <h2 class="text-danger">Data here is cleaned up, but needs to be updated to display on the map.</h2>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>