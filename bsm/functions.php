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
 

 require_once ('dateFunctions.php');
 
 
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
			$units = array(); //reset units object
			$units = createUnitsObject($fields,12,26);
		}
		catch (Exception $e) {
			print '<h1 class="text-danger text-center">Unable to create units object: '.$e->getMessage().' - '.$fields[0].'</h1>';
			//die();
		}

		$dischage_date = parseDischargeDateCell($fields[28]);

		//fix units end date for soldiers who only had one unit
		//we get the end date from discharge date
		if (sizeof($units)==1){
			$units[0][2] = $dischage_date[0];
		}

		try{
		$soldier = array(

				"id"=> $fields[0],
				"last_name" => $fields[1],
				"first_name" => $fields[2],
				"residence_county" => $fields[3],
				"residence_city" => $fields[4],
				"induction_status" => $fields[5],
				"induction_place" => $fields[6],
				"induction_date" => formatDate($fields[7]), /* TODO: test if formatting function works, add try-catch*/
				"birth_place" => $fields[8],
				"age" => $fields[11], /* TODO: check if this works*/
				"birth_date" => formatBirthDate($fields[10]), /* ISO 8601 date format */
				"unit_progression" => $units,
				"rank_progression" => [
					/* TODO: add stuff for ranks*/
				],
				"engagements" => [
					/* TODO: add stuff for engagements*/
				],
				"discharge_date" => $dischage_date[0],
				"discharge_date_notes" => $dischage_date[1],
				"service_date_start" => formatDate($fields[29]),
				"service_date_end" => formatDate($fields[30]),
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
		 //This isn't working!!!!
		 //TODO: Fix this
		 /*$soldierUnits = $soldier['unit_progression'];
		 //print $soldier['id'].'<br>';
		 foreach ($soldierUnits as $soldierUnit){
			 //TODO: add error detection - try catch blocks
			 $soldierUnitID = $soldierUnit[0];
			 print '|'.$soldierUnitID.'|';
			 $unit = $units[$soldierUnitID];
			 if (preg_match('/92/',$unit['category'])){
				 $total92Division++;
			 }
			 else if (preg_match('/93/',$unit['category'])){
				 $total93Division++;
			 }
		 }*/


		 //TODO: add other calculations to this loop
		 //      and add to $soldierStats array to be used by visualizations


	 }

	 $soldierStats['birth_place_NC'] = $birthPlaceNC;
	 $soldierStats['birth_place_other'] = $birthPlaceOther;

	 $soldierStats['induction_place_NC'] = $inductionPlaceNC;
	 $soldierStats['induction_place_other'] = $inductionPlaceOther;

	 //commented out until fixed
	 //$soldierStats['total_92_division']  = $total92Division;
	 //$soldierStats['total_93_division']  = $total93Division;

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
	$camps = readJson('data/camps.json');
	
	//will need to adjust these
	$minDate = [1917,1,31];
	$maxDate = [1920,1,31];

	$prevDate = $minDate;
	$currentDate = [1917,2,28];

	$soldierLocations = array();

//ini_set('memory_limit', '3072M');
set_time_limit(600);
	//brute force approach
	while(compareDates($currentDate,$maxDate)==-1){
		print '<h1>'.$currentDate[0].'-'.$currentDate[1].'</h1><br><br>';
		foreach ($soldiers as $soldier){
			//continue;
			$soldierUnits = $soldier['unit_progression'];
			if (sizeof($soldierUnits)<1) continue;//TODO: add error reporting here
			$unit = $soldierUnits[0];
			foreach ($soldierUnits as $currentUnit){
				$isInRange=false;
				$isGreaterThanPrev = compareDates(parseDate($currentUnit[2]),$prevDate) == 1;
				$isLessThanCurrent = compareDates(parseDate($currentUnit[2]),$currentDate) ==-1;
				$isEqualToCurrent = compareDates(parseDate($currentUnit[2]),$currentDate) == 0;
				$isInRange = $isGreaterThanPrev && ($isLessThanCurrent || $isEqualToCurrent);
				if ($isInRange){
					$unit = $currentUnit;
				}
			}

			$unitName = $unit[0];
			$unitDetails = $units[$unitName];//this corresponds to a unit object from units.json
			$unitLocations = $unitDetails['location'];//from unit object
			if (sizeof($unitLocations)<1) continue; //TODO: add error reporting
			$location = $unitLocations[0];
			foreach ($unitLocations as $currentLocation){
				$isInRange=false;
				$isGreaterThanPrev = compareDates(parseDate($currentLocation['date']),$prevDate) == 1;
				$isLessThanCurrent = compareDates(parseDate($currentLocation['date']),$currentDate) ==-1;
				$isEqualToCurrent = compareDates(parseDate($currentLocation['date']),$currentDate) == 0;
				$isInRange = $isGreaterThanPrev && ($isLessThanCurrent || $isEqualToCurrent);
				if ($isInRange){
					$location = $currentLocation;
				}
			}
			$campName = $location['id'];

			if (!array_key_exists($campName,$camps)) continue;//TODO add error reporting
			$campDetails = $camps[$campName];//This corresponds to a camp object


			if (!array_key_exists('latlng',$campDetails)) continue;//TODO add error reporting
			$latlng = $campDetails['latlng'];

			
			//$soldierLocationsItem = [$soldier['id'],$latlng];

			if ($latlng==null) continue;
			$dateIndex = $currentDate[0].'-'.$currentDate[1];
			$soldierLocations[$dateIndex][$soldier['id']] = $latlng;
			//print_r($soldierLocations);
			//return;

		}
		$prevDate = incrementDate($prevDate);
		$currentDate = incrementDate($currentDate);
	}

	writeJson('data/soldierLocations.json',$soldierLocations);
}

