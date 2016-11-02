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
          $soldiers = readJson('data/soldiers.json');
          //reset($soldiers);
          //$key = key($soldiers);
          //$soldier = $soldiers[$key];
          //print  ($soldier);
          usort($soldiers, function($a, $b)
{
    return strcasecmp($a['last_name'].$a['first_name'], $b['last_name'].$b['first_name']);
});
//var_dump($soldiers);
          $azArray = array();
          foreach ($soldiers as $soldier):
            if (trim($soldier['last_name'])==''){
                //empty so we skip
                continue;
            }
            $currentLetter = strtoupper($soldier['last_name'][0]);
            if (!array_key_exists($currentLetter,$azArray)){
                //if needed we add letter to array
                $azArray[$currentLetter] = array();
            }
            $azArray[$currentLetter][] = $soldier;
            //break;
          endforeach;
          
          foreach ($azArray as $key=>$value):
          ?>
            <a href="#<?php print $key?>"><?php print $key;?></a>&nbsp;
          <?php
          endforeach;

          foreach($azArray as $letter => $letterSoldiers):?>
            <div class="col-xs-3">
              <h2 id="<?php print $letter; ?>"><?php print $letter;?></h2>
              <?php foreach ($letterSoldiers as $soldier):?>
                <a href="soldier?id=<?php print $soldier['id']?>"><?php print $soldier['last_name'].', '.$soldier['first_name'];?></a><br>
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