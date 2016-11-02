<?php


// Define global constants
define("ROOT_FOLDER", "http://" . $_SERVER["HTTP_HOST"] . "/bsm/");


/* Global MySQL Database Connection.
global $mysqli;
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_BASE);
if ($mysqli->connect_error || $mysqli->connect_errno) {
	exit("<h1 class='text-danger'>Database Connection Error (" . $mysqli->connect_errno . "): " . $mysqli->connect_error . "</h1>");
}*/

global $soldierFieldNames;
$soldierFieldNames = array (
  "id"=> "ID",
  "last_name"=> "Last name",
  "first_name"=> "First name",
  "residence_county"=> "Residence county",
  "residence_city"=> "Residence city",
  "induction_status"=> "Induction status",
  "induction_place"=> "Induction place",
  "induction_date"=> "Induction date",
  "birth_place"=> "Birth place",
  "age"=> "Age",
  "birth_date"=> "Birth date",
  "unit_progression"=> "Units",
  "rank_progression"=> "Rank",
  "engagements"=> "Engagements",
  "discharge_date"=> "Discharge date",
  "discharge_date_notes"=> "Discharge notes",
  "service_date_start"=> "Overseas service start date",
  "service_date_end"=> "Overseas servie end date",
  "wounded"=> "Wounded",
  "death_date"=> "Death date",
  "death_cause"=> "Cause of death",
  "death_notified"=> "Date death notified"
);