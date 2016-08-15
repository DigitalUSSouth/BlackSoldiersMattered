<?php
$title = 'slide-6';

require_once ('../header.php');

require ('../visualizationFunctions.php');
?>
    <!-- Content -->
    <div class="row" id="page-container">
      <div class="visualization-container">
      <script>
          var inductionPlaceRatio = <?php print getInductionPlaceRatio();?>;
          var inductionPlaces = <?php print file_get_contents('../data/inductionPlaces.json'); ?>;
        </script>
        <!-- induction place map-->
        <div id="inductionPlaceMap" style="height: 400px;">
        </div>
        
        <div id="myPie">
        </div>
      </div>

      
    </div>
<?php 
require_once ('../footer.php');
?>
