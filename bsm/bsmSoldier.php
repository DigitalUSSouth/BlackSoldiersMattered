<?php
/**bsmSoldier.php
 * 
 * bsmSoldier class
 * This class is used to represent one soldier
 * */
class bsmSoldier {
	public $id; //should these be private?
	public $first_name;
	public $last_name;
	public $residence_county;
	public $residence_city;
	public $entrance_status;
	public $induction_place;
	public $induction_date;
	public $birth_place;
	public $age;
	public $birth_date;
	public $initial_unit;
	public $initial_unit_company;
	public $initial_unit_transfer_out_date;
	public $last_unit;
	public $last_unit_company;
	public $last_unit_transfer_out_date;
	public $discharge_date;
	public $service_date_start;
	public $service_date_end;
	public $wounded;
	public $death_date;
	public $death_cause;
	public $death_notified;
	
	/** constructor
	 * read soldier info from db
	 **/
	public function __construct($soldier_id){
		//throw exception if soldier id is not a positive integer
		if (!is_int($soldier_id) || (is_int($soldier_id) && $soldier_id<0)) throw new Exception('Invalid soldier id.'); //TODO: someone double check my logic here!
		
		//TODO: write code to read from db
	}
}
