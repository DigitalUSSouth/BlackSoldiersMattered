<?php
$pageTitle = 'Soldiers';
require_once "header-new.php";
?>
<div class="pad-section">
  <div class="container">
    <div class="row">
      <div style="height:1em;"></div>
      <div class="col-xs-12">
        <script src="js/soldiers.js"></script>
        <div class="col-xs-3 pull-right">
              <span></span>
              <input id="nameInput" class="form-control awesomplete pull-right" placeholder="Type a name" list="names-list" name="contributor[]">
              <?php require ("namesList.php"); ?>
              </div>
      </div>

      <div class="col-sm-4">
        <img src="images/logo.png" alt="" />
      </div>
      <div class="col-sm-8 text-left">
        <?php
          $soldiers = readJson('data/soldiers.json');
          $combinedSoldiers = readJson('data/combined-soldiers.json');
          $collectiveSoldiers = readJson('data/collective-soldiers.json');
          //reset($soldiers);
          //$key = key($soldiers);
          //$soldier = $soldiers[$key];
          //print  ($soldier);
          /*usort($soldiers, function($a, $b)
{
    return strcasecmp($a['last_name'].$a['first_name'], $b['last_name'].$b['first_name']);
});
          usort($combinedSoldiers, function($a, $b)
{
    return strcasecmp($a['last_name'].$a['first_name'], $b['last_name'].$b['first_name']);
});
          usort($collectiveSoldiers, function($a, $b)
{
    return strcasecmp($a['last_name'].$a['first_name'], $b['last_name'].$b['first_name']);
});*/
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
          foreach ($combinedSoldiers as $soldier):
            if (trim($soldier['last_name'])==''){
                //empty so we skip
                continue;
            }
            //print $soldier['last_name'].'<br>';
            $currentLetter = strtoupper($soldier['last_name'][0]);
            if (!array_key_exists($currentLetter,$azArray)){
                //if needed we add letter to array
                $azArray[$currentLetter] = array();
            }
            $azArray[$currentLetter][] = $soldier;
            //break;
          endforeach;
          foreach ($collectiveSoldiers as $soldier):
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
          
          

          ksort($azArray);


          $counter = 0;
          foreach($azArray as $letter => $letterSoldiers):
            usort($letterSoldiers, function($a, $b)
{
    return strcasecmp($a['last_name'].$a['first_name'], $b['last_name'].$b['first_name']);
});
          ?>
            <div class="panel-group">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h4 class="panel-title">
                    <a data-toggle="collapse" href="#collapse<?php print $counter;?>"><?php print $letter;?></a>
                  </h4>
                </div>
                <div id="collapse<?php print $counter;?>" class="panel-collapse collapse">
                  <div class="panel-body">
                    <?php 
                    
                    
                    foreach ($letterSoldiers as $soldier):?>
                      <a href="soldier?id=<?php print $soldier['id']?>"><?php print $soldier['last_name'].', '.$soldier['first_name'];?></a><br>
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