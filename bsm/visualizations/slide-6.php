<?php
$title = 'slide-6';

require_once ('../header.php');

require ('../visualizationFunctions.php');
?>
    <!-- Content -->
    <div class="row" id="page-container">
      <div class="visualization-container">
        <!-- TODO: Insert map here -->
        <script>
          var inductionPlaceRatio = <?php print getInductionPlaceRatio();?>;
        </script>
        <div id="myPie">
        </div>
      </div>
      
    </div>
<?php 
require_once ('../footer.php');
?>
