<?php
/**functions.php
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
 * Import tab-delimited file for soldiers random sample and
 * create soldier.json files
 */
function importRandomSample(){
	ini_set("auto_detect_line_endings", true);
	$file = NULL;
	
	try {
		$file = new SplFileObject("uploads/random-sample.txt");
	}
	catch (Exception $error){
		echo '<div class="jumbotron"><h1 class="text-danger">Unable to open uploaded file. Please try again.</h1><p>'.$error->getMessage().'</p></div>';
		return;
	}

 $counter=0;
 $soldiers = array();
 try {
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

		try {
			$units = createUnitsObject(array_splice($fields,12,15));
		}
		catch (Exception $e) {
			print '<h1 class="text-danger text-center">Unable to parse date: '.$e->getMessage().' - '.$fields[0].'</h1>';
			//die();
		}

		try{
		$soldier = array(

				"id"=> $fields[0],
				"first_name" => $fields[1],
				"last_name" => $fields[2],
				"residence_county" => $fields[3],
				"residence_city" => $fields[4],
				"entrance_status" => $fields[5],
				"induction_place" => $fields[6],
				"induction_date" => formatDate($fields[7]), /* TODO: test if formatting function works, add try-catch*/
				"birth_place" => $fields[8],
				"age" => $fields[11], /* TODO: check if this works*/
				"birth_date" => $fields[10], /* ISO 8601 date format */
				"unit_progression" => $units,
				"rank_progression" => [
					/* TODO: add stuff for ranks*/
				],
				"engagements" => [
					/* TODO: add stuff for engagements*/
				],
				"discharge_date" => $fields[28], /* TODO:  convert all these dates to ISO 8601 date format */
				"service_date_start" => $fields[29],
				"service_date_end" => $fields[30],
				"wounded" => $fields[32],
				"death_date" => $fields[33],
				"death_cause" => $fields[34],
				"death_notified" => $fields[35]
		);
		}
		catch (Exception $e) {
			print '<h1 class="text-danger text-center">Exception: '.$e->getMessage().' - '.$fields[0].'</h1>';
			continue;
			//die();
		}
		
		$soldiers [$soldier['id']] = $soldier;	
	  }
    }
	catch (Exception $e) {
			print '<h1 class="text-danger text-center">Exception: '.$e->getMessage().' </h1>';
			//die();
	}

	writeJson('data/soldiers.json',$soldiers);

}

/**
 * computes stats for all soldiers
 * @param {}
 * @return {}
 */
 function computeSoldierStats(){

	 $soldiers = readJson('data/soldiers.json');

	 $soldierStats = array();//main soldierStats object
	 $soldierStats['total_number'] = sizeof($soldiers);

	 $birthPlaceNC = 0;
	 $birthPlaceOther = 0;

	 
	 foreach ($soldiers as $soldier){

		 //calculate total number from NC vs from other states
		 //check birth place
		 //the regex will match . XX
		 // coma(,) followed by one or more spaces, followed by two letter state codes
		 if (preg_match('/, +[A-Z]{2}$/',$soldier['birth_place'])){
			 $birthPlaceOther++;
			 //debug
			 //print $soldier['birth_place'].'<br>';
		 }
		 else {
			 $birthPlaceNC++;
		 }

		 //TODO: add other calculations to this loop
		 //      and add to $soldierStats array to be used by visualizations


	 }

	 $soldierStats['birth_place_NC'] = $birthPlaceNC;
	 $soldierStats['birth_place_other'] = $birthPlaceOther;

	 writeJson('data/soldierStats.json',$soldierStats);

	 //var_dump($soldierStats);
 }

/**
 * function to read from a json file and place contents in php array
 * @param {string} filepath to a valid json file 
 * @return {string} associative array of json file contents or exception on failure
 */
function readJson($filename){
	try{
		 $jsonData = file_get_contents(ROOT_FOLDER.$filename);
		 return json_decode($jsonData,true);
	 }
	 catch (Exception $e) {
			print '<h1 class="text-danger text-center">Exception: Unable to read json file '.$filename.' - '.$e->getMessage().' </h1>';
			die();
	 }
}

/**
 * function to write contents of php array object to json file
 * @param {string} filepath to a valid json file 
 * @return {none} exception on failure
 */
function writeJson($filename,$object){
	try {
	$jsonObject = json_encode($object,JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT); //remove JSON_PRETTY_PRINT in production
	 print $jsonObject.'<br>';
	 file_put_contents($filename,$jsonObject);
	 }
	 catch (Exception $e) {
			print '<h1 class="text-danger text-center">Exception: Unable to write json file '.$filename.' - '.$e->getMessage().' </h1>';
			die();
	 }
}

/**
 * function to format the date from M^/D^/YY to YYYY-MM-DD
 * @param {string} excel-formatted date string 
 * @return {string} ISO 8601 string if successful or exception on failure
 */
