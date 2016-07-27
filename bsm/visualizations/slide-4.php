<?php
$title = 'slide-4';

require_once ('../header.php');

require ('../visualizationFunctions.php');
?>
    <!-- Content -->
    <div id="page-container">
      <div class="visualization-container">
        <script>
          var domesticUnitsPieData = <?php print getDomesticUnitsPieData(); ?>;
        </script>
        <div id="myPie">
          </div>
      </div>
      
    </div>
<?php 
require_once ('../footer.php');
?>
