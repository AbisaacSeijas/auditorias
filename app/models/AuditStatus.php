<?php 

use LaravelBook\Ardent\Ardent;

 class AuditStatus extends Ardent{

 	public $table = 'audit.audit_status';

	public $throwOnValidation = true;

	public static $rules = array();

 }