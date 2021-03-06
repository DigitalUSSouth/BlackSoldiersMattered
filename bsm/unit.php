<?php
$pageTitle = 'Unit';
require_once "header-new.php";
require_once "config.php";
?>
<div class="pad-section">
  <div class="container">
    <div class="row">
      <div style="height:1em;"></div>
      <div class="col-sm-2">
        <img src="images/logo.png" alt="" />
      </div>
      <div class="col-sm-6 text-left">
        
        <?php
          if (!isset($_GET['id'])|| trim($_GET['id'])==""){
              print 'Invalid id';
              die();
          }
          $id = $_GET['id'];
          $units = readJson('data/units.json');
          $camps = readJson('data/camps.json');
          $unit = $units[$id];
          //print '<pre>';var_dump($soldier);print '</pre>';
          print '<h1 class="text-primary">'.$unit['id'].'</h1>';
          print '<table>';
          foreach ($unit as $key=>$val):
            if (empty($val)){
                continue;
            }
            if ($key=='location'):?>
                <tr><th><big><?php print $unitFieldNames[$key];?>:&nbsp;&nbsp;&nbsp;</big></th><td>
                <?php
                foreach ($val as $camp):?>
                  <strong>Camp: </strong><?php print $camp['id'];?>
                  <strong>Date: </strong><?php 
                    if (preg_match('/-00$/',$camp['date'])){
                        $date = $camp['date'];
                        print preg_replace('/-[0-9]{2}$/',"",$date);
                    }
                    else {
                        print $camp['date'];
                    }    
                    ?>
                  <br>
                <?php
                endforeach;?>
                </td></tr>
            <?php
            else:
            ?>
            <tr><th><big><?php print $unitFieldNames[$key];?>:&nbsp;&nbsp;&nbsp;</big></th><td><?php print $val;?></td></tr>
          <?php
            endif;
          endforeach;
        ?>
        </table>
      </div><!-- col-sm-6 -->
      <div class="col-sm-4">
        <a href="units">Back to all units</a>
        <br><br>
        <h4 class="text-primary">Some Soldiers in the Unit:</h4>
        <div class="col-xs-12 scroll-y">
          <?php
            $soldiers = readJson('data/soldiers.json');
            $nSoldiers = array();
            foreach ($soldiers as $soldier){
              foreach ($soldier['unit_progression'] as $sUnit){
                if ($sUnit[0]==$id){
                  $nSoldiers[] = $soldier;
                }
              }
            }
            usort($nSoldiers, function($a, $b)
{
    return strcasecmp($a['last_name'].$a['first_name'], $b['last_name'].$b['first_name']);
});
            foreach ($nSoldiers as $soldier):?>  
                  <a href="soldier?id=<?php print $soldier['id'];?>"><?php print $soldier['last_name'].', '.$soldier['first_name'];?></a><br>
            <?php endforeach;?>
        </div>

        
      </div><!-- col-sm-4-->
    </div><!-- row -->
    <div class="row">
      <div class="col-xs-10 col-xs-offset-2"><h2 class="text-primary">Unit progression</h2></div>
      <div class="col-xs-10 col-xs-offset-2">
        <script src="js/unitPage.js"></script>
        <div id="map-buttons">
          <?php
            $unitCounter = 0;
            foreach ($unit['location'] as $loc):
              //$unitName = $unit[0];
              //$companyName = $unit[1];
              $toDate = $loc['date'];
              $camp = $loc['id'];
              $latlng = $camps[$camp]['latlng'];
              //var_dump( $latlng);
              if ($latlng==NULL) continue;//skip if error
              if ($unitCounter==0):
              ?>
                <button id="unit-button-<?php print $unitCounter;?>" class="btn btn-primary"><?php print $camp; ?></button>
              <?php
              else:
              ?>
                <i class="fa fa-arrow-right"></i><button id="unit-button-<?php print $unitCounter;?>" class="btn btn-default"><?php print $camp; ?></button>
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
          var unit = <?php print json_encode($unit);?>;
          var units = <?php print file_get_contents('data/units.json');?>;
          var camps = <?php print file_get_contents('data/camps.json');?>;
</script>
<?php 
require_once "footer-new.php";
?>