<?php
$pageTitle = 'Soldiers';
require_once "header-new.php";
?>
<div id="about" class="pad-section">
  <div class="container">
    <div class="row">
      <div class="col-sm-1">
        <img src="images/logo.png" alt="" />
      </div>
      <div class="col-sm-11 text-left">
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

          foreach($azArray as $letter => $letterUnits):?>
            <div class="col-xs-3">
              <h2 id="<?php print $letter; ?>"><?php print ($letter=="")?"Uncategorized":$letter;?></h2>
              <?php foreach ($letterUnits as $unit):?>
                <a href="unit?id=<?php print $unit['id']?>"><?php print $unit['id'];?></a><br>
              <?php
              endforeach;?>
            </div>
            <?php
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