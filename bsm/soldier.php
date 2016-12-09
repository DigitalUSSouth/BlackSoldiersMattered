<?php
$pageTitle = 'Soldier';
require_once "header-new.php";
require_once "config.php";
?>
<div class="pad-section">
  <div class="container">
    <div class="row">
      <div style="height:1em;"></div>
      <div class="col-sm-3">
        <img src="images/logo.png" alt="" />
      </div>
      <div class="col-sm-6 text-left">
        
        <?php
          if (!isset($_GET['id'])|| trim($_GET['id'])==""){
              print 'Invalid id';
              die();
          }
          $id = $_GET['id'];
          $picPath = $id;
          $picPath = preg_replace('/\.tif/','.jpg',$picPath);
          $soldiers = readJson('data/soldiers.json');
          $units = readJson('data/units.json');
          $camps = readJson('data/camps.json');
          $soldier = $soldiers[$id];
          //print '<pre>';var_dump($soldier);print '</pre>';
          print '<h1 class="text-primary">'.$soldier['last_name'].', '.$soldier['first_name'].'</h1>';
          print '<table>';
          foreach ($soldier as $key=>$val):
            if (empty($val)){
                continue;
            }
            if ($key=='unit_progression'):?>
                <tr><th><big><?php print $soldierFieldNames[$key];?>:&nbsp;</big></th><td>
                <?php
                foreach ($val as $unit):?>
                  <strong>Unit: </strong><?php print $unit[0];?>
                  <strong>Company: </strong><?php print $unit[1];?>
                  <strong>To date: </strong><?php print $unit[2];?>
                  <br>
                <?php
                endforeach;?>
                </td></tr>
            <?php
            else:
            ?>
            <tr><th><big><?php print $soldierFieldNames[$key];?>:&nbsp;</big></th><td><?php print $val;?></td></tr>
          <?php
            endif;
          endforeach;
        ?>
        </table>
      </div><!-- col-sm-6 -->
      <div class="col-sm-3">
        <!-- Trigger the modal with a button -->
<a data-toggle="modal" data-target="#cardModal">
  <img src="<?php print ROOT_FOLDER.'data/bsm-imgs/'.$picPath; ?>" class="img-responsive" />
</a>

<!-- Modal -->
<div id="cardModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Service card</h4>
      </div>
      <div class="modal-body">
        <img src="<?php print ROOT_FOLDER.'data/bsm-imgs/'.$picPath; ?>" class="img-responsive" />
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
      </div><!-- col-sm-3 -->
    </div><!-- row -->
    <div class="row">
      <div class="col-xs-10 col-xs-offset-1"><h2 class="text-primary">Unit progression</h2></div>
      <div class="col-xs-10 col-xs-offset-1">
        <script src="js/soldierPage.js"></script>
        <div id="map-buttons">
          <?php
            $unitCounter = 0;
            foreach ($soldier['unit_progression'] as $unit):
              $unitName = $unit[0];
              $companyName = $unit[1];
              $toDate = $unit[2];
              $camp = $units[$unitName]['location'][0]['id'];
              $latlng = $camps[$camp]['latlng'];
              //var_dump( $latlng);
              if ($latlng==NULL) continue;//skip if error
              if ($unitCounter==0):
              ?>
                <button id="unit-button-<?php print $unitCounter;?>" class="btn btn-primary"><?php print $unitName; ?></button>
              <?php
              else:
              ?>
                <i class="fa fa-arrow-right"></i><button id="unit-button-<?php print $unitCounter;?>" class="btn btn-default"><?php print $unitName; ?></button>
              <?php
              endif;
              ?>
                <script>
                  $("#unit-button-<?php print $unitCounter;?>").click(function(e){
                    //alert('hi<?php print $unitCounter;?>');
                    soldierMap.panTo(<?php print json_encode($latlng);?>);
                    unitMarkers[<?php print $unitCounter;?>].openPopup();
                  });
	    </script>
              <?php
              $unitCounter++;
            endforeach;
          ?>
        </div><!-- map-buttons -->
        <div id="soldierMap" style="height: 400px;">
        </div><!-- soldierMap -->
      </div><!-- col-xs-10 -->
    </div><!-- row -->
  </div>
</div>
<script>
          var soldier = <?php print json_encode($soldier);?>;
          var units = <?php print file_get_contents('data/units.json');?>;
          var camps = <?php print file_get_contents('data/camps.json');?>;
</script>
<?php 
require_once "footer-new.php";
?>