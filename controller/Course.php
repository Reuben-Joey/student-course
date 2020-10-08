<?php
/*
    Course Controller
    This class demonstrate the use of OOPS concepts, Exception handling, Pagination
*/

/*
	TODO: 
	1. Add debug message logger in the code flow. Since log messages
	can help in investigating any bugs in the system.

	2. Instead of showing the error in the error page.
	It would be better to add the exception and stack strace to
	a log file so that developer can investigate the issue in the backend.
*/
namespace Controller;

use Model\Course as CourseModel;
class Course extends Controller implements IController{

	const COURSE_VIEW = 'course';
	const COURSE_PATH = '/course';
	const COURSE_EDIT_VIEW = 'courseEdit';

	public function show(){

		$page = isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;
        $rows = isset($_REQUEST['rows']) ? intval($_REQUEST['rows']) : self::DEFAULT_NUM_ROWS;
        $offset = ($page - 1) * $rows;
        $success = true;
        try {
			$total = CourseModel::count()->execute();
			$courses = CourseModel::select('*')->limit($offset, $rows)->execute();
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
			$this->view(self::COURSE_VIEW, compact('courses', 'total'))->view->render();	
		} else {
			$this->view(self::ERROR_VIEW, compact('error', 'message'))->view->render();
		}	
		
	}

	public function create($param){
		

		$this->validate();

		$course = new CourseModel();
		$course->name = $_REQUEST['name'];
		$course->detail = $_REQUEST['detail'];


		$success = true;
		try {
			$course->save();	
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
			$messages[self::SUCCESS] = 'Course created successfully';
			// Redirecting back with success message
			$this->back($messages);
		} else {
			$this->view(self::ERROR_VIEW, compact('error', 'message'))->view->render();
		}	
		
	}

	public function edit($param){
		$id = $param[0];
		$success = true;
		try {
			$course = CourseModel::select('*')->where('id = '.$id)->execute();
			$course = $course[0];
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
			$this->view(self::COURSE_EDIT_VIEW, compact('course'))->view->render();
		} else {
			$this->view(self::ERROR_VIEW, compact('error', 'message'))->view->render();
		}	
	}

	public function save(){

		$this->validate();

		$success = true;
		try {
			$course = CourseModel::update(array(
				'name' => $_REQUEST['name'],
				'detail' => $_REQUEST['detail']
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
			$messages[self::SUCCESS] = 'Course updated successfully';
			$this->redirectTo(self::COURSE_PATH,$messages);
		} else {
			$this->view(self::ERROR_VIEW, compact('error', 'message'))->view->render();
		}	
	}

	public function delete(){
		$success = true;
		try {
			$course = CourseModel::delete()->where('id ='.$_REQUEST['id'])->execute();
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
			$messages[self::SUCCESS] = 'Course deleted successfully';
			$this->redirectTo(self::COURSE_PATH,$messages);
		} else {
			$this->view(self::ERROR_VIEW, compact('error', 'message'))->view->render();
		}	
	}

	private function validate(){
		if (!preg_match('/^[A-z](.)*$/', $_REQUEST['name'])) {
			$messages[self::ERROR] = 'Name should start with an alphabet';
			// Redirecting back with error message
			$this->back($messages);
		}

		if (!empty($_REQUEST['detail']) && !preg_match('/^[A-z](.)*$/', $_REQUEST['detail'])) {
			$messages[self::ERROR] = 'Detail should start with an alphabet';
			// Redirecting back with error message
			$this->back($messages);	
		}

		$count = CourseModel::count()->where("name='".$_REQUEST['name']."'")->execute();
		if ($count) {
			$messages[self::ERROR] = 'Course name should be unique';
			// Redirecting back with error message
			$this->back($messages);	
		}	
	}
}