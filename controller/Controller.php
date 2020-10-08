<?php
/*
    The main class which every other Controllers extends their functionality
    This class demonstrate the use of OOPS concepts, namespacing
*/

namespace Controller;
use View\View;
class Controller{
	protected $view;

	/*
		TODO: We can also make a function to pass the list of extra 
		css and js files which are specific to a particular view
	*/

	function view($viewName, $args){
		$this->view = new View($viewName);
		$this->view->params = $args;
		return $this;
	}

	function back($messages=null){
		if (!empty($messages)) {
			session_start();
			$_SESSION['viewReturnMessages'] = $messages;
		}		
		header('Location: ' . $_SERVER['HTTP_REFERER']);
		exit;
	}

	function redirectTo($location, $messages=null){
		if (!empty($messages)) {
			session_start();
			$_SESSION['viewReturnMessages'] = $messages;
		}		
		header('Location: ' . $location);
		exit;
	}
}