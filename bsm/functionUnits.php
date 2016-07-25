<?php
/**functionUnits.php
 * defines functions used throughout site
 */

/**
 * catch-all function to handle exceptions
 * @param {type} 
 * @return {type}
 */
 function handleException(){
 	//todo this function should handle the any exceptions and gracefully exit the script
 }
 
 
 
/**
 * Import tab-delimited file for Units and
 * create unit.json files
 */
function importUnits(){
	ini_set("auto_detect_line_endings", true);
	$file = NULL;
	
	try {
		$file = new SplFileObject("uploads/units.txt");
	}
	catch (Exception $error){
		echo '<div class="jumbotron"><h1 class="text-danger">Unable to open uploaded file. Please try again.</h1><p>'.$error->getMessage().'</p></div>';
		return;
	}

 $counter=0;
 $units = array();

 try{
	while($line = $file->fgets()){
		//discard first 4 lines
		//TODO: move this outside of loop for performance
		if ($counter++ < 4) {/*echo $line;*/continue;}
		
		//read every other line until the end of file
		//excel will add double quotes around cells that contain commas
		//remove double quotes if they are at the edge of a cell
		//echo $line.'<br>';
		$line = preg_replace('/\\t"/',"\t", $line);
		//echo $line.'<br>';
		$line = preg_replace('/"\\t/',"\t", $line);
		//print $line.'<br>';
		
		$fields = explode("\t",$line);

		foreach($fields as &$field){
			$field = trim($field);
		}

		//check if empty
		//TODO: add prior check to make sure it's an array before accessing $fields[0]
		$name = $fields[0];
		if ($name=='') continue;
		
		$camps = array();
		$initialCamp = array(
			"id" => $fields[5],
			"date" => $fields[6]//TODO: parse into date object
		);
		$camps[] = $initialCamp;
		$secondCamp = array(
			"id" => $fields[8],
			"date" => $fields[9]//TODO: parse into date object
		);
		$camps[] = $secondCamp;

		$unit = array(
				"id" => $name,
				"service_location" => $fields[1],
				"type" => $fields[2],
				"location" => [
					
				],
				"port_embarkation" => $fields[10],
				"responsibilities" => $fields[14],
				"unusual_experiences" => $fields[15],
				"demobilized_date" => $fields[16],//TODO: parse into date object
				"demobilized_place" => $fields[17],
				"companies" => $fields[15]

				
		);
		
		$units[$name]  = $unit;
		
		
	  }
    }
	catch (Exception $error){
		echo '<div class="jumbotron"><h2 class="text-danger">Error parsing units file  -- Results may not be correct</h2><p>'.$error->getMessage().' -- line: '.$counter.'</p></div>';
	}

	$jsonUnits = json_encode($units,JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT); //remove JSON_PRETTY_PRINT in production
	print $jsonUnits;
	file_put_contents('data/units.json',$jsonUnits);
	
	
}
