<?php
require_once "header-new.php";
?>
<div id="about" class="pad-section">
  <div class="container">
    <div class="row">
      <div class="col-sm-3">
        <img src="images/logo.png" alt="" />
      </div>
      <div class="col-sm-9 text-left">
        <?php
          $soldiers = readJson('data/soldiers.json');
          //reset($soldiers);
          //$key = key($soldiers);
          //$soldier = $soldiers[$key];
          //print  ($soldier);
          foreach ($soldiers as $soldier):
            print '<h1>'.$soldier['last_name'].', '.$soldier['first_name'].'</h1>';
            foreach ($soldier as $key => $val):?>
              <strong><?php print $key?>:</strong><pre><?php var_dump($val);?></pre>
          <?php 
            endforeach;
            break;
          endforeach;
        ?>
      </div>
    </div>
  </div>
</div>

<?php 
require_once "footer-new.php";
?>