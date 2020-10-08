<?php
/*
    The class that handles DB connection
    This class demonstrate the use of OOPS concepts, Exception handling and Design Pattern
*/

namespace DB;
// Singleton Design pattern
 class DbConfig {
    const engine = 'mysql';
    const host = '127.0.0.1';
    const database = 'sage';
   	const user = 'root';
    const pass = '';
    const port = '3306';

 	private static $instance;
 	private function __construct(){	
 	}

 	public static function getInstance(){
 		if (empty(self::$instance)) {
 			try {
	 			$dns = self::engine.':dbname='.self::database.";host=".self::host.";port=".self::port;
	 			self::$instance = new \PDO($dns, self::user, self::pass);
	            self::$instance->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
	        } catch(PDOException $e){
	        	throw $e;
	        }
 		} 
 		return self::$instance;
 	}	
 }