function formatDate($input){
	if (!is_string($input)){
		throw new Exception('Input date must be a string: '.$input);
	}
	$parts = explode('/',$input);

	if (sizeof($parts) != 3) {
		throw new Exception('Invalid date format. Incorrect number of parts. - '.$input);
	}

	$month = $parts[0];
	$day = $parts[1];
	$year = $parts[2];

	//pad month and day with zeroes if needed
	$month = sprintf('%02d', (int)$month);
	$day = sprintf('%02d', (int)$day);

	//add leading '19' to year
	$year = '19'.$year;

	//create final return string
	return $year.'-'.$month.'-'.$day;
}

/**
 * creates a units object for a soldier
 * @param {array} array of strings containing unit details
 * @return {string} Unit object to be inserted into a soldier, exception on failure
 */
 function createUnitsObject($unitFields){
	 if (sizeof($unitFields) != 15){
		throw new Exception('Invalid input for createUnitsObject function.');
	}

	 $units = array();

	 //initial unit
	 $unit[] = $unitFields[1];//unit name
	 $unit[] = $unitFields[0];//company
	 $unit[] = $unitFields[2];//transfer date

	 $units[] = $unit;

	 //second unit
	 $unit = array();
	 $unit[] = $unitFields[4];
	 $unit[] = $unitFields[3];
	 $unit[] = '';//TODO: parse date out from unit name	
	 
	 if ($unit[0] != '' )$units[] = $unit;

	 //third unit
	 $unit = array();
	 $unit[] = $unitFields[6];
	 $unit[] = $unitFields[5];
	 $unit[] = '';//TODO: parse date out from unit name	
	 
	 if ($unit[0] != '' )$units[] = $unit; //only add if it's not empty
	 
	 //fourth unit
	 $unit = array();
	 $unit[] = $unitFields[8];
	 $unit[] = $unitFields[7];
	 $unit[] = '';//TODO: parse date out from unit name	
	 
	 if ($unit[0] != '' )$units[] = $unit;

	 //fifth unit
	 $unit = array();
	 $unit[] = $unitFields[10];
	 $unit[] = $unitFields[9];
	 $unit[] = '';//TODO: parse date out from unit name	
	 
	 if ($unit[0] != '' )$units[] = $unit;

	 //sixth unit
	 $unit = array();
	 $unit[] = $unitFields[12];
	 $unit[] = $unitFields[11];
	 $unit[] = '';//TODO: parse date out from unit name	
	 
	 if ($unit[0] != '' )$units[] = $unit;

	 //last unit
	 $unit = array();
	 $unit[] = $unitFields[14];
	 $unit[] = $unitFields[13];
	 $unit[] = '';//TODO: parse date out from unit name	
	 
	 if ($unit[0] != '' )$units[] = $unit;

	 return $units;

 }



/**
 * Import tab-delimited file for Camps and
 * create camps.json file
 */
function importCamps(){
	ini_set("auto_detect_line_endings", true);
	$file = NULL;
	
	try {
		$file = new SplFileObject("uploads/camps.txt");
	}
	catch (Exception $error){
		echo '<div class="jumbotron"><h1 class="text-danger">Unable to open uploaded file. Please try again.</h1><p>'.$error->getMessage().'</p></div>';
		return;
	}

 $counter=0;
 $camps = array();
 try{
	while($line = $file->fgets()){
		//discard first 3 lines
		//TODO: move this outside of loop for performance
		if ($counter++ < 3) {/*echo $line;*/continue;}
		
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
		
		$camp = array(
				"id" => $name,
				"place" => $fields[1],
				"type" => $fields[2]

				
		);

		$camps[$name]  = $camp;
		
		//debug:
		//print $jsonCamp;	
		
	  }
    }
	catch (Exception $error){
		echo '<div class="jumbotron"><h2 class="text-danger">Error parsing camps file  -- Results may not be correct</h2><p>'.$error->getMessage().' -- line: '.$counter.'</p></div>';
	}

	writeJson('data/camps.json',$camps);
	
}


/**
 * Import tab-delimited file for Units and
 * create units.json file
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
		$name = trim($fields[0]);
		if ($name=='') continue;
		
		$camps = array();
		$initialCamp = array(
			"id" => $fields[6],
			"date" => $fields[7]//TODO: parse into date object
		);
		$camps[] = $initialCamp;
		$secondCamp = array(
			"id" => $fields[9],
			"date" => $fields[10]//TODO: parse into date object
		);
		if ($secondCamp['id']!='')$camps[] = $secondCamp;

		$unit = array(
				"id" => $name,
				"service_location" => $fields[1],
				"category" => $fields[2],
				"type" => $fields[3],
				"location" => $camps,
				"port_embarkation" => $fields[11],
				"responsibilities" => $fields[15],
				"unusual_experiences" => $fields[16],
				"demobilized_date" => $fields[17],//TODO: parse into date object
				"demobilized_place" => $fields[18],
				"companies" => $fields[20]

				
		);
		
		$units[$name]  = $unit;
		
		
	  }
    }
	catch (Exception $error){
		echo '<div class="jumbotron"><h2 class="text-danger">Error parsing units file  -- Results may not be correct</h2><p>'.$error->getMessage().' -- line: '.$counter.'</p></div>';
	}

	writeJson('data/units.json',$units);
	
	
}