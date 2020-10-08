<?php
namespace Controller;
class Home extends Controller{
	public function show(){
		$this->view('home', null)->view->render();
	}
}