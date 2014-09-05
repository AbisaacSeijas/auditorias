<?php

use LaravelBook\Ardent\Ardent;

class Tax extends Ardent {

	public $table = 'public.tax';

	public $throwOnValidation = true;

	public static $rules = array();

	public $timestamps = false;

	public function taxpayer()
	{
		return $this->belongsTo('Taxpayer', 'id_taxpayer');
	}

/*
	public static $relationsData = array(
	    'taxpayer' => array(self::BELONGS_TO, 'Taxpayer', 'id_taxpayer'),
	    #'orders'  => array(self::HAS_MANY, 'Order'),
	    #'groups'  => array(self::BELONGS_TO_MANY, 'Group', 'table' => 'groups_have_users')
	);
*/
}