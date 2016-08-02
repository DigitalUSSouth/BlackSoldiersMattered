<?php
$title = 'slide-13';

require_once ('../header.php');

require ('../visualizationFunctions.php');
?>
    <!-- Content -->
    <div class="row" id="page-container">
      <div class="visualization-container">
        <!-- TODO: Insert map here -->
        <script>
          var 92vs93 = <?php print get92vs93();?>;
        </script>
        <div id="myPie">
        </div>
      </div>
      
    </div>
<?php 
require_once ('../footer.php');
?>
