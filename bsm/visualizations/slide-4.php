<?php
$title = 'slide-4';

require_once ('../header.php');

require ('../visualizationFunctions.php');
?>
    <!-- Content -->
    <div class="row" id="page-container">
      <div class="visualization-container">
        <script>
          var overseasVsDomesticPieData = <?php print getUnitsOverseasDomesticPieData(); ?>;
          var domesticUnitsPieData = <?php print getUnitsPieData('Domestic'); ?>;
          var overseasUnitsPieData = <?php print getUnitsPieData('France'); ?>;
        </script>
        <div id="myPie3">
        </div>
        <div id="myPie">
        </div>
        <div id="myPie2">
        </div>
      </div>
      
    </div>
<?php 
require_once ('../footer.php');
?>
