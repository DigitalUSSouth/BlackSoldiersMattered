<?php


// Define global constants
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_BASE", "bsm");
define("ROOT_FOLDER", "http://" . $_SERVER["HTTP_HOST"] . "/bsm/");


// Global MySQL Database Connection.
global $mysqli;
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_BASE);
if ($mysqli->connect_error || $mysqli->connect_errno) {
	exit("<h1 class='text-danger'>Database Connection Error (" . $mysqli->connect_errno . "): " . $mysqli->connect_error . "</h1>");
}