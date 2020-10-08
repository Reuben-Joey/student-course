<?php
/*
    The main class which performs view rendering and making
    the parameter passed from the backend available to the view

*/
namespace View;
class View {
	private $viewname;
	public $params;
    
    public function __construct($viewname) {
    	$this->viewname = $viewname;   
    }
    
    public function render() {
    	if(!empty($this->params)){
            extract($this->params); 
        }   
        session_start();
        if(!empty($_SESSION['viewReturnMessages'])){
            extract($_SESSION['viewReturnMessages']);
            session_unset();
        }

        require 'templates/header.php';        
        require  ucfirst($this->viewname) . '.php';
        require 'templates/footer.php';
    }
}