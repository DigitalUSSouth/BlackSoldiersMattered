<?php
$title = 'map-3';

require_once ('../header.php');
require_once ('../functions.php');
?>

<?php 

/*$jsonData = file_get_contents('testdata/soldiers.js');
$soldiers = json_decode($jsonData,true);//'true' will make this return as array instead os StdClass
//var_dump($soldiers);
$newSoldiers = [];
foreach ($soldiers as $soldier){
	//$lat = $soldier['geometry'];//['coordinates'][0][1];
	//var_dump( $lat);
	$newSoldier['latlng'] = [$soldier['geometry']['coordinates'][1][1],
			$soldier['geometry']['coordinates'][1][0]];
	$newSoldiers[] = $newSoldier;
}*/

$fullSoldierLocations = readJson('data/soldierLocations.json');
$soldierLocations = array();
foreach ($fullSoldierLocations as $key => $fullSoldierLocationsItem){
    $soldierLocationsItem = array();
    foreach ($fullSoldierLocationsItem as $latlng){
        //var_dump( $latlng);
        if (!preg_match('/[0-9]{1,2}\.[0-9]{1,5}/',$latlng[0]) || !preg_match('/[0-9]{1,2}\.[0-9]{1,5}/',$latlng[1])) continue; //TODO: add error reporting
        $soldierLocationsItem[] = $latlng;
    }
    $soldierLocations[$key] = $soldierLocationsItem;
}


?>
<script>
var soldierLocations = <?php print json_encode($soldierLocations,JSON_PRETTY_PRINT);?>;

</script>

<?php


//print json_encode($newSoldiers,JSON_PRETTY_PRINT);
/*print json_encode($newSoldiers,JSON_PRETTY_PRINT);
switch (json_last_error()) {
        case JSON_ERROR_NONE:
            echo ' - No errors';
        break;
        case JSON_ERROR_DEPTH:
            echo ' - Maximum stack depth exceeded';
        break;
        case JSON_ERROR_STATE_MISMATCH:
            echo ' - Underflow or the modes mismatch';
        break;
        case JSON_ERROR_CTRL_CHAR:
            echo ' - Unexpected control character found';
        break;
        case JSON_ERROR_SYNTAX:
            echo ' - Syntax error, malformed JSON';
        break;
        case JSON_ERROR_UTF8:
            echo ' - Malformed UTF-8 characters, possibly incorrectly encoded';
        break;
        default:
            echo ' - Unknown error';
        break;
    }*/

?>

    <!-- Content -->
    <div id="page-container">
      <h1>Map 3: static heatmap</h1>
      <div id="testmap3"></div>
      <div id="slider"></div>
    </div>
<?php 
require_once ('../footer.php');
?>
