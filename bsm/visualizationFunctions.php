<?php /* visualizationFunctions.php 
 * functions used for data visualization 
 */


require_once 'functions.php';

 /**
 * function to return json data to use in pie chart for domestic units
 * @param {string}: "Domestic" or "France""
 * @return {string}: json-formatted string
 */
 function getUnitsPieData($serviceLocation){

     $units = readJson('data/units.json');

     $content = array();
     $unitTypes = array();


     //TODO: combine the next two loops into one for performance
     foreach ($units as $unit){
         if ($unit['service_location']==$serviceLocation){
             $unitTypes[$unit['category']] = 0;
         }
     }
     foreach ($units as $unit){
         if ($unit['service_location']==$serviceLocation){
             $unitTypes[$unit['category']]++;
         }
     }

     foreach ($unitTypes as $type => $count){
         $content[] = array(
             "label" => $type,
             "value" => $count/*,
             "color" => "#2484c1"*/
         );
     }

     $jsonContent = json_encode($content,JSON_PRETTY_PRINT);

     //var_dump($jsonContent);
     return $jsonContent;
 }

 /**
 * function to return json data to use in pie chart for domestic units
 * @param {}: none
 * @return {string}: json-formatted config object for d3pie
 */
 function getUnitsOverseasDomesticPieData(){

     $units = readJson('data/units.json');

     $domesticCount = 0;
     $overseasCount = 0;

     foreach ($units as $unit){
         if ($unit['service_location']=='France'){
             $overseasCount++;
         }
         else if ($unit['service_location']=='Domestic'){
             $domesticCount++;
         }
     }

     $content = array(
         array(
             "label" => 'Domestic Units',
             "value" => $domesticCount
         ),
         array(
             "label" => 'Overseas Units',
             "value" => $overseasCount
         )
     );

     return json_encode($content,JSON_PRETTY_PRINT);

 }

/**
 * function to return json data to use in pie chart for birth place ratio
 * @param {none}
 * @return {string}: json-formatted string
 */
function getBirthPlaceRatio(){
    $soldierStats = readJson('data/soldierStats.json');
    $birthPlaceRatio = array(
         array(
             "label" => 'Born in North Carolina',
             "value" => $soldierStats['birth_place_NC']
         ),
         array(
             "label" => 'Born in other states',
             "value" => $soldierStats['birth_place_other']
         )
    );
    return json_encode($birthPlaceRatio,JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);
}

/**
 * function to return json data to use in pie chart for induction place ratio
 * @param {none}
 * @return {string}: json-formatted string
 */
function getInductionPlaceRatio(){
    $soldierStats = readJson('data/soldierStats.json');
    $inductionPlaceRatio = array(
         array(
             "label" => 'Inducted in North Carolina',
             "value" => $soldierStats['induction_place_NC']
         ),
         array(
             "label" => 'Inducted in other states',
             "value" => $soldierStats['induction_place_other']
         )
    );
    return json_encode($inductionPlaceRatio,JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);
}

/**
 * function to return json data to use in pie chart
 * @param {none}
 * @return {string}: json-formatted string
 */
function get92vs93(){
    $soldierStats = readJson('data/soldierStats.json');
    $inductionPlaceRatio = array(
         array(
             "label" => '92nd Division',
             "value" => $soldierStats['total_92_division']
         ),
         array(
             "label" => '93rd Division',
             "value" => $soldierStats['total_93_division']
         )
    );
    return json_encode($inductionPlaceRatio,JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);
}
 ?>