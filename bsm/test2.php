<?php
/*
 * This file includes all the solr related functions
 * 
 * */
require_once('config.php');
/*
 * The following functions are used to index specific projects.
 * Each function implements the appropriate crosswalk for its
 * respective project.
 * */
//SC Civil War
function importTabFileSCCivilWar(){
	$file = NULL;
	try {
		$file = new SplFileObject("units.txt");
	}
	catch (Exception $error){
		echo '<div class="jumbotron"><h1 class="text-danger">Unable to open uploaded file. Please try again.</h1><p>'.$error->getMessage().'</p></div>';
		return;
	}
	$counter=0;
	while ($line = $file->fgets()) {
		if ($counter++ == 0) continue; //discard first line because it only contains headers
		$fields = explode("\t",$line);
		
		$description = $fields[9].($fields[3]=='')? '': ' - Inscription:'.$fields[3] ;
		
		$subjectHeadings = parseSubjectHeadings($fields[8]);
		
		
		
		$document = array(
				'id' => $fields[0],
				'service_location' => $fields[1],
				'type' => $fields[2],
				'port_embarkation' => $fields[7]
				'responsibilities' => $fields[10]
				'unusual_experiences' => $fields[11]
				'demobilized' => $fields[12]
				'companies' => $fields[15]
				
			  //  'description' => $description,
				//date stuff:
			
				
				//copyright stuff:
				'copyright_holder' => 'University of South Carolina. Rare Books and Special Collections, Thomas Cooper Library.',
				'use_permissions' => 'Images are to be used for educational purposes only, and are not to be reproduced without permission from Rare Books and Special Collections, Thomas Cooper Library, University of South Carolina, SC 29208.',
			
		);
		indexDocument($document);
		//$date_parsed = parse_date($date);
		//$date_digital_parsed = parse_date($date_digital);
	}
}







/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////






/* function parseSubjectHeadings($inputString)
 *
 *returns array of subject headings
 *
 * @param {string} $inputString:
 *   colon ';' separated list of subject headings
 * @return {array}: array of strings, each containing a subject heading
 *
 */
function parseSubjectHeadings($inputString){
	$subjectHeadings = explode(';',trim($inputString));
	foreach ($subjectHeadings as &$heading){
		$heading = trim($heading);
	}
	return array_filter($subjectHeadings);
}
/* function indexDocument($doc){
 * indexes a document into solr
 * does not commit
 *
 * @param {array} $doc:
 *   associative array in the following format:
 *   $doc = array(
 *     'field1' => 'value',
 *     'field2' => array('value1','value2'),
 *     'field3' => 1234,
 *     etc
 *   );
 *   the keys correspond to a field in the solr schema;
 *   values are values to be indexed
 * @return {int}: result value of postJsonDataToSolr();
 *
 */
function indexDocument($doc){
	//print 'indexDocument()<br>';
	$data = array(
			'add' => array (
					'doc' => $doc
			)
	);
	$data_string = json_encode($data);                                                                                   
	print 'curl_exec() done <br>';
	//print_r($doc);
	//print '<br>';
	return postJsonDataToSolr($data_string, 'update');
}
/* function commitIndex()
 * commits all pending changes in solr
 * @param {none}
 * @return {int}: result value of postJsonDataToSolr();
 */
function commitIndex(){
	$data = array(
			'commit' => new stdClass()
	);
	$data_string = json_encode($data);
	return postJsonDataToSolr($data_string, 'update');
}
/* function delete_all()
 * deletes all documents in solr
 * @param {none}
 * @return {int}: result value of postJsonDataToSolr();
 */
function delete_all(){
	print 'delete_all();<br>';
	$data = array(
			'delete' => array(
						'query' => '*:*'
					),
			'commit' => new stdClass()
	);
	$data_string = json_encode($data);
	print $data_string;
	return postJsonDataToSolr($data_string, 'update');
}
