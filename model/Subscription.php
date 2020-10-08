<?php
/*
    Subscription Model
    This class demonstrate the use of OOPS concepts, DB transactions, Exception handling
*/
namespace Model;
class Subscription extends Model implements IModel{
	public static $table = 'course_subscriptions';

	public function save(){
		try {
			$this->db->beginTransaction();
			$query = "INSERT INTO ". self::$table. " (student_id, course_id) VALUES (?,?)";
			$stmt= $this->db->prepare($query);
			$stmt->execute([$this->student_id, $this->course_id]);
			$this->db->commit();
		} catch(\PDOException $e) {	
    		$this->db->rollBack();
            throw $e;
    	}	
	}
}