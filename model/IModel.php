<?php
namespace Model;

interface IModel {
	// I want each of the Models to implement its own save function
	// So that it save the attribute which are specific to that Model
	public function save();
}
?>