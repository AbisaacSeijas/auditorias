<?php 

use LaravelBook\Ardent\Ardent;

 class Status extends Ardent{

 	public $table = 'audit.status';

	public $throwOnValidation = true;

	public static $rules = array();

 }
