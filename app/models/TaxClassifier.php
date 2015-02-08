<?php 
use LaravelBook\Ardent\Ardent;
 class TaxClassifier extends Ardent{
 	public $table = 'public.tax_classifier';

	public $throwOnValidation = true;

	public static $rules = array();

	public function permissibleActivities()
	{
		return $this->hasMany('PermissibleActivities','id_classifier_tax');
	}
 }
