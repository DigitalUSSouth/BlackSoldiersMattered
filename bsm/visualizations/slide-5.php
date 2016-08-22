<?php
$title = 'slide-5';

require_once ('../header.php');

require ('../visualizationFunctions.php');
?>
    <!-- Content -->
    <div class="row" id="page-container">
      <div class="visualization-container">
        
        <script>
          var birthPlaceRatio = <?php print getBirthPlaceRatio();?>;
          var birthPlaces = <?php print file_get_contents('../data/birthPlaces.json'); ?>;
        </script>
        <!-- birth place map-->
        <div id="birthPlaceMap" style="height: 400px;">
        </div>
        <div id="myPie">
        </div>
      </div>
      
    </div>
<?php 
require_once ('../footer.php');
?>
