<?php
/*
    Student Controller
    This class demonstrate the use of OOPS concepts, Exception handling, Pagination
*/
namespace Controller;

use Model\Student as StudentModel;

class Student extends Controller implements IController{

	const STUDENT_VIEW = 'student';
	const STUDENT_PATH = '/student';
	const STUDENT_EDIT_VIEW = 'studentEdit';

	public function show(){
		$page = isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;
        $rows = isset($_REQUEST['rows']) ? intval($_REQUEST['rows']) : self::DEFAULT_NUM_ROWS;
        $offset = ($page - 1) * $rows;

        $success = true;
        try {

			$total = StudentModel::count()->execute();
			$students = StudentModel::select('*')->limit($offset, $rows)->execute();

		} catch (\PDOException $e) {
			$success = false;
			$error = 'Database Issue';
			$message = 'Please try again!';
		} catch (\RuntimeException $e) {
			$success = false;
			$error = 'Runtime Issue';
			$message = $e->getMessage();
		} catch (\Exception $e) {
			$success = false;
			$error = 'Unknown Issue';
			$message = 'We will figure out what went wrong!';	
		}		
		if ($success) {
			$this->view(self::STUDENT_VIEW, compact('students', 'total'))->view->render();
		} else {
			$this->view(self::ERROR_VIEW, compact('error', 'message'))->view->render();
		}		
	}

	public function create($param){

		$this->validate();

		$student = new StudentModel();
		$student->first_name = $_REQUEST['first_name'];
		$student->last_name = $_REQUEST['last_name'];
		$student->dob = $_REQUEST['dob'];
		$student->contact_no = $_REQUEST['contact_no'];

		$success = true;
		try{
			$student->save();
		} catch (\PDOException $e) {
			$success = false;
			$error = 'Database Issue';
			$message = 'Please try again!';
		} catch (\Exception $e) {
			$success = false;
			$error = 'Unknown Issue';
			$message = 'We will figure out what went wrong!';	
		}		
		
		if ($success) {
			$messages[self::SUCCESS] = 'Student created successfully';
			// Redirecting back with success message
			$this->back($messages);	
		}  else {
			$this->view(self::ERROR_VIEW, compact('error', 'message'))->view->render();
		}		
	}

	public function edit($param){
		$id = $param[0];
		$success = true;
		try {
			$student = StudentModel::select('*')->where('id = '.$id)->execute();
			$student = $student[0];
		} catch (\PDOException $e) {
			$success = false;
			$error = 'Database Issue';
			$message = 'Please try again!';
		} catch (\RuntimeException $e) {
			$success = false;
			$error = 'Runtime Issue';
			$message = $e->getMessage();
		} catch (\Exception $e) {
			$success = false;
			$error = 'Unknown Issue';
			$message = 'We will figure out what went wrong!';	
		}		
		if ($success) {
			$this->view(self::STUDENT_EDIT_VIEW, compact('student'))->view->render();
		} else {
			$this->view(self::ERROR_VIEW, compact('error', 'message'))->view->render();
		}		
	}

	public function save(){

		$this->validate();

		$success = true;
		try{
			$student = StudentModel::update(array(
				'first_name' => $_REQUEST['first_name'],
				'last_name' => $_REQUEST['last_name'],
				'dob' => $_REQUEST['dob'],
				'contact_no' => $_REQUEST['contact_no'],
				))
			->where('id ='.$_REQUEST['id'])->execute();

		} catch (\PDOException $e) {
			$success = false;
			$error = 'Database Issue';
			$message = 'Please try again!';
		} catch (\RuntimeException $e) {
			$success = false;
			$error = 'Runtime Issue';
			$message = $e->getMessage();
		} catch (\Exception $e) {
			$success = false;
			$error = 'Unknown Issue';
			$message = 'We will figure out what went wrong!';
		}		

		if ($success) {
			$messages[self::SUCCESS] = 'Student updated successfully';
			$this->redirectTo(self::STUDENT_PATH,$messages);	
		} else {
			$this->view(self::ERROR_VIEW, compact('error', 'message'))->view->render();
		}	
	}

	public function delete(){
		$success = true;
		try{
			$student = StudentModel::delete()->where('id ='.$_REQUEST['id'])->execute();
		} catch (\PDOException $e) {
			$success = false;
			$error = 'Database Issue';
			$message = 'Please try again!';
		} catch (\Exception $e) {
			$success = false;
			$error = 'Unknown Issue';
			$message = 'We will figure out what went wrong!';	
		}		
		
		if ($success) {
			$messages[self::SUCCESS] = 'Student deleted successfully';
			$this->redirectTo(self::STUDENT_PATH,$messages);
		} else {
			$this->view(self::ERROR_VIEW, compact('error', 'message'))->view->render();
		}	
	}


	private function validate() {
		if (!ctype_alpha($_REQUEST['first_name'])) {
			$messages[self::ERROR] = 'First Name should be alphabets';
			// Redirecting back with error message
			$this->back($messages);
		}

		if (!ctype_alpha($_REQUEST['last_name'])) {
			$messages[self::ERROR] = 'Last Name should be alphabets';
			// Redirecting back with error message
			$this->back($messages);	
		}

		if (!preg_match('/^\d{4}\-(0?[1-9]|1[012])\-(0?[1-9]|[12][0-9]|3[01])$/', $_REQUEST['dob'])) {
			$messages[self::ERROR] = 'DOB should be of the form YYYY-MM-DD';
			// Redirecting back with error message
			$this->back($messages);
		}

		if (!is_numeric($_REQUEST['contact_no'])) {
			$messages[self::ERROR] = 'Contact No. should be numeric';
			// Redirecting back with error message
			$this->back($messages);
		}

		if (!preg_match('/^[0-9]{10}$/', $_REQUEST['contact_no'])) {
			$messages[self::ERROR] = 'Contact No. should be of 10 digits';
			// Redirecting back with error message
			$this->back($messages);
		}

		$count = StudentModel::count()->where('contact_no='.$_REQUEST['contact_no'])->execute();
		if ($count) {
			$messages[self::ERROR] = 'Contact No. should be unique';
			// Redirecting back with error message
			$this->back($messages);	
		}
	}
}