function incrementDate($date){
	if ($date[1]==12) {
		$date[0]++;
		$date[1] = 1;
		$date[2] = 31;
	}
	else {
		$date[1]++;
		switch ($date[1]){
			case 1:
			  $date[2] = 31;
			  break;
			case 1:
			  $date[2] = 31;
			  break;
			case 2:
			  $date[2] = 28;
			  break;
			case 3:
			  $date[2] = 31;
			  break;
			case 4:
			  $date[2] = 30;
			  break;
			case 5:
			  $date[2] = 31;
			  break;
			case 6:
			  $date[2] = 30;
			  break;
			case 7:
			  $date[2] = 31;
			  break;
			case 8:
			  $date[2] = 31;
			  break;
			case 9:
			  $date[2] = 30;
			  break;
			case 10:
			  $date[2] = 31;
			  break;
			case 11:
			  $date[2] = 30;
			  break;
			case 12:
			  $date[2] = 31;
			  break;
		}
	}
	return $date;
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
 * creates a units object for a soldier
 * @param {int,int} offset ints for units array details
 * @return {string} Unit object to be inserted into a soldier, exception on failure
 */
 function createUnitsObject($input,$startIndex, $endIndex){
	 $unitFields = array();
	 for ($i=$startIndex; $i<=$endIndex; $i++){
		 $unitFields[] = $input[$i];
	 }

	 if (sizeof($unitFields) != 15){
		throw new Exception('Invalid input for createUnitsObject function.');
	}

	 $units = array();

	 //initial unit
	 $unit[] = $unitFields[1];//unit name
	 $unit[] = $unitFields[0];//company
	 $unit[] = formatDate($unitFields[2]);//transfer date

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

		//add trailing '-00' if needed
		$dateInitialCamp = (sizeof(explode('-',trim($fields[7])))==2)?$fields[7].'-00':$fields[7];
		$dateSecondCamp = (sizeof(explode('-',trim($fields[10])))==2)?$fields[10].'-00':$fields[10];

		$initialCamp = array(
			"id" => $fields[6],
			"date" => $dateInitialCamp
		);
		$camps[] = $initialCamp;
		$secondCamp = array(
			"id" => $fields[9],
			"date" => $dateSecondCamp
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
				"demobilized_date" => (sizeof(explode('-',trim($fields[17])))==2)?$fields[17].'-00':$fields[17],
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