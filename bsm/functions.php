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
		print $line.'<br>';
		
		$fields = explode("\t",$line);
		
		$soldier = array(
				"id"=> $fields[0],
				"first_name" => $fields[1],
				"last_name" => $fields[2],
				"residence_county" => $fields[3],
				"residence_city" => $fields[4],
				"entrance_status" => $fields[5],
				"induction_place" => $fields[6],
				"induction_date" => $fields[7], /* TODO: convert to ISO 8601 date format */
				"birth_place" => $fields[8],
				"age" => $fields[9], /* TODO: normalize format*/
				"birth_date" => $fields[10], /* ISO 8601 date format */
				"unit_progression" => [
						/* TODO: add stuff for units*/
				],
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
		
		$jsonSoldier = json_encode($soldier,JSON_PRETTY_PRINT);
		
		file_put_contents('data/'.$soldier['id'].'.json',$jsonSoldier);
		
		print $jsonSoldier;
		
		
	}
	
	
	
}