<?php

/*
    Course Model
    This class demonstrate the use of OOPS concepts, DB transactions, Exception handling
*/

namespace Model;
class Course extends Model implements IModel{
	public static $table = 'courses';

	public function save(){
		try {
			$this->db->beginTransaction();
			$query = "INSERT INTO ". self::$table. " (name, detail) VALUES (?,?)";
			$stmt= $this->db->prepare($query);
			$stmt->execute([$this->name, $this->detail]);
			$this->db->commit();	
		} catch(\PDOException $e) {	
    		$this->db->rollBack();
            throw $e;
    	}		
	}
}