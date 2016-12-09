<datalist id="names-list">
    <?php 
    //include "functions.php";
    $soldiers = readJson('data/soldiers.json');
    foreach ($soldiers as $soldier):
    if (trim($soldier['id'])=="") continue;?>
<option value="<?php print $soldier['id']; ?>"><?php print $soldier['last_name'].', '.$soldier['first_name'];?></option>
    <?php endforeach;?>
</datalist>