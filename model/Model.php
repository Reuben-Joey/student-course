<?php
/*
    The main class which every other Model extends their functionality
    This class demonstrate the use of OOPS concepts, DB transactions, Exception handling
*/
namespace Model;
use DB\DbConfig;
class Model {
	protected $db;
	protected $query;
	protected $params;
	protected $type;

	public function __construct(){
		$this->db = DbConfig::getInstance();
	}

	public static function select($fields){
		$query = "SELECT ";

		if (empty($fields)) {
			throw new \RuntimeException(__METHOD__.': fields should not be empty');
		}
		
		if (is_array($fields)) {
			$query .= implode(",", $fields)." FROM ";
		} else {
			if ($fields == "*") {
				$query .= $fields." FROM ";	
			} else {
				throw new \RuntimeException(__METHOD__.': fields should be of type array or *');
			}	
		}

		$query .= static::$table;
		$obj = new static();
		$obj->query = $query;
		$obj->type = 'select';
		return $obj;
	}

	public static function update($fields){
	
		if (empty($fields)) {
			throw new \RuntimeException(__METHOD__.': fields should not be empty');
		}

		$query = "UPDATE ".static::$table." SET ";
		$params = array();

		if (is_array($fields)) {
			foreach ($fields as $key => $value) {
				$query .= $key."=?,";
				array_push($params, $value);
			}
			$query .= "updated_at=now() ";
		} else {
			throw new \RuntimeException(__METHOD__.': fields should be of type array');
		}

		$obj = new static();
		$obj->query = $query;
		$obj->params = $params; 
		$obj->type = 'update';
		return $obj;	
	}

	public static function delete(){
		$query = "DELETE FROM ".static::$table." ";

		$obj = new static();
		$obj->query = $query;
		$obj->type = 'delete';
		return $obj;	
	}

	public static function count(){
		$query = "SELECT COUNT(*) FROM ".static::$table." ";

		$obj = new static();
		$obj->query = $query;
		$obj->type = 'count';
		return $obj;	
	}

	public function join($table, $condition, $type = 'INNER'){

		if (empty($table)) {
			throw new \RuntimeException(__METHOD__.': table should not be empty');
		}
		if (empty($condition)) {
			throw new \RuntimeException(__METHOD__.': condition should not be empty');
		}

		$this->query .= " ".$type." JOIN ".$table." ON ".$condition; 
		return $this;			
	}

	public function where($condition){

		if (empty($condition)) {
			throw new \RuntimeException(__METHOD__.': condition should not be empty');
		}

		$this->query .= " WHERE ".$condition;
		return $this;
	}

	public function orderBy($columns, $type='ASC'){

		if (empty($columns)) {
			throw new \RuntimeException(__METHOD__.': columns should not be empty');
		}

		$this->query .= " ORDER BY ".$columns. " ". $type;
		return $this;
	}

	public function limit($offset, $row=null){

		if (!isset($offset)) {
			throw new \RuntimeException(__METHOD__.': offset should not be empty');
		}

		if (!is_int($offset)) {
			throw new \RuntimeException(__METHOD__.': offset should be of type int');	
		}

		if (empty($row)) {
			$this->query .= " LIMIT ".$offset;
		} else {
			$this->query .= " LIMIT ".$offset. ", ". $row;	
		}

		
		return $this;
	}
	
	public function execute(){
		try {
        	
			if ($this->type == 'select') {
				$stm = $this->db->query($this->query);
				$result = $stm->fetchAll(\PDO::FETCH_ASSOC);
				return $result;	
			} else if ($this->type == 'update'){

				$this->db->beginTransaction();

				$stmt= $this->db->prepare($this->query);
				$stmt->execute($this->params);

				$this->db->commit();

			} else if ($this->type == 'delete'){

				$this->db->beginTransaction();

				$stmt= $this->db->prepare($this->query);
				$stmt->execute();

				$this->db->commit();

			} else if ($this->type == 'count'){
	            $count = $this->db->query($this->query);
				return $count->fetchColumn();
			} 
			
    	} catch(\PDOException $e) {	
    		$this->db->rollBack();
            throw $e;
    	}			
	}

}