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
		
		$unit = array(
				"id" => $fields[0],
				"service_location" => $fields[1],
				"type" => $fields[2],
				"location" => [
					/* TODO: add ["camp","date"] array for location */
				],
				"port_embarkation" => $fields[7]
				"responsibilities" => $fields[10]
				"unusual_experiences" => $fields[11]
				"demobilized" => $fields[12]
				"companies" => $fields[15]

				
		);
		
		$jsonUnit = json_encode($unit,JSON_UNESCAPED_SLASHES);
		
		file_put_contents('data/'.$unit['id'].'.json',$jsonUnit);
		
		print $jsonUnit;
		
		
	}
	
	
	
}
