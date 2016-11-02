<?php
$pageTitle = 'Soldier';
require_once "header-new.php";
require_once "config.php";
?>
<div id="about" class="pad-section">
  <div class="container">
    <div class="row">
      <div class="col-sm-3">
        <img src="images/logo.png" alt="" />
      </div>
      <div class="col-sm-9 text-left">
        <?php
          if (!isset($_GET['id'])|| trim($_GET['id'])==""){
              print 'Invalid id';
              die();
          }
          $id = $_GET['id'];
          $soldiers = readJson('data/soldiers.json');
          $soldier = $soldiers[$id];
          //print '<pre>';var_dump($soldier);print '</pre>';
          foreach ($soldier as $key=>$val):
            if (empty($val)){
                continue;
            }
            if ($key=='unit_progression'){
                foreach ($val as $unit):?>
                  <p><strong></strong></p>
                <?php
                endforeach;
            }
            else:
            ?>
            <p><strong><?php print $soldierFieldNames[$key];?>:</strong> <?php print $val;?></p>
          <?php
            endif;
          endforeach;
        ?>
      </div>
    </div>
  </div>
</div>

<?php 
require_once "footer-new.php";
?>