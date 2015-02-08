<?php

use LaravelBook\Ardent\Ardent;

class AuditData extends Ardent{

	public $table = 'audit.audit_data';

	public $throwOnValidation = true;

	public static $rules = array();

}