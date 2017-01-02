<?php 
/** dateFunctions.php
 * defines all date-realted functions used throughout site
 */



/**
 * function to parse a discharge date cell
 * @param {string} string in the following format: 7/15/1919 for immediate re-enlistment
 *                 where "for immediate re-enlistment" is the notes and "7/15/1919"
 * @return {array} element [0] is date element [1] is notes
 */
 function parseDischargeDateCell($input){
     $dischargeDate = array();
     //var_dump($input);
	 if (preg_match('/^[0-9]{1,2}\/[0-9]{1,2}\/[0-9]{2,4}/',trim($input),$dateMatch)){
		 $dischargeDate[] = formatDate($dateMatch[0]);//convert to YYYY-MM-DD
	 }
	 else {
		 $dischargeDate[] = ''; 
	 }

     if (preg_match('/\b[0-9]{1,2}\/[0-9]{1,2}\/[0-9]{2,4}\s+\K.+/',trim($input),$dateMatch)){
		 $dischargeDate[] = $dateMatch[0];
	 }
	 else {
		 $dischargeDate[] = ''; 
	 }
     //var_dump ($dischargeDate);
	 return $dischargeDate;
 }



function formatBirthDate($input){
	//input is MM/DD/YYYY
	//output is YYYY-MM-DD -> ISO
	try{
		if ($input=='') return '';
		$parts = explode("/",$input);
		if (sizeof($parts)!= 3) return $input;//TODO: add parsing for other types of dates
		$formattedDate = $parts[2].'-'.$parts[0].'-'.$parts[1];
		return $formattedDate;
	}
	catch (Exception $e) {
			print '<h1 class="text-danger text-center">Exception: Error formatting birth date '.$e->getMessage().' - '.$input.' </h1>';
			//die();
	}
}


//SOMETIMES I REALLY WISH PHP ALLOWED OPERATOR OVERLOADING
/**
 * function to compare two date objects
 * @param {array,array} two date objects to compare [year,month,day]
 * @return {int} 0 if equal, 1 if first is greater (later date), -1 if second if greater
 * WARNING: does not check if objects are valid. Make sure objects are valid if using function
 */
function compareDates($date1, $date2){
	$year = 0;
	$month = 1;
	$day = 2;
	if ($date1[$year] > $date2[$year]) return 1;
	else if ($date1[$year] < $date2[$year]) return -1;
	//if years are equal then we check months
	else if ($date1[$month] > $date2[$month]) return 1;
	else if ($date1[$month] < $date2[$month]) return -1;
	//if months are equal we check days
	else if ($date1[$day] > $date2[$day]) return 1;
	else if ($date1[$day] < $date2[$day]) return -1;
	//if all else fails then they are equal
	else return 0;
}



/**
 * function to parse an iso date into discrete parts
 * @param {string} ISO formatted date string YYYY-MM-DD
 * @return {array} associative array [year,month,day], throws exception on failure
 */
function parseDate($input){
	try{
	if (!preg_match('/[0-9]{4}-[0-9]{2}-[0-9]{2}/',trim($input))) throw new Exception('Parse date: Invalid date format: '.$input);

	$parts = explode('-',trim($input));
	if (sizeof($parts)!= 3) throw new Exception('Parse date. Incorrect number of parts: '.$input);

	$date=array();
	$date[] = (int)$parts[0];
	$date[] = (int)$parts[1];
	$date[] = (int)$parts[2];
	}
	catch (Exception $e) {
		//TODO: add proper exception handling
		print '<h1 class="text-danger text-center">Exception: '.$e->getMessage().' </h1>';
		array_walk(debug_backtrace(),create_function('$a,$b','print "{$a[\'function\']}()(".basename($a[\'file\']).":{$a[\'line\']}); ";'));
		return array(0,0,0);
	}
	return $date;
	
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

    if (trim($input)=='') return '';
 
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
    if (strlen($year)<4) $year = '19'.$year;

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