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
        <table>
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
      </div>
    </div>
  </div>
</div>

<?php 
require_once "footer-new.php";
?>