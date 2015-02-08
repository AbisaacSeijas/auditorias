<?php 
use LaravelBook\Ardent\Ardent;
 class PermissibleActivities extends Ardent{
 	public $table = 'public.permissible_activities';

	public $throwOnValidation = true;

	public static $rules = array();

	public function taxClassifier()
	{
		return $this->belongsTo('TaxClassifier','id_classifier_tax');
	}

	public function Taxes()
	{
		return $this->belongsTo('Tax', 'id_tax');
	}
 }
