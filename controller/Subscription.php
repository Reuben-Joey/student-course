<?php
/*
    Subscription Controller
    This class demonstrate the use of OOPS concepts, Exception handling, Pagination
*/
namespace Controller;

use Model\Subscription as SubscriptionModel;
use Model\Student as StudentModel;
use Model\Course as CourseModel;

class Subscription extends Controller implements IController{

	const SUBSCRIPTION_VIEW = 'subscriptions';
	const SUBSCRIPTION_PATH = '/subscription';
	const REPORT_VIEW = 'report';
	const REPORT_PATH = '/subscription/showReport';

	public function show(){

		$page = isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;
        $rows = isset($_REQUEST['rows']) ? intval($_REQUEST['rows']) : self::DEFAULT_NUM_ROWS;
        $offset = ($page - 1) * $rows;

		$success = true;
		try {

			$total = SubscriptionModel::count()->execute();

			$reports = StudentModel::select(array('course_subscriptions.id', 'students.first_name', 'students.last_name', 'courses.name'))
			->join('course_subscriptions', "students.id = course_subscriptions.student_id")
			->join('courses', "courses.id = course_subscriptions.course_id")
			->limit($offset, $rows)
			->execute();

			$students = StudentModel::select('*')->execute();
			$courses = CourseModel::select('*')->execute();

		} catch (\PDOException $e) {
			$success = false;
			$error = 'Database Issue';
			$message = 'Please try again!';
		} catch (\RuntimeException $e) {
			$success = false;
			$error = 'Runtime Issue';
			$message = $e->getMessage();;
		} catch (\Exception $e) {
			$success = false;
			$error = 'Unknown Issue';
			$message = 'We will figure out what went wrong!';
			
		}		
		if ($success) {
			$this->view(self::SUBSCRIPTION_VIEW, compact('students', 'courses', 'reports', 'total'))->view->render();
		} else {
			$this->view(self::ERROR_VIEW, compact('error', 'message'))->view->render();		
		}
		
	}

	public function create($param){
		$students = $_REQUEST['student_id'];
		$courses = $_REQUEST['course_id'];

		$success = true;
		try{
			foreach($students as $index => $student)
			{
				$subscription = new SubscriptionModel();
				$subscription->student_id = $student;
				$subscription->course_id = $courses[$index];
				$subscription->save();
			}
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
			$messages[self::SUCCESS] = 'Subscription created successfully';
			$this->back($messages);
		} else {
			$this->view(self::ERROR_VIEW, compact('error', 'message'))->view->render();	
		}			
	}

	public function showReport($param){

		$page = isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;
        $rows = isset($_REQUEST['rows']) ? intval($_REQUEST['rows']) : self::DEFAULT_NUM_ROWS;
        $offset = ($page - 1) * $rows;

        $success = true;
		try {
			$total = SubscriptionModel::count()->execute();

			$reports = StudentModel::select(array('students.first_name', 'students.last_name', 'courses.name'))
			->join('course_subscriptions', "students.id = course_subscriptions.student_id")
			->join('courses', "courses.id = course_subscriptions.course_id")
			->limit($offset, $rows)
			->execute();
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
			$this->view(self::REPORT_VIEW, compact('reports', 'total'))->view->render();
		} else {
			$this->view(self::ERROR_VIEW, compact('error', 'message'))->view->render();
		}
	}

	public function delete(){
		$success = true;
		try{
			$student = SubscriptionModel::delete()->where('id ='.$_REQUEST['id'])->execute();
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
			$messages[self::SUCCESS] = 'Subscription deleted successfully';
			$this->back($messages);
		} else {
			$this->view(self::ERROR_VIEW, compact('error', 'message'))->view->render();
		}	
	}
}