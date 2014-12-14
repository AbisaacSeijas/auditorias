<?php

use LaravelBook\Ardent\Ardent;

class Tax extends Ardent {

	public $table = 'appweb.tax';

	public $throwOnValidation = true;

	public static $rules = array();

	public function taxpayer()
	{
		return $this->belongsTo('Taxpayer', 'id_taxpayer');
	}

	public function permissibleActivities()
	{
		return $this->hasMany('PermissibleActivities', 'id_tax');
	}

	public function taxClassifier()
	{
		return $this->belongstoMany('TaxClassifier', 'permissible_activities', 'id_tax','id_classifier_tax');
	}

/*
	public static $relationsData = array(
	    'taxpayer' => array(self::BELONGS_TO, 'Taxpayer', 'id_taxpayer'),
	    #'orders'  => array(self::HAS_MANY, 'Order'),
	    #'groups'  => array(self::BELONGS_TO_MANY, 'Group', 'table' => 'groups_have_users')
	);
*/
}