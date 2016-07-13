<?php
/**functionCamps.php
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
 * Import tab-delimited file for Camps and
 * create camp.json files
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
		print $line.'<br>';
		
		$fields = explode("\t",$line);
		
		$camp = array(
				"id" => [
					/* TODO: need to add auto-generated ID */
				],
				"name" => $fields[0],
				"place" => $fields[1],
				"type" => $fields[2]

				
		);
		
		$jsonCamp = json_encode($camp,JSON_UNESCAPED_SLASHES);
		
		file_put_contents('data/'.$camp['id'].'.json',$jsonCamp);
		
		print $jsonCamp;
		
		
	}
	
	
	
}
