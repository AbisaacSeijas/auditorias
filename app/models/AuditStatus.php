<?php 

use LaravelBook\Ardent\Ardent;

 class AuditStatus extends Ardent{

 	public $table = 'audit.audit_status';

	public $throwOnValidation = true;

	public static $rules = array();

	public static $status= array('notification_date' => '1', 'requirement_date' => '2'  ,'reception_date' => '3', 
	'final_review_date' => '4', 'result_notification_date' =>'5' ,'resolution_review_date' =>  '6' ,'resolution_notification_date' => '7'  );
 }