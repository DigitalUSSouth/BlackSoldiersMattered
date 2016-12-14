<?php
$pageTitle = 'Units';
require_once "header-new.php";
?>
<div class="pad-section">
  <div class="container">
    <div class="row">
      <div style="height:1em;"></div>
      <div class="col-sm-4">
        <img src="images/logo.png" alt="" />
      </div>
      <div class="col-sm-8 text-left">
        
        <?php
          $units = readJson('data/units.json');
          //reset($units);
          //$key = key($units);
          //$unit = $units[$key];
          //print  ($unit);
          usort($units, function($a, $b)
{
    return strcasecmp($a['category'].$a['id'], $b['category'].$b['id']);
});
//var_dump($units);
          $azArray = array();
          foreach ($units as $unit):
            if (trim($unit['id'])==''){
                //empty so we skip
                continue;
            }
            $currentLetter = strtoupper($unit['category']);
            if (!array_key_exists($currentLetter,$azArray)){
                //if needed we add letter to array
                $azArray[$currentLetter] = array();
            }
            $azArray[$currentLetter][] = $unit;
            //break;
          endforeach;
          
          foreach ($azArray as $key=>$value):
          continue;
          ?>
            <a href="#<?php print $key?>"><?php print $key;?></a>&nbsp;
          <?php
          endforeach;
          $counter=0;
          foreach($azArray as $letter => $letterUnits):?>
            <div class="panel-group">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h4 class="panel-title">
                    <a data-toggle="collapse" href="#collapse<?php print $counter;?>">
  <?php print ($letter=="")?"Uncategorized":$letter;?>
                      
                    </a>
                  </h4>
                </div>
                <div id="collapse<?php print $counter;?>" class="panel-collapse collapse">
                  <div class="panel-body">
                    <?php foreach ($letterUnits as $unit):?>
                      <a href="unit?id=<?php print $unit['id']?>"><?php print $unit['id'];?></a><br>
                    <?php
                    endforeach;?>
                  </div>
                  <!--<div class="panel-footer">Panel Footer</div>-->
                </div>
              </div>
            </div>

            <?php
            $counter++;
          endforeach
          //print '<pre>';var_dump($azArray);print '</pre>';
        ?>
      </div>
    </div>
  </div>
</div>

<?php 
require_once "footer-new.php";
?>