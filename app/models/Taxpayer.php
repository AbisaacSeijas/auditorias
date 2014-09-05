<?php

use LaravelBook\Ardent\Ardent;

class Taxpayer extends Ardent {

	public $table = 'public.taxpayer';

	public $throwOnValidation = true;

	public static $rules = array();

	public $timestamps = false;

	public function taxes()
	{
		return $this->hasMany('Tax', 'id_taxpayer');
	}
/*
	public static $relationsData = array(
	    'taxes' => array(self::HAS_MANY, 'Tax', 'id_taxpayer'),
	    #'orders'  => array(self::HAS_MANY, 'Order'),
	    #'groups'  => array(self::BELONGS_TO_MANY, 'Group', 'table' => 'groups_have_users')
	);
*/
}