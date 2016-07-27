<?php /* visualizationFunctions.php 
 * functions used for data visualization 
 */


 /**
 * function to return json data to use in pie chart for domestic units
 * @param {string}: "Domestic" or "France""
 * @return {string}: json-formatted string
 */
 function getUnitsPieData($serviceLocation){
     //$unitsJson = file_get_contents('data/units.json');

     //TODO: fix file permission issues to use file_get_contents instead of curl
     $ch = curl_init();
	curl_setopt_array($ch, array(
      CURLOPT_RETURNTRANSFER => 1,
      CURLOPT_URL => ROOT_FOLDER.'data/units.json',
	));
	
	$unitsJson = curl_exec($ch);
	if (curl_error($ch)){
		throw new Exception('Unable to read units.json file.');
	}

     $units = json_decode($unitsJson,true);

     $content = array();
     $unitTypes = array();


     //TODO: combine the next two loops into one for performance
     foreach ($units as $unit){
         if ($unit['service_location']==$serviceLocation){
             $unitTypes[$unit['type']] = 0;
         }
     }
     foreach ($units as $unit){
         if ($unit['service_location']==$serviceLocation){
             $unitTypes[$unit['type']]++;
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
 ?>