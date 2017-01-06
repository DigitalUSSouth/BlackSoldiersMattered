<?php 
require_once "../functions.php";

$soldiers = readJson("../data/soldiers.json");


$soldierSample = array();
$randKeys = array_rand($soldiers,500);

foreach ($randKeys as $key){
    if ($soldiers[$key]['discharge_date']=="" || $soldiers[$key]['induction_status']=="") {
        continue;
    }
    $soldierSample[] = $soldiers[$key];
}

print "got wample";
$output = "id,type,month,date,year\n";
$counter = 1;
$yearsArray = array();

foreach ($soldierSample as $soldier){
    $date = explode("-",$soldier['discharge_date']);
    $year = $date[0];
    $month = $date[1];
    $day = $date[2];
    $newLine = $counter++.",".$soldier['induction_status'].",".$month.",".$day.",".$year."\n";
    //print $newLine.'<br>';
    if (!array_key_exists($year,$yearsArray)){
        $yearsArray[$year] = true;
    }
    $output = $output.$newLine;
}

//commenting out so we don't override previous file
//file_put_contents("data/ind5.csv",$output);
//file_put_contents("data/ind6.csv",$output);

var_dump($yearsArray);