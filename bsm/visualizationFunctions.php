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
             "value" => $domesticCount,
         ),
         array(
             "label" => 'Overseas Units',
             "value" => $overseasCount
         )
     );

     return json_encode($content,JSON_PRETTY_PRINT);

 }
 ?>