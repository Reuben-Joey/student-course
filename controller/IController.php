<?php
namespace Controller;

interface IController {
	const ERROR_VIEW = 'error';
	const SUCCESS = 'hasSuccessMessage';
	const ERROR = 'hasErrorMessage';
	const DEFAULT_NUM_ROWS = 3;
}
?>