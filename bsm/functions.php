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

		//get rid of whitespace around all fields
		foreach ($fields as &$field){//need to use &$ to pass by reference
			$field = trim($field);
		}

		try {
			$units = createUnitsObject(array_splice($fields,12,15));
		}
		catch (Exception $e) {
			print '<h1 class="text-danger text-center">Unable to create units object: '.$e->getMessage().' - '.$fields[0].'</h1>';
			//die();
		}

		try{
		$soldier = array(

				"id"=> $fields[0],
				"last_name" => $fields[1],
				"first_name" => $fields[2],
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

	 $inductionPlaceNC = 0;
	 $inductionPlaceOther = 0;

	 $total92Division = 0;
	 $total93Division = 0;

	 //TODO: Add try-catch aroung this
	 $units = readJson('data/units.json'); //load units object

	 
	 foreach ($soldiers as $soldier){

		 //calculate total number from NC vs from other states
		 //check birth place
		 //the regex will match . XX
		 // comma(,) followed by one or more spaces, followed by two letter state codes
		 if (preg_match('/, +[A-Z]{2}$/',$soldier['birth_place'])){
			 $birthPlaceOther++;
			 //debug
			 //print $soldier['birth_place'].'<br>';
		 }
		 else {
			 $birthPlaceNC++;
		 }

		 //calculate total number inducted in NC vs from other states
		 if (preg_match('/, +[A-Z]{2}$/',$soldier['induction_place'])){
			 $inductionPlaceOther++;
			 //debug
			 //print $soldier['induction_place'].'<br>';
		 }
		 else {
			 $inductionPlaceNC++;
		 }

		 //calculate total number in 92nd vs 93rd combat divisions
		 $soldierUnits = $soldier['unit_progression'];
		 //print $soldier['id'].'<br>';
		 foreach ($soldierUnits as $soldierUnit){
			 //TODO: add error detection - try catch blocks
			 $soldierUnitID = $soldierUnit[0];
			 //print '|'.$soldierUnitID.'|';
			 $unit = $units[$soldierUnitID];
			 if ($unit['category']=='Combat--92nd Division'){
				 $total92Division++;
			 }
			 else if ($unit['category']=='Combat--93rd Division'){
				 $total93Division++;
			 }
		 }


		 //TODO: add other calculations to this loop
		 //      and add to $soldierStats array to be used by visualizations


	 }

	 $soldierStats['birth_place_NC'] = $birthPlaceNC;
	 $soldierStats['birth_place_other'] = $birthPlaceOther;

	 $soldierStats['induction_place_NC'] = $inductionPlaceNC;
	 $soldierStats['induction_place_other'] = $inductionPlaceOther;

	 $soldierStats['total_92_division']  = $total92Division;
	 $soldierStats['total_93_division']  = $total93Division;

	 writeJson('data/soldierStats.json',$soldierStats);

	 //var_dump($soldierStats);
 }

/**
 * computes locations for all soldiers, separated per month and saves it in soldierLocations.json
 * @param {}
 * @return {}
 */
 function computeSoldierLocations(){
	 $soldiers = readJson('data/soldiers.json');
	 $units = readJson('data/units.json');
	 //$camps = readJson('data/camps.json');

	 
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
 * function to parse a unit + date cell
 * @param {string} string in the following format: QMC Camp Taylor to 1918-04-13
 *                 where "QMC Camp Taylor" is the unit and "1918-04-13"
 * @return {array} element [0] is unit element [1] is date string, exception on failure
 */
 function parseUnitDateCell($input){
	 //this is some really ugly regex
	 if (preg_match('/.+?(?= to [0-9]{4}-[0-9]{2}-[0-9]{2})/',trim($input),$dateMatch)){
		 $unit[] = $dateMatch[0];
	 }
	 else {
		 $unit[] = ''; 
	 }

	 //parse date from unit column
	 // column format is: QMC Camp Taylor to 1918-04-13
	 if (preg_match('/[0-9]{4}-[0-9]{2}-[0-9]{2}$/',trim($input),$dateMatch)){
		 $unit[] = $dateMatch[0];
	 }
	 else {
		 $unit[] = ''; 
	 }
	 return $unit;
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

	 //parse date from unit column
	 $parsedUnit = parseUnitDateCell($unitFields[4]);
	 
	 $unit[] = $parsedUnit[0];
	 $unit[] = $unitFields[3];
	 $unit[] = $parsedUnit[1];

	 if ($unit[0] != '' )$units[] = $unit;


	 //TODO: Update the following units to use parse function
	 //third unit
	 $unit = array();

	 $parsedUnit = parseUnitDateCell($unitFields[6]);

	 $unit[] = $parsedUnit[0];
	 $unit[] = $unitFields[5];
	 $unit[] = $parsedUnit[1];
	 
	 if ($unit[0] != '' )$units[] = $unit; //only add if it's not empty
	 
	 //fourth unit
	 $unit = array();

	 $parsedUnit = parseUnitDateCell($unitFields[8]);

	 $unit[] = $parsedUnit[0];
	 $unit[] = $unitFields[7];
	 $unit[] = $parsedUnit[1];
	 
	 if ($unit[0] != '' )$units[] = $unit;

	 //fifth unit
	 $unit = array();

	 $parsedUnit = parseUnitDateCell($unitFields[10]);

	 $unit[] = $parsedUnit[0];
	 $unit[] = $unitFields[9];
	 $unit[] = $parsedUnit[1];
	 
	 if ($unit[0] != '' )$units[] = $unit;

	 //sixth unit
	 $unit = array();

	 $parsedUnit = parseUnitDateCell($unitFields[12]);

	 $unit[] = $parsedUnit[0];
	 $unit[] = $unitFields[11];
	 $unit[] = $parsedUnit[1];
	 
	 if ($unit[0] != '' )$units[] = $unit;

	 //last unit
	 $unit = array();

	 $parsedUnit = parseUnitDateCell($unitFields[14]);

	 $unit[] = $parsedUnit[0];
	 $unit[] = $unitFields[13];
	 $unit[] = $parsedUnit[1];
	 
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

	try {
		$file = new SplFileObject("testdata/camps.csv");
	}
	catch (Exception $error){
		echo '<div class="jumbotron"><h1 class="text-danger">Unable to open uploaded file. Please try again.</h1><p>'.$error->getMessage().'</p></div>';
		return;
	}

	$counter=0;
	try{
		while($line = $file->fgets()){
			//discard first line
			if ($counter++ < 1) {/*echo $line;*/continue;}

			$fields = explode(",",$line);
			print $line.'<br>';
			foreach($fields as &$field){
				$field = trim($field);
			}

			try{
				$camps[$fields[0]]['latlng'] = [$fields[4],$fields[5]];
			}
			catch(Exception $error){
				echo '<div class="jumbotron"><h2 class="text-danger">Error parsing camps.csv file  </h2><p>'.$error->getMessage().' -- line: '.$counter.'</p></div>';
			}
		}
	}
	catch (Exception $error){
		echo '<div class="jumbotron"><h2 class="text-danger">Error parsing camps.csv file  </h2><p>'.$error->getMessage().' -- line: '.$counter.'</p></div>';
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