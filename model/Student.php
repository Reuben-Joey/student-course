<?php
/*
    Student Model
    This class demonstrate the use of OOPS concepts, DB transactions, Exception handling
*/
namespace Model;
class Student extends Model implements IModel{
	public static $table = 'students';

	public function save(){
		try {
			$this->db->beginTransaction();
			$query = "INSERT INTO ". self::$table. " (first_name, last_name, dob, contact_no) VALUES (?,?,?,?)";
			$stmt= $this->db->prepare($query);
			$stmt->execute([$this->first_name, $this->last_name, $this->dob,$this->contact_no]);
			$this->db->commit();	
		} catch(\PDOException $e) {	
    		$this->db->rollBack();
            throw $e;
    	}	
	}
}