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
          $combinedSoldiers = readJson('data/combined-soldiers.json');
          $collectiveSoldiers = readJson('data/collective-soldiers.json');
          $units = readJson('data/units.json');
          $camps = readJson('data/camps.json');
          if (array_key_exists($id,$soldiers)){
            $soldier = $soldiers[$id];
          }
          else if (array_key_exists($id,$combinedSoldiers)) {
            $soldier = $combinedSoldiers[$id];
          }
          else if (array_key_exists($id,$collectiveSoldiers)){
            $soldier = $collectiveSoldiers[$id];
          }
          else {
            die();
          }
          //print '<pre>';var_dump($soldier);print '</pre>';
          print '<h1 class="text-primary">'.$soldier['last_name'].', '.$soldier['first_name'].'</h1>';
          print '<table>';?>
          <?php
          $keys[] ='last_name';
          $keys[] ='first_name';
          $keys[] ='residence_county';
          $keys[] ='residence_city';
          $keys[] ='birth_place';
          $keys[] ='age';
          $keys[] ='induction_status';
          $keys[] ='induction_place';
          $keys[] ='induction_date';
          $keys[] ='unit_progression';
          $keys[] ='engagements';
          $keys[] ="service_date_start";
          $keys[] ="service_date_end";
          $keys[] = "discharge_date";
          $keys[] ="discharge_date_notes";
          $keys[] ="wounded";
          $keys[] ="death_date";
          $keys[] ="death_cause";
          $keys[] ="death_notified";

          foreach ($keys as $key):
          if (!array_key_exists($key,$soldier)) continue;
          $val = $soldier[$key];
            if (empty($val)){
                continue;
            }
            if ($key=='unit_progression'):?>
                <tr><th><big><?php print $soldierFieldNames[$key];?>:&nbsp;</big></th><td>
                <?php
                foreach ($val as $unit):?>
                  <strong>Unit: </strong>
                  <?php 
                  $isUnit = true;
                  if (array_key_exists($unit[0],$units)):?>
                  <a href="unit?id=<?php print $unit[0];?>"><?php print $unit[0];?></a>
                  <?php else:
                  $isUnit = false;?>
                  <?php print $unit[0];?>
                  <?php endif; ?>
                  
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
        <a href="soldiers">Back to all soldiers</a>
        <div style="height:4em;"></div>
        <!-- Trigger the modal with a button -->
<a data-toggle="modal" data-target="#cardModal">
  <h4>View soldier service card</h4>
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
    <?php if ($isUnit):?>
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
    <?php endif;?>